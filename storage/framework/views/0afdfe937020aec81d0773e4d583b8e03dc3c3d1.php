<div id="sidebar" class="sidebar">
   <?php
      $module = 'Account Settings';
      $property = Wingu::get_account_module_details(1);
   ?>
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      <?php echo $__env->make('partials._nav-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <li class="<?php echo e(Nav::isResource('businessprofile')); ?>"> <a href="<?php echo route('settings.business.index'); ?>"><i class="fal fa-globe"></i> Business Profile</a></li>
         
         
         
         
         
         
         <?php if(Wingu::business()->plan_code != 'pNIjNQhri1auVNDwahl2Lbi8TTVIlp'): ?>
            <li class="<?php echo e(Nav::isResource('users')); ?>"><a href="<?php echo route('settings.users.index'); ?>"><i class="fal fa-users-cog"></i> User Management</a></li>
            <li class="<?php echo e(Nav::isResource('roles')); ?>"><a href="<?php echo route('settings.roles.index'); ?>"><i class="fal fa-shield-alt"></i> Roles & Permissions</a></li>
            <li class="<?php echo e(Nav::isResource('integrations')); ?>"><a href="<?php echo route('settings.integrations.payments'); ?>"><i class="fal fa-credit-card"></i> Payment Integration</a></li>
            
            
         <?php endif; ?>
         <li class=""><a href="<?php echo route('settings.account.subscription'); ?>"><i class="fal fa-money-check-alt"></i> Subscription</a></li>
         <!-- begin sidebar minify button -->
         <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
         <!-- end sidebar minify button -->
      </ul>
      <!-- end sidebar nav -->
   </div>
   <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/settings/partials/_menu.blade.php ENDPATH**/ ?>