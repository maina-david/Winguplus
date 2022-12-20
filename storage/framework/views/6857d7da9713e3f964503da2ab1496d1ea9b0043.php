<?php $__env->startSection('title','List Asset'); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.assets.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="content">
	<div class="pull-right">
      <a href="<?php echo route('assets.create'); ?>" class="btn btn-pink"><i class="fal fa-plus-circle"></i> Add Asset</a>
   </div>
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fas fa-barcode"></i> Assets</h1>
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('assets.assets.assets')->html();
} elseif ($_instance->childHasBeenRendered('6Cqlifr')) {
    $componentId = $_instance->getRenderedChildComponentId('6Cqlifr');
    $componentTag = $_instance->getRenderedChildComponentTagName('6Cqlifr');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('6Cqlifr');
} else {
    $response = \Livewire\Livewire::mount('assets.assets.assets');
    $html = $response->html();
    $_instance->logRenderedChild('6Cqlifr', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/assets/assets/index.blade.php ENDPATH**/ ?>