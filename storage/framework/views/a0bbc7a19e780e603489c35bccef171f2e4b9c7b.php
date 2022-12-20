<?php $__env->startSection('title','Items List | Finance'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="<?php echo route('finance.products.create'); ?>" class="btn btn-success"><i class="fas fa-plus"></i> Add New Items</a>
         <a href="<?php echo route('finance.products.import'); ?>" class="btn btn-warning"><i class="fas fa-file-upload"></i> Import Items</a>
         <a href="<?php echo route('finance.products.export','csv'); ?>" class="btn btn-pink"><i class="fas fa-file-download"></i> Export Items</a>
		</div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"> <i class="fal fa-cube"></i> All Items </h1>
      <!-- end page-header -->
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.products.products')->html();
} elseif ($_instance->childHasBeenRendered('z3IiAzw')) {
    $componentId = $_instance->getRenderedChildComponentId('z3IiAzw');
    $componentTag = $_instance->getRenderedChildComponentTagName('z3IiAzw');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('z3IiAzw');
} else {
    $response = \Livewire\Livewire::mount('finance.products.products');
    $html = $response->html();
    $_instance->logRenderedChild('z3IiAzw', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/products/index.blade.php ENDPATH**/ ?>