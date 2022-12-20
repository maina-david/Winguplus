<?php
namespace App\Http\Controllers\app\crm\customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\customer\call_logs;
use App\Models\wingu\country;
use App\Models\crm\leads\status;
use Auth;
use Session;

class calllogController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * call_log
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

      $logs = call_logs::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->orderby('id','desc')->paginate(4);
      $status = status::where('business_code',Auth::user()->business_code)->pluck('name','id')->prepend('Choose status', '');

      return view('app.crm.customers.view', compact('client','code','logs','status','contacts'));
   }


   /**
   * store call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request){

      $this->validate($request,[
         'note' => 'required',
         'phone_number' => 'required',
         'contact_person' => 'required',
         'minutes' => 'required',
         'seconds' => 'required',
         'call_type' => 'required',
         'customerID' => 'required',
      ]);

      $calllog = new call_logs;
      $calllog->subject = $request->subject;
      $calllog->note = $request->note;
      $calllog->customerID = $request->customerID;
      $calllog->phone_number = $request->phone_number;
      $calllog->contact_person = $request->contact_person;
      $calllog->hours = $request->hours;
      $calllog->minutes = $request->minutes;
      $calllog->seconds = $request->seconds;
      $calllog->call_type = $request->call_type;
      $calllog->statusID = $request->statusID;
      $calllog->created_by = Auth::user()->id;
      $calllog->business_code = Auth::user()->business_code;
      $calllog->save();

      Session::flash('success','call log successfully added');

      return redirect()->back();
   }


   /**
   * update call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id){

      $this->validate($request,[
         'note' => 'required',
         'phone_number' => 'required',
         'contact_person' => 'required',
         'minutes' => 'required',
         'seconds' => 'required',
         'call_type' => 'required',
         'customerID' => 'required',
      ]);

      $calllog = call_logs::where('business_code',Auth::user()->business_code)->where('id',$id)->first();
      $calllog->subject = $request->subject;
      $calllog->note = $request->note;
      $calllog->customerID = $request->customerID;
      $calllog->phone_number = $request->phone_number;
      $calllog->contact_person = $request->contact_person;
      $calllog->hours = $request->hours;
      $calllog->minutes = $request->minutes;
      $calllog->seconds = $request->seconds;
      $calllog->call_type = $request->call_type;
      $calllog->statusID = $request->statusID;
      $calllog->updated_by = Auth::user()->id;
      $calllog->business_code = Auth::user()->business_code;
      $calllog->save();

      Session::flash('success','call log successfully updated');

      return redirect()->back();
   }

   public function delete($id){
      call_logs::where('business_code',Auth::user()->business_code)->where('id',$id)->delete();

      Session::flash('success','call log is successfully delete');

      return redirect()->back();
   }
}
