<?php

namespace App\Http\Controllers\app\crm\customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\customer\notes;
use App\Models\wingu\country;
use App\Models\crm\leads\status;
use Auth;
use Session;

class notesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }


   /**
   * notes
   *
   * @return \Illuminate\Http\Response
   */
   public function index($code){
		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
                        ->join('wp_business','wp_business.business_code','=','fn_customers.business_code')
                        ->where('fn_customers.customer_code',$code)
                        ->where('fn_customers.business_code',Auth::user()->business_code)
                        ->first();

      //contacts
      $contacts = contact_persons::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->get();

      $notes = notes::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->orderby('id','desc')->paginate(6);

      $status = status::where('business_code',Auth::user()->business_code)->pluck('name','id')->prepend('Choose status', '');

      return view('app.crm.customers.view', compact('client','code','notes','status','contacts'));
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
         'customer_code' => 'required',
      ]);

      $note = new notes;
      $note->subject = $request->subject;
      $note->note = $request->note;
      $note->customer_code = $request->customer_code;
      $note->created_by = Auth::user()->id;
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
   public function update(Request $request, $id){
      $this->validate($request,[
         'note' => 'required',
         'customer_code' => 'required',
      ]);

      $note = notes::where('business_code',Auth::user()->business_code)->where('id',$id)->first();
      $note->subject    = $request->subject;
      $note->note       = $request->note;
      $note->customer_code = $request->customer_code;
      $note->updated_by = Auth::user()->id;
      $note->business_code = Auth::user()->business_code;
      $note->save();

      Session::flash('success','Note successfully updated');

      return redirect()->back();
   }

   /**
   * delete note
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($id){
      notes::where('business_code',Auth::user()->business_code)->where('id',$id)->delete();
      Session::flash('success','Note successfully deleted');
      return redirect()->back();
   }
}
