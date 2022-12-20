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
                  <a href="<?php echo route('job.mytask.list'); ?>">
                     <i class="far fa-list-ul"></i> All
                     <span class="label label-primary pull-right"><?php echo $allTasks->count(); ?></span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Today')" href="#">
                     <i class="fad fa-star text-warning"></i> Today
                     <span class="label label-yellow pull-right"><?php echo $todaysTasks->count(); ?></span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Tomorrow')" href="#">
                     <i class="fad fa-calendar-day"></i> Tomorrow
                     <span class="label label-warning pull-right"><?php echo $tomorrowTasks->count(); ?></span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Next 7 Days')" href="#">
                     <i class="fad fa-calendar-week"></i> Next 7 Days
                     <span class="label label-pink pull-right"><?php echo $next7DaysTasks->count(); ?></span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Past Due')" href="#">
                     <i class="fad fa-calendar-times"></i> Past Due
                     <span class="label label-danger pull-right"><?php echo $pastDueTasks->count(); ?></span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Waiting Approval')" href="#">
                     <i class="fad fa-history"></i> Waiting Approval
                     <span class="label label-purple pull-right"><?php echo $waitingApprovalTasks->count(); ?></span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Pending')" href="#">
                     <i class="fad fa-exclamation-circle"></i> Pending
                     <span class="label label-indigo pull-right"><?php echo $pendingTasks->count(); ?></span>
                  </a>
               </li>
               <li>
                  <a wire:click="change_view('Completed')" href="#">
                     <i class="fad fa-clipboard-check"></i> Completed
                     <span class="label label-green pull-right"><?php echo $completeTasks->count(); ?></span>
                  </a>
               </li>
               
            </ul>
            
            
         </aside>
         <aside class="lg-side">
            <div class="inbox-head">
               <h3><?php echo $view; ?> Tasks</h3>
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
                              <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $job->job_code; ?>"><?php echo $job->job_title; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <?php if($this->view == 'All'): ?>
                  <table class="table table-inbox table-hover">
                     <tbody>
                        <?php $__currentLoopData = $allTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($task->business_code == Auth::user()->business_code): ?>
                              <?php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              ?>
                              <tr class="">
                                 
                                 <td class="view-message">
                                    <a wire:click="view_task(<?php echo e($getTaskCode); ?>,'overview')" data-toggle="modal" data-target="#taskview" class="text-dark">
                                       <span class="font-bold font-14">
                                          <?php if($task->status == 16): ?>
                                             <strike><?php echo $task->title; ?></strike>
                                          <?php else: ?>
                                             <?php echo $task->title; ?>

                                          <?php endif; ?>
                                       </span>
                                       <br>
                                       <p class="font-small text-height-1">
                                          <?php if($task->priority): ?>
                                             <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                             <span class="badge <?php echo Wingu::status($task->priority)->name; ?>"><?php echo Wingu::status($task->priority)->name; ?></span> |
                                          <?php endif; ?>
                                          <?php if($task->status): ?>
                                             <b><i class="fal fa-heartbeat"></i> Status :</b>
                                             <span class="badge <?php echo Wingu::status($task->status)->name; ?>"><?php echo Wingu::status($task->status)->name; ?></span> |
                                          <?php endif; ?>
                                          <?php if($task->start_date): ?>
                                          <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success"><?php echo date('d F Y', strtotime($task->start_date)); ?></span>
                                          <?php endif; ?>
                                          <?php if($task->due_date): ?>
                                          | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning"><?php echo date('d F Y', strtotime($task->due_date)); ?></span>
                                          <?php endif; ?>
                                          | <b><i class="fal fa-paperclip"></i> Attachment :</b> <?php echo Job::task_attachments($task->task_code)->count(); ?>

                                          | <b><i class="fal fa-comments"></i> Comments :</b> <?php echo Job::task_comments($task->task_code)->count(); ?>

                                          <?php if($jobDetails->check == 1): ?>
                                          | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink"><?php echo $jobDetails->details->job_title; ?></span>
                                          <?php endif; ?>
                                       </p>
                                    </a>
                                 </td>
                                 
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
                           <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               <?php endif; ?>

               <?php if($this->view == 'Today'): ?>
                  <table class="table table-inbox table-hover">
                     <tbody>
                        <?php $__currentLoopData = $todaysTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($task->business_code == Auth::user()->business_code): ?>
                              <?php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              ?>
                              <tr class="">
                                 
                                 <td class="view-message">
                                    <span class="font-bold font-14"><?php if($task->status == 16): ?><strike><?php echo $task->title; ?></strike><?php else: ?> <?php echo $task->title; ?> <?php endif; ?></span><br>
                                    <p class="font-small text-height-1">
                                       <?php if($task->priority): ?>
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge <?php echo Wingu::status($task->priority)->name; ?>"><?php echo Wingu::status($task->priority)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->status): ?>
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge <?php echo Wingu::status($task->status)->name; ?>"><?php echo Wingu::status($task->status)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->start_date): ?>
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success"><?php echo date('d F Y', strtotime($task->start_date)); ?></span>
                                       <?php endif; ?>
                                       <?php if($task->due_date): ?>
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning"><?php echo date('d F Y', strtotime($task->due_date)); ?></span>
                                       <?php endif; ?>
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> <?php echo Job::task_attachments($task->task_code)->count(); ?>

                                       | <b><i class="fal fa-comments"></i> Comments :</b> <?php echo Job::task_comments($task->task_code)->count(); ?>

                                       <?php if($jobDetails->check == 1): ?>
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink"><?php echo $jobDetails->details->job_title; ?></span>
                                       <?php endif; ?>
                                    </p>
                                 </td>
                                 
                                 
                              </tr>
                           <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               <?php endif; ?>

               <?php if($this->view == 'Tomorrow'): ?>
                  <table class="table table-inbox table-hover">
                     <tbody>
                        <?php $__currentLoopData = $tomorrowTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($task->business_code == Auth::user()->business_code): ?>
                              <?php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              ?>
                              <tr class="">
                                 
                                 <td class="view-message">
                                    <span class="font-bold font-14"><?php if($task->status == 16): ?><strike><?php echo $task->title; ?></strike><?php else: ?> <?php echo $task->title; ?> <?php endif; ?></span><br>
                                    <p class="font-small text-height-1">
                                       <?php if($task->priority): ?>
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge <?php echo Wingu::status($task->priority)->name; ?>"><?php echo Wingu::status($task->priority)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->status): ?>
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge <?php echo Wingu::status($task->status)->name; ?>"><?php echo Wingu::status($task->status)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->start_date): ?>
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success"><?php echo date('d F Y', strtotime($task->start_date)); ?></span>
                                       <?php endif; ?>
                                       <?php if($task->due_date): ?>
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning"><?php echo date('d F Y', strtotime($task->due_date)); ?></span>
                                       <?php endif; ?>
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> <?php echo Job::task_attachments($task->task_code)->count(); ?>

                                       | <b><i class="fal fa-comments"></i> Comments :</b> <?php echo Job::task_comments($task->task_code)->count(); ?>

                                       <?php if($jobDetails->check == 1): ?>
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink"><?php echo $jobDetails->details->job_title; ?></span>
                                       <?php endif; ?>
                                    </p>
                                 </td>
                                 
                                 
                              </tr>
                           <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               <?php endif; ?>

               <?php if($this->view == 'Next 7 Days'): ?>
                  <table class="table table-inbox table-hover">
                     <tbody>
                        <?php $__currentLoopData = $next7DaysTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($task->business_code == Auth::user()->business_code): ?>
                              <?php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              ?>
                              <tr class="">
                                 
                                 <td class="view-message">
                                    <span class="font-bold font-14"><?php if($task->status == 16): ?><strike><?php echo $task->title; ?></strike><?php else: ?> <?php echo $task->title; ?> <?php endif; ?></span><br>
                                    <p class="font-small text-height-1">
                                       <?php if($task->priority): ?>
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge <?php echo Wingu::status($task->priority)->name; ?>"><?php echo Wingu::status($task->priority)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->status): ?>
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge <?php echo Wingu::status($task->status)->name; ?>"><?php echo Wingu::status($task->status)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->start_date): ?>
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success"><?php echo date('d F Y', strtotime($task->start_date)); ?></span>
                                       <?php endif; ?>
                                       <?php if($task->due_date): ?>
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning"><?php echo date('d F Y', strtotime($task->due_date)); ?></span>
                                       <?php endif; ?>
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> <?php echo Job::task_attachments($task->task_code)->count(); ?>

                                       | <b><i class="fal fa-comments"></i> Comments :</b> <?php echo Job::task_comments($task->task_code)->count(); ?>

                                       <?php if($jobDetails->check == 1): ?>
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink"><?php echo $jobDetails->details->job_title; ?></span>
                                       <?php endif; ?>
                                    </p>
                                 </td>
                                 
                                 
                              </tr>
                           <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               <?php endif; ?>

               <?php if($this->view == 'Past Due'): ?>
                  <table class="table table-inbox table-hover">
                     <tbody>
                        <?php $__currentLoopData = $pastDueTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($task->business_code == Auth::user()->business_code): ?>
                              <?php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              ?>
                              <tr class="">
                                 
                                 <td class="view-message">
                                    <span class="font-bold font-14"><?php if($task->status == 16): ?><strike><?php echo $task->title; ?></strike><?php else: ?> <?php echo $task->title; ?> <?php endif; ?></span><br>
                                    <p class="font-small text-height-1">
                                       <?php if($task->priority): ?>
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge <?php echo Wingu::status($task->priority)->name; ?>"><?php echo Wingu::status($task->priority)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->status): ?>
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge <?php echo Wingu::status($task->status)->name; ?>"><?php echo Wingu::status($task->status)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->start_date): ?>
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success"><?php echo date('d F Y', strtotime($task->start_date)); ?></span>
                                       <?php endif; ?>
                                       <?php if($task->due_date): ?>
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning"><?php echo date('d F Y', strtotime($task->due_date)); ?></span>
                                       <?php endif; ?>
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> <?php echo Job::task_attachments($task->task_code)->count(); ?>

                                       | <b><i class="fal fa-comments"></i> Comments :</b> <?php echo Job::task_comments($task->task_code)->count(); ?>

                                       <?php if($jobDetails->check == 1): ?>
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink"><?php echo $jobDetails->details->job_title; ?></span>
                                       <?php endif; ?>
                                    </p>
                                 </td>
                                 
                                 
                              </tr>
                           <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               <?php endif; ?>

               <?php if($this->view == 'Pending'): ?>
                  <table class="table table-inbox table-hover">
                     <tbody>
                        <?php $__currentLoopData = $pendingTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($task->business_code == Auth::user()->business_code): ?>
                              <?php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              ?>
                              <tr class="">
                                 
                                 <td class="view-message">
                                    <span class="font-bold font-14"><?php if($task->status == 16): ?><strike><?php echo $task->title; ?></strike><?php else: ?> <?php echo $task->title; ?> <?php endif; ?></span><br>
                                    <p class="font-small text-height-1">
                                       <?php if($task->priority): ?>
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge <?php echo Wingu::status($task->priority)->name; ?>"><?php echo Wingu::status($task->priority)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->status): ?>
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge <?php echo Wingu::status($task->status)->name; ?>"><?php echo Wingu::status($task->status)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->start_date): ?>
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success"><?php echo date('d F Y', strtotime($task->start_date)); ?></span>
                                       <?php endif; ?>
                                       <?php if($task->due_date): ?>
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning"><?php echo date('d F Y', strtotime($task->due_date)); ?></span>
                                       <?php endif; ?>
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> <?php echo Job::task_attachments($task->task_code)->count(); ?>

                                       | <b><i class="fal fa-comments"></i> Comments :</b> <?php echo Job::task_comments($task->task_code)->count(); ?>

                                       <?php if($jobDetails->check == 1): ?>
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink"><?php echo $jobDetails->details->job_title; ?></span>
                                       <?php endif; ?>
                                    </p>
                                 </td>
                                 
                                 
                              </tr>
                           <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               <?php endif; ?>

               <?php if($this->view == 'Waiting Approval'): ?>
                  <table class="table table-inbox table-hover">
                     <tbody>
                        <?php $__currentLoopData = $waitingApprovalTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($task->business_code == Auth::user()->business_code): ?>
                              <?php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              ?>
                              <tr class="">
                                 
                                 <td class="view-message">
                                    <span class="font-bold font-14"><?php if($task->status == 16): ?><strike><?php echo $task->title; ?></strike><?php else: ?> <?php echo $task->title; ?> <?php endif; ?></span><br>
                                    <p class="font-small text-height-1">
                                       <?php if($task->priority): ?>
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge <?php echo Wingu::status($task->priority)->name; ?>"><?php echo Wingu::status($task->priority)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->status): ?>
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge <?php echo Wingu::status($task->status)->name; ?>"><?php echo Wingu::status($task->status)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->start_date): ?>
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success"><?php echo date('d F Y', strtotime($task->start_date)); ?></span>
                                       <?php endif; ?>
                                       <?php if($task->due_date): ?>
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning"><?php echo date('d F Y', strtotime($task->due_date)); ?></span>
                                       <?php endif; ?>
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> <?php echo Job::task_attachments($task->task_code)->count(); ?>

                                       | <b><i class="fal fa-comments"></i> Comments :</b> <?php echo Job::task_comments($task->task_code)->count(); ?>

                                       <?php if($jobDetails->check == 1): ?>
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink"><?php echo $jobDetails->details->job_title; ?></span>
                                       <?php endif; ?>
                                    </p>
                                 </td>
                                 
                                 
                              </tr>
                           <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               <?php endif; ?>

               <?php if($this->view == 'Completed'): ?>
                  <table class="table table-inbox table-hover">
                     <tbody>
                        <?php $__currentLoopData = $completeTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($task->business_code == Auth::user()->business_code): ?>
                              <?php
                                 $getTaskCode = json_encode($task->task_code);
                                 $jobDetails = Job::job_details($task->job_code)->getData();
                              ?>
                              <tr class="">
                                 
                                 <td class="view-message">
                                    <span class="font-bold font-14"><?php if($task->status == 16): ?><strike><?php echo $task->title; ?></strike><?php else: ?> <?php echo $task->title; ?> <?php endif; ?></span><br>
                                    <p class="font-small text-height-1">
                                       <?php if($task->priority): ?>
                                          <b><i class="fal fa-exclamation-triangle"></i> Priority :</b>
                                          <span class="badge <?php echo Wingu::status($task->priority)->name; ?>"><?php echo Wingu::status($task->priority)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->status): ?>
                                          <b><i class="fal fa-heartbeat"></i> Status :</b>
                                          <span class="badge <?php echo Wingu::status($task->status)->name; ?>"><?php echo Wingu::status($task->status)->name; ?></span> |
                                       <?php endif; ?>
                                       <?php if($task->start_date): ?>
                                       <b><i class="fal fa-calendar-day"></i> Task Date :</b>  <span class="text-success"><?php echo date('d F Y', strtotime($task->start_date)); ?></span>
                                       <?php endif; ?>
                                       <?php if($task->due_date): ?>
                                       | <b><i class="fal fa-calendar-times"></i> Due Date :</b> <span class="text-warning"><?php echo date('d F Y', strtotime($task->due_date)); ?></span>
                                       <?php endif; ?>
                                       | <b><i class="fal fa-paperclip"></i> Attachment :</b> <?php echo Job::task_attachments($task->task_code)->count(); ?>

                                       | <b><i class="fal fa-comments"></i> Comments :</b> <?php echo Job::task_comments($task->task_code)->count(); ?>

                                       <?php if($jobDetails->check == 1): ?>
                                       | <b><i class="fal fa-hard-hat"></i> Job :</b> <span class="badge badge-pink"><?php echo $jobDetails->details->job_title; ?></span>
                                       <?php endif; ?>
                                    </p>
                                 </td>
                                 
                                 
                              </tr>
                           <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               <?php endif; ?>
            </div>
         </aside>
      </div>
   </div>

   
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
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/jobs/my-task-list.blade.php ENDPATH**/ ?>