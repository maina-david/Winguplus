<?php $__env->startSection('title','Customer | Sales Flow'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.salesflow.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="<?php echo route('salesflow.customer.create'); ?>" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add a Customer</a>
         <a href="<?php echo route('salesflow.customer.import'); ?>" class="btn btn-primary"><i class="fal fa-file-upload"></i> Import Customer</a>
         <a href="<?php echo route('salesflow.customer.export','csv'); ?>" class="btn btn-warning"><i class="fal fa-file-download"></i> Export Customer</a>
      </div>
      <!-- end breadcrumb -->
      <h1 class="page-header"><i class="fal fa-users"></i> All Customers</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('salesflow.customers.index')->html();
} elseif ($_instance->childHasBeenRendered('zt8I8pg')) {
    $componentId = $_instance->getRenderedChildComponentId('zt8I8pg');
    $componentTag = $_instance->getRenderedChildComponentTagName('zt8I8pg');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('zt8I8pg');
} else {
    $response = \Livewire\Livewire::mount('salesflow.customers.index');
    $html = $response->html();
    $_instance->logRenderedChild('zt8I8pg', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/customers/index.blade.php ENDPATH**/ ?>