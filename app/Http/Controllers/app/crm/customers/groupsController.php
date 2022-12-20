<?php
namespace App\Http\Controllers\app\crm\customers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\groups;
use Auth;
use Session;
use Helper;

class groupsController extends Controller
{
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
      $groups = groups::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      return view('app.crm.customers.groups.index', compact('groups'));
   }


   /**
    * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      $this->validate($request,[
         'name' => 'required'
      ]);

      $group = new groups;
      $group->group_code    = Helper::generateRandomString(30);
      $group->name          = $request->name;
      $group->status        = $request->status;
      $group->business_code = Auth::user()->business_code;
      $group->created_by    = Auth::user()->user_code;
      $group->save();

      Session::flash('success','Group added successfully');

      return redirect()->back();

   }

   /**
    * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($code)
   {
      $groups = groups::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      $edit = groups::where('business_code',Auth::user()->business_code)->where('group_code',$code)->first();

      return view('app.crm.customers.groups.edit', compact('groups','edit'));
   }

   /**
    * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $code)
   {
      $this->validate($request,[
         'name' => 'required'
      ]);

      $group = groups::where('business_code',Auth::user()->business_code)->where('group_code',$code)->first();
      $group->name          = $request->name;
      $group->status        = $request->status;
      $group->business_code = Auth::user()->business_code;
      $group->updated_by    = Auth::user()->user_code;
      $group->save();

      Session::flash('success','Group updated successfully');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function delete($code)
   {
      $group = groups::where('business_code',Auth::user()->business_code)->where('group_code',$code)->first();
      $group->delete();

      Session::flash('success','Group successfully deleted');

      return redirect()->route('crm.customers.groups.index');
   }
}
