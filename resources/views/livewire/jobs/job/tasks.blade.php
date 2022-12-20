<div>
   <div class="row">

      <div class="col-md-12 mb-3">
         <div class="row">
            <div class="col-md-10">
               <h4 class="font-weight-bold"><i class="fal fa-check-square"></i> Job Tasks | <a href="{!! route('job.dashboard',$this->jobCode) !!}">{!! $job->job_title !!}</a> </h4>
            </div>
            <div class="col-md-2">
               <button data-toggle="modal" data-target="#addTaskGroup" class="btn btn-block btn-sm btn-success">
                  <i class="fas fa-plus-circle"></i> Add Task Group
               </button>
            </div>
         </div>
      </div>

      @if($sections->count() > 0)
         <div class="col-md-12">
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
               <li class="nav-item">
                  <a class="nav-link active" href="{!! route('job.task',$this->jobCode) !!}">General</a>
               </li>
               @foreach($sections as $sec)
                  <li class="nav-item">
                     <a class="nav-link" href="{!! route('job.task.section',[$this->jobCode,$sec->section_code,Helper::seoUrl($sec->title)]) !!}">{!! $sec->title !!}</a>
                  </li>
               @endforeach
            </ul>
         </div>
      @endif

      <div class="task-board">
         @foreach($groups as $group)
            @php
               $getGroupCode = json_encode($group->group_code);
            @endphp
            <div class="status-card">
               <div class="card-header" @if($group->color)style="color:#fff;background-color:{!!$group->color!!};"@endif>
                  <span class="card-header-text mb-2">
                     {!! $group->name !!} ({!! Job::group_tasks($group->group_code)->count() !!})
                     <a wire:click="delete_alert({{$getGroupCode}},'group')" data-toggle="modal" data-target="#delete" href="#">
                        <i class="fas fa-trash-alt @if($group->color) text-white @else text-danger @endif float-right mr-2"></i>
                     </a>

                     <a wire:click="editGroup({{$getGroupCode}})" data-toggle="modal" data-target="#updateTaskGroup" href="#">
                        <i class="fas fa-edit @if($group->color) text-white @else text-info @endif float-right mr-2"></i>
                     </a>

                     <a wire:click="addTaskModal({{$getGroupCode}})" data-toggle="modal" data-target="#addTask" href="#">
                        <i class="fas fa-plus-circle @if($group->color) text-white @endif float-right mr-2"></i>
                     </a>
                  </span>
               </div>
               <ul class="sortable ui-sortable" id="sort{!! $group->id !!}" data-status-id="{!! $group->group_code !!}"> 
                  @foreach(Job::group_tasks($group->group_code) as $groupTasks)
                     @php
                        $getTaskCode = json_encode($groupTasks->task_code);
                     @endphp
                     <li class="text-row ui-sortable-handle" data-task-id="{!! $groupTasks->task_code !!}" style="border-top: 5px solid {!!$group->color!!};">
                        <a href="#" data-toggle="dropdown" class="pull-right"><i class="fa fa-ellipsis-h f-s-14"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                           <li><a class="text-primary" wire:click="complete({{$getTaskCode}})"><i class="far fa-check-circle"></i> Mark as Complete</a></li>
                        </ul>
                        <h5>
                           <a wire:click="view_task({{$getTaskCode}},'overview')" data-toggle="modal" data-target="#taskview" class="text-dark">
                              @if($groupTasks->status == 16)<strike>{!! $groupTasks->title !!}</strike>@else {!! $groupTasks->title !!} @endif
                           </a>
                        </h5>
                        <p class="font-small">
                           @if($groupTasks->priority)
                              <i class="fal fa-exclamation-triangle"></i> Priority :
                              <span class="badge {!! Wingu::status($groupTasks->priority)->name !!}">{!! Wingu::status($groupTasks->priority)->name !!}</span> |
                           @endif
                           @if($groupTasks->status)
                              <i class="fal fa-heartbeat"></i> Status :
                              <span class="badge {!! Wingu::status($groupTasks->status)->name !!}">{!! Wingu::status($groupTasks->status)->name !!}</span> |
                           @endif
                           @if($groupTasks->start_date)
                           <i class="fal fa-calendar-day"></i> Task Date :  <span class="text-success"><b>{!! date('d F Y', strtotime($groupTasks->start_date)) !!}</b></span>
                           @endif
                           @if($groupTasks->due_date)
                           | <i class="fal fa-calendar-times"></i> Due Date : <span class="text-warning"><b>{!! date('d F Y', strtotime($groupTasks->due_date)) !!}</b></span>
                           @endif
                           | <i class="fal fa-paperclip"></i> Attachment : <b>{!! Job::task_attachments($groupTasks->task_code)->count() !!}</b>
                           | <i class="fal fa-comments"></i> Comments : <b>{!! Job::task_comments($groupTasks->task_code)->count() !!}</b>
                        </p>
                        <div class="symbol-group symbol-hover mt-2 mb-3 ml-0">
                           <p class="mb-0">Assigned to:</p>
                           @foreach(Job::task_allocations($groupTasks->task_code) as $alloc)
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
                        </div>
                        <hr>
                        <a data-toggle="modal" data-target="#taskview" wire:click="view_task({{$getTaskCode}},'overview')" class="btn btn-xs btn-warning text-white"><i class="fal fa-eye"></i> View</a>
                        <a data-toggle="modal" data-target="#editTask" wire:click="edit_task({{$getTaskCode}})" class="btn btn-xs btn-primary text-white"><i class="fal fa-edit"></i> Edit</a>
                        <a wire:click="delete_alert({{$getTaskCode}},'task')" data-toggle="modal" data-target="#delete" class="btn btn-xs btn-danger text-white"><i class="fal fa-trash"></i> Delete</a>
                     </li>
                  @endforeach
               </ul>
               <a wire:click="addTaskModal({{$getGroupCode}})" data-toggle="modal" data-target="#addTask" href="#" class="badge badge-info ml-2 mt-2 mb-2"><i class="fas fa-plus-circle"></i> Add Task</a>
            </div>
         @endforeach
      </div>

      {{-- task groups --}}
      <div wire:ignore.self class="modal fade" id="addTaskGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <!--begin::Modal dialog-->
         <div class="modal-dialog">
            <!--begin::Modal content-->
            <div class="modal-content">
               <!--begin::Modal header-->
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Task Group</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <!--begin::Modal header-->
               <!--begin::Modal body-->
               <div class="modal-body">
                  <div class="row mb-5">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Group Title</label>
                           <input type="text" class="form-control" placeholder="Enter title" wire:model="group_title" />
                           @error('group_title')<span class="error text-danger">{{$message}}</span>@enderror
                        </div>
                        <div class="form-group">
                           <label for="">Section</label>
                           <select wire:model="group_section" class="form-control select2">
                              <option value="">Choose section</option>
                              @foreach($sections as $groupSection)
                                 <option value="{!! $groupSection->section_code !!}">{!! $groupSection->title !!}</option>
                              @endforeach
                           </select>
                           @error('group_section')<span class="error text-danger">{{$message}}</span>@enderror
                        </div>
                        <div class="form-group">
                           <label for="">Label</label>
                           <select wire:model="color" class="form-control select2">
                              <option value="">Choose Label</option>
                              <option value="#468847">Green</option>
                              <option value="#348fe2">Blue</option>
                              <option value="#ebeb35">Yellow</option>
                              <option value="#000000">Black</option>
                              <option value="#8753de">Purple</option>
                              <option value="#FF0000">Red</option>
                              <option value="#00FFFF">Cyan / Aqua</option>
                              <option value="#FF00FF">Magenta / Fuchsia	</option>
                              <option value="#C0C0C0">Silver</option>
                              <option value="#808080">Gray</option>
                              <option value="#800000">Maroon</option>
                              <option value="#808000">Olive</option>
                              <option value="#008080">Teal</option>
                              <option value="#f59c1a">Orange</option>
                              <option value="#000080">Navy</option>
                           </select>
                        </div>
                        <button class="btn btn-success btn-sm mt-4" wire:click="add_task_group()" wire:loading.class="none">Add Task Group</button>
                        <div wire:loading wire:target="add_task_group">
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load float-right" alt="" width="30%">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      {{-- edit task groups --}}
      @if($editGroupModal="on")
         <div wire:ignore.self class="modal fade" id="updateTaskGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog">
               <!--begin::Modal content-->
               <div class="modal-content">
                  <!--begin::Modal header-->
                  <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle">Update Task Group</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     @php
                        $groupEditCode2 = json_encode($groupEditCode);
                     @endphp
                     <div class="row mb-5">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Group Title</label>
                              <input type="text" class="form-control" placeholder="Enter title" wire:model.defer="group_title" />
                              @error('group_title')<span class="error text-danger">{{$message}}</span>@enderror
                           </div>
                           <div class="form-group">
                              <label for="">Section</label>
                              <select wire:model.defer="group_section" class="form-control select2">
                                 <option value="">Choose section</option>
                                 @foreach($sections as $groupSection)
                                    <option value="{!! $groupSection->section_code !!}">{!! $groupSection->title !!}</option>
                                 @endforeach
                              </select>
                              @error('group_section')<span class="error text-danger">{{$message}}</span>@enderror
                           </div>
                           <div class="form-group">
                              <label for="">Label</label>
                              <select wire:model="color" class="form-control select2">
                                 <option value="">Choose Label</option>
                                 <option value="#468847">Green</option>
                                 <option value="#348fe2">Blue</option>
                                 <option value="#ebeb35">Yellow</option>
                                 <option value="#000000">Black</option>
                                 <option value="#8753de">Purple</option>
                                 <option value="#FF0000">Red</option>
                                 <option value="#00FFFF">Cyan / Aqua</option>
                                 <option value="#FF00FF">Magenta / Fuchsia	</option>
                                 <option value="#C0C0C0">Silver</option>
                                 <option value="#808080">Gray</option>
                                 <option value="#800000">Maroon</option>
                                 <option value="#808000">Olive</option>
                                 <option value="#008080">Teal</option>
                                 <option value="#f59c1a">Orange</option>
                                 <option value="#000080">Navy</option>
                              </select>
                           </div>
                           <button class="btn btn-success btn-sm mt-4" wire:click="update_group({{$groupEditCode2}})" wire:loading.class="none">Update Task Group</button>
                           <div wire:loading wire:target="update_group">
                              <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load float-right" alt="" width="30%">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      @endif

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
                     <div class="col-md-12">
                        <div wire:ignore class="form-group">
                           <label for="tasks_tasks_label_id">Assign Task</label>
                           <select class="form-control select2" id="memberSelect" multiple="multiple" wire:model="assignMembers">
                              @foreach($members as $member)
                                 <option value="{!! $member->user_code !!}">{!! $member->name !!}</option>
                              @endforeach
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
                              <label for="tasks_tasks_label_id">Assign Task</label>
                              <select id="memberSelect" class="form-control select2" multiple="multiple" wire:model="assignMembers">
                                 @foreach($members as $member)
                                    <option value="{!! $member->user_code !!}">{!! $member->name !!}</option>
                                 @endforeach
                              </select>
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

      <!-- delete modal -->
      <div wire:ignore.self id="delete" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-confirm">
            @if($deleteType)
               <div class="modal-content">
                  <div class="modal-header flex-column">
                     <div class="icon-box">
                        <i class="fal fa-times"></i>
                     </div>
                     <h4 class="modal-title w-100">Are you sure?</h4>
                  </div>
                  <div class="modal-body">
                     <p>Do you really want to delete these records? This process cannot be undone.</p>
                  </div>
                  <div class="modal-footer justify-content-center">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close()">Cancel</button>
                     @php
                        $deleteCode2 = json_encode($deleteCode);
                     @endphp
                     @if($deleteType == 'task')
                        <button type="button" class="btn btn-danger" wire:click="delete_task({{$deleteCode2}})">Delete</button>
                     @endif
                     @if($deleteType == 'group')
                        <button type="button" class="btn btn-danger" wire:click="delete_group({{$deleteCode2}})">Delete</button>
                     @endif
                  </div>
               </div>
            @endif
         </div>
      </div>
   </div>
</div>
@section('script2')
   <script>
      $(function(){
         $('#memberSelect').on('change', function(){
            @this.set('assignMembers', $(this).val());
         });
      });
   </script>
@endsection
