<?php
namespace App\Http\Controllers\app\ecommerce\products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\category;
use Session;
use Helper;
use Input;
use File;
use Auth;
use Wingu;

class categoryController extends Controller{

   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $category = category::where('business_code',Auth::user()->business_code)->orderBy('id','desc')->get();
      return view('app.ecommerce.products.category.index', compact('category'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $this->validate($request,array(
         'name'=>'required',
      ));

      $check = category::where('business_code',Auth::user()->business_code)->where('name',$request->name)->count();
      if($check == 0){
         $url = Helper::seoUrl($request->name);
      }else{
         $url = Helper::seoUrl($request->name).Helper::generateRandomString(3);
      }

      $category = new category;
      $category->category_code = Helper::generateRandomString(30);
      $category->name = $request->name;
      $category->parent = $request->parent;
      $category->url = $url;
      $category->business_code = Auth::user()->business_code;
      $category->created_by = Auth::user()->user_code;
      $category->save();

      session::flash('success','You have successfully created a new Category.');

      return redirect()->route('ecommerce.product.category');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($code)
   {
      $category = category::where('category_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $parents = category::where('business_code',Auth::user()->business_code)
                  ->where('business_code',Auth::user()->business_code)
                  ->get();
      $categories = category::where('business_code',Auth::user()->business_code)->orderBy('id','desc')->get();
      
      return view('app.ecommerce.products.category.edit', compact('category','parents','count','categories'));
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
      $this->validate($request,[
         'name' => 'required',
      ]);

      $category = category::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      if($category->name != $request->name){
         $check = category::where('business_code',Auth::user()->business_code)->where('name',$request->name)->count();
         if($check == 0){
            $url = Helper::seoUrl($request->name);
         }else{
            $url = Helper::seoUrl($request->name).Helper::generateRandomString(3);
         }

         $category->url = $url;
      }
      $category->name = $request->name;
      $category->parentID = $request->parent;
      $category->updated_by = Auth::user()->user_code;
      $category->save();

      session::flash('success','Category successfully updated!');

      return redirect()->route('ecommerce.product.category.edit',$category->id);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $category = category::where('id',$id)->where('business_code',Auth::user()->business_code)->first();
      $category->delete();

      Session::flash('success', 'The category was successfully deleted !');

      return redirect()->route('ecommerce.product.category');
   }
}
