<?php $__env->startSection('title','Supplier List | Finance'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
            <a href="<?php echo route('finance.supplier.create'); ?>" class="btn btn-pink"><i class="fas fa-user-plus"></i> Add A Supplier</a>
            <a href="<?php echo route('supplier.import.index'); ?>" class="btn btn-pink"><i class="fas fa-file-upload"></i> Import Supplier</a>
            <a href="<?php echo route('supplier.export','csv'); ?>" class="btn btn-pink"><i class="fas fa-file-download"></i> Export Supplier</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users-cog"></i> All Supplier</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.suppliers.suppliers')->html();
} elseif ($_instance->childHasBeenRendered('BmABVUa')) {
    $componentId = $_instance->getRenderedChildComponentId('BmABVUa');
    $componentTag = $_instance->getRenderedChildComponentTagName('BmABVUa');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('BmABVUa');
} else {
    $response = \Livewire\Livewire::mount('finance.suppliers.suppliers');
    $html = $response->html();
    $_instance->logRenderedChild('BmABVUa', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/suppliers/index.blade.php ENDPATH**/ ?>