<ul class="nav nav-tabs">
   <li class="nav-item <?php echo Nav::isRoute('crm.customers.show'); ?>">
      <a class="nav-link <?php echo Nav::isRoute('crm.customers.show'); ?>" href="<?php echo route('crm.customers.show',$code); ?>"><i class="fal fa-info-circle"></i> Overview</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isRoute('crm.customers.comments')); ?>">
      <a href="<?php echo route('crm.customers.comments', $code); ?>" class="nav-link <?php echo e(Nav::isRoute('crm.customers.comments')); ?>">
         <i class="fal fa-comments-alt"></i> Comments
      </a>
   </li>
   <li class="nav-item <?php echo e(Nav::isRoute('crm.customers.invoices')); ?>">
      <a href="<?php echo route('crm.customers.invoices', $code); ?>" class="nav-link <?php echo e(Nav::isRoute('crm.customers.invoices')); ?>"><i class="fal fa-file-invoice-dollar"></i> invoices</span></a>
   </li>
   <li class="nav-item <?php echo e(Nav::isRoute('crm.customers.quotes')); ?>">
      <a href="<?php echo route('crm.customers.quotes', $code); ?>" class="nav-link <?php echo e(Nav::isRoute('crm.customers.quotes')); ?>"><i class="fal fa-file-invoice"></i> Quote</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isRoute('crm.customers.creditnotes')); ?>">
      <a href="<?php echo route('crm.customers.creditnotes', $code); ?>" class="nav-link <?php echo e(Nav::isRoute('crm.customers.creditnotes')); ?>"><i class="fal fa-file-alt"></i> Credits</a>
   </li>
   <li class="nav-item <?php echo e(Nav::isRoute('crm.customers.projects')); ?>">
      <a href="<?php echo route('crm.customers.projects', $code); ?>" class="nav-link <?php echo e(Nav::isRoute('crm.customers.projects')); ?>"><i class="fal fa-tasks"></i> Jobs / Projects</a>
   </li>

   <li class="nav-item <?php echo e(Nav::isRoute('crm.customers.statement')); ?> <?php echo e(Nav::isRoute('crm.customers.statement.mail')); ?>">
      <a href="<?php echo route('crm.customers.statement',$code); ?>" class="nav-link <?php echo e(Nav::isRoute('crm.customers.statement.mail')); ?> <?php echo e(Nav::isRoute('crm.customers.statement.mail')); ?>"><i class="fal fa-receipt"></i> Statement</a>
   </li>
   
</ul>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/customers/_nav.blade.php ENDPATH**/ ?>