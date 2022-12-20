<div>
   <div class="container">
      <div class="mail-box">
         <aside class="sm-side">
            <div class="inbox-body">
               <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#addTask">
                  <i class="fas fa-plus-circle"></i> Add New Task
               </a>
            </div>
            <ul class="inbox-nav inbox-divider">
               <li class="active">
                  <a href="{!! route('job.mytask.list') !!}">
                     <i class="far fa-list-ul"></i> All
                     <span class="label label-primary pull-right">{!! $allTasks->count() !!}</span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Today')" href="#">
                     <i class="fad fa-star text-warning"></i> Today
                     <span class="label label-yellow pull-right">{!! $todaysTasks->count() !!}</span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Tomorrow')" href="#">
                     <i class="fad fa-calendar-day"></i> Tomorrow
                     <span class="label label-warning pull-right">{!! $tomorrowTasks->count() !!}</span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Next 7 Days')" href="#">
                     <i class="fad fa-calendar-week"></i> Next 7 Days
                     <span class="label label-pink pull-right">{!! $next7DaysTasks->count() !!}</span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Past Due')" href="#">
                     <i class="fad fa-calendar-times"></i> Past Due
                     <span class="label label-danger pull-right">{!! $pastDueTasks->count() !!}</span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Waiting Approval')" href="#">
                     <i class="fad fa-history"></i> Waiting Approval
                     <span class="label label-purple pull-right">{!! $waitingApprovalTasks->count() !!}</span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Pending')" href="#">
                     <i class="fad fa-exclamation-circle"></i> Pending
                     <span class="label label-indigo pull-right">{!! $pendingTasks->count() !!}</span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Completed')" href="#">
                     <i class="fad fa-clipboard-check"></i> Completed
                     <span class="label label-green pull-right">{!! $completeTasks->count() !!}</span>
                  </a>
               </li>
               {{-- <li>
                  <a href="#">
                     <i class="fad fa-thumbs-up"></i> Needs my Approval
                     <span class="label label-danger pull-right">2</span>
                  </a>
               </li> --}}
            </ul>
            {{-- <ul class="nav nav-pills nav-stacked labels-info inbox-divider">
               <li><h4 class="mt-1 text-center font-bold">Projects</h4> </li>
               <li> <a href="#"> <i class="text-danger"></i> Project Title </a> </li>
            </ul> --}}
            {{-- <ul class="nav nav-pills nav-stacked labels-info ">
               <li> <h4>Buddy online</h4> </li>
               <li> <a href="#"> <i class=" fa fa-circle text-success"></i>Alireza Zare <p>I do not think</p></a>  </li>
               <li> <a href="#"> <i class=" fa fa-circle text-danger"></i>Dark Coders<p>Busy with coding</p></a> </li>
               <li> <a href="#"> <i class=" fa fa-circle text-muted "></i>Mentaalist <p>I out of control</p></a>
               </li><li> <a href="#"> <i class=" fa fa-circle text-muted "></i>H3s4m<p>I am not here</p></a>
               </li><li> <a href="#"> <i class=" fa fa-circle text-muted "></i>Dead man<p>I do not think</p></a>
               </li>
            </ul> --}}
         </aside>
         <aside class="lg-side">
            <div class="inbox-head">
               <h3>{!! $view !!} Tasks</h3>
               <form action="#" class="pull-right position">
                  <div class="input-append">
                     <input type="text" class="sr-input" wire:model.debounce.2000ms="search" placeholder="Search by task title">
                  </div>
               </form>
            </div>
            <div class="inbox-body">
               <div class="mail-option">
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <select wire:model="status" class="form-control" id="status_filter">
                              <option value="">Filter By Task Status</option>
                              <option value="21">Open</option>
                              <option value="54">Suspended</option>
                              <option value="55">Waiting Assessment</option>
                              <option value="56">Re-opened</option>
                              <option value="16">Completed</option>
                              <option value="62">Waiting Approval</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <select wire:model="projects" class="form-control">
                              <option value="">Filter By Jobs</option>
                              @foreach ($jobs as $job)
                                 <option value="{!! $job->job_code !!}">{!! $job->job_title !!}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               @if($this->view == 'All')
                  <table class="table table-inbox table-hover">
                     <tbody>
                        @foreach($allTasks as $task)
                           @if($task->business_code == Auth::user()->business_code)
                              @php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              @endphp
                              <tr class="">
                                 {{-- <td class="inbox-small-cells" width="1%">
                                    <input type="checkbox" class="mail-checkbox mt-2">
                                 </td> --}}
                                 <td class="view-message">
                                    <a wire:click="view_task({{$getTaskCode}},'overview')" data-toggle="modal" data-target="#taskview" class="text-dark">
                                       <span class="font-bold font-14">
                                          @if($task->status == 16)
                                             <strike>{!! $task->title !!}</strike>
                                          @else
                                             {!! $task->title !!}
                                          @endif
                                       </span>
                                       <br>
                                       <p class="font-small text-height-1">
                                          @if($task->priority)
                                             <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                             <span class="badge {!! Wingu::status($task->priority)->name !!}">{!! Wingu::status($task->priority)->name !!}</span> |
                                          @endif
                                          @if($task->status)
                                             <b><i class="fal fa-heartbeat"></i> Status :</b>
                                             <span class="badge {!! Wingu::status($task->status)->name !!}">{!! Wingu::status($task->status)->name !!}</span> |
                                          @endif
                                          @if($task->start_date)
                                          <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success">{!! date('d F Y', strtotime($task->start_date)) !!}</span>
                                          @endif
                                          @if($task->due_date)
                                          | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning">{!! date('d F Y', strtotime($task->due_date)) !!}</span>
                                          @endif
                                          | <b><i class="fal fa-paperclip"></i> Attachment :</b> {!! Job::task_attachments($task->task_code)->count() !!}
                                          | <b><i class="fal fa-comments"></i> Comments :</b> {!! Job::task_comments($task->task_code)->count() !!}
                                          @if($jobDetails->check == 1)
                                          | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink">{!! $jobDetails->details->job_title !!}</span>
                                          @endif
                                       </p>
                                    </a>
                                 </td>
                                 {{-- <td class="view-message">Stop wasting your visitors </td>
                                 <td class="view-message inbox-small-cells"></td>--}}
                                 <td class="view-message">
                                    <div class="btn-group mt-3">
                                       <a data-toggle="dropdown" href="#" class="btn btn-default btn-sm">
                                          Action
                                          <i class="fa fa-angle-down "></i>
                                       </a>
                                       <ul class="dropdown-menu">
                                          <li><a href="#">View</a></li>
                                          <li><a href="#">Complete</a></li>
                                          <li class="divider"></li>
                                          <li><a href="#">Delete</a></li>
                                       </ul>
                                    </div>
                                 </td>
                              </tr>
                           @endif
                        @endforeach
                     </tbody>
                  </table>
               @endif

               @if($this->view == 'Today')
                  <table class="table table-inbox table-hover">
                     <tbody>
                        @foreach($todaysTasks as $task)
                           @if($task->business_code == Auth::user()->business_code)
                              @php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              @endphp
                              <tr class="">
                                 {{-- <td class="inbox-small-cells" width="1%">
                                    <input type="checkbox" class="mail-checkbox mt-2">
                                 </td> --}}
                                 <td class="view-message">
                                    <span class="font-bold font-14">@if($task->status == 16)<strike>{!! $task->title !!}</strike>@else {!! $task->title !!} @endif</span><br>
                                    <p class="font-small text-height-1">
                                       @if($task->priority)
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge {!! Wingu::status($task->priority)->name !!}">{!! Wingu::status($task->priority)->name !!}</span> |
                                       @endif
                                       @if($task->status)
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge {!! Wingu::status($task->status)->name !!}">{!! Wingu::status($task->status)->name !!}</span> |
                                       @endif
                                       @if($task->start_date)
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success">{!! date('d F Y', strtotime($task->start_date)) !!}</span>
                                       @endif
                                       @if($task->due_date)
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning">{!! date('d F Y', strtotime($task->due_date)) !!}</span>
                                       @endif
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> {!! Job::task_attachments($task->task_code)->count() !!}
                                       | <b><i class="fal fa-comments"></i> Comments :</b> {!! Job::task_comments($task->task_code)->count() !!}
                                       @if($jobDetails->check == 1)
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink">{!! $jobDetails->details->job_title !!}</span>
                                       @endif
                                    </p>
                                 </td>
                                 {{-- <td class="view-message">Stop wasting your visitors </td>
                                 <td class="view-message inbox-small-cells"></td>--}}
                                 {{-- <td class="view-message">
                                    <div class="btn-group mt-3">
                                       <a data-toggle="dropdown" href="#" class="btn btn-default btn-sm">
                                          Action
                                          <i class="fa fa-angle-down "></i>
                                       </a>
                                       <ul class="dropdown-menu">
                                             <li><a href="#"><i class="fa fa-pencil"></i> Mark as Complete</a></li>
                                             <li class="divider"></li>
                                             <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                                       </ul>
                                    </div>
                                 </td> --}}
                              </tr>
                           @endif
                        @endforeach
                     </tbody>
                  </table>
               @endif

               @if($this->view == 'Tomorrow')
                  <table class="table table-inbox table-hover">
                     <tbody>
                        @foreach($tomorrowTasks as $task)
                           @if($task->business_code == Auth::user()->business_code)
                              @php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              @endphp
                              <tr class="">
                                 {{-- <td class="inbox-small-cells" width="1%">
                                    <input type="checkbox" class="mail-checkbox mt-2">
                                 </td> --}}
                                 <td class="view-message">
                                    <span class="font-bold font-14">@if($task->status == 16)<strike>{!! $task->title !!}</strike>@else {!! $task->title !!} @endif</span><br>
                                    <p class="font-small text-height-1">
                                       @if($task->priority)
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge {!! Wingu::status($task->priority)->name !!}">{!! Wingu::status($task->priority)->name !!}</span> |
                                       @endif
                                       @if($task->status)
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge {!! Wingu::status($task->status)->name !!}">{!! Wingu::status($task->status)->name !!}</span> |
                                       @endif
                                       @if($task->start_date)
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success">{!! date('d F Y', strtotime($task->start_date)) !!}</span>
                                       @endif
                                       @if($task->due_date)
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning">{!! date('d F Y', strtotime($task->due_date)) !!}</span>
                                       @endif
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> {!! Job::task_attachments($task->task_code)->count() !!}
                                       | <b><i class="fal fa-comments"></i> Comments :</b> {!! Job::task_comments($task->task_code)->count() !!}
                                       @if($jobDetails->check == 1)
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink">{!! $jobDetails->details->job_title !!}</span>
                                       @endif
                                    </p>
                                 </td>
                                 {{-- <td class="view-message">Stop wasting your visitors </td>
                                 <td class="view-message inbox-small-cells"></td>--}}
                                 {{-- <td class="view-message">
                                    <div class="btn-group mt-3">
                                       <a data-toggle="dropdown" href="#" class="btn btn-default btn-sm">
                                          Action
                                          <i class="fa fa-angle-down "></i>
                                       </a>
                                       <ul class="dropdown-menu">
                                             <li><a href="#"><i class="fa fa-pencil"></i> Mark as Complete</a></li>
                                             <li class="divider"></li>
                                             <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                                       </ul>
                                    </div>
                                 </td> --}}
                              </tr>
                           @endif
                        @endforeach
                     </tbody>
                  </table>
               @endif

               @if($this->view == 'Next 7 Days')
                  <table class="table table-inbox table-hover">
                     <tbody>
                        @foreach($next7DaysTasks as $task)
                           @if($task->business_code == Auth::user()->business_code)
                              @php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              @endphp
                              <tr class="">
                                 {{-- <td class="inbox-small-cells" width="1%">
                                    <input type="checkbox" class="mail-checkbox mt-2">
                                 </td> --}}
                                 <td class="view-message">
                                    <span class="font-bold font-14">@if($task->status == 16)<strike>{!! $task->title !!}</strike>@else {!! $task->title !!} @endif</span><br>
                                    <p class="font-small text-height-1">
                                       @if($task->priority)
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge {!! Wingu::status($task->priority)->name !!}">{!! Wingu::status($task->priority)->name !!}</span> |
                                       @endif
                                       @if($task->status)
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge {!! Wingu::status($task->status)->name !!}">{!! Wingu::status($task->status)->name !!}</span> |
                                       @endif
                                       @if($task->start_date)
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success">{!! date('d F Y', strtotime($task->start_date)) !!}</span>
                                       @endif
                                       @if($task->due_date)
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning">{!! date('d F Y', strtotime($task->due_date)) !!}</span>
                                       @endif
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> {!! Job::task_attachments($task->task_code)->count() !!}
                                       | <b><i class="fal fa-comments"></i> Comments :</b> {!! Job::task_comments($task->task_code)->count() !!}
                                       @if($jobDetails->check == 1)
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink">{!! $jobDetails->details->job_title !!}</span>
                                       @endif
                                    </p>
                                 </td>
                                 {{-- <td class="view-message">Stop wasting your visitors </td>
                                 <td class="view-message inbox-small-cells"></td>--}}
                                 {{-- <td class="view-message">
                                    <div class="btn-group mt-3">
                                       <a data-toggle="dropdown" href="#" class="btn btn-default btn-sm">
                                          Action
                                          <i class="fa fa-angle-down "></i>
                                       </a>
                                       <ul class="dropdown-menu">
                                             <li><a href="#"><i class="fa fa-pencil"></i> Mark as Complete</a></li>
                                             <li class="divider"></li>
                                             <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                                       </ul>
                                    </div>
                                 </td> --}}
                              </tr>
                           @endif
                        @endforeach
                     </tbody>
                  </table>
               @endif

               @if($this->view == 'Past Due')
                  <table class="table table-inbox table-hover">
                     <tbody>
                        @foreach($pastDueTasks as $task)
                           @if($task->business_code == Auth::user()->business_code)
                              @php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              @endphp
                              <tr class="">
                                 {{-- <td class="inbox-small-cells" width="1%">
                                    <input type="checkbox" class="mail-checkbox mt-2">
                                 </td> --}}
                                 <td class="view-message">
                                    <span class="font-bold font-14">@if($task->status == 16)<strike>{!! $task->title !!}</strike>@else {!! $task->title !!} @endif</span><br>
                                    <p class="font-small text-height-1">
                                       @if($task->priority)
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge {!! Wingu::status($task->priority)->name !!}">{!! Wingu::status($task->priority)->name !!}</span> |
                                       @endif
                                       @if($task->status)
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge {!! Wingu::status($task->status)->name !!}">{!! Wingu::status($task->status)->name !!}</span> |
                                       @endif
                                       @if($task->start_date)
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success">{!! date('d F Y', strtotime($task->start_date)) !!}</span>
                                       @endif
                                       @if($task->due_date)
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning">{!! date('d F Y', strtotime($task->due_date)) !!}</span>
                                       @endif
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> {!! Job::task_attachments($task->task_code)->count() !!}
                                       | <b><i class="fal fa-comments"></i> Comments :</b> {!! Job::task_comments($task->task_code)->count() !!}
                                       @if($jobDetails->check == 1)
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink">{!! $jobDetails->details->job_title !!}</span>
                                       @endif
                                    </p>
                                 </td>
                                 {{-- <td class="view-message">Stop wasting your visitors </td>
                                 <td class="view-message inbox-small-cells"></td>--}}
                                 {{-- <td class="view-message">
                                    <div class="btn-group mt-3">
                                       <a data-toggle="dropdown" href="#" class="btn btn-default btn-sm">
                                          Action
                                          <i class="fa fa-angle-down "></i>
                                       </a>
                                       <ul class="dropdown-menu">
                                             <li><a href="#"><i class="fa fa-pencil"></i> Mark as Complete</a></li>
                                             <li class="divider"></li>
                                             <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                                       </ul>
                                    </div>
                                 </td> --}}
                              </tr>
                           @endif
                        @endforeach
                     </tbody>
                  </table>
               @endif

               @if($this->view == 'Pending')
                  <table class="table table-inbox table-hover">
                     <tbody>
                        @foreach($pendingTasks as $task)
                           @if($task->business_code == Auth::user()->business_code)
                              @php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              @endphp
                              <tr class="">
                                 {{-- <td class="inbox-small-cells" width="1%">
                                    <input type="checkbox" class="mail-checkbox mt-2">
                                 </td> --}}
                                 <td class="view-message">
                                    <span class="font-bold font-14">@if($task->status == 16)<strike>{!! $task->title !!}</strike>@else {!! $task->title !!} @endif</span><br>
                                    <p class="font-small text-height-1">
                                       @if($task->priority)
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge {!! Wingu::status($task->priority)->name !!}">{!! Wingu::status($task->priority)->name !!}</span> |
                                       @endif
                                       @if($task->status)
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge {!! Wingu::status($task->status)->name !!}">{!! Wingu::status($task->status)->name !!}</span> |
                                       @endif
                                       @if($task->start_date)
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success">{!! date('d F Y', strtotime($task->start_date)) !!}</span>
                                       @endif
                                       @if($task->due_date)
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning">{!! date('d F Y', strtotime($task->due_date)) !!}</span>
                                       @endif
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> {!! Job::task_attachments($task->task_code)->count() !!}
                                       | <b><i class="fal fa-comments"></i> Comments :</b> {!! Job::task_comments($task->task_code)->count() !!}
                                       @if($jobDetails->check == 1)
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink">{!! $jobDetails->details->job_title !!}</span>
                                       @endif
                                    </p>
                                 </td>
                                 {{-- <td class="view-message">Stop wasting your visitors </td>
                                 <td class="view-message inbox-small-cells"></td>--}}
                                 {{-- <td class="view-message">
                                    <div class="btn-group mt-3">
                                       <a data-toggle="dropdown" href="#" class="btn btn-default btn-sm">
                                          Action
                                          <i class="fa fa-angle-down "></i>
                                       </a>
                                       <ul class="dropdown-menu">
                                             <li><a href="#"><i class="fa fa-pencil"></i> Mark as Complete</a></li>
                                             <li class="divider"></li>
                                             <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                                       </ul>
                                    </div>
                                 </td> --}}
                              </tr>
                           @endif
                        @endforeach
                     </tbody>
                  </table>
               @endif

               @if($this->view == 'Waiting Approval')
                  <table class="table table-inbox table-hover">
                     <tbody>
                        @foreach($waitingApprovalTasks as $task)
                           @if($task->business_code == Auth::user()->business_code)
                              @php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              @endphp
                              <tr class="">
                                 {{-- <td class="inbox-small-cells" width="1%">
                                    <input type="checkbox" class="mail-checkbox mt-2">
                                 </td> --}}
                                 <td class="view-message">
                                    <span class="font-bold font-14">@if($task->status == 16)<strike>{!! $task->title !!}</strike>@else {!! $task->title !!} @endif</span><br>
                                    <p class="font-small text-height-1">
                                       @if($task->priority)
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge {!! Wingu::status($task->priority)->name !!}">{!! Wingu::status($task->priority)->name !!}</span> |
                                       @endif
                                       @if($task->status)
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge {!! Wingu::status($task->status)->name !!}">{!! Wingu::status($task->status)->name !!}</span> |
                                       @endif
                                       @if($task->start_date)
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success">{!! date('d F Y', strtotime($task->start_date)) !!}</span>
                                       @endif
                                       @if($task->due_date)
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning">{!! date('d F Y', strtotime($task->due_date)) !!}</span>
                                       @endif
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> {!! Job::task_attachments($task->task_code)->count() !!}
                                       | <b><i class="fal fa-comments"></i> Comments :</b> {!! Job::task_comments($task->task_code)->count() !!}
                                       @if($jobDetails->check == 1)
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink">{!! $jobDetails->details->job_title !!}</span>
                                       @endif
                                    </p>
                                 </td>
                                 {{-- <td class="view-message">Stop wasting your visitors </td>
                                 <td class="view-message inbox-small-cells"></td>--}}
                                 {{-- <td class="view-message">
                                    <div class="btn-group mt-3">
                                       <a data-toggle="dropdown" href="#" class="btn btn-default btn-sm">
                                          Action
                                          <i class="fa fa-angle-down "></i>
                                       </a>
                                       <ul class="dropdown-menu">
                                             <li><a href="#"><i class="fa fa-pencil"></i> Mark as Complete</a></li>
                                             <li class="divider"></li>
                                             <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                                       </ul>
                                    </div>
                                 </td> --}}
                              </tr>
                           @endif
                        @endforeach
                     </tbody>
                  </table>
               @endif

               @if($this->view == 'Completed')
                  <table class="table table-inbox table-hover">
                     <tbody>
                        @foreach($completeTasks as $task)
                           @if($task->business_code == Auth::user()->business_code)
                              @php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              @endphp
                              <tr class="">
                                 {{-- <td class="inbox-small-cells" width="1%">
                                    <input type="checkbox" class="mail-checkbox mt-2">
                                 </td> --}}
                                 <td class="view-message">
                                    <span class="font-bold font-14">@if($task->status == 16)<strike>{!! $task->title !!}</strike>@else {!! $task->title !!} @endif</span><br>
                                    <p class="font-small text-height-1">
                                       @if($task->priority)
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge {!! Wingu::status($task->priority)->name !!}">{!! Wingu::status($task->priority)->name !!}</span> |
                                       @endif
                                       @if($task->status)
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge {!! Wingu::status($task->status)->name !!}">{!! Wingu::status($task->status)->name !!}</span> |
                                       @endif
                                       @if($task->start_date)
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success">{!! date('d F Y', strtotime($task->start_date)) !!}</span>
                                       @endif
                                       @if($task->due_date)
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning">{!! date('d F Y', strtotime($task->due_date)) !!}</span>
                                       @endif
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> {!! Job::task_attachments($task->task_code)->count() !!}
                                       | <b><i class="fal fa-comments"></i> Comments :</b> {!! Job::task_comments($task->task_code)->count() !!}
                                       @if($jobDetails->check == 1)
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink">{!! $jobDetails->details->job_title !!}</span>
                                       @endif
                                    </p>
                                 </td>
                                 {{-- <td class="view-message">Stop wasting your visitors </td>
                                 <td class="view-message inbox-small-cells"></td>--}}
                                 {{-- <td class="view-message">
                                    <div class="btn-group mt-3">
                                       <a data-toggle="dropdown" href="#" class="btn btn-default btn-sm">
                                          Action
                                          <i class="fa fa-angle-down "></i>
                                       </a>
                                       <ul class="dropdown-menu">
                                             <li><a href="#"><i class="fa fa-pencil"></i> Mark as Complete</a></li>
                                             <li class="divider"></li>
                                             <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                                       </ul>
                                    </div>
                                 </td> --}}
                              </tr>
                           @endif
                        @endforeach
                     </tbody>
                  </table>
               @endif
            </div>
         </aside>
      </div>
   </div>

   {{-- tasks --}}
   <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="addTask" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle"><i class="fal fa-check-square"></i> Add Task</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group form-group-default required">
                        <label for="tasks_name">Title</label>
                        <input type="text" wire:model.defer="task_title" class="form-control" placeholder="Enter task title" required>
                        @error('task_title')<span class="error text-danger">{{$message}}</span>@enderror
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="tasks_name">Priority</label>
                        <select wire:model.defer="priority" class="form-control">
                           <option value="">Choose</option>
                           <option value="59">Urgent</option>
                           <option value="60">High</option>
                           <option value="61">Low</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="tasks_name">Status</label>
                        <select wire:model.defer="task_status" class="form-control">
                           <option value="">Choose</option>
                           <option value="21">Open</option>
                           <option value="54">Suspended</option>
                           <option value="55">Waiting Assessment</option>
                           <option value="56">Re-opened</option>
                           <option value="16">Completed</option>
                           <option value="62">Waiting Approval</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="tasks_start_date">Start Date</label>
                        <input type="date" wire:model.defer="start_date" class="form-control">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="tasks_due_date">Due Date</label>
                        <input type="date" wire:model.defer="due_date" class="form-control">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="tasks_name">Jobs</label>
                        <select wire:model.defer="jobs" class="form-control">
                           <option value="">Choose</option>
                           <option value="59">Urgent</option>
                           <option value="60">High</option>
                           <option value="61">Low</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="tasks_name">Job Section</label>
                        <select wire:model.defer="jobs" class="form-control">
                           <option value="">Choose</option>
                           <option value="59">Urgent</option>
                           <option value="60">High</option>
                           <option value="61">Low</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div wire:ignore class="form-group">
                        {!! Form::label('Description', 'Details', array('class'=>'control-label mb-3')) !!}
                        <textarea wire:model.defer="details" data-details="@this" class="form-control" id="details" cols="30" rows="10"></textarea>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" wire:click.prevent="add_task()" id="save_task" class="btn btn-pink submit" wire:loading.class="none"><i class="fas fa-save"></i> Add task</button>
               <div wire:loading wire:target="add_task">
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load float-right" alt="" width="15%">
               </div>
            </div>
         </div>
      </div>
   </div>

   {{-- Edit tasks --}}
   @if($editTask="on")
      <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="editTask" aria-hidden="true">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle"><i class="fal fa-check-square"></i> Edit Task</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <label for="tasks_name">Title</label>
                           <input type="text" wire:model="task_title" class="form-control" placeholder="Enter task title" required>
                           @error('task_title')<span class="error text-danger">{{$message}}</span>@enderror
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label for="tasks_name">Priority</label>
                           <select wire:model="priority" class="form-control">
                              <option value="">Choose</option>
                              <option value="59">Urgent</option>
                              <option value="60">High</option>
                              <option value="61">Low</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label for="tasks_name">Status</label>
                           <select wire:model="task_status" class="form-control">
                              <option value="">Choose</option>
                              <option value="21">Open</option>
                              <option value="54">Suspended</option>
                              <option value="55">Waiting Assessment</option>
                              <option value="56">Re-opened</option>
                              <option value="16">Completed</option>
                              <option value="62">Waiting Approval</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label for="tasks_start_date">Start Date</label>
                           <input type="date" wire:model="start_date" class="form-control">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label for="tasks_due_date">Due Date</label>
                           <input type="date" wire:model="due_date" class="form-control">
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div wire:ignore class="form-group">
                           {!! Form::label('Description', 'Details', array('class'=>'control-label mb-3')) !!}
                           <textarea wire:model="details" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                     </div>
                  </div>
               </div>
               @php
                  $editTaskCode2 = json_encode($editTaskCode);
               @endphp
               <div class="modal-footer">

                  <button type="submit" wire:click="update_task({{$editTaskCode2}})" class="btn btn-pink" wire:loading.class="none"><i class="fas fa-save"></i> Update task</button>
                  <div wire:loading wire:target="update_task">
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load float-right" alt="" width="30%">
                  </div>
               </div>
            </div>
         </div>
      </div>
   @endif

   {{-- task details --}}
   <div wire:ignore.self class="modal task-modal-single right fade" id="taskview" tabindex="-1" role="dialog" aria-labelledby="right_modal_xl"  data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-xl" role="document">
         <div class="modal-content">
            @if($taskCode)
               @php
                  $parentTaskCode = json_encode($taskCode);
               @endphp
               <div class="modal-header bg-grey-2">
                  <h4 class="modal-title">{!! $taskDetails->title !!}</h4>
                  <a href="#" wire:click="close()" class="btn btn-sm btn-danger">Close</a>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-8 task-single-col-left">
                        <ul class="nav nav-pills">
                           <li class="nav-item">
                              <a  wire:click="change_task_view('overview',{{$parentTaskCode}})" class="nav-link pointer-cursor @if($currentView == 'overview') active @endif">Overview</a>
                           </li>
                           <li class="nav-item">
                              <a wire:click="change_task_view('checklist',{{$parentTaskCode}})" class="nav-link pointer-cursor @if($currentView == 'checklist') active @endif">Checklist ({{ $checklistItems->count() }})</a>
                           </li>
                           <li class="nav-item">
                              <a wire:click="change_task_view('comments',{{$parentTaskCode}})" class="nav-link pointer-cursor @if($currentView == 'comments') active @endif">Comments ({!! $comments->count() !!})</a>
                           </li>
                        </ul>

                        @if($currentView == 'overview')
                           <div class="panel">
                              <div class="panel-body">
                                 <h4>Task Details</h4>
                                 {!! $taskDetails->details !!}
                              </div>
                           </div>
                        @endif

                        @if($currentView == 'checklist')
                           {{-- <div class="panel" wire:loading.class="none"></div> --}}
                           <div class="card-hover-shadow-2x mb-3 card">
                              <div class="card-header">
                                 <i class="fa fa-tasks"></i> Checklist ({{ $checklistItems->count() }})
                              </div>
                              <div class="scroll-area-sm">
                                 <div style="position: static;" class="ps ps--active-y">
                                    <div class="ps-content">
                                       <ul class=" list-group list-group-flush">
                                          @foreach($checklistItems as $checkListCount=>$listItem)
                                             @php
                                                $checkListCode = json_encode($listItem->task_code);
                                             @endphp
                                             <li class="list-group-item">
                                                @if($listItem->status == 16)
                                                   <div class="todo-indicator bg-success"></div>
                                                @else
                                                   <div class="todo-indicator bg-primary"></div>
                                                @endif
                                                <div class="widget-content p-0">
                                                   <div class="widget-content-wrapper">
                                                      <div class="widget-content-left mr-2">
                                                         <div class="custom-checkbox custom-control">
                                                            @if($listItem->status == 16)
                                                               <input class="custom-control-input" id="checkbox{{ $checkListCount+1 }}" type="checkbox"  checked wire:click="update_checklist_status({{$parentTaskCode}},{{$checkListCode}},21)">
                                                            @else
                                                               <input class="custom-control-input" id="checkbox{{ $checkListCount+1 }}" type="checkbox" wire:click="update_checklist_status({{$parentTaskCode}},{{$checkListCode}},16)">
                                                            @endif
                                                            <label class="custom-control-label" for="checkbox{{ $checkListCount+1 }}">&nbsp;</label>
                                                         </div>
                                                      </div>
                                                      <div class="widget-content-left">
                                                         <div class="widget-heading">
                                                            @if($listItem->status == 16)
                                                               <strike>{!! $listItem->title !!}</strike>
                                                            @else
                                                               {!! $listItem->title !!}
                                                            @endif
                                                            {{-- <div class="badge badge-danger ml-2">Rejected</div> --}}
                                                         </div>
                                                         <div class="widget-subheading">
                                                            <i>added on {!! date('F jS, Y', strtotime($listItem->created_at)) !!}</i>
                                                            @if($listItem->status == 16)
                                                               | <i>completed on {!! date('F jS, Y', strtotime($listItem->close_date)) !!}</i>
                                                            @endif
                                                         </div>
                                                      </div>
                                                      <div class="widget-content-right">
                                                         @if($listItem->status == 16)
                                                            <button class="border-0 btn-transition btn btn-outline-primary pointer-cursor" wire:loading.class="none" wire:click="update_checklist_status({{$parentTaskCode}},{{$checkListCode}},21)">
                                                               <i class="fal fa-redo fa-2x"></i>
                                                            </button>
                                                         @else
                                                            <button class="border-0 btn-transition btn btn-outline-success pointer-cursor" wire:loading.class="none" wire:click="update_checklist_status({{$parentTaskCode}},{{$checkListCode}},16)">
                                                               <i class="fal fa-check-circle fa-2x"></i>
                                                            </button>
                                                         @endif
                                                         <button class="border-0 btn-transition btn btn-outline-danger pointer-cursor" wire:loading.class="none" wire:click="delete_checklist({{$parentTaskCode}},{{$checkListCode}})">
                                                            <i class="fal fa-times-circle fa-2x"></i>
                                                         </button>
                                                      </div>
                                                   </div>
                                                </div>
                                             </li>
                                          @endforeach
                                          {{-- <li class="list-group-item">
                                             <div class="todo-indicator bg-focus"></div>
                                             <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                   <div class="widget-content-left mr-2">
                                                      <div class="custom-checkbox custom-control">
                                                         <input class="custom-control-input" id="exampleCustomCheckbox1" type="checkbox">
                                                         <label class="custom-control-label" for="exampleCustomCheckbox1">&nbsp;</label>
                                                      </div>
                                                   </div>
                                                   <div class="widget-content-left">
                                                      <div class="widget-heading">Make payment to Bluedart</div>
                                                      <div class="widget-subheading">
                                                         <div>By Johnny <div class="badge badge-pill badge-info ml-2">NEW</div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="widget-content-right">
                                                      <button class="border-0 btn-transition btn btn-outline-success"> <i class="fa fa-check"></i></button>
                                                      <button class="border-0 btn-transition btn btn-outline-danger"> <i class="fa fa-trash"></i> </button>
                                                   </div>
                                                </div>
                                             </div>
                                          </li> --}}
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <div class="d-block text-right card-footer">
                                 <form class="row" wire:submit.prevent="add_checklist({{$parentTaskCode}})">
                                    <div class="col-md-10">
                                       <input type="text" wire:model.defer="checklist_task" class="form-control" placeholder="Add new checklist">
                                       @error('checklist_task') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-2">
                                       <button class="btn btn-primary" wire:loading.class="none"><i class="fas fa-save"></i> Add Task</button>
                                       <div wire:loading wire:target="add_checklist">
                                          <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="img-responsive" alt="loader">
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        @endif

                        @if($currentView == 'comments')
                           <div class="panel" wire:loading.class="none">
                              <div class="panel-body">
                                 <h5 class="mb-2">Comments ({!! $comments->count() !!})
                                    <a data-toggle="collapse" aria-expanded="true" aria-controls="collapse-1" href="#collapse-1" class="float-right badge badge-warning">Comment Box</a>
                                 </h5>
                                 <form id="collapse-1" class="border-bottom collapse" action="{!! route('task.comment.store') !!}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                       <textarea name="comment" class="form-control" rows="6"></textarea>
                                       @error('comment')<span class="error text-danger">{{$message}}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                       <label for="customFile">Attach File</label><br>
                                       <input type="text" name="file_title" class="form-control mb-2" placeholder="File title">
                                       <input type="file" name="comment_files[]" class="form-control" multiple>
                                    </div>
                                    <input type="hidden" name="jobCode" value="{!! $jobCode !!}" required>
                                    <input type="hidden" name="taskCode" value="{!! $taskDetails->task_code !!}" required>
                                    <button type="submit" class="btn btn-success submit mb-3"><i class="fas fa-save"></i> Post comment</button>
                                    <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                                 </form>
                                 <div class="row mt-3">
                                    <div class="col-md-12">
                                       <div class="blog-comment">
                                          <ul class="comments">
                                             @foreach($comments as $comm)
                                                <li class="clearfix">
                                                   @if($comm->profile_picture)
                                                      <img src="{!! asset('businesses/'.Auth::user()->business_code.'/images/'.$comm->profile_picture) !!}" class="avatar" alt="{!! $comm->user_name !!}">
                                                   @else
                                                      <img src="https://ui-avatars.com/api/?name={!! $comm->user_name !!}&rounded=false&size=70" class="avatar" alt="{!! $comm->user_name !!}">
                                                   @endif
                                                   <div class="post-comments">
                                                      <p class="meta">
                                                         <b><a href="#">{!! $comm->user_name !!}</a></b>
                                                         | <i class="fal fa-clock-o"></i> {!! Helper::get_timeago(strtotime($comm->comment_date)) !!}
                                                         {{-- <i class="pull-right cursor action-collapse"><a data-toggle="collapse" aria-expanded="true" aria-controls="collapse{!! $comment->comment_code !!}" href="#collapse{!! $comment->comment_code !!}"><small>Reply</small></a></i> --}}
                                                      </p>
                                                      <p>{!! $comm->user_comment !!}</p>
                                                   </div>
                                                   {{-- <ul class="comments">
                                                      <div id="collapse{!! $comment->comment_code !!}" class="mb-3 collapse">
                                                         <div class="d-flex flex-row align-items-start">
                                                            @if(Auth::user()->avatar)
                                                               <img src="{!! asset('businesses/'.Auth::user()->business_code.'/images/'.Auth::user()->avatar) !!}" alt="{!! Auth::user()->name !!}">
                                                            @else
                                                               <img src="https://ui-avatars.com/api/?name={!! Auth::user()->name !!}&rounded=false&size=40"  alt="{!! Auth::user()->name !!}">
                                                            @endif
                                                            <textarea class="form-control ml-1" wire:model="reply" rows="4"></textarea>
                                                            <input type="text" wire:model="parent_comment" class="form-control" value="{!! $comment->comment_code !!}">
                                                            <input type="text" class="form-control" value="{!! $taskCode !!}">
                                                         </div>
                                                         <div class="mt-2 text-right">
                                                            <button class="btn btn-success btn-sm" type="button">Post Reply</button>
                                                         </div>
                                                      </div>
                                                      @foreach(Job::task_comment_replies($jobCode,$comment->comment_code) as $reply)
                                                         <li class="clearfix">
                                                            <img src="https://bootdey.com/img/Content/user_3.jpg" class="avatar" alt="">
                                                            <div class="post-comments">
                                                               <p class="meta">
                                                                  Dec 20, 2014 <a href="#">JohnDoe</a>
                                                                  <i class="pull-right"><a href="#"><small>Reply</small></a></i>
                                                               </p>
                                                               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam a sapien odio, sit amet</p>
                                                            </div>
                                                         </li>
                                                      @endforeach
                                                   </ul> --}}
                                                </li>
                                             @endforeach
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        @endif

                        <div wire:loading wire:target="change_task_view">
                           <div class="panel">
                              <div class="panel-body">
                                 <center><img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load" alt="" width="35%"></center>
                              </div>
                           </div>
                        </div>

                     </div>
                     <div class="col-md-4 task-single-col-right">
                        <h5><i class="fal fa-info-circle"></i> Task Info</h5>
                        <p>
                           <b><i class="fad fa-star-half-alt"></i> Status :</b>
                           @if($taskDetails->status)
                              @php
                                 $statusInfo = Wingu::status($taskDetails->status);
                              @endphp
                              <span class="badge {!! $statusInfo->name !!}">{!! $statusInfo->name !!}</span>
                           @endif
                           <br>
                           <b><i class="fal fa-calendar-plus"></i> Start Date :</b>
                           @if($taskDetails->start_date) {!! date('F jS, Y', strtotime($taskDetails->start_date)) !!} @endif
                           <br>
                           <b><i class="fal fa-calendar-times"></i> End Date :</b> @if($taskDetails->start_date) {!! date('F jS, Y', strtotime($taskDetails->start_date)) !!} @endif
                           <br>
                           <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                           @if($taskDetails->priority)
                              @php
                                 $priorityInfo = Wingu::status($taskDetails->priority);
                              @endphp
                              <span class="badge {!! $priorityInfo->name !!}">{!! $priorityInfo->name !!}</span>
                           @endif
                        </p>
                        <p class="border-bottom"></p>
                        <h5><i class="fal fa-folder"></i> Documents </h5>
                        <!-- begin widget-list -->
                        <div class="widget-list rounded mb-4">
                           @foreach(Job::task_attachments($taskDetails->task_code) as $document)
                              <div class="widget-list-item mb-1">
                                 <div class="widget-list-media">
                                    @if(Helper::like_match('%image%',$document->file_mime))
                                       <i class="rounded fas fa-file-image fa-3x"></i>
                                    @elseif(Helper::like_match('%pdf%',$document->file_mime))
                                       <i class="rounded fas fa-file-pdf fa-3x"></i>
                                    @elseif(Helper::like_match('%word%',$document->file_mime))
                                       <i class="rounded fas fa-file-word fa-3x"></i>
                                    @elseif(Helper::like_match('%zip%',$document->file_mime))
                                       <i class="rounded fas fa-file-archive fa-3x"></i>
                                    @elseif(Helper::like_match('%excel%',$document->file_mime))
                                       <i class="rounded fas fa-file-excel fa-3x"></i>
                                    @elseif(Helper::like_match('%powerpoint%',$document->file_mime))
                                       <i class="rounded fas fa-file-powerpoint fa-3x"></i>
                                    @elseif(Helper::like_match('%application%',$document->file_mime))
                                       <i class="rounded far fa-file-code fa-3x"></i>
                                    @else
                                       <i class="rounded far fa-file fa-3x"></i>
                                    @endif
                                 </div>
                                 <div class="widget-list-content">
                                    <h4 class="widget-list-title"><a href="" target="_blank">{!! $document->name !!}</a></h4>
                                    <p class="widget-list-desc">{!! $document->file_mime !!}</p>
                                 </div>
                                 <div class="widget-list-action">
                                    <a href="#" data-toggle="dropdown" class="text-gray-500"><i class="fa fa-ellipsis-h fs-14px"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                       <a href="{!! asset('businesses/'.Wingu::business()->business_code.'/jobs/'.$jobCode.'/'.$document->file_name) !!}" class="dropdown-item" target="_blank">Download</a>
                                       {{-- <a href="#" class="dropdown-item">Edit Title</a>
                                       <a href="#" class="dropdown-item">Delete</a> --}}
                                    </div>
                                 </div>
                              </div>
                           @endforeach
                        </div>
                        <!-- end widget-list -->
                        <!-- end widget-list -->
                        <p class="border-bottom"></p>
                        <h5><i class="fal fa-users"></i> Assignees</h5>
                        @foreach(Job::task_allocations($taskDetails->task_code) as $alloc)
                           @if(Wingu::check_user($alloc->user) == 1)
                              @php
                                 $allocededUser = Wingu::user($alloc->user);
                              @endphp
                              @if( $allocededUser->avatar)
                                 <img alt="{!! $allocededUser->name !!}" src="{!! asset('businesses/'.Wingu::business()->business_code.'/users/'. $allocededUser->user_code.'/'. $allocededUser->avatar) !!}" title="{!! $allocededUser->name !!}" class="mr-1">
                              @else
                                 <img alt="{!! $allocededUser->name !!}" src="https://ui-avatars.com/api/?name={!! $allocededUser->name !!}&rounded=true&size=35" title="{!! $allocededUser->name !!}" class="mr-1">
                              @endif
                           @endif
                        @endforeach
                        <p class="border-bottom mt-3"></p>
                        <p>
                           Created at <b>{!! date('F jS, Y', strtotime($taskDetails->created_at)) !!}</b><br>
                           @if($taskDetails->created_by)
                           Created by <b>{!! Wingu::user($taskDetails->created_by)->name !!}</b>
                           @endif
                        </p>
                        <p class="border-bottom"></p>
                     </div>
                  </div>
               </div>
            @else
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load float-right" alt="" style="width: 70%; justify-content: center;align-items: center;padding-left: 30%; padding-top: 30%">
            @endif
         </div>
      </div>
   </div>
</div>
