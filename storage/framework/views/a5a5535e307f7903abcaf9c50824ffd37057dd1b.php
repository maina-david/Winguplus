<div id="sidebar" class="sidebar">
   <?php
      $module = 'Finance Management';
   ?>
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      <?php echo $__env->make('partials._nav-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <li class="has-sub <?php echo e(Nav::isResource('dashboard')); ?>">
            <a href="<?php echo route('finance.index'); ?>">
               <i class="fa fa-th-large"></i>
               <span>Dashboard</span>
            </a>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('customer')); ?> <?php echo e(Nav::isRoute('finance.contact.index')); ?> <?php echo e(Nav::isRoute('finance.contact.create')); ?> <?php echo e(Nav::isRoute('finance.contact.groups.index')); ?> <?php echo Nav::isRoute('finance.contact.edit'); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users"></i>
               <span>Customers</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isRoute('finance.contact.index')); ?>"><a href="<?php echo route('finance.contact.index'); ?>">Customer List</a></li>
               <li class="<?php echo e(Nav::isRoute('finance.contact.create')); ?>"><a href="<?php echo route('finance.contact.create'); ?>">Add Customer</a></li>
               <li class="<?php echo e(Nav::isRoute('finance.contact.groups.index')); ?>"><a href="<?php echo route('finance.contact.groups.index'); ?>">Customer category</a></li>
            </ul>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('finance/items')); ?> <?php echo e(Nav::isResource('stock')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-cube"></i>
               <span>Items</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isResource('items')); ?>"><a href="<?php echo route('finance.product.index'); ?>">Items</a></li>
               <li class="<?php echo e(Nav::isRoute('finance.products.create')); ?>"><a href="<?php echo route('finance.products.create'); ?>">Add Item</a></li>
               <li class="<?php echo e(Nav::isResource('category')); ?>"><a href="<?php echo route('finance.product.category'); ?>">Category</a></li>
               <li class="<?php echo e(Nav::isResource('stock')); ?>"><a href="<?php echo route('finance.product.stock.control'); ?>">Stock Control</a></li>
               <li class="<?php echo e(Nav::isResource('brand')); ?>"><a href="<?php echo route('finance.product.brand'); ?>">Brands</a></li>
               
            </ul>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('invoice')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-file-invoice"></i>
               <span>Invoice</span>
            </a>
            <ul class="sub-menu">
               <li><a href="<?php echo route('finance.invoice.index'); ?>">All Invoices</a></li>
               <li class="has-sub <?php echo e(Nav::isResource('create')); ?>">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Create Invoice
                  </a>
                  <ul class="sub-menu">
                     <li><a href="<?php echo route('finance.invoice.product.create'); ?>">Add New Invoice</a></li>
                     
                  </ul>
               </li>
            </ul>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('payments')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-cash-register"></i>
               <span>Payments Received</span>
            </a>
            <ul class="sub-menu">
               <li><a href="<?php echo route('finance.payments.received'); ?>">All Payments</a></li>
                  <li><a href="<?php echo route('finance.payments.create'); ?>">Add Payments</a></li>
            </ul>
         </li>
         <?php if(Wingu::business()->plan_code != 'pNIjNQhri1auVNDwahl2Lbi8TTVIlp'): ?>
            <li class="has-sub <?php echo e(Nav::isResource('expense')); ?>">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-receipt"></i>
                  <span>Expenses</span>
               </a>
               <ul class="sub-menu">
                  <li class="<?php echo e(Nav::isRoute('finance.expense.index')); ?>"><a href="<?php echo route('finance.expense.index'); ?>">Expense List</a></li>
                  <li class="<?php echo e(Nav::isRoute('finance.expense.create')); ?>"><a href="<?php echo route('finance.expense.create'); ?>">Add Expense</a></li>
                  <li class="<?php echo e(Nav::isRoute('finance.expense.category.index')); ?>"><a href="<?php echo route('finance.expense.category.index'); ?>">Expense Category</a></li>
               </ul>
            </li>
            <li class="has-sub <?php echo e(Nav::isResource('supplier')); ?>">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-users-cog"></i>
                  <span>Suppliers</span>
               </a>
               <ul class="sub-menu">
                  <li class="<?php echo Nav::isRoute('finance.supplier.index'); ?>"><a href="<?php echo route('finance.supplier.index'); ?>">Suppliers List</a></li>
                  <li class="<?php echo Nav::isRoute('finance.supplier.create'); ?>"><a href="<?php echo route('finance.supplier.create'); ?>">Add Suppliers</a></li>
                  <li class="<?php echo e(Nav::isRoute('finance.supplier.groups.index')); ?>"><a href="<?php echo route('finance.supplier.groups.index'); ?>">Suppliers category</a></li>
               </ul>
            </li>

            <li class="has-sub <?php echo e(Nav::isResource('quotes')); ?>">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-file-alt"></i>
                  <span>Quotes</span>
               </a>
               <ul class="sub-menu">
                  <li><a href="<?php echo route('finance.quotes.index'); ?>">All Quotes</a></li>
                  <li><a href="<?php echo route('finance.quotes.create'); ?>">Create Quotes</a></li>
               </ul>
            </li>
            <li class="has-sub <?php echo e(Nav::isResource('purchaseorders')); ?>">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-file-contract"></i>
                  <span>Purchase Order </span>
               </a>
               <ul class="sub-menu">
                  <li class="<?php echo e(Nav::isRoute('finance.lpo.index')); ?>"><a href="<?php echo route('finance.lpo.index'); ?>">All Purchase Orders</a></li>
                  <li class="<?php echo e(Nav::isRoute('finance.lpo.create')); ?>"><a href="<?php echo route('finance.lpo.create'); ?>">Add Purchase Order</a></li>
               </ul>
            </li>
            
            <li class="has-sub <?php echo e(Nav::isResource('creditnote')); ?>">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-credit-card"></i>
                  <span>Credit Note</span>
               </a>
               <ul class="sub-menu">
                  <li><a href="<?php echo route('finance.creditnote.index'); ?>">All Credit Note</a></li>
                  <li><a href="<?php echo route('finance.creditnote.create'); ?>">Create Credit Note</a></li>
               </ul>
            </li>
            
            <li class="has-sub <?php echo e(Nav::isResource('report')); ?>">
               <a href="<?php echo route('finance.report'); ?>">
                  <i class="fal fa-chart-pie"></i>
                  <span>Report</span>
               </a>
            </li>
         <?php endif; ?>
         <li class="has-sub <?php echo e(Nav::isResource('settings')); ?>">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="fal fa-tools"></i>
					<span>Settings</span>
				</a>
				<ul class="sub-menu">
               <li><a href="<?php echo route('finance.settings.invoice'); ?>">Invoice</a></li>
               <li class="<?php echo e(Nav::isResource('taxes')); ?>"><a href="<?php echo route('finance.settings.taxes'); ?>">Tax Rates</a></li>
               <?php if(Wingu::business()->plan_code != 'pNIjNQhri1auVNDwahl2Lbi8TTVIlp'): ?>
                  <li class="<?php echo e(Nav::isResource('lpo')); ?>"><a href="<?php echo route('finance.settings.lpo'); ?>">Purchase order</a></li>
                  <li class="<?php echo e(Nav::isResource('quote')); ?>"><a href="<?php echo route('finance.settings.quote'); ?>">Quotes</a></li>
                  <li><a href="<?php echo route('finance.expense.category.index'); ?>">Expense</a></li>
                  <li><a href="<?php echo route('finance.income.category'); ?>">Income</a></li>
                  <li class="<?php echo e(Nav::isResource('creditnote')); ?>"><a href="<?php echo route('finance.settings.creditnote'); ?>">Credit Note</a></li>
               <?php endif; ?>
               <li class="<?php echo Nav::isRoute('finance.payment.mode'); ?>"><a href="<?php echo route('finance.payment.mode'); ?>">Payment Methods</a></li>
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/partials/_menu.blade.php ENDPATH**/ ?>