<?php $__env->startSection('title'); ?> Tenants List | Property Wingu <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.propertywingu.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      
      <a href="<?php echo route('tenants.create'); ?>" class="btn btn-pink mr-2"><i class="fal fa-plus-circle"></i> Add Tenant</a>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-users"></i> Tenants - List</h1>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('propertywingu.tenants.index')->html();
} elseif ($_instance->childHasBeenRendered('qBZW1dt')) {
    $componentId = $_instance->getRenderedChildComponentId('qBZW1dt');
    $componentTag = $_instance->getRenderedChildComponentTagName('qBZW1dt');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('qBZW1dt');
} else {
    $response = \Livewire\Livewire::mount('propertywingu.tenants.index');
    $html = $response->html();
    $_instance->logRenderedChild('qBZW1dt', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/propertywingu/tenants/index.blade.php ENDPATH**/ ?>