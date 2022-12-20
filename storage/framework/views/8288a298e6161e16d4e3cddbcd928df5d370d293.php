<div>
   <div class="row">
      <div class="col-md-12 mb-3">
         <div class="row">
            <div class="col-md-8">
               <h4 class="font-weight-bold"><i class="fal fa-check-square"></i> Job Tasks | <a href="<?php echo route('job.dashboard',$this->jobCode); ?>"><?php echo $job->job_title; ?></a> | <?php echo $sectionDetails->title; ?></h4>
            </div>
            <div class="col-md-2">
               <button data-toggle="modal" data-target="#addTaskGroup" class="btn btn-block btn-sm btn-success">
                  <i class="fas fa-plus-circle"></i> Add Task Group
               </button>
            </div>
            <div class="col-md-2">
               <a class="btn btn-grey text-white btn-block btn-sm" data-toggle="modal" data-target="#add-section">
                  <i class="fas fa-sticky-note"></i> Add Task Section
               </a>
            </div>
         </div>
      </div>

      <?php if($sections->count() > 0): ?>
         <div class="col-md-12">
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
               <li class="nav-item">
                  <a class="nav-link" href="<?php echo route('job.task',$this->jobCode); ?>">General</a>
               </li>
               <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                     $url = Helper::seoUrl($sec->title);
                  ?>
                  <li class="nav-item">
                     <a class="nav-link <?php echo Nav::isResource($url); ?>" href="<?php echo route('job.task.section',[$this->jobCode,$sec->section_code,$url]); ?>"><?php echo $sec->title; ?></a>
                  </li>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
         </div>
      <?php endif; ?>
      <?php
         $getSectionCode = json_encode($this->sectionCode);
      ?>
      
      <div class="col-md-12">
         <a class="btn btn-sm btn-danger float-right" data-toggle="modal" data-target="#delete" wire:click="remove_section(<?php echo e($getSectionCode); ?>)" href="#"><i class="fas fa-trash-alt"></i> Delete Section</a>
         <a class="btn btn-sm btn-primary float-right mr-2" wire:click="edit_section(<?php echo e($getSectionCode); ?>)" data-toggle="modal" data-target="#edit-section" href="#"><i class="fas fa-edit"></i> Edit Section</a>
      </div>

      <div class="task-board">
         <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
               $getGroupCode = json_encode($group->group_code);
            ?>
            <div class="status-card">
               <div class="card-header" <?php if($group->color): ?>style="color:#fff;background-color:<?php echo $group->color; ?>;"<?php endif; ?>>
                  <span class="card-header-text mb-2">
                     <?php echo $group->name; ?> (<?php echo Job::group_tasks($group->group_code)->count(); ?>)
                     <a wire:click="delete_alert(<?php echo e($getGroupCode); ?>,'group')" data-toggle="modal" data-target="#delete" href="#">
                        <i class="fas fa-trash-alt <?php if($group->color): ?> text-white <?php else: ?> text-danger <?php endif; ?> float-right mr-2"></i>
                     </a>

                     <a wire:click="editGroup(<?php echo e($getGroupCode); ?>)" data-toggle="modal" data-target="#updateTaskGroup" href="#">
                        <i class="fas fa-edit <?php if($group->color): ?> text-white <?php else: ?> text-info <?php endif; ?> float-right mr-2"></i>
                     </a>

                     <a wire:click="addTaskModal(<?php echo e($getGroupCode); ?>)" data-toggle="modal" data-target="#addTask" href="#">
                        <i class="fas fa-plus-circle <?php if($group->color): ?> text-white <?php endif; ?> float-right mr-2"></i>
                     </a>
                  </span>
               </div>
               <ul class="sortable ui-sortable" id="sort<?php echo $group->id; ?>" data-status-id="<?php echo $group->group_code; ?>">
                  <?php $__currentLoopData = Job::group_tasks($group->group_code); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupTasks): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php
                        $getTaskCode = json_encode($groupTasks->task_code);
                     ?>
                     <li class="text-row ui-sortable-handle" data-task-id="<?php echo $groupTasks->task_code; ?>" style="border-top: 5px solid <?php echo $group->color; ?>;">
                        <a href="#" data-toggle="dropdown" class="pull-right"><i class="fa fa-ellipsis-h f-s-14"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                           <li><a class="text-primary" wire:click="complete(<?php echo e($getTaskCode); ?>)"><i class="far fa-check-circle"></i> Mark as Complete</a></li>
                        </ul>
                        <h5>
                           <a wire:click="view_task(<?php echo e($getTaskCode); ?>,'overview')" data-toggle="modal" data-target="#taskview" class="text-dark">
                              <?php if($groupTasks->status == 16): ?><strike><?php echo $groupTasks->title; ?></strike><?php else: ?> <?php echo $groupTasks->title; ?> <?php endif; ?>
                           </a>
                        </h5>
                        <p class="font-small">
                           <?php if($groupTasks->priority): ?>
                              <i class="fal fa-exclamation-triangle"></i> Priority :
                              <span class="badge <?php echo Wingu::status($groupTasks->priority)->name; ?>"><?php echo Wingu::status($groupTasks->priority)->name; ?></span> |
                           <?php endif; ?>
                           <?php if($groupTasks->status): ?>
                              <i class="fal fa-heartbeat"></i> Status :
                              <span class="badge <?php echo Wingu::status($groupTasks->status)->name; ?>"><?php echo Wingu::status($groupTasks->status)->name; ?></span> |
                           <?php endif; ?>
                           <?php if($groupTasks->start_date): ?>
                           <i class="fal fa-calendar-day"></i> Task Date :  <span class="text-success"><b><?php echo date('d F Y', strtotime($groupTasks->start_date)); ?></b></span>
                           <?php endif; ?>
                           <?php if($groupTasks->due_date): ?>
                           | <i class="fal fa-calendar-times"></i> Due Date : <span class="text-warning"><b><?php echo date('d F Y', strtotime($groupTasks->due_date)); ?></b></span>
                           <?php endif; ?>
                           | <i class="fal fa-paperclip"></i> Attachment : <b><?php echo Job::task_attachments($groupTasks->task_code)->count(); ?></b>
                           | <i class="fal fa-comments"></i> Comments : <b><?php echo Job::task_comments($groupTasks->task_code)->count(); ?></b>
                        </p>
                        <div class="symbol-group symbol-hover mt-2 mb-3 ml-0">
                           <p class="mb-0">Assigned to:</p>
                           <?php $__currentLoopData = Job::task_allocations($groupTasks->task_code); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alloc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php if(Wingu::check_user($alloc->user) == 1): ?>
                                 <?php
                                    $allocededUser = Wingu::user($alloc->user);
                                 ?>
                                 <?php if( $allocededUser->avatar): ?>
                                    <img alt="<?php echo $allocededUser->name; ?>" src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/users/'. $allocededUser->user_code.'/'. $allocededUser->avatar); ?>" title="<?php echo $allocededUser->name; ?>" class="mr-1">
                                 <?php else: ?>
                                    <img alt="<?php echo $allocededUser->name; ?>" src="https://ui-avatars.com/api/?name=<?php echo $allocededUser->name; ?>&rounded=true&size=35" title="<?php echo $allocededUser->name; ?>" class="mr-1">
                                 <?php endif; ?>
                              <?php endif; ?>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <hr>
                        <a data-toggle="modal" data-target="#taskview" wire:click="view_task(<?php echo e($getTaskCode); ?>,'overview')" class="btn btn-xs btn-warning text-white"><i class="fal fa-eye"></i> View</a>
                        <a data-toggle="modal" data-target="#editTask" wire:click="edit_task(<?php echo e($getTaskCode); ?>)" class="btn btn-xs btn-primary text-white"><i class="fal fa-edit"></i> Edit</a>
                        <a wire:click="delete_alert(<?php echo e($getTaskCode); ?>,'task')" data-toggle="modal" data-target="#delete" class="btn btn-xs btn-danger text-white"><i class="fal fa-trash"></i> Delete</a>
                     </li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </ul>
               <a wire:click="addTaskModal(<?php echo e($getGroupCode); ?>)" data-toggle="modal" data-target="#addTask" href="#" class="badge badge-info ml-2 mt-2 mb-2"><i class="fas fa-plus-circle"></i> Add Task</a>
            </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      
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
                           <?php $__errorArgs = ['group_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                           <label for="">Section</label>
                           <select wire:model="group_section" class="form-control select2">
                              <option value="">Choose section</option>
                              <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupSection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $groupSection->section_code; ?>"><?php echo $groupSection->title; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                           <?php $__errorArgs = ['group_section'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load float-right" alt="" width="30%">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      
      <?php if($editGroupModal="on"): ?>
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
                     <?php
                        $groupEditCode2 = json_encode($groupEditCode);
                     ?>
                     <div class="row mb-5">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Group Title</label>
                              <input type="text" class="form-control" placeholder="Enter title" wire:model.defer="group_title" />
                              <?php $__errorArgs = ['group_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                           </div>
                           <div class="form-group">
                              <label for="">Section</label>
                              <select wire:model.defer="group_section" class="form-control select2">
                                 <option value="">Choose section</option>
                                 <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupSection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $groupSection->section_code; ?>"><?php echo $groupSection->title; ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                              <?php $__errorArgs = ['group_section'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                           <button class="btn btn-success btn-sm mt-4" wire:click="update_group(<?php echo e($groupEditCode2); ?>)" wire:loading.class="none">Update Task Group</button>
                           <div wire:loading wire:target="update_group">
                              <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load float-right" alt="" width="30%">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      <?php endif; ?>

      
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
                           <?php $__errorArgs = ['task_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                              <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $member->user_code; ?>"><?php echo $member->name; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div wire:ignore class="form-group">
                           <?php echo Form::label('Description', 'Details', array('class'=>'control-label mb-3')); ?>

                           <textarea wire:model.defer="details" data-details="window.livewire.find('<?php echo e($_instance->id); ?>')" class="form-control" id="details" cols="30" rows="10"></textarea>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" wire:click.prevent="add_task()" id="save_task" class="btn btn-pink submit" wire:loading.class="none"><i class="fas fa-save"></i> Add task</button>
                  <div wire:loading wire:target="add_task">
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load float-right" alt="" width="15%">
                  </div>
               </div>
            </div>
         </div>
      </div>

      
      <?php if($editTask="on"): ?>
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
                              <?php $__errorArgs = ['task_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                 <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $member->user_code; ?>"><?php echo $member->name; ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div wire:ignore class="form-group">
                              <?php echo Form::label('Description', 'Details', array('class'=>'control-label mb-3')); ?>

                              <textarea wire:model="details" class="form-control" cols="30" rows="10"></textarea>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php
                     $editTaskCode2 = json_encode($editTaskCode);
                  ?>
                  <div class="modal-footer">

                     <button type="submit" wire:click="update_task(<?php echo e($editTaskCode2); ?>)" class="btn btn-pink" wire:loading.class="none"><i class="fas fa-save"></i> Update task</button>
                     <div wire:loading wire:target="update_task">
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load float-right" alt="" width="30%">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      <?php endif; ?>

      
      <div wire:ignore.self class="modal fade" id="edit-section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Section</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="form-group">
                     <label for="">Section Title</label>
                     <input type="text" wire:model="section_title" class="form-control" required>
                     <?php $__errorArgs = ['section_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-success" wire:click.prevent="update_section()">Update Section</button>
               </div>
            </div>
         </div>
      </div>

      
      <div wire:ignore.self class="modal task-modal-single right fade" id="taskview" tabindex="-1" role="dialog" aria-labelledby="right_modal_xl"  data-keyboard="false" data-backdrop="static">
         <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
               <?php if($taskCode): ?>
                  <?php
                     $parentTaskCode = json_encode($taskCode);
                  ?>
                  <div class="modal-header bg-grey-2">
                     <h4 class="modal-title"><?php echo $taskDetails->title; ?></h4>
                     <a href="#" wire:click="close()" class="btn btn-sm btn-danger">Close</a>
                  </div>
                  <div class="modal-body">
                     <div class="row">
                        <div class="col-md-8 task-single-col-left">
                           <ul class="nav nav-pills">
                              <li class="nav-item">
                                 <a  wire:click="change_task_view('overview',<?php echo e($parentTaskCode); ?>)" class="nav-link pointer-cursor <?php if($currentView == 'overview'): ?> active <?php endif; ?>">Overview</a>
                              </li>
                              <li class="nav-item">
                                 <a wire:click="change_task_view('checklist',<?php echo e($parentTaskCode); ?>)" class="nav-link pointer-cursor <?php if($currentView == 'checklist'): ?> active <?php endif; ?>">Checklist (<?php echo e($checklistItems->count()); ?>)</a>
                              </li>
                              <li class="nav-item">
                                 <a wire:click="change_task_view('comments',<?php echo e($parentTaskCode); ?>)" class="nav-link pointer-cursor <?php if($currentView == 'comments'): ?> active <?php endif; ?>">Comments (<?php echo $comments->count(); ?>)</a>
                              </li>
                           </ul>

                           <?php if($currentView == 'overview'): ?>
                              <div class="panel">
                                 <div class="panel-body">
                                    <h4>Task Details</h4>
                                    <?php echo $taskDetails->details; ?>

                                 </div>
                              </div>
                           <?php endif; ?>

                           <?php if($currentView == 'checklist'): ?>
                              
                              <div class="card-hover-shadow-2x mb-3 card">
                                 <div class="card-header">
                                    <i class="fa fa-tasks"></i> Checklist (<?php echo e($checklistItems->count()); ?>)
                                 </div>
                                 <div class="scroll-area-sm">
                                    <div style="position: static;" class="ps ps--active-y">
                                       <div class="ps-content">
                                          <ul class=" list-group list-group-flush">
                                             <?php $__currentLoopData = $checklistItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checkListCount=>$listItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                   $checkListCode = json_encode($listItem->task_code);
                                                ?>
                                                <li class="list-group-item">
                                                   <?php if($listItem->status == 16): ?>
                                                      <div class="todo-indicator bg-success"></div>
                                                   <?php else: ?>
                                                      <div class="todo-indicator bg-primary"></div>
                                                   <?php endif; ?>
                                                   <div class="widget-content p-0">
                                                      <div class="widget-content-wrapper">
                                                         <div class="widget-content-left mr-2">
                                                            <div class="custom-checkbox custom-control">
                                                               <?php if($listItem->status == 16): ?>
                                                                  <input class="custom-control-input" id="checkbox<?php echo e($checkListCount+1); ?>" type="checkbox"  checked wire:click="update_checklist_status(<?php echo e($parentTaskCode); ?>,<?php echo e($checkListCode); ?>,21)">
                                                               <?php else: ?>
                                                                  <input class="custom-control-input" id="checkbox<?php echo e($checkListCount+1); ?>" type="checkbox" wire:click="update_checklist_status(<?php echo e($parentTaskCode); ?>,<?php echo e($checkListCode); ?>,16)">
                                                               <?php endif; ?>
                                                               <label class="custom-control-label" for="checkbox<?php echo e($checkListCount+1); ?>">&nbsp;</label>
                                                            </div>
                                                         </div>
                                                         <div class="widget-content-left">
                                                            <div class="widget-heading">
                                                               <?php if($listItem->status == 16): ?>
                                                                  <strike><?php echo $listItem->title; ?></strike>
                                                               <?php else: ?>
                                                                  <?php echo $listItem->title; ?>

                                                               <?php endif; ?>
                                                               
                                                            </div>
                                                            <div class="widget-subheading">
                                                               <i>added on <?php echo date('F jS, Y', strtotime($listItem->created_at)); ?></i>
                                                               <?php if($listItem->status == 16): ?>
                                                                  | <i>completed on <?php echo date('F jS, Y', strtotime($listItem->close_date)); ?></i>
                                                               <?php endif; ?>
                                                            </div>
                                                         </div>
                                                         <div class="widget-content-right">
                                                            <?php if($listItem->status == 16): ?>
                                                               <button class="border-0 btn-transition btn btn-outline-primary pointer-cursor" wire:loading.class="none" wire:click="update_checklist_status(<?php echo e($parentTaskCode); ?>,<?php echo e($checkListCode); ?>,21)">
                                                                  <i class="fal fa-redo fa-2x"></i>
                                                               </button>
                                                            <?php else: ?>
                                                               <button class="border-0 btn-transition btn btn-outline-success pointer-cursor" wire:loading.class="none" wire:click="update_checklist_status(<?php echo e($parentTaskCode); ?>,<?php echo e($checkListCode); ?>,16)">
                                                                  <i class="fal fa-check-circle fa-2x"></i>
                                                               </button>
                                                            <?php endif; ?>
                                                            <button class="border-0 btn-transition btn btn-outline-danger pointer-cursor" wire:loading.class="none" wire:click="delete_checklist(<?php echo e($parentTaskCode); ?>,<?php echo e($checkListCode); ?>)">
                                                               <i class="fal fa-times-circle fa-2x"></i>
                                                            </button>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </li>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="d-block text-right card-footer">
                                    <form class="row" wire:submit.prevent="add_checklist(<?php echo e($parentTaskCode); ?>)">
                                       <div class="col-md-10">
                                          <input type="text" wire:model.defer="checklist_task" class="form-control" placeholder="Add new checklist">
                                          <?php $__errorArgs = ['checklist_task'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                       </div>
                                       <div class="col-md-2">
                                          <button class="btn btn-primary" wire:loading.class="none"><i class="fas fa-save"></i> Add Task</button>
                                          <div wire:loading wire:target="add_checklist">
                                             <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="img-responsive" alt="loader">
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           <?php endif; ?>

                           <?php if($currentView == 'comments'): ?>
                              <div class="panel" wire:loading.class="none">
                                 <div class="panel-body">
                                    <h5 class="mb-2">Comments (<?php echo $comments->count(); ?>)
                                       <a data-toggle="collapse" aria-expanded="true" aria-controls="collapse-1" href="#collapse-1" class="float-right badge badge-warning">Comment Box</a>
                                    </h5>
                                    <form id="collapse-1" class="border-bottom collapse" action="<?php echo route('task.comment.store'); ?>" method="POST" enctype="multipart/form-data">
                                       <?php echo csrf_field(); ?>
                                       <div class="form-group">
                                          <textarea name="comment" class="form-control" rows="6"></textarea>
                                          <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                       </div>
                                       <div class="form-group">
                                          <label for="customFile">Attach File</label><br>
                                          <input type="text" name="file_title" class="form-control mb-2" placeholder="File title">
                                          <input type="file" name="comment_files[]" class="form-control" multiple>
                                       </div>
                                       <input type="hidden" name="jobCode" value="<?php echo $jobCode; ?>" required>
                                       <input type="hidden" name="taskCode" value="<?php echo $taskDetails->task_code; ?>" required>
                                       <button type="submit" class="btn btn-success submit mb-3"><i class="fas fa-save"></i> Post comment</button>
                                       <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                                    </form>
                                    <div class="row mt-3">
                                       <div class="col-md-12">
                                          <div class="blog-comment">
                                             <ul class="comments">
                                                <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                   <li class="clearfix">
                                                      <?php if($comm->profile_picture): ?>
                                                         <img src="<?php echo asset('businesses/'.Auth::user()->business_code.'/images/'.$comm->profile_picture); ?>" class="avatar" alt="<?php echo $comm->user_name; ?>">
                                                      <?php else: ?>
                                                         <img src="https://ui-avatars.com/api/?name=<?php echo $comm->user_name; ?>&rounded=false&size=70" class="avatar" alt="<?php echo $comm->user_name; ?>">
                                                      <?php endif; ?>
                                                      <div class="post-comments">
                                                         <p class="meta">
                                                            <b><a href="#"><?php echo $comm->user_name; ?></a></b>
                                                            | <i class="fal fa-clock-o"></i> <?php echo Helper::get_timeago(strtotime($comm->comment_date)); ?>

                                                            
                                                         </p>
                                                         <p><?php echo $comm->user_comment; ?></p>
                                                      </div>
                                                      
                                                   </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           <?php endif; ?>

                           <div wire:loading wire:target="change_task_view">
                              <div class="panel">
                                 <div class="panel-body">
                                    <center><img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load" alt="" width="35%"></center>
                                 </div>
                              </div>
                           </div>

                        </div>
                        <div class="col-md-4 task-single-col-right">
                           <h5><i class="fal fa-info-circle"></i> Task Info</h5>
                           <p>
                              <b><i class="fad fa-star-half-alt"></i> Status :</b>
                              <?php if($taskDetails->status): ?>
                                 <?php
                                    $statusInfo = Wingu::status($taskDetails->status);
                                 ?>
                                 <span class="badge <?php echo $statusInfo->name; ?>"><?php echo $statusInfo->name; ?></span>
                              <?php endif; ?>
                              <br>
                              <b><i class="fal fa-calendar-plus"></i> Start Date :</b>
                              <?php if($taskDetails->start_date): ?> <?php echo date('F jS, Y', strtotime($taskDetails->start_date)); ?> <?php endif; ?>
                              <br>
                              <b><i class="fal fa-calendar-times"></i> End Date :</b> <?php if($taskDetails->start_date): ?> <?php echo date('F jS, Y', strtotime($taskDetails->start_date)); ?> <?php endif; ?>
                              <br>
                              <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                              <?php if($taskDetails->priority): ?>
                                 <?php
                                    $priorityInfo = Wingu::status($taskDetails->priority);
                                 ?>
                                 <span class="badge <?php echo $priorityInfo->name; ?>"><?php echo $priorityInfo->name; ?></span>
                              <?php endif; ?>
                           </p>
                           <p class="border-bottom"></p>
                           <h5><i class="fal fa-folder"></i> Documents </h5>
                           <!-- begin widget-list -->
                           <div class="widget-list rounded mb-4">
                              <?php $__currentLoopData = Job::task_attachments($taskDetails->task_code); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <div class="widget-list-item mb-1">
                                    <div class="widget-list-media">
                                       <?php if(Helper::like_match('%image%',$document->file_mime)): ?>
                                          <i class="rounded fas fa-file-image fa-3x"></i>
                                       <?php elseif(Helper::like_match('%pdf%',$document->file_mime)): ?>
                                          <i class="rounded fas fa-file-pdf fa-3x"></i>
                                       <?php elseif(Helper::like_match('%word%',$document->file_mime)): ?>
                                          <i class="rounded fas fa-file-word fa-3x"></i>
                                       <?php elseif(Helper::like_match('%zip%',$document->file_mime)): ?>
                                          <i class="rounded fas fa-file-archive fa-3x"></i>
                                       <?php elseif(Helper::like_match('%excel%',$document->file_mime)): ?>
                                          <i class="rounded fas fa-file-excel fa-3x"></i>
                                       <?php elseif(Helper::like_match('%powerpoint%',$document->file_mime)): ?>
                                          <i class="rounded fas fa-file-powerpoint fa-3x"></i>
                                       <?php elseif(Helper::like_match('%application%',$document->file_mime)): ?>
                                          <i class="rounded far fa-file-code fa-3x"></i>
                                       <?php else: ?>
                                          <i class="rounded far fa-file fa-3x"></i>
                                       <?php endif; ?>
                                    </div>
                                    <div class="widget-list-content">
                                       <h4 class="widget-list-title"><a href="" target="_blank"><?php echo $document->name; ?></a></h4>
                                       <p class="widget-list-desc"><?php echo $document->file_mime; ?></p>
                                    </div>
                                    <div class="widget-list-action">
                                       <a href="#" data-toggle="dropdown" class="text-gray-500"><i class="fa fa-ellipsis-h fs-14px"></i></a>
                                       <div class="dropdown-menu dropdown-menu-end">
                                          <a href="<?php echo asset('businesses/'.Wingu::business()->business_code.'/jobs/'.$jobCode.'/'.$document->file_name); ?>" class="dropdown-item" target="_blank">Download</a>
                                          
                                       </div>
                                    </div>
                                 </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </div>
                           <!-- end widget-list -->
                           <!-- end widget-list -->
                           <p class="border-bottom"></p>
                           <h5><i class="fal fa-users"></i> Assignees</h5>
                           <?php $__currentLoopData = Job::task_allocations($taskDetails->task_code); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alloc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php if(Wingu::check_user($alloc->user) == 1): ?>
                                 <?php
                                    $allocededUser = Wingu::user($alloc->user);
                                 ?>
                                 <?php if( $allocededUser->avatar): ?>
                                    <img alt="<?php echo $allocededUser->name; ?>" src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/users/'. $allocededUser->user_code.'/'. $allocededUser->avatar); ?>" title="<?php echo $allocededUser->name; ?>" class="mr-1">
                                 <?php else: ?>
                                    <img alt="<?php echo $allocededUser->name; ?>" src="https://ui-avatars.com/api/?name=<?php echo $allocededUser->name; ?>&rounded=true&size=35" title="<?php echo $allocededUser->name; ?>" class="mr-1">
                                 <?php endif; ?>
                              <?php endif; ?>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <p class="border-bottom mt-3"></p>
                           <p>
                              Created at <b><?php echo date('F jS, Y', strtotime($taskDetails->created_at)); ?></b><br>
                              <?php if($taskDetails->created_by): ?>
                              Created by <b><?php echo Wingu::user($taskDetails->created_by)->name; ?></b>
                              <?php endif; ?>
                           </p>
                           <p class="border-bottom"></p>
                        </div>
                     </div>
                  </div>
               <?php else: ?>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load float-right" alt="" style="width: 70%; justify-content: center;align-items: center;padding-left: 30%; padding-top: 30%">
               <?php endif; ?>
            </div>
         </div>
      </div>

      <!-- delete modal -->
      <div wire:ignore.self id="delete" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-confirm">
            <?php if($deleteType): ?>
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
                     <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="delete_close()">Cancel</button>
                     <?php
                        $deleteCode2 = json_encode($deleteCode);
                     ?>
                     <?php if($deleteType == 'section'): ?>
                        <button type="button" class="btn btn-danger" wire:click="delete_section(<?php echo e($getSectionCode); ?>)">Delete</button>
                     <?php endif; ?>
                     <?php if($deleteType == 'task'): ?>
                        <button type="button" class="btn btn-danger" wire:click="delete_task(<?php echo e($deleteCode2); ?>)">Delete</button>
                     <?php endif; ?>
                     <?php if($deleteType == 'group'): ?>
                        <button type="button" class="btn btn-danger" wire:click="delete_group(<?php echo e($deleteCode2); ?>)">Delete</button>
                     <?php endif; ?>
                  </div>
               </div>
            <?php endif; ?>
         </div>
      </div>
   </div>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.sections', ['jobCode' => $jobCode])->html();
} elseif ($_instance->childHasBeenRendered('3bTW27s')) {
    $componentId = $_instance->getRenderedChildComponentId('3bTW27s');
    $componentTag = $_instance->getRenderedChildComponentTagName('3bTW27s');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('3bTW27s');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.sections', ['jobCode' => $jobCode]);
    $html = $response->html();
    $_instance->logRenderedChild('3bTW27s', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>
<?php $__env->startSection('script2'); ?>
   <script>
      $(function(){
         $('#memberSelect').on('change', function(){
            window.livewire.find('<?php echo e($_instance->id); ?>').set('assignMembers', $(this).val());
         });
      });
   </script>
<?php $__env->stopSection(); ?>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/jobs/job/task-section.blade.php ENDPATH**/ ?>