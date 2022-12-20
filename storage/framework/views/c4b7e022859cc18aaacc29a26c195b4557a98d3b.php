<?php $__env->startSection('title'); ?> <?php echo $details->product_name; ?> | Items| Finance  <?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <a href="<?php echo e(route('finance.products.edit', $details->productCode)); ?>"  class="btn btn-primary ml-1"><i class="fal fa-pen-fancy"></i></a>
      <a href="" class="btn btn-warning ml-1">Mark as inactive</a>
      <a href="<?php echo route('finance.products.destroy', $details->productCode); ?>" class="btn btn-danger ml-1 delete">Delete</a>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><?php echo $details->product_name; ?></h1>
   <div class="row">
      <div class="col-md-12">
         <ul class="nav nav-tabs">
            <li class="nav-item <?php echo Nav::isRoute('finance.products.details'); ?>">
               <a class="nav-link <?php echo Nav::isRoute('finance.products.details'); ?>" href="#"><i class="fal fa-info-circle"></i> Overview</a>
            </li>
            <li class="nav-item">
               <a class="nav-link <?php echo Nav::isRoute('subscriptions.invoices'); ?>" href="#"><i class="fal fa-file-invoice-dollar"></i> Invoice History</a>
            </li>
         </ul>
      </div>
      <?php if(Request::is('finance/items/'.$details->productCode.'/details')): ?>
         <?php echo $__env->make('app.finance.products.details.overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
   </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/products/details/show.blade.php ENDPATH**/ ?>