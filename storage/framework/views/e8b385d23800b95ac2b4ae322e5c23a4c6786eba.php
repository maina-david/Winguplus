<ul class="nav nav-tabs">
   <li class="nav-item <?php echo Nav::isRoute('crm.leads.show'); ?>">
      <a class="nav-link <?php echo Nav::isRoute('crm.leads.show'); ?>" href="<?php echo route('crm.leads.show',$code); ?>"><i class="fal fa-info-circle"></i> Overview</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isResource('events')); ?>">
      <a class="nav-link <?php echo e(Nav::isResource('events')); ?>" href="<?php echo route('crm.leads.events',$code); ?>"><i class="fal fa-calendar-alt"></i>  Meetings / Events</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isRoute('crm.leads.calllog')); ?>">
      <a class="nav-link <?php echo e(Nav::isRoute('crm.leads.calllog')); ?>" href="<?php echo route('crm.leads.calllog',$code); ?>"><i class="fal fa-phone-office"></i>  Call log</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isResource('tasks')); ?>">
      <a class="nav-link <?php echo e(Nav::isResource('tasks')); ?>" href="<?php echo route('crm.leads.tasks',$code); ?>"><i class="fal fa-check-square"></i>  Tasks</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isResource('notes')); ?>">
      <a class="nav-link <?php echo e(Nav::isResource('notes')); ?>" href="<?php echo route('crm.leads.notes',$code); ?>"><i class="fal fa-feather-alt"></i>  Notes</a>
   </li>
   
   
   
</ul>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/leads/_nav.blade.php ENDPATH**/ ?>