<div class="col-md-3">
   <div class="list-group">
      <a href="<?php echo route('settings.business.index'); ?>" class="list-group-item <?php echo e(Nav::isResource('business')); ?>">
         <i class="fal fa-globe"></i> Business Profile
      </a>
      <a href="<?php echo route('finance.settings.invoice'); ?>" class="list-group-item <?php echo e(Nav::isResource('invoice')); ?>">
         <i class="fal fa-file-invoice-dollar"></i> Invoice
      </a>
      <a href="<?php echo route('finance.settings.taxes'); ?>" class="list-group-item <?php echo e(Nav::isResource('taxes')); ?>">
         <i class="fal fa-coins"></i> Tax Rates
      </a>
      <a href="<?php echo route('finance.income.category'); ?>" class="list-group-item <?php echo e(Nav::isResource('income')); ?>">
         <i class="fal fa-money-bill-alt"></i> Income Categories
      </a>
      <a href="<?php echo route('finance.expense.category.index'); ?>" class="list-group-item <?php echo e(Nav::isResource('expense')); ?>">
         <i class="fal fa-sitemap"></i> Expense Categories
      </a>
      <a href="<?php echo route('finance.settings.lpo'); ?>" class="list-group-item <?php echo e(Nav::isResource('lpo')); ?>">
         <i class="fal fa-file-contract"></i> Purchase Order
      </a>
      <a href="<?php echo route('finance.settings.quote'); ?>" class="list-group-item <?php echo e(Nav::isResource('quote')); ?>">
         <i class="far fa-file-alt"></i> Quotes
      </a>
      <a href="<?php echo route('finance.settings.salesorders'); ?>" class="list-group-item <?php echo e(Nav::isResource('salesorders')); ?>">
         <i class="fal fa-cart-arrow-down"></i> Sales orders
      </a>
      <a href="<?php echo route('finance.settings.creditnote'); ?>" class="list-group-item <?php echo e(Nav::isResource('creditnote')); ?>">
         <i class="fal fa-credit-card"></i> Credit Note
      </a>
      <a href="<?php echo route('finance.payment.mode'); ?>" class="list-group-item <?php echo e(Nav::isResource('mode')); ?>">
      <i class="fab fa-amazon-pay"></i> Payment Modes
      </a>
      
      
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/partials/_settings_nav.blade.php ENDPATH**/ ?>