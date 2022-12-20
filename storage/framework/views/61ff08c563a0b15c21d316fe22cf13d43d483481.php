<div id="sidebar" class="sidebar">
   <?php  $module = 'Jobs Management' ?>
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      <?php echo $__env->make('partials._nav-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">My Menu</li>
         
         <li class="has-sub <?php echo e(Nav::isResource('my-tasks')); ?>">
            <a href="<?php echo route('job.mytask.list'); ?>">
               <i class="far fa-list-ul"></i>
               <span>My Tasks</span>
            </a>
         </li>
         
         

         <li class="nav-header">Module Menu</li>
         <li class="has-sub <?php echo e(Nav::isResource('dashboard')); ?>">
            <a href="<?php echo route('jobs.dashboard'); ?>">
               <i class="fal fa-chart-network"></i>
               <span>Dashboard</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-rocket-launch"></i>
               <span>Jobs</span>
            </a>
            <ul class="sub-menu">
               <li><a href="<?php echo route('job.index'); ?>">All Jobs</a></li>
               <li><a href="<?php echo route('job.create'); ?>">Add Job</a></li>
            </ul>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('client')); ?>">
            <a href="<?php echo route('job.clients.index'); ?>">
               <i class="fal fa-users"></i>
               <span>Clients</span>
            </a>
         </li>
         
         
         
         
         <!-- begin sidebar minify button -->
         <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
         <!-- end sidebar minify button -->
      </ul>
      <!-- end sidebar nav -->
   </div>
   <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/partials/_menu.blade.php ENDPATH**/ ?>