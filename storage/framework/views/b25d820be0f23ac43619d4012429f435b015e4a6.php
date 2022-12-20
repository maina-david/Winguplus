<div class="col-lg-3 col-md-4 col-sm-12">
   <div class="faq-navigation d-flex justify-content-between flex-column mb-2 mb-md-0">
      <!-- pill tabs navigation -->
      <ul class="nav nav-pills nav-left flex-column" role="tablist">
         <!-- account -->
         <li class="nav-item">
            <a class="nav-link <?php echo Nav::isResource('account'); ?>" href="<?php echo route('settings.account'); ?>">
               <i data-feather='briefcase' class="font-medium-3 me-1"></i>
               <span class="fw-bold">Account</span>
            </a>
         </li>
         <!-- activity logs -->
         <li class="nav-item">
            <a class="nav-link <?php echo Nav::isResource('activity'); ?>" href="<?php echo route('settings.activity.log'); ?>">
               <i data-feather='activity' class="font-medium-3 me-1"></i>
               <span class="fw-bold">Activity logs</span>
            </a>
         </li>
         <!-- Roles and Permissions -->
         
      </ul>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/settings/_menu.blade.php ENDPATH**/ ?>