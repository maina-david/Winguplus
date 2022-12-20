<?php

namespace App\Http\Controllers\app\crm\customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\comments;
use App\Models\finance\customer\contact_persons;
use Session;
use Helper;
use Auth;

class commentsController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($code)
   {
		$client = customers::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
					->join('wp_business','wp_business.business_code','=','fn_customers.business_code')
					->where('fn_customers.customer_code',$code)
					->where('fn_customers.business_code',Auth::user()->business_code)
               ->first();

      //contacts
		$contacts = contact_persons::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->get();

      $comments = comments::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->orderby('id','desc')->get();

      return view('app.crm.customers.view', compact('client','code','comments','contacts'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $this->validate($request, [
			'comment' => 'required',
		]);

		$comment = new comments;
      $comment->comment_code = Helper::generateRandomString(30);
		$comment->comment = $request->comment;
		$comment->created_by = Auth::user()->user_code;
		$comment->customer_code = $request->customer;
		$comment->business_code = Auth::user()->business_code;
		$comment->save();

		Session::flash('success', 'comment added');

		return redirect()->back();
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
   public function edit($id)
   {
      //
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
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($code)
   {
      comments::where('comment_code',$code)->where('business_code',Auth::user()->business_code)->delete();

		Session::flash('success', 'comment deleted');

		return redirect()->back();
   }
}
