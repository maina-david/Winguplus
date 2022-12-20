<?php

namespace App\Http\Controllers\app\crm\leads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\crm\leads\sources;
use Auth;
use Session;
use Helper;

class sourcesController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $sources = sources::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('app.crm.settings.leads.settings', compact('sources'));
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

      $source = new sources;
      $source->source_code   = Helper::generateRandomString(30);
      $source->name          = $request->name;
      $source->business_code = Auth::user()->business_code;
      $source->created_by    = Auth::user()->user_code;
      $source->save();

      Session::flash('success','source created successfully');

      return redirect()->back();
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

      $source = sources::where('source_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $source->name          = $request->name;
      $source->updated_by    = Auth::user()->user_code;
      $source->save();

      Session::flash('success','source update successfully');

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
      sources::where('source_code',$code)->where('business_code',Auth::user()->business_code)->delete();

      Session::flash('success','source deleted successfully');

      return redirect()->back();
   }
}
