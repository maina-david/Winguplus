<?php $__env->startSection('title','Items'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
				<a href="<?php echo route('pos.item.create'); ?>" class="btn btn-success"><i class="fas fa-plus"></i> Add New Item</a>
				
		</div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shopping-basket"></i> All Items </h1>
      <!-- end page-header -->
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('pos.items')->html();
} elseif ($_instance->childHasBeenRendered('2Okc4Ay')) {
    $componentId = $_instance->getRenderedChildComponentId('2Okc4Ay');
    $componentTag = $_instance->getRenderedChildComponentTagName('2Okc4Ay');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('2Okc4Ay');
} else {
    $response = \Livewire\Livewire::mount('pos.items');
    $html = $response->html();
    $_instance->logRenderedChild('2Okc4Ay', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/items/index.blade.php ENDPATH**/ ?>