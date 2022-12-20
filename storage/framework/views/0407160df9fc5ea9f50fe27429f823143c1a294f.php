<?php $__env->startSection('stylesheet'); ?>
   <style>
      ul.product li {
         width: 100%;
      }
   </style>
<?php $__env->stopSection(); ?>
<div class="col-md-3">
   <div class="panel panel-default">
      <div class="panel-body">
         <ul class="nav nav-pills nav-stacked product">
            <li class="<?php echo e(Nav::isRoute('salesflow.products.edit')); ?> mb-2">
            <a href="<?php echo route('salesflow.products.edit',$productCode); ?>"> <i class="fa fa-info-circle" aria-hidden="true"></i> Information</a>
            </li>
            
            <li class="<?php echo e(Nav::isResource('price')); ?>">
               <a href="<?php echo route('salesflow.product.price', $productCode); ?>"><i class="fal fa-usd-circle"></i> Price</a>
            </li>
            <li class="<?php echo e(Nav::isResource('inventory')); ?>">
               <a href="<?php echo route('salesflow.products.inventory', $productCode); ?>"><i class="fal fa-inventory"></i> Inventory</a>
            </li>
            <li class="<?php echo e(Nav::isResource('images')); ?>">
            <a href="<?php echo route('salesflow.product.images', $productCode); ?>"><i class="fal fa-images"></i> Images</a>
            </li>
            
         </ul>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/partials/_shop_menu.blade.php ENDPATH**/ ?>