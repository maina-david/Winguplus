<div>
   <div class="panel mb-3">
      <div class="panel-body">
         <!--begin::Details-->
         <div class="row">
            <!--begin::Image-->
            <div class="col-md-6 mb-4">
               <div class="row">
                  <div class="col-md-3">
                     @if($job->image)
                        <img src="{!! asset('businesses/'.Auth::user()->business_code.'/jobs/'.$job->job_code.'/images/'.$job->image) !!}" alt="{!! $job->job_title !!}" class="img-responsive">
                     @else
                        <img src="https://ui-avatars.com/api/?name={!! $job->job_title !!}&rounded=false&size=120" alt="{!! $job->job_title !!}" class="img-responsive">
                     @endif
                  </div>
                  <div class="col-md-9">
                     <h4 class="">{!! $job->job_title !!}</h4>

                     @if($job->job_type != 'Internal')
                        @if($client)
                           <h5>
                              <b><i class="fal fa-user"></i> Client:</b> {!! $client->email !!}<br>
                              <b><i class="fal fa-phone-alt"></i> Phone Number:</b> <a href="tel:{!! $client->primary_phone_number !!}">{!! $client->primary_phone_number !!}</a><br>
                              <b><i class="fal fa-at"></i> Email:</b> <a href="mailto:{!! $client->email !!}">{!! $client->email !!}</a><br>
                              <b><i class="fal fa-globe"></i> Website:</b> <a href="{!! $client->website !!}" target="_blank">{!! $client->website !!}</a><br>
                           </h5>
                        @endif
                     @endif
                     @if($job->job_type == 'Internal')
                        <h5>{!! Wingu::business()->name !!}</h5>
                     @endif
                     <h5> Job Status :
                        <span class="badge {!! $job->name !!}">{!! $job->name !!}</span>
                     </h5>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="row">
                  <div class="col-md-12 mb-4">
                     <a class="btn btn-grey float-right text-white ml-2" data-toggle="modal" data-target="#add-section"><i class="fas fa-sticky-note"></i> Add Task Section</a>
                     <a class="btn btn-info float-right text-white ml-2" href="{!! route('job.edit',$job->job_code) !!}"><i class="fas fa-edit"></i> Edit Job</a>
                     <a class="btn btn-success float-right btn-pink text-white" data-toggle="modal" data-target="#kt_modal_users_search"><i class="fas fa-user-plus"></i> Add Team Member</a>
                  </div>
                  <div class="col-md-3">
                     <b> Start Date</b><br>
                     <a href="" class="btn btn-primary btn-block mt-0">{!! date('F jS, Y', strtotime($job->start_date)) !!}</a>
                  </div>
                  <div class="col-md-3">
                     <b> Due Date</b><br>
                     <a href="" class="btn btn-warning btn-block mt-0">{!! date('F jS, Y', strtotime($job->end_date)) !!}</a>
                  </div>
                  <div class="col-md-6">
                     <span><b>Progress</b></span><br>
                     @if(Job::count_task_per_status($job->job_code,16) && Job::count_task_per_job($job->job_code) != 0)
                        @php
                           $tasks = Job::count_task_per_job($job->job_code);
                           $complete = Job::count_task_per_status($job->job_code,16);
                           $progress = ($complete/$tasks)*100;
                        @endphp
                        <div class="progress mb-1" style="height: 7px;">
                           <div class="progress-bar"
                              role="progressbar" aria-valuenow="<?php echo $progress ?>" aria-valuemin="0" aria-valuemax="100"
                              style="width: <?php echo number_format($progress) ?>%;">
                           </div>
                        </div>
                        <span><b><?php echo number_format($progress) ?>%</b></span>
                     @else
                        <div class="progress mb-1" style="height: 7px;">
                           <div class="progress-bar"
                              role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                              style="width: 0%;">
                           </div>
                        </div>
                        <span class="mt-1"><b>0%</b></span>
                     @endif
                  </div>
               </div>
            </div>
            <!--end::Wrapper-->
         </div>
         <!--end::Details-->
         <div class="separator"></div>
         <!--begin::Nav wrapper-->
         <!--begin::Nav links-->
         <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x mt-2">
            <li class="nav-item">
               <a class="nav-link active" href="{!! route('job.dashboard',$code) !!}"><i class="fal fa-chart-network"></i> Dashboard</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="{!! route('job.task',$code) !!}"><i class="fal fa-check-square"></i> Tasks</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="{!! route('job.discussions',$code) !!}"><i class="fal fa-comments-alt"></i> Discussions</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="{!! route('job.users',$code) !!}"><i class="fal fa-users"></i> Users</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="{!! route('job.files',$code) !!}"><i class="fal fa-paperclip"></i> Files</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="{!! route('job.notes',$code) !!}"><i class="fal fa-sticky-note"></i> Notes</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="{!! route('job.goals',$code) !!}"><i class="far fa-bullseye-arrow"></i> Goals</a>
            </li>
            {{-- <li class="nav-item">
               <a class="nav-link" href="{!! route('job.task',$code) !!}"><i class="fal fa-check-square"></i> tickets</a>
            </li> --}}
            <li class="nav-item">
               <a class="nav-link" href="{!! route('job.events',$code) !!}"><i class="fal fa-calendar-alt"></i> Events</a>
            </li>
            {{-- <li class="nav-item">
               <a class="nav-link" href="{!! route('job.budget',$code) !!}"><i class="fal fa-usd-circle"></i> Expense</a>
            </li> --}}
            {{-- <li class="nav-item">
               <a class="nav-link" href="{!! route('job.activity',$code) !!}"><i class="fal fa-heartbeat"></i> Activity</a>
            </li> --}}
            <li class="nav-item">
               <a class="nav-link" href="{!! route('job.edit',$job->job_code) !!}"><i class="fal fa-cogs"></i> Settings</a>
            </li>
         </ul>
      </div>
   </div>
   @livewire('jobs.job.add-member-modal', ['jobCode' => $jobCode])
   @livewire('jobs.job.sections', ['jobCode' => $jobCode])
</div>

