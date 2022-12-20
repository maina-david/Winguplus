<ul class="nav nav-pills mb-4">
   <li class="nav-items <?php echo e(Nav::isRoute('finance.contact.show')); ?>">
      <a href="<?php echo route('finance.contact.show', $customerID); ?>">
         <span class="d-sm-none"><i class="fas fa-chart-bar"></i> Overview</span>
         <span class="d-sm-block d-none"><i class="fas fa-chart-bar"></i> Overview</span>
      </a>
   </li>
   <li class="nav-items <?php echo e(Nav::isRoute('finance.contact.comments')); ?>">
      <a href="<?php echo route('finance.contact.comments', $customerID); ?>">
         <span class="d-sm-none"><i class="fas fa-comment"></i> Comments</span>
         <span class="d-sm-block d-none"><i class="fas fa-comment"></i> Comments</span>
      </a>
   </li>
   <li class="nav-items <?php echo e(Nav::isRoute('finance.contact.invoices')); ?>">
      <a href="<?php echo route('finance.contact.invoices', $customerID); ?>">
         <span class="d-sm-none"><i class="fas fa-file-invoice-dollar"></i> invoices</span>
         <span class="d-sm-block d-none"><i class="fas fa-file-invoice-dollar"></i> invoices</span>
      </a>
   </li>

   <li class="nav-items <?php echo e(Nav::isRoute('finance.contact.creditnotes')); ?>">
      <a href="<?php echo route('finance.contact.creditnotes', $customerID); ?>">
         <span class="d-sm-none"><i class="fas fa-funnel-dollar"></i> Credits</span>
         <span class="d-sm-block d-none"><i class="fas fa-funnel-dollar"></i> Credits</span>
      </a>
   </li>
   
   <li class="nav-items <?php echo e(Nav::isRoute('finance.contact.contacts')); ?>">
      <a href="<?php echo route('finance.contact.contacts',$customerID); ?>">
         <span class="d-sm-none"><i class="fas fa-address-book"></i> Contacts</span>
         <span class="d-sm-block d-none"><i class="fas fa-address-book"></i> Contacts</span>
      </a>
   </li>
   <li class="nav-items">
      <a href="#nav-pills-tab-4">
         <span class="d-sm-none"><i class="fas fa-file-alt"></i> Statement</span>
         <span class="d-sm-block d-none"><i class="fas fa-file-alt"></i> Statement</span>
      </a>
   </li>
   <li class="nav-items">
      <a href="#nav-pills-tab-4">
         <span class="d-sm-none"><i class="fas fa-sync-alt"></i> Subscriptions</span>
         <span class="d-sm-block d-none"><i class="fas fa-sync-alt"></i> Subscriptions</span>
      </a>
   </li>
   
</ul>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/customer/_nav.blade.php ENDPATH**/ ?>