<?php $__env->startSection('title','Products'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
			<a href="<?php echo route('pos.products.create'); ?>" class="btn btn-success"><i class="fas fa-plus"></i> Add New Products</a>
			
		</div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shopping-basket"></i> All Products </h1>
      <!-- end page-header -->
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('pos.products')->html();
} elseif ($_instance->childHasBeenRendered('qj6mecF')) {
    $componentId = $_instance->getRenderedChildComponentId('qj6mecF');
    $componentTag = $_instance->getRenderedChildComponentTagName('qj6mecF');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('qj6mecF');
} else {
    $response = \Livewire\Livewire::mount('pos.products');
    $html = $response->html();
    $_instance->logRenderedChild('qj6mecF', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/products/products/index.blade.php ENDPATH**/ ?>