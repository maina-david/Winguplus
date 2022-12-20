<?php

namespace App\Http\Controllers\app\crm\leads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\crm\leads\status;
use Auth;
use Session;
use Helper;

class statusController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $statuses = status::where('business_code',Auth::user()->business_code)->get();

      return view('app.crm.settings.leads.settings', compact('statuses'));
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

      $status = new status;
      $status->status_code = Helper::generateRandomString(30);
      $status->name= $request->name;
      $status->business_code = Auth::user()->business_code;
      $status->created_by = Auth::user()->user_code;
      $status->description= $request->description;
      $status->save();

      Session::flash('success','status created successfully');

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
   public function edit($code)
   {
      $statuses = status::where('business_code',Auth::user()->business_code)->get();
      $edit = status::where('status_code',$code)->where('business_code',Auth::user()->business_code)->first();

      return view('app.crm.settings.leads.status.edit', compact('statuses','edit','count'));
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

      $status = status::where('status_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $status->name          = $request->name;
      $status->business_code = Auth::user()->business_code;
      $status->updated_by    = Auth::user()->user_code;
      $status->description   = $request->description;
      $status->save();

      Session::flash('success','status update successfully');

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
      status::where('status_code',$code)->where('business_code',Auth::user()->business_code)->delete();

      Session::flash('success','status deleted successfully');

      return redirect()->back();
   }
}
