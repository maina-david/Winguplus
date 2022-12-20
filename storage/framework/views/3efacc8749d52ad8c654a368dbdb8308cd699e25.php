<div id="sidebar" class="sidebar">
   <?php  $module = 'Event Manager' ?>
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      <?php echo $__env->make('partials._nav-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Module Menu</li>
         <li class="has-sub <?php echo e(Nav::isResource('dashboard')); ?>">
            <a href="<?php echo route('events.manager.dashboard'); ?>">
               <i class="fal fa-chart-network"></i>
               <span>Dashboard</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="#">
               <i class="fal fa-users"></i>
               <span>Customers</span>
            </a>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('events')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-calendar-alt"></i>
               <span>Events</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isResource('events')); ?>"><a href="<?php echo route('events'); ?>">Events</a></li>
               <li class="<?php echo e(Nav::isResource('events')); ?>"><a href="<?php echo route('events.create'); ?>">Add Events</a></li>
            </ul>
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/events/partials/_menu.blade.php ENDPATH**/ ?>