<?php

namespace App\Http\Controllers\app\jobs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\jobs\jobs;
use App\Models\jobs\notes;
use Auth;
use Session;

class notesController extends Controller
{
   /**
    * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($code)
   {
      return view('app.jobs.notes.index', compact('code'));
   }


   /**
    * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($code,$noteCode)
   {
      $edit = notes::where('note_code',$noteCode)
                     ->where('job',$code)
                     ->where('business_code',Auth::user()->business_code)
                     ->first();

      return view('app.jobs.notes.edit', compact('code','edit'));
   }

   /**
    * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request,$code,$noteCode)
   {
      $this->validate($request, [
         'title' => 'required',
         'content' => 'required',
      ]);

      $note = notes::where('note_code',$noteCode)
                  ->where('job',$code)
                  ->where('business_code',Auth::user()->business_code)
                  ->first();

      $note->title = $request->title;
      $note->content = $request->content;
      $note->brief = $request->brief;
      $note->status = $request->status;
      $note->label = $request->label;
      $note->updated_by = Auth::user()->user_code;
      $note->save();

      Session::flash('success', 'Note successfully updated');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function delete($pid,$id)
   {
      $note = notes::where('id',$id)->where('projectID',$pid)->where('business_code',Auth::user()->business_code)->first();
      $note->delete();

      Session::flash('success', 'Note successfully deleted');

      return redirect()->back();
   }
}
