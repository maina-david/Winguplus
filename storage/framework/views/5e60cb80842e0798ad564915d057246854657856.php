<?php $__env->startSection('title','Products List | Sales Flow'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.salesflow.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="<?php echo route('salesflow.products.create'); ?>" class="btn btn-success"><i class="fas fa-plus"></i> Add New Product</a>
         <a href="<?php echo route('salesflow.products.import'); ?>" class="btn btn-warning"><i class="fas fa-file-upload"></i> Import Product</a>
         <a href="<?php echo route('salesflow.products.export','csv'); ?>" class="btn btn-pink"><i class="fas fa-file-download"></i> Export Product</a>
		</div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"> <i class="fal fa-cube"></i> All Products </h1>
      <!-- end page-header -->
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('salesflow.products.index')->html();
} elseif ($_instance->childHasBeenRendered('BnXDNpT')) {
    $componentId = $_instance->getRenderedChildComponentId('BnXDNpT');
    $componentTag = $_instance->getRenderedChildComponentTagName('BnXDNpT');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('BnXDNpT');
} else {
    $response = \Livewire\Livewire::mount('salesflow.products.index');
    $html = $response->html();
    $_instance->logRenderedChild('BnXDNpT', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/products/index.blade.php ENDPATH**/ ?>