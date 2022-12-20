<?php

namespace App\Http\Controllers\app\jobs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\jobs\comments;
use App\Models\wingu\file_manager;
use Helper;
use Auth;
use Session;
use Wingu;

class discussionsController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($code)
   {
      return view('app.jobs.job.discussions', compact('code'));
   }


   /**
   * Store a newly created comment linked to job
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request){
      $this->validate($request, [
         'comment' => 'required',
      ]);

      $comment = new comments;
      $code = Helper::generateRandomString(20);
      $comment->comment_code  = $code;
      $comment->job           = $request->jobCode;
      $comment->comment       = $request->comment;
      $comment->created_by    = Auth::user()->user_code;
      $comment->business_code = Auth::user()->business_code;
      $comment->save();

      if($request->file_title){
         $filetitle = $request->file_title;
      }else{
         $filetitle = 'Discussion files';
      }

      /*==== upload attachment ====*/
      if($request->comment_files){
         //directory
         $path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/jobs/'.$request->jobCode.'/';
         if(!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         //
         $documents = $request->comment_files;

         foreach($documents as $doc) {
            $size =  $doc->getSize();

            // GET THE FILE EXTENSION
            $extension = $doc->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(20).'.'.$extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $doc->move($path, $fileName);

            $upload = new file_manager;
            $upload->file_code     = $request->jobCode;
            $upload->folder 	     = 'Jobs';
            $upload->section 	     = 'Discussion';
            $upload->name 		     = $filetitle;
            $upload->file_name     = $fileName;
            $upload->file_size     = $size;
            $upload->file_mime     = $doc->getClientMimeType();
            $upload->created_by    = Auth::user()->user_code;
            $upload->business_code = Auth::user()->business_code;
            $upload->save();
         }
      }

      //recored activity
      $activity     = '<a href="#">'.Auth::user()->name.'</a> has add a comment to his allocated job.';
      $module       = 'Jobs Management';
      $section      = 'Task comments';
      $action       = 'Create';
      $activityCode = $code;

      Wingu::activity($activity,$module,$section,$action,$activityCode);

      Session::flash('success','Comment added successfully');

      return redirect()->back();
   }


   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function delete($projectCode,$code)
   {
      $delete = comments::where('comment_code',$code)->where('business_code',Auth::user()->business_code)->first();

      //files
      $files = file_manager::where('file_code',$delete->comment_code)->where('business_code',Auth::user()->business_code)->get();
      foreach($files as $file){
         $doc = file_manager::where('id',$file->id)->where('business_code',Auth::user()->business_code)->first();
         $directory = base_path().'/public/businesses/'.Wingu::business()->business_code.'/prm/'.$projectCode.'/';
         $unlink = $directory.$doc->file_name;
         unlink($unlink);
      }
      $delete->delete();

      Session::flash('success','comment deleted successfully');

      return redirect()->back();
   }
}
