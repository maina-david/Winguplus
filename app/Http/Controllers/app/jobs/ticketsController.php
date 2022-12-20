<?php

namespace App\Http\Controllers\app\jobs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\project\tickets;
use App\Models\project\project;
use App\Models\project\status;
use App\Models\project\priority;
use App\Models\project\tickets_allocation;
use App\Models\hr\employees;
use App\Models\wingu\file_manager as documents;
use App\Models\project\ticket_comment;
use App\Models\finance\customer\customers;
use Auth;
use Session;
use Prm;
use Wingu;
use Helper;
use File;

class ticketsController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($id)
   {
      $tickets = tickets::where('projectID',$id)->OrderBy('id','DESC')->paginate(10);
      $project = project::join('status','status.id','=','project.statusID')
                        ->where('project.id',$id)
                        ->where('businessID',Auth::user()->businessID)
                        ->select('*','project.id as id')
                        ->first();
      $client = customers::where('businessID','=',Auth::user()->businessID)->where('id',$project->company_id)->first();
      $status = status::pluck('name','id')->prepend('Choose task status');
      $priority = priority::pluck('name','id')->prepend('Choose task priority');
      $employee = employees::where('businessID','=',Auth::user()->businessID)->pluck('names','id');



      return view('app.jobs.tickets.index', compact('tickets','project','employee','priority','status'));
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
      $this->validate($request, array(
         'projectID'         => 'required',
         'name'              => 'required',
      ));

      $ticket = new tickets;
      $ticket->projectID = $request->projectID;
      $ticket->name = $request->name;
      $ticket->statusID = $request->statusID;
      $ticket->priorityID = $request->priorityID;
      $ticket->start_date = $request->start_date;
      $ticket->due_date = $request->due_date;
      $ticket->progress = $request->progress;
      $ticket->description = $request->description;
      $ticket->userID = Auth::user()->id;
      $ticket->businessID = Auth::user()->id;
      $ticket->save();

      /*==== allocate ticket to employee ====*/
      if(!empty($request->employee)){
         for($i=0; $i < count($request->employee); $i++ ) {
            $allocation = new tickets_allocation;
            $allocation->ticketID = $ticket->id;
            $allocation->employeeID = $request->employee[$i];
            $allocation->save();
         }
      }

      /*==== upload attachment ====*/
      if($request->hasFile('attachment')){

         //directory
         $path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/prm/'.Prm::project_info($request->projectID)->projectID.'/';

         if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         //
         $files = $request->file('attachment');

         foreach($files as $file) {

            $size =  $file->getSize();

            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::seoUrl($request->name).'-'.Helper::generateRandomString(). '.' . $extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $upload_success = $file->move($path, $fileName);

            $upload = new documents;
            $upload->parentid  = $request->projectID;
            $upload->sectionID = $ticket->id;
            $upload->folder 	 = 'Project';
            $upload->section 	 = 'Ticket';
            $upload->name 		 = $request->name;
            $upload->file_name = $fileName;
            $upload->status 	 = 'No';
            $upload->file_size = $size;
            $upload->file_mime = $file->getClientMimeType();
            $upload->userID  = Auth::user()->id;
            $upload->businessID  = Auth::user()->businessID;

            $upload->save();
         }
      }

      $projectID = $request->projectID;
      $activity  = '<a href="#">'.Auth::user()->name.'</a> has <b>added</b> a new ticket <a href="#">'.$ticket->name.'</a>';
      $action = 'Add';

      Prm::activity($projectID,$activity,$action);

      Session::flash('success', 'The ticket was added successfully');

      return redirect()->route('project.tickets.index',$request->projectID);
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($projectID,$ticketID)
   {
      $ticket = tickets::join('project_tasks_priority','project_tasks_priority.id','=','project_tickets.priorityID')
               ->where('projectID',$projectID)
               ->where('project_tickets.businessID',Auth::user()->businessID)
               ->where('project_tickets.id',$ticketID)
               ->select('*','project_tickets.id as ticketID','project_tasks_priority.name as priority','project_tickets.name as ticketName')
               ->first();

      $project = project::join('status','status.id','=','project.statusID')
               ->where('project.id',$id)
               ->where('businessID',Auth::user()->businessID)
               ->select('*','project.id as id')
               ->first();
      $comments = ticket_comment::where('projectID',$projectID)->where('ticketID',$ticketID)->orderby('id','desc')->get();
      $documents = documents::where('sectionID',$ticketID)
                  ->where('folder','Project')
                  ->where('section','Ticket')
                  ->where('businessID',Auth::user()->businessID)
                  ->orderby('id','DESC')
                  ->get();

      return view('app.jobs.tickets.show', compact('ticket','project','documents','comments'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($projectID,$ticketID)
   {
      $edit = tickets::where('id',$ticketID)->where('projectID',$projectID)->where('businessID',Auth::user()->businessID)->first();
      $project = project::join('status','status.id','=','project.statusID')
                        ->where('project.id',$projectID)
                        ->where('businessID',Auth::user()->businessID)
                        ->select('*','project.id as id')
                        ->first();
      $status = status::all();
      $priority = priority::all();
      $employee = employees::where('businessID', Auth::user()->businessID)->pluck('names','id');

      //employee
      $employee = employees::where('businessID', Auth::user()->businessID)->get();
      $employeelink = array();

      foreach ($employee as $emp) {
         $employeelink[$emp->id] = $emp->names;
      }

      //chosen employee
      $emps = tickets_allocation::join('hr_employees', 'hr_employees.id', '=' ,'project_ticket_allocation.employeeID')
            ->where('ticketID',$ticketID)
            ->select('hr_employees.id as empID')
            ->get();
      $currentemp= array();
      foreach($emps as $ep){
         $currentemp[] = $ep->empID;
      }

      return view('app.jobs.tickets.edit', compact('edit','project','status','priority','employee','currentemp','employeelink'));
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
      $this->validate($request, array(
         'projectID'         => 'required',
         'name'              => 'required',
      ));

      $ticket = tickets::find($id);
      $ticket->projectID = $request->projectID;
      $ticket->name = $request->name;
      $ticket->statusID = $request->statusID;
      $ticket->start_date = $request->start_date;
      $ticket->due_date = $request->due_date;
      $ticket->progress = $request->progress;
      $ticket->notify_client = $request->notify_client;
      $ticket->userID = Auth::user()->id;
      $ticket->businessID = Auth::user()->businessID;
      $ticket->save();

      /*==== allocate project to emloyee ====*/
      if(!empty($request->employee)){

         //delete the current employee
         $delete = tickets_allocation::where('ticketID',$id)->get();

         foreach($delete as $del){
            $toa = tickets_allocation::where('id',$del->id)->first();
            $toa->delete();
         }

         for($i=0; $i < count($request->employee); $i++ ) {
            $allocation = new tickets_allocation;
            $allocation->ticketID = $ticket->id;
            $allocation->employeeID = $request->employee[$i];
            $allocation->save();
         }
      }

      /*==== upload attachment ====*/
      if($request->hasFile('attachment')){

         //directory
         $path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/prm/'.Prm::project_info($request->projectID)->projectID.'/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         //
         $files = $request->file('attachment');

         foreach($files as $file) {

      		$size =  $file->getSize();

            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::seoUrl($request->name).'-'.Helper::generateRandomString(). '.' . $extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $upload_success = $file->move($path, $fileName);

            $upload = new documents;
            $upload->parentid  = $request->projectID;
            $upload->sectionID = $ticket->id;
            $upload->folder 	 = 'Project';
            $upload->section 	 = 'Task';
      		$upload->name 		 = $request->name;
      		$upload->file_name = $fileName;
      		$upload->status 	 = 'No';
      		$upload->file_size = $size;
            $upload->file_mime = $file->getClientMimeType();
      		$upload->userID  = Auth::user()->id;
      		$upload->businessID  = Auth::user()->businessID;

            $upload->save();
         }
      }

      $projectID = $request->projectID;
      $activity  = '<a href="#">'.Auth::user()->name.'</a> has made an <b>update</b> on <a href="#">'.$ticket->name.'</a> task';
      $action = 'Updated';

      Prm::activity($projectID,$activity,$action);

      Session::flash('success', 'The task was updated successfully');

      return redirect()->back();
   }



   /**
    * ticket comment.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
   */
   public function comment(Request $request){
      $this->validate($request,[
         'comment' => 'required',
         'projectID' => 'required',
      ]);

      $comment = new ticket_comment;
      $comment->comment = $request->comment;
      $comment->projectID = $request->projectID;
      $comment->ticketID = $request->taskID;
      $comment->userID = Auth::user()->id;
      $comment->businessID = Auth::user()->businessID;
      $comment->save();

      /*==== upload attachment ====*/
      if($request->hasFile('attachment')){

         //directory
         $path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/prm/'.Prm::project_info($request->projectID)->projectID.'/';

			if (!file_exists($path)) {
            mkdir($path, 0777,true);
         }

         //
         $files = $request->file('attachment');

         foreach($files as $file) {

      		$size =  $file->getSize();

            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::seoUrl('comment files').'-'.Helper::generateRandomString(). '.' . $extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $upload_success = $file->move($path, $fileName);

            $upload = new documents;
            $upload->parentid  = $request->projectID;
            $upload->sectionID = $comment->id;
            $upload->folder 	 = 'Project';
            $upload->section 	 = 'Ticket';
      		$upload->name 		 = 'comment files';
      		$upload->file_name = $fileName;
      		$upload->status 	 = 'No';
      		$upload->file_size = $size;
            $upload->file_mime = $file->getClientMimeType();
      		$upload->userID  = Auth::user()->id;
      		$upload->businessID  = Auth::user()->businessID;

            $upload->save();
         }
      }

      $projectID = $request->projectID;
      $activity  = '<a href="#">'.Auth::user()->name.'</a> has made a <b>comment to the project</b>';
      $action = 'Add';

      Prm::activity($projectID,$activity,$action);

      //send notification to project leaders


      Session::flash('success', 'comment successful');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($projectID, $id)
   {
      $delete = tickets::find($id);
      $delete->delete();

      Session::flash('success','the ticket was deleted successfully');

      return redirect()->back();
   }

   /**
    * Delete files
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete_file($pid,$id)
   {
      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/prm/'.Prm::project_info($pid)->projectID.'/';
      $delete = documents::where('businessID',Auth::user()->businessID)->where('folder','Project')->where('section','Ticket')->where('id',$id)->first();

      //delete document if already exists
		if($delete->file_name != ""){
			$unlink = $directory.$delete->file_name;
			if (File::exists($unlink)) {
				unlink($unlink);
			}
		}
      $delete->delete();

      Session::flash('success','document deleted successfully');

      return redirect()->back();
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function delete_comment($id)
   {
      $comment = ticket_comment::where('id',$id)->where('businessID',Auth::user()->businessID)->first();

      $comment->delete();

      Session::flash('success','comment deleted successfully');

      return redirect()->back();
   }
}
