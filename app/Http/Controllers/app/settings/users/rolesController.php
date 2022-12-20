<?php
namespace App\Http\Controllers\app\settings\users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\permission_role;
use App\Models\wingu\business_modules;
use App\Models\wingu\modules;
use App\Models\wingu\roles;
use Session;
use Helper;
use Auth;
use DB;

class rolesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function index(){
      $roles = roles::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();
      return view('app.settings.roles.index', compact('roles'));
   }


   public function create(){
      $modules = business_modules::join('wp_modules','wp_modules.module_code','=','wp_business_modules.module_code')
                        ->where('wp_business_modules.business_code',Auth::user()->business_code)
                        ->where('wp_business_modules.status',15)
                        ->select('*','wp_modules.module_code as moduleCode')
                        ->get();

      return view('app.settings.roles.create', compact('modules'));
   }

   public function store(Request $request){

      $this->validate($request, [
         'display_name' => 'required|max:255',
         'description' => 'sometimes|max:255',
      ]);

      $role = new roles;
      $role->display_name = $request->display_name;
      $role->role_code = Helper::generateRandomString(30);
      $role->name = Helper::seoUrl($request->display_name);
      $role->description = $request->description;
      $role->business_code = Auth::user()->business_code;
      $role->created_by = Auth::user()->user_code;
      $role->updated_by = Auth::user()->user_code;
      $role->save();

      $permission = count(collect($request->permissions));
      if($permission > 0){
         //upload new category
         for($i=0; $i < count($request->permissions); $i++){
            $permission = new permission_role;
            $permission->permission_code = $request->permissions[$i];
            $permission->role_code       = $role->role_code;
            $permission->business_code   = Auth::user()->business_code;
            $permission->updated_by      = Auth::user()->user_code;
            $permission->save();
         }
      }

      Session::flash('success', 'Role successfully added.');

      return redirect()->route('settings.roles.index');
   }

   public function edit($code){
      $role = roles::where('role_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $modules = modules::where('status',15)->get();

      return view('app.settings.roles.edit', compact('role','modules'));
   }

   public function update(Request $request, $code){
      $this->validate($request, [
         'display_name' => 'required|max:255',
         'description' => 'sometimes|max:255'
      ]);

      $role = roles::where('role_code',$code)->first();
      $role->name = Helper::seoUrl($request->display_name);
      $role->display_name = $request->display_name;
      $role->description = $request->description;
      $role->updated_by = Auth::user()->user_code;
      $role->save();

      $permission = count(collect($request->permissions));
      DB::table('wp_permission_role')->where('role_code',$code)->where('business_code',Auth::user()->business_code)->delete();
      if($permission > 0){
         //upload new category
         for($i=0; $i < count($request->permissions); $i++){
            $permission = new permission_role;
            $permission->permission_code = $request->permissions[$i];
            $permission->role_code = $code;
            $permission->business_code = Auth::user()->business_code;
            $permission->updated_by = Auth::user()->user_code;
            $permission->save();
         }
      }

      Session::flash('success', 'Role successfully updated');

      return redirect()->back();
   }

   public function show($code){
      $role = roles::where('role_code', $code)->where('business_code',Auth::user()->business_code)->first();
      return view('app.settings.roles.show', compact('role'));
   }

   public function delete($code){
      DB::table('permission_role')->where('role_id',$id)->where('business_code',Auth::user()->business_code)->delete();

      roles::where('role_code',$code)->where('business_code',Auth::user()->business_code)->delete();

      Session::flash('success','Role successfully deleted');

      return redirect()->back();
   }
}
