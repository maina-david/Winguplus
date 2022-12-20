<div>
   <div class="row mb-3">
      <div class="col-md-6">
         <input type="text" wire:model="search" class="form-control" placeholder="Search by job title">
      </div>
   </div>
   <div class="row">
      @foreach($jobs as $job)
         @if($job->business_code == Auth::user()->business_code)
            <div class="col-xl-4">
               <div class="card-box project-box">
                  <div class="dropdown float-right">
                     <a href="#" class="" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-h m-0 text-muted h3"></i>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('job.dashboard',$job->job_code) }}">View</a>
                        <a class="dropdown-item" href="{{ route('job.edit',$job->job_code) }}">Edit</a>
                        <a class="dropdown-item delete" href="{{ route('job.destroy',$job->job_code) }}">Delete</a>
                     </div>
                  </div> <!-- end dropdown -->
                  <!-- Title-->
                  <h4 class="mt-0"><a href="{{ route('job.dashboard',$job->job_code) }}" class="text-dark">{!! $job->job_title !!}</a></h4>
                  <p class="text-muted text-uppercase">
                     <i class="fas fa-user-circle"></i>
                     <small>
                        @if($job->job_type != 'Internal')
                           @if($job->customer != "")
                              {!! substr(Finance::client($job->customer)->customer_name, 0,55) !!}
                           @endif
                        @else
                           {!! $job->businessName !!}
                        @endif
                     </small>
                  </p>
                  <div class="badge {!! $job->statusName !!} mb-3">{!! $job->statusName !!}</div>
                  <!-- Task info-->
                  <p class="mb-1">
                     <span class="pr-2 text-nowrap mb-2 d-inline-block">
                        <i class="fas fa-headset text-muted"></i>
                        <b>{!! Job::count_job_tickets($job->job_code) !!}</b> Tickets
                     </span>
                     <span class="pr-2 text-nowrap mb-2 d-inline-block">
                        <i class="fas fa-th-list text-muted"></i>
                        <b>{!! Job::count_task_per_job($job->job_code) !!}</b> Tasks
                     </span>
                     <span class="text-nowrap mb-2 d-inline-block">
                        <i class="fas fa-comments text-muted"></i>
                        <b>{!! Job::count_comments_per_job($job->job_code) !!}</b> Comments
                     </span>
                  </p>
                  <!-- Team-->
                  <div class="avatar-group mb-3">
                     @foreach(Job::job_leaders($job->job_code) as $leader)
                        @if(Wingu::check_user($leader->user) == 1)
                           <a href="javascript: void(0);" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="{!! Wingu::user($leader->user)->name !!}">
                              @php
                                 $user = Wingu::user($leader->user);
                              @endphp
                              @if($user->image != "")
                                 <img src="{!! asset('/business/'.$code.'/hr/employee/images/'.$user->image) !!}" class="rounded-circle avatar-sm" alt="{!! $user->name !!}" />
                              @else
                                 <img class="rounded-circle" width="40" height="40" alt="{!! $user->name !!}" class="img-circle FL" src="{!! asset('assets/img/image.png') !!}">
                              @endif
                           </a>
                        @endif
                     @endforeach
                  </div>
                  <!-- Progress-->
                  <p class="mb-2 font-weight-bold">Task completed:
                     <span class="float-right">{!! Job::count_task_per_status($job->job_code,16) !!}/{!! Job::count_task_per_job($job->job_code) !!}</span>
                  </p>
                  @if(Job::count_task_per_status($job->job_code,16) && Job::count_task_per_job($job->job_code) != 0)
                     @php
                        $tasks = Job::count_task_per_job($job->job_code);
                        $complete = Job::count_task_per_status($job->job_code,16);
                        $progress = ($complete/$tasks)*100;
                     @endphp
                     <div class="progress mb-1" style="height: 7px;">
                        <div class="progress-bar"
                           role="progressbar" aria-valuenow="<?php echo $progress ?>" aria-valuemin="0" aria-valuemax="100"
                           style="width: <?php echo $progress ?>%;">
                        </div>
                     </div>
                  @else
                     <div class="progress mb-1" style="height: 7px;">
                        <div class="progress-bar"
                           role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                           style="width: 0%;">
                        </div>
                     </div>
                  @endif
               </div> <!-- end card box-->
            </div>
         @endif
      @endforeach
      <div class="row mt-3">
         <div class="col-md-12">
            {!! $jobs->links() !!}
         </div>
      </div>
   </div>
</div>
