<div id="sidebar" class="sidebar">
   <?php  $module = 'Human Resource' ?>
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      <?php echo $__env->make('partials._nav-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <?php if(Auth::user()->employee_code): ?>
            <li class="nav-header">My Menu</li>

            
            <li class="has-sub <?php echo e(Nav::isResource('leave')); ?>">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-calendar-day"></i>
                  <span>Leave Management</span>
               </a>
               <ul class="sub-menu">
                  <li class="<?php echo Nav::isRoute('hrm.leave.apply'); ?> <?php echo Nav::isRoute('hrm.leave.apply.edit'); ?>"><a href="<?php echo route('hrm.leave.apply'); ?>">Apply</a></li>
                  <li class="<?php echo Nav::isRoute('hrm.leave.apply.index'); ?>"><a href="<?php echo route('hrm.leave.apply.index'); ?>">My Leave List</a></li>
               </ul>
            </li>
            
         <?php endif; ?>

         <li class="nav-header">Account Menu</li>

         <li class="has-sub <?php echo e(Nav::isRoute('hrm.dashboard')); ?>">
            <a href="<?php echo route('hrm.dashboard'); ?>">
               <i class="fa fa-th-large"></i>
               <span>Dashboard</span>
            </a>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('employee')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users"></i>
               <span>Employee</span>
            </a>
            <ul class="sub-menu">
               <li><a href="<?php echo route('hrm.employee.index'); ?>">All Employee</a></li>
               <li><a href="<?php echo route('hrm.employee.create'); ?>">Add Employee</a></li>
            </ul>
         </li>
         <?php if(Wingu::check_if_user_has_role(Auth::user()->user_code,'admin') == 1 || Wingu::check_user_permission('read-leave') == 1 ): ?>
            <li class="has-sub <?php echo e(Nav::isResource('leave')); ?>">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-calendar-day"></i>
                  <span>Leave Management</span>
               </a>
               <ul class="sub-menu">
                  <li class="<?php echo e(Nav::isRoute('hrm.leave.index')); ?>"><a href="<?php echo route('hrm.leave.index'); ?>">All Requests</a></li>
                  <li class="<?php echo e(Nav::isRoute('hrm.leave.create')); ?>"><a href="<?php echo route('hrm.leave.create'); ?>">Assign Leave</a></li>
                  
                  <li class="<?php echo e(Nav::isRoute('hrm.leave.calendar')); ?>"><a href="<?php echo route('hrm.leave.calendar'); ?>">Leave Calendar</a></li>
                  <li class="<?php echo e(Nav::isRoute('hrm.leave.type')); ?>"><a href="<?php echo route('hrm.leave.type'); ?>">Leave Types</a></li>
               </ul>
            </li>
         <?php endif; ?>
         
         <?php if(Wingu::check_if_user_has_role(Auth::user()->user_code,'admin') == 1 || Wingu::check_user_permission('read-payroll') == 1 ): ?>
            <li class="has-sub <?php echo e(Nav::isResource('payroll')); ?>">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-money-check-alt"></i>
                  <span>Payroll</span>
               </a>
               <ul class="sub-menu">
                  <li class="<?php echo e(Nav::isRoute('hrm.payroll.people')); ?>"><a href="<?php echo route('hrm.payroll.people'); ?>">People</a></li>
                  <li class="<?php echo Nav::isRoute('hrm.payroll.index'); ?>"><a href="<?php echo route('hrm.payroll.index'); ?>">Payroll History</a></li>
                  <li class="<?php echo e(Nav::isRoute('hrm.payroll.process')); ?>"><a href="<?php echo route('hrm.payroll.process'); ?>">Run payroll</a></li>
                  <li class="<?php echo e(Nav::isRoute('hrm.payroll.settings.deduction')); ?>"><a href="<?php echo route('hrm.payroll.settings.deduction'); ?>">Payroll Deductions</a></li>
               </ul>
            </li>
         <?php endif; ?>
         
         <li class="has-sub <?php echo e(Nav::isResource('recruitment')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-search"></i>
               <span>Recruitment</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isResource('job-openings')); ?>"><a href="<?php echo route('hrm.recruitment.jobs'); ?>">Job Openings</a></li>
               
               
               
            </ul>
         </li>
         
         
         <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-calendar-alt"></i>
               <span>Events</span>
            </a>
            <ul class="sub-menu">
               <li class="#"><a href="<?php echo route('hrm.events'); ?>">All Events</a></li>
               <li class="#"><a href="<?php echo route('hrm.events.create'); ?>">Add Events</a></li>
            </ul>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('organization')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-sitemap"></i>
               <span>Organization</span>
            </a>
            <ul class="sub-menu">
               <li class="has-sub <?php echo e(Nav::isResource('positions')); ?>">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Positions
                  </a>
                  <ul class="sub-menu">
                     <li><a href="<?php echo route('hrm.positions'); ?>">All Positions</a></li>
                     <li><a href="<?php echo route('hrm.positions'); ?>">Add Positions</a></li>
                  </ul>
               </li>
               <li class="has-sub <?php echo e(Nav::isResource('departments')); ?>">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Department
                  </a>
                  <ul class="sub-menu">
                     <li class="<?php echo e(Nav::isRoute('hrm.departments')); ?>"><a href="<?php echo route('hrm.departments'); ?>">All Department</a></li>
                     <li class="<?php echo e(Nav::isRoute('hrm.departments.create')); ?>"><a href="<?php echo route('hrm.departments.create'); ?>">Add Department</a></li>
                  </ul>
               </li>
               <li class="has-sub <?php echo e(Nav::isResource('branches')); ?>">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Branches
                  </a>
                  <ul class="sub-menu">
                     <li><a href="<?php echo route('hrm.branches'); ?>">All Branches</a></li>
                     <li><a href="<?php echo route('hrm.branches.create'); ?>">Add Branches</a></li>
                  </ul>
               </li>
            </ul>
         </li>
         
         
         <li class="has-sub <?php echo e(Nav::isResource('travel')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-plane"></i>
               <span>Travel</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isRoute('hrm.travel.index')); ?>"><a href="<?php echo route('hrm.travel.index'); ?>">Travels</a></li>
               <li class="<?php echo e(Nav::isRoute('hrm.travel.expenses')); ?>"><a href="<?php echo route('hrm.travel.expenses'); ?>">Travel Expenses</a></li>
            </ul>
         </li>
         
         
         
         <li class="has-sub <?php echo e(Nav::isResource('settings')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-cogs"></i>
               <span>Settings</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isRoute('hrm.payroll.settings.deduction')); ?>"><a href="<?php echo route('hrm.payroll.settings.deduction'); ?>">Payroll Deductions</a></li>
               
               <?php if(Wingu::check_if_user_has_role(Auth::user()->user_code,'admin') == 1 || Wingu::check_user_permission('read-leavetype') == 1 ): ?>
                  <li class="<?php echo e(Nav::isRoute('hrm.leave.type')); ?>"><a href="<?php echo route('hrm.leave.type'); ?>"> Leave Types</a></li>
               <?php endif; ?>
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/partials/_menu.blade.php ENDPATH**/ ?>