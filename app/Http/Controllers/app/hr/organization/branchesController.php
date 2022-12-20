<?php

namespace App\Http\Controllers\app\hr\organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\product_price;
use App\Models\hr\branches;
use App\Models\wingu\country;
use Auth;
use Session;
use Helper;

class branchesController extends Controller
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
      $branches = branches::where('business_code',Auth::user()->business_code)
                           ->orderby('hr_branches.id','desc')
                           ->get();
      return view('app.hr.organization.branches.index', compact('branches'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $country = country::pluck('name','name')->prepend('Choose country','');

      return view('app.hr.organization.branches.create', compact('country'));
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
         'name' => 'required',
         'phone_number' => 'required',
      ]);


      //check if is main branch
      if($request->is_main == 'Yes'){
         branches::where('business_code',Auth::user()->business_code)
                  ->where('is_main','Yes')
                  ->update(['is_main' => 'No']);
      }


      $branches = new branches;
      $branches->branch_code = Helper::generateRandomString(30);
      $branches->name = $request->name;
      $branches->country = $request->country;
      $branches->city = $request->city;
      $branches->address = $request->address;
      $branches->phone_number = $request->phone_number;
      $branches->email = $request->email;
      $branches->is_main = $request->is_main;
      $branches->business_code = Auth::user()->business_code;
      $branches->created_by = Auth::user()->user_code;
      $branches->save();

      //check if the account has a main branch, if it doesnt make the updated or added branch as main, this is usefull on the p.o.s inventroy section and item price section
      $checkMainBranch = branches::where('business_code',Auth::user()->business_code)->where('is_main','Yes')->count();
      if($checkMainBranch == 0){
         //make the new branch main
         $update = branches::where('business_code',Auth::user()->business_code)->where('branch_code',$branches->branch_code)->first();
         $update->is_main = 'Yes';
         $update->save();
      }

      Session::flash('success','branch successfully added');

      return redirect()->route('hrm.branches');
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
      $country = country::pluck('name','name')->prepend('Choose country','');
      $edit = branches::where('business_code',Auth::user()->business_code)->where('branch_code',$code)->first();
      return view('app.hr.organization.branches.edit', compact('country','edit'));
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

      $this->validate($request, [
         'name' => 'required',
      ]);

      if($request->is_main == 'Yes'){
         branches::where('business_code',Auth::user()->business_code)
                  ->where('is_main','Yes')
                  ->update(['is_main' => 'No']);
      }

      $branches = branches::where('business_code',Auth::user()->business_code)->where('branch_code',$code)->first();
      $branches->name = $request->name;
      $branches->country = $request->country;
      $branches->city = $request->city;
      $branches->address = $request->address;
      $branches->phone_number = $request->phone_number;
      $branches->is_main = $request->is_main;
      $branches->email = $request->email;
      $branches->business_code = Auth::user()->business_code;
      $branches->updated_by = Auth::user()->user_code;
      $branches->save();

      //check if the account has a main branch, if it doesnt make the updated or added branch as main, this is usefull on the p.o.s inventroy section and item price section
      $checkMainBranch = branches::where('business_code',Auth::user()->business_code)->where('is_main','Yes')->count();
      if($checkMainBranch == 0){
         //make the new branch main
         $update = branches::where('business_code',Auth::user()->business_code)->where('branch_code',$branches->branch_code)->first();
         $update->is_main = 'Yes';
         $update->save();
      }

      Session::flash('success','branch successfully updated');

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
      //check if is linked to product inventory
      $checkInventryLink = product_inventory::where('branch_code',$code)->where('business_code',Auth::user()->business_code)->count();
      $checkPriceLink = product_price::where('branch_code',$code)->where('business_code',Auth::user()->business_code)->count();
      if($checkInventryLink == 0 && $checkPriceLink == 0){
         //delete branch
         $branches = branches::where('business_code',Auth::user()->business_code)->where('branch_code',$code)->first();
         $branches->delete();

         Session::flash('success','branch successfully updated');

         return redirect()->route('hrm.branches');
      }else{

         Session::flash('warning','This branch has inventory linked to it');

         return redirect()->back();
      }

   }
}
