<?php
namespace App\Http\Controllers\app\finance\contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\groups;
use Auth;
use Session;

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
      return view('app.finance.contacts.groups.index');
   }
}
