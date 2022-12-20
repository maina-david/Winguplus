<div id="sidebar" class="sidebar">
   <?php  $module = 'Point of sale' ?>
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      <?php echo $__env->make('partials._nav-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <li class="has-sub <?php echo e(Nav::isResource('dashboard')); ?>">
            <a href="<?php echo route('pos.dashboard'); ?>">
               <i class="fa fa-th-large"></i>
               <span>Dashboard</span>
            </a>
         </li>
         
         <li class="has-sub <?php echo e(Nav::isResource('sale')); ?>">
            <a href="https://pos.winguplus.com" target="_blank">
               <i class="fal fa-cash-register"></i>
               <span>Sales Terminal</span>
            </a>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('history')); ?>">
            <a href="<?php echo route('sales.history'); ?>">
               <i class="fal fa-history"></i>
               <span>Sales history</span>
            </a>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('product')); ?> <?php echo e(Nav::isResource('brand')); ?> <?php echo e(Nav::isResource('category')); ?> <?php echo e(Nav::isResource('brand')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-boxes"></i>
               <span>Inventory </span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isResource('product')); ?>"><a href="<?php echo route('pos.products'); ?>">Products</a></li>
               
               <li class="<?php echo e(Nav::isResource('category')); ?>"><a href="<?php echo route('pos.product.category'); ?>">Categories</a></li>
               <li class="<?php echo e(Nav::isResource('brand')); ?>"><a href="<?php echo route('pos.product.brand'); ?>">Brand</a></li>
               
               
            </ul>
         </li>
         <li class="has-sub <?php echo Nav::isResource('supplier'); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users-cog"></i>
               <span>Suppliers </span>
            </a>
            <ul class="sub-menu">
               <li class="#"><a href="<?php echo route('pos.supplier.index'); ?>">Suppliers</a></li>
               <li class="#"><a href="<?php echo route('pos.supplier.groups.index'); ?>">Categories</a></li>
            </ul>
         </li>
         <li class="has-sub <?php echo Nav::isResource('customer'); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users"></i>
               <span>Customers </span>
            </a>
            <ul class="sub-menu">
               <li class="#"><a href="<?php echo route('pos.contact.index'); ?>">Customers</a></li>
               <li class="#"><a href="<?php echo route('pos.supplier.groups.index'); ?>">Categories</a></li>
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/partials/_menu.blade.php ENDPATH**/ ?>