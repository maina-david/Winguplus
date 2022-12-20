<?php

namespace App\Http\Controllers\app\hr\recruitment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hr\department;
use App\Models\hr\branches;
use App\Models\hr\recruitment_jobs;
use App\Models\wingujobs\wingujobs_listing;
use App\Models\wingujobs\applications;
use App\Models\wingu\country;
use App\Models\wingu\wp_user;
use Auth;
use Helper;
use Session;

class jobsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * All Jobs
   * */
   public function index(){
      $jobs = recruitment_jobs::join('wp_status','wp_status.id','=','hr_recruitment_jobs.status')
                        ->where('business_code',Auth::user()->business_code)
                        ->select('*','hr_recruitment_jobs.created_at as job_date')
                        ->orderby('hr_recruitment_jobs.id','desc')
                        ->get();
      $count = 1;

      return view('app.hr.recruitment.jobs.index', compact('count','jobs'));
   }

   //create
   public function create(){
      $users = wp_user::where('business_code',Auth::user()->business_code)->pluck('name','user_code')->prepend('Choose Lead','');
      $departments = department::where('business_code',Auth::user()->business_code)->pluck('title','department_code')->prepend('Choose department');
      $branches = branches::where('business_code',Auth::user()->business_code)->pluck('name','branch_code')->prepend('Choose branch','');
      $country = country::OrderBy('id','DESC')->pluck('name','name')->prepend('Choose country','');

      return view('app.hr.recruitment.jobs.create', compact('users','departments','branches','country'));
   }

   //save job
   public function store(Request $request){
      $this->validate($request,[
         'title' => 'required',
         'status' => 'required',
         'contract_type' => 'required',
         'experience' => 'required',
         'location' => 'required',
         'country' => 'required',
         'job_description' => 'required',
      ]);

      $code =  Helper::generateRandomString(30);

      $jobs = new recruitment_jobs;
      $jobs->business_code   = Auth::user()->business_code;
      $jobs->code            = $code;
      $jobs->title           = $request->title;
      $jobs->status          = $request->status;
      $jobs->contract_type   = $request->contract_type;
      $jobs->hiring_lead     = $request->hiring_lead;
      $jobs->department      = $request->department;
      $jobs->experience      = $request->experience;
      $jobs->headcount       = $request->headcount;
      $jobs->min_salary      = $request->min_salary;
      $jobs->max_salary      = $request->max_salary;
      $jobs->location        = $request->location;
      $jobs->country         = $request->country;
      $jobs->listed          = $request->listed;
      $jobs->start_date      = $request->start_date;
      $jobs->end_date        = $request->end_date;
      $jobs->job_description = $request->job_description;
      $jobs->listed          = $request->listed;
      $jobs->created_by      = Auth::user()->user_code;
      $jobs->updated_by      = Auth::user()->user_code;
      $jobs->save();

      if($request->listed == 'Yes'){
         $listingCode = Helper::generateRandomString(30);

         $list = new wingujobs_listing;
         $list->job_code      = $code;
         $list->start_date    = $request->start_date;
         $list->closing_date  = $request->end_date;
         $list->business_code = Auth::user()->user_code;
         $list->code          = $listingCode;
         $list->save();

         //updated job
         $jobs = recruitment_jobs::where('code',$code)->where('business_code',Auth::user()->business_code)->first();
         $jobs->listing_code = $listingCode;
         $jobs->save();
      }

      Session::flash('success','Job successfully added');

      return redirect()->route('hrm.recruitment.jobs');
   }

   /**
   * Edit job
   * */
   public function edit($code){
      $users = wp_user::where('business_code',Auth::user()->business_code)->pluck('name','user_code')->prepend('Choose Lead','');
      $departments = department::where('business_code',Auth::user()->business_code)->pluck('title','department_code')->prepend('Choose department');
      $branches = branches::where('business_code',Auth::user()->business_code)->pluck('name','branch_code')->prepend('Choose branch','');
      $country = country::OrderBy('id','DESC')->pluck('name','name')->prepend('Choose country','');

      $edit = recruitment_jobs::where('code',$code)->where('business_code',Auth::user()->business_code)->first();

      return view('app.hr.recruitment.jobs.edit', compact('users','departments','branches','country','edit'));
   }


   /**
   * update job
   * */
   public function update(Request $request, $code){
      $this->validate($request,[
         'title' => 'required',
         'status' => 'required',
         'contract_type' => 'required',
         'experience' => 'required',
         'location' => 'required',
         'country' => 'required',
         'job_description' => 'required',
      ]);

      $edit = recruitment_jobs::where('code',$code)->where('business_code',Auth::user()->business_code)->first();

      if($edit->listed != 'Yes' && $request->listed == 'Yes'){
         if(!$edit->listing_code){
            $listingCode = Helper::generateRandomString(30);

            $list = new wingujobs_listing;
            $list->job_code      = $code;
            $list->start_date    = $request->start_date;
            $list->closing_date  = $request->end_date;
            $list->business_code = Auth::user()->business_code;
            $list->code          = $listingCode;
            $list->save();

            //updated job
            $jobs = recruitment_jobs::where('code',$code)->where('business_code',Auth::user()->business_code)->first();
            $jobs->listing_code = $listingCode;
            $jobs->save();
         }
      }

      $edit->business_code = Auth::user()->business_code;
      $edit->title = $request->title;
      $edit->status = $request->status;
      $edit->contract_type = $request->contract_type;
      $edit->hiring_lead = $request->hiring_lead;
      $edit->department = $request->department;
      $edit->experience = $request->experience;
      $edit->headcount = $request->headcount;
      $edit->min_salary = $request->min_salary;
      $edit->max_salary = $request->max_salary;
      $edit->location = $request->location;
      $edit->country = $request->country;
      $edit->listed = $request->listed;
      $edit->start_date = $request->start_date;
      $edit->end_date = $request->end_date;
      $edit->job_description = $request->job_description;
      $edit->updated_by = Auth::user()->user_code;
      $edit->save();

      if($request->listed == 'Yes'){
         $list =  wingujobs_listing::where('job_code',$code)->where('business_code',Auth::user()->business_code)->first();
         $list->start_date    = $request->start_date;
         $list->closing_date  = $request->end_date;
         $list->updated_by    = Auth::user()->user_code;
         $list->save();
      }

      Session::flash('success','Job successfully updated');

      return redirect()->back();
   }

   /**
   * update job
   * */
   public function show($code){
      $job = recruitment_jobs::where('code',$code)->where('business_code',Auth::user()->business_code)->first();
      $applications = applications::join('wingujob_users','wingujob_users.id','=','wingujobs_applications.user_code')
                                 ->where('job_code',$code)
                                 ->orderby('wingujobs_applications.id','asc')
                                 ->select('*','wingujobs_applications.location as location','wingujobs_applications.name as name','wingujobs_applications.phone_number as phone_number')
                                 ->get();

      return view('app.hr.recruitment.jobs.show', compact('job','applications'));
   }
}
