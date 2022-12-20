<?php $__env->startSection('title','All To do items'); ?>


<?php $__env->startSection('stylesheet'); ?>
	<link rel="stylesheet" href="<?php echo assets('assets/css/project.css'); ?>" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.prm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo route('prm.index'); ?>">Projects Management</a></li>
      <li class="breadcrumb-item"><a href="<?php echo route('project.index'); ?>">to-do list</a></li>
      <li class="breadcrumb-item active">All To do items</li>
   </ol>
   <h1 class="page-header">All To do items</h1>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="row mt-3">
      <div class="col-md-8">
         <div class="panel panel-inverse">
            <div class="panel-heading">
               <h4 class="panel-title">All Tasks</h4>
            </div>
            <div class="panel-body">
               <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="widget-list-item">
                     <div class="widget-list-media">
                        <?php if($task->tasks_status_id == 1): ?>
                           <?php if($task->tasks_priority_id == 1): ?>
                              <img src="<?php echo asset('assets/img/urgent.png'); ?>" alt="" class="rounded">
                           <?php elseif($task->tasks_priority_id == 2): ?>
                              <img src="<?php echo asset('assets/img/high.png'); ?>" alt="" class="rounded">
                           <?php elseif($task->tasks_priority_id == 5): ?>
                              <img src="<?php echo asset('assets/img/medium.png'); ?>" alt="" class="rounded">
                           <?php else: ?>
                              <img src="<?php echo asset('assets/img/deafult.png'); ?>" alt="" class="rounded">
                           <?php endif; ?>
                        <?php elseif($task->tasks_status_id == 7): ?>
                        <img src="<?php echo asset('assets/img/complete.png'); ?>" alt="" class="rounded">
                        <?php else: ?>
                        <img src="<?php echo asset('assets/img/blank-check.png'); ?>" alt="" class="rounded">
                        <?php endif; ?>
                     </div>
                     <div class="widget-list-content">
                        <h4 class="widget-list-title"> <?php if($task->tasks_status_id == 7): ?><strike><?php echo $task->name; ?></strike><?php else: ?> <?php echo $task->name; ?> <?php endif; ?></h4>
                        <p class="widget-list-desc font-bold">
                           Priority :
                           <?php if($task->tasks_priority_id == 1): ?>
										<span class="badge badge-danger"><?php echo prm::tasks_priority($task->tasks_priority_id)->name; ?></span>
									<?php elseif($task->tasks_priority_id == 2): ?>
										<span class="badge badge-warning"><?php echo prm::tasks_priority($task->tasks_priority_id)->name; ?></span>
									<?php elseif($task->tasks_priority_id == 5): ?>
										<span class="badge badge-primary"><?php echo prm::tasks_priority($task->tasks_priority_id)->name; ?></span>
									<?php else: ?>
                              <span class="badge badge-default"><?php echo prm::tasks_priority($task->tasks_priority_id)->name; ?></span>
                           <?php endif; ?> |
									Status :
									<?php if($task->tasks_status_id == 1): ?>
										<span class="badge badge-success"><?php echo prm::task_status($task->tasks_status_id)->name; ?></span>
									<?php else: ?>
										<span class="text-primary"><?php echo prm::task_status($task->tasks_status_id)->name; ?></span>
									<?php endif; ?> |
									Assigned To :
									<span class="text-primary"><?php $__currentLoopData = prm::task_allocations($task->taskID); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alloc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo Hr::employee($alloc->employeeID)->names; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></span> |
										Due Date : <b><?php echo date('d F Y', strtotime($task->due_date)); ?></b> |
										Project : <b> <?php echo prm::project_info($task->projectID)->project_name; ?> </b>
                        </p>
                     </div>
                     <div class="widget-list-action">
                        <a href="#" data-toggle="dropdown" class="text-muted pull-right"><i class="fa fa-ellipsis-h f-s-14"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                           <li><a href="<?php echo route('task.edit',$task->taskID); ?>"><i class="fas fa-pen-square"></i> Edit</a></li>
                           <li><a href="#"><i class="fas fa-eye"></i> View</a></li>
                           <li><a href="#"><i class="fas fa-trash"></i> Delete</a></li>
                        </ul>
                     </div>
                  </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <nav aria-label="..." class="mt-3">
                  <center>
                     <ul class="pagination">
                        <?php if($tasks->lastPage() > 1): ?>
                           <li class="page-item">
                              <a class="page-link" href="<?php echo e($tasks->url(1)); ?>">Previous</a>
                           </li>
                           <?php for($i = 1; $i <= $tasks->lastPage(); $i++): ?>
                           <li class="page-item <?php echo e(($tasks->currentPage() == $i) ? 'active' : ''); ?>"><a class="page-link" href="<?php echo e($tasks->url($i)); ?>"><?php echo e($i); ?></a></li>
                           <?php endfor; ?>
                           <li class="page-item">
                              <a class="page-link" href="<?php echo e($tasks->url($tasks->currentPage()+1)); ?>">Next</a>
                           </li>
                        <?php endif; ?>
                     </ul>
                  </center>
               </nav>
            </div>
         </div>
         <!--- \\\\\\\Post-->
      </div>
      <div class="col-md-4">
         <div class="panel panel-inverse">
            <div class="panel-heading">
               <h4 class="panel-title">Task Statistics</h4>
            </div>
            <div class="panel-body">
               <div class="table-scrollable">
                  <table class="table table-bordered table-hover table-item-details">
                     <tbody>
                        <tr>
                           <th>Total Tasks :</th>
                           <td><span class="text-uppercase"></td>
                        </tr>
                        <tr>
                           <th>Total Tasks Completed :</th>
                           <td><span class="text-uppercase"></td>
                        </tr>
                        <tr>
                           <th>Total Tasks Due :</th>
                           <td><span class="text-uppercase"></td>
                        </tr>
                        <tr>
                           <th>Due today:</th>
                           <td><span class="text-uppercase"></td>
                        </tr>
                        <tr>
                           <th>Due in the next 1 week :</th>
                           <td><span class="text-uppercase"></td>
                        </tr>
                        <tr>
                           <th>Due in the next 2 week :</th>
                           <td><span class="text-uppercase"></td>
                        </tr>
                        <tr><th>Status :</th><td><span class="badge badge-primary"></span></td></tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/todo/index.blade.php ENDPATH**/ ?>