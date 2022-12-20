<?php

namespace App\Http\Controllers\app\jobs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\project\project;
use App\Models\wingu\file_manager;
use Mail;
use Helper;
use Auth;
use Session;
use File;
use Prm;
use Wingu;

class filesController extends Controller
{
   /**
   * All Job files
   *
   * @param  string  $code
   * @return \Illuminate\Http\Response
   */
   public function index($code){
      return view('app.jobs.job.files', compact('code'));
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
      $path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/jobs/'.$request->jobcode.'/';

      if(!file_exists($path)) {
         mkdir($path, 0777,true);
      }

      //get attachment
      $files = $request->file('attachment');

      foreach($files as $file) {

         $size =  $file->getSize();

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();

         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(30). '.' . $extension;

         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $file->move($path, $fileName);

         $upload = new file_manager;
         $upload->file_code     = $request->jobcode;
         $upload->folder 	     = 'Jobs';
         $upload->section 	     = 'General';
         $upload->name 		     = $request->title;
         $upload->file_name     = $fileName;
         $upload->file_size     = $size;
         $upload->file_mime     = $file->getClientMimeType();
         $upload->created_by    = Auth::user()->user_code;
         $upload->business_code = Auth::user()->business_code;
         $upload->save();
      }

      Session::flash('success','Files uploaded successfully');

      return redirect()->route('job.files',$request->jobcode);
   }


   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

   public function delete($projectID,$fileID){
      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/prm/'.Prm::project_info($projectID)->projectID.'/';

      $delete = documents::where('businessID',Auth::user()->businessID)->where('folder','Project')->where('section','Project')->where('id',$fileID)->first();

      //delete document if already exists
      if($delete->file_name != ""){
         $unlink = $directory.$delete->file_name;
         if (File::exists($unlink)) {
            unlink($unlink);
         }
      }
      $delete->delete();

      Session::flash('success','document deleted successfully');

      return redirect()->back();
   }
}
