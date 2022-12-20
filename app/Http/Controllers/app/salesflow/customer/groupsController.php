<?php
namespace App\Http\Controllers\app\salesflow\customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
      return view('app.salesflow.customers.groups');
   }
}
