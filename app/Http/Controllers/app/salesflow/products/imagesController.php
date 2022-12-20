<?php
namespace App\Http\Controllers\app\salesflow\products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\file_manager;
use App\Models\finance\products\product_information;
use Session;
use Helper;
use File;
use Wingu;
use Auth;

class imagesController extends Controller{

   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      //directory
		$directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/finance/products/';

		//create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

       //get file name
      $file = $request->file('file');

      $extension = $file->getClientOriginalExtension();
      $size =  $file->getSize();

      //change file name
      $filename = Helper::generateRandomString(40). '.' .$extension;

      //move file
      $file->move($directory, $filename);

      //save the image details into the database
      $image = new file_manager;
      $image->file_code     = $request->product_code;
      $image->file_name  = $filename;
      $image->business_code = Auth::user()->business_code;
      $image->file_size  = $size;
      $image->folder 	 = 'Finance';
		$image->section 	 = 'products';
      $image->created_by = Auth::user()->user_code;
      $image->updated_by = Auth::user()->user_code;
      $image->file_mime  = $file->getClientMimeType();
      $image->save();
   }


   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($productCode)
   {
      $images = file_manager::where('file_code',$productCode)->where('business_code',Auth::user()->business_code)
                           ->where('section','products')
                           ->where('folder','Finance')
                           ->get();

      $product = product_information::where('product_code',$productCode)
                                    ->where('business_code',Auth::user()->business_code)
                                    ->first();

      return view('app.salesflow.products.images', compact('productCode','images','product'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      file_manager::where('file_code', $request->product_code)
                  ->where('business_code',Auth::user()->business_code)
                  ->where('cover', 1)
                  ->where('folder','Finance')
                  ->where('section','products')
                  ->update(['cover' => 0]);

      $cover = file_manager::where('id',$id)->where('section','products')->where('file_code', $request->product_code)->first();
      $cover->cover = 1;
      $cover->save();

      Session::flash('Success', 'Cover Images has been selected !');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

   public function destroy($id)
   {
      //delete image from folder/directory
      $oldimagename = file_manager::where('id','=',$id)->where('business_code',Auth::user()->business_code)->where('section','products')->select('file_name')->first();

      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->business_code)->business_code.'/finance/products/';
      $delete = $directory.$oldimagename->file_name;

      if (File::exists($delete)) {
         unlink($delete);
      }

      //delete from database
      file_manager::where('id',$id)->where('section','products')->delete();

      session::flash('success','You have successfully Delete!');

      return redirect()->back();
   }
}
