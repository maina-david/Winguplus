<?php

namespace App\Http\Controllers\app\hr\organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\position;
use Auth;
use Limitless;
use Helper;
use Session;
class positionsController extends Controller
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
      $titles = position::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      $count = 1;
      return view('app.hr.organization.positions.index', compact('count','titles'));
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
      $this->validate($request,[
         'name' => 'required',
      ]);

      $title = new position;
      $title->business_code = Auth::user()->business_code;
      $title->position_code = Helper::generateRandomString(20);
      $title->name = $request->name;
      $title->description = $request->description;
      $title->created_by = Auth::user()->user_code;
      $title->save();

      Session::flash('success','Job title added successfully');

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
      $edit = position::where('position_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $titles = position::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      $count = 1;

      return view('app.hr.organization.positions.edit', compact('count','titles','edit'));
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
         'name' => 'required',
      ]);

      $title = position::where('position_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $title->name = $request->name;
      $title->description = $request->description;
      $title->business_code = Auth::user()->business_code;
      $title->updated_by = Auth::user()->user_code;
      $title->save();

      Session::flash('success','Job title updated successfully');

      return redirect()->back();
   }

    /**
        * Remove the specified resource from storage.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
    public function destroy($code)
    {
        $title = position::where('position_code',$code)->where('business_code',Auth::user()->business_code)->first();
        $title->delete();

        Session::flash('success','Job title deleted successfully');

        return redirect()->route('hrm.positions');
    }
}
