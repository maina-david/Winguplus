<?php $__env->startSection('title','Jobs Management'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.jobs.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Jobs Management</a></li>
         <li class="breadcrumb-item active">Dashboard</li>
      </ol>
      <!-- end breadcrumb -->
      <h1 class="page-header"><i class="fal fa-chart-network"></i> Dashboard </h1>
      <!-- begin #content -->
      <div class="row">
         <div class="col-md-3">
            <div class="widget widget-stats bg-gradient-blue">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-briefcase"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Total Jobs</div>
                  <div class="stats-number"><?php echo number_format($totalJobs); ?></div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="<?php echo route('job.index'); ?>" class="text-white">View Jobs</a></div>
               </div>
            </div>
            <div class="widget widget-stats bg-gradient-aqua">
               <div class="stats-icon stats-icon-lg"><i class="fas fa-ballot-check"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Total Open Tasks</div>
                  <div class="stats-number">0</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">Jobs</div>
               </div>
            </div>
            <div class="widget widget-stats bg-gradient-green">
               <div class="stats-icon stats-icon-lg"><i class="fas fa-check-square"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Total Completed Tasks</div>
                  <div class="stats-number">0</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">Jobs</div>
               </div>
            </div>
         </div>
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                 Jobs Per Month
               </div>
               <div class="card-body" style="height:383px">
                  <?php echo $jobOverTime->container(); ?>

               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  Current Jobs
               </div>
               <div class="card-body" style="min-height:817px;">
                  <ul class="registered-users-list">
                     <?php $__currentLoopData = $currentJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currentJob): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                           <a href="<?php echo e(route('job.dashboard',$currentJob->job_code)); ?>">
                              <?php if($currentJob->image): ?>
                                 <img src="<?php echo asset('businesses/'.Auth::user()->business_code.'/jobs/'.$currentJob->job_code.'/images/'.$currentJob->image); ?>" alt="<?php echo $currentJob->job_title; ?>" class="img-responsive">
                              <?php else: ?>
                                 <img src="https://ui-avatars.com/api/?name=<?php echo $currentJob->job_title; ?>&rounded=false&size=120" alt="<?php echo $currentJob->job_title; ?>" class="img-responsive">
                              <?php endif; ?>
                           </a>
                           <h4 class="username text-ellipsis">
                              <?php echo $currentJob->job_title; ?>

                              <small><?php echo $currentJob->job_type; ?></small>
                           </h4>
                        </li>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  Over Due Tasks
               </div>
               <div class="card-body" style="min-height:463px;">
                  <?php $__currentLoopData = $dueTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <div class="widget-list-item mb-2">
                        <div class="widget-list-media">
                           <?php if($task->status == 1): ?>
                              <?php if($task->priority == 1): ?>
                                 <img src="<?php echo asset('assets/img/urgent.png'); ?>" alt="" class="rounded">
                              <?php elseif($task->priority == 2): ?>
                                 <img src="<?php echo asset('assets/img/high.png'); ?>" alt="" class="rounded">
                              <?php elseif($task->priority == 5): ?>
                                 <img src="<?php echo asset('assets/img/medium.png'); ?>" alt="" class="rounded">
                              <?php else: ?>
                                 <img src="<?php echo asset('assets/img/deafult.png'); ?>" alt="" class="rounded">
                              <?php endif; ?>
                           <?php elseif($task->status == 7): ?>
                              <img src="<?php echo asset('assets/img/complete.png'); ?>" alt="" class="rounded">
                           <?php else: ?>
                              <img src="<?php echo asset('assets/img/blank-check.png'); ?>" alt="" class="rounded">
                           <?php endif; ?>
                        </div>
                        <div class="widget-list-content">
                           <h4 class="widget-list-title mb-1"> <?php if($task->status == 16): ?><strike><?php echo $task->title; ?></strike><?php else: ?> <?php echo $task->title; ?> <?php endif; ?></h4>
                           <p class="widget-list-desc font-bold">
                              <?php if($task->priority != 0): ?>
                                 <i class="fas fa-exclamation-triangle"></i> Priority :
                                 <?php if($task->priority == 1): ?>
                                    <span class="badge badge-danger"><?php echo Wingu::status($task->priority)->name; ?></span>
                                 <?php elseif($task->priority == 2): ?>
                                    <span class="badge badge-warning"><?php echo Wingu::status($task->priority)->name; ?></span>
                                 <?php elseif($task->priority == 5): ?>
                                    <span class="badge badge-primary"><?php echo Wingu::status($task->priority)->name; ?></span>
                                 <?php else: ?>
                                    <span class="badge badge-default"><?php echo Wingu::status($task->priority)->name; ?></span>
                                 <?php endif; ?>
                                 |
                              <?php endif; ?>
                              <?php if($task->status != 0 ): ?>
                              <i class="fas fa-heartbeat"></i> Status :
                                 <?php if($task->status == 1): ?>
                                    <span class="badge badge-success"><?php echo Wingu::status($task->status)->name; ?></span>
                                 <?php else: ?>
                                    <span class="text-primary"><?php echo Wingu::status($task->status)->name; ?></span>
                                 <?php endif; ?>
                                 |
                              <?php endif; ?>
                              <i class="fas fa-users-cog"></i> Assigned To :
                              <span class="text-primary">
                                 <?php $__currentLoopData = Job::task_allocations($task->task_code); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alloc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(Wingu::check_user($alloc->user) == 1): ?>
                                       <?php echo Wingu::user($alloc->user)->name; ?>,
                                    <?php endif; ?>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </span>
                              <?php if($task->due_date != ""): ?>
                              | <i class="fas fa-calendar-times"></i> Due Date : <b><?php echo date('d F Y', strtotime($task->due_date)); ?></b>
                              <?php endif; ?>
                              | <i class="fas fa-paperclip"></i> Attachment : <b><?php echo Job::task_attachments($task->task_code)->count(); ?></b>
                              | <i class="fas fa-comments"></i> Comments : <b><?php echo Job::task_comments($task->task_code)->count(); ?></b>
                           </p>
                        </div>
                        <div class="widget-list-action">
                           <?php if($task->status != 16): ?>
                              <a href="#" data-toggle="dropdown" class="text-muted pull-right"><i class="fa fa-ellipsis-h f-s-14"></i></a>
                              <ul class="dropdown-menu dropdown-menu-right">
                                 <li><a href="<?php echo route('task.complete',[$task->job,$task->task_code]); ?>"><i class="far fa-check-circle"></i> Mark as Complete</a></li>
                              </ul>
                           <?php endif; ?>
                        </div>
                     </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </div>
            </div>
         </div>
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  Total Tasks Per Member
               </div>
               <div class="card-body">
                  <?php echo $membersWithTasks->container(); ?>

               </div>
            </div>
         </div>

         
         
      </div>
   </div>
   <!-- end #content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo asset('assets/plugins/chart.js/2.7.1/Chart.min.js'); ?>" charset="utf-8"></script>
   <?php echo $jobOverTime->script(); ?>

   <?php echo $membersWithTasks->script(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/dashboard/dashboard.blade.php ENDPATH**/ ?>