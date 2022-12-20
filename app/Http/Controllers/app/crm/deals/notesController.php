<?php

namespace App\Http\Controllers\app\crm\deals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\crm\deals\stages;
use App\Models\crm\deals\deals;
use App\Models\crm\notes;
use App\Models\finance\customer\customers;
use App\Models\wingu\wp_user;
use Auth;
use Session;
use Helper;

class notesController extends Controller
{

   public function __construct(){
      $this->middleware('auth');
   }

   //index
   public function index($code){
      $deal = deals::join('wp_business','wp_business.business_code','=','crm_deals.business_code')
                     ->where('crm_deals.deal_code',$code)
                     ->where('crm_deals.business_code',Auth::user()->business_code)
                     ->orderby('crm_deals.id','desc')
                     ->select('*','crm_deals.created_at as create_date')
                     ->first();

      $stages = stages::where('pipeline_code',$deal->pipeline)->where('business_code',Auth::user()->business_code)->orderby('position','asc')->get();
      $notes = notes::where('parent_code',$code)->where('business_code',Auth::user()->business_code)->where('section','Deal')->orderby('id','desc')->get();
      $customer = customers::where('business_code',Auth::user()->business_code)->where('customer_code',$deal->contact)->first();
      $owner = wp_user::where('business_code',Auth::user()->business_code)->where('user_code',$deal->owner)->first();

      return view('app.crm.deals.deal.show', compact('deal','stages','notes','owner','customer'));
   }

   /**
   * store call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request, $code){
      $this->validate($request,[
         'subject' => 'required',
         'deal_note' => 'required',
      ]);

      $notes = new notes;
      $notes->note_code     = Helper::generateRandomString(30);
      $notes->subject       = $request->subject;
      $notes->note          = $request->deal_note;
      $notes->parent_code   = $code;
      $notes->created_by    = Auth::user()->user_code;
      $notes->business_code = Auth::user()->business_code;
      $notes->section       = 'Deal';
      $notes->save();

      Session::flash('success','Note successfully added');

      return redirect()->back();
   }


   /**
   * update call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $code){
      $this->validate($request,[
         'subject' => 'required',
         'deal_note' => 'required',
         'parent_code' => 'required',
      ]);

      $notes = notes::where('business_code',Auth::user()->business_code)->where('note_code',$code)->first();
      $notes->subject       = $request->subject;
      $notes->note          = $request->deal_note;
      $notes->parent_code   = $request->parent_code;
      $notes->updated_by    = Auth::user()->user_code;
      $notes->business_code = Auth::user()->business_code;
      $notes->section       = 'Deal';
      $notes->save();

      Session::flash('success','Note successfully updated');

      return redirect()->back();
   }

   /**
   * delete
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($code){
      notes::where('business_code',Auth::user()->business_code)->where('section','Deal')->where('note_code',$code)->delete();

      Session::flash('success','Call successfully deleted');

      return redirect()->back();
   }

}
