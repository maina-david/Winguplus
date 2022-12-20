<div id="sidebar" class="sidebar">
   <?php  $module = 'E-commerce' ?>
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      <?php echo $__env->make('partials._nav-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <li class="has-sub <?php echo e(Nav::isResource('dashboard')); ?>">
            <a href="<?php echo route('ecommerce.dashboard'); ?>">
               <i class="fa fa-th-large"></i>
               <span>Dashboard</span>
            </a>
         </li>
         
         <li class="has-sub <?php echo e(Nav::isResource('products')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-boxes"></i>
               <span>Products</span>
            </a>
            <ul class="sub-menu">
               <li class="has-sub closed <?php echo e(Nav::isRoute('ecommerce.product.index')); ?>">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Products
                  </a>
                  <ul class="sub-menu" style="display: none;">
                     <li class="<?php echo e(Nav::isResource('products')); ?>"><a href="<?php echo route('ecommerce.product.index'); ?>">All Products</a></li>
                     <li><a href="<?php echo route('ecommerce.products.create'); ?>">Add Products</a></li>
                  </ul>
               </li>
               <li class="has-sub closed <?php echo e(Nav::isRoute('ecommerce.product.category')); ?>">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Category
                  </a>
                  <ul class="sub-menu" style="display: none;">
                     <li><a href="<?php echo route('ecommerce.product.category'); ?>">All Category</a></li>
                     <li><a href="<?php echo route('ecommerce.product.category'); ?>">Add Category</a></li>
                  </ul>
               </li>
            </ul>
         </li>        
         <li class="has-sub <?php echo e(Nav::isResource('orders')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-cart-plus"></i>
               <span>Orders</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isResource('orders')); ?>"><a href="<?php echo route('ecommerce.orders.index'); ?>">All Orders</a></li>
            </ul>
         </li>      
         <li class="has-sub <?php echo Nav::isResource('customer'); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users-crown"></i>
               <span>Customers</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo Nav::isResource('customers'); ?>"><a href="<?php echo route('ecommerce.customers.index'); ?>">All Customers</a></li>
               
            </ul>
         </li>  
         <li class="has-sub <?php echo e(Nav::isResource('website')); ?>">
            <a href="<?php echo route('ecommerce.settings.website.details'); ?>">
               <i class="fal fa-globe"></i>
               <span>Website settings</span>
            </a>
         </li>      
         
         
         <li class="has-sub <?php echo e(Nav::isResource('licenses')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-tools"></i>
               <span>Settings</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isResource('businessprofile')); ?>"> <a href="<?php echo route('settings.business.index'); ?>">Business Profile</a></li>
               <li class="<?php echo e(Nav::isResource('integrations')); ?>"><a href="<?php echo route('settings.integrations.payments'); ?>">Payment Integration</a></li>
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/ecommerce/partials/_menu.blade.php ENDPATH**/ ?>