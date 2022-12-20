<?php

namespace App\Http\Controllers\app\crm\leads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\notes;
use App\Models\wingu\country;
use App\Models\crm\leads\status;
use Auth;
use Helper;
use Session;

class notesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }


   /**
   * view note
   *
   * @return \Illuminate\Http\Response
   */
   public function notes($code){
      $notes = notes::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->orderby('id','desc')->get();
      $lead = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->where('category','Lead')->first();
      $phoneCode = country::pluck('phonecode','id')->prepend('Choose phone code', '');
      $status = status::where('business_code',Auth::user()->business_code)->pluck('name','id')->prepend('Choose status', '');

      return view('app.crm.leads.show', compact('lead','code','notes','phoneCode','status'));
   }

   /**
   * store note
   *
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request){
      $this->validate($request,[
         'subject' => 'required',
         'note' => 'required',
      ]);

      $note = new notes;
      $note->note_code     = Helper::generateRandomString(30);
      $note->subject       = $request->subject;
      $note->note          = $request->note;
      $note->customer_code = $request->customer_code;
      $note->created_by    = Auth::user()->user_code;
      $note->business_code = Auth::user()->business_code;
      $note->save();

      Session::flash('success','Note successfully added');

      return redirect()->back();
   }

   /**
   * update note
   *
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $code){
      $this->validate($request,[
         'note' => 'required',
      ]);

      $note = notes::where('business_code',Auth::user()->business_code)->where('note_code',$code)->first();
      $note->subject        = $request->subject;
      $note->note           = $request->note;
      $note->updated_by     = Auth::user()->user_code;
      $note->business_code  = Auth::user()->business_code;
      $note->save();

      Session::flash('success','Note successfully updated');

      return redirect()->back();
   }

   /**
   * delete note
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($code){
      notes::where('business_code',Auth::user()->business_code)->where('note_code',$code)->delete();
      Session::flash('success','Note successfully deleted');
      return redirect()->back();
   }






}
