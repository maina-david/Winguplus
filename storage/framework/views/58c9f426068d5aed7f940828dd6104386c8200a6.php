<?php $__env->startSection('title','Customer | Finance'); ?>

<?php $__env->startSection('stylesheets'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="<?php echo route('finance.contact.create'); ?>" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add a Customer</a>
         <a href="<?php echo route('finance.contact.import'); ?>" class="btn btn-primary"><i class="fal fa-file-upload"></i> Import Customer</a>
         <a href="<?php echo route('finance.contact.export','csv'); ?>" class="btn btn-warning"><i class="fal fa-file-download"></i> Export Customer</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> All Customers</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.customers.index')->html();
} elseif ($_instance->childHasBeenRendered('Z5PKobY')) {
    $componentId = $_instance->getRenderedChildComponentId('Z5PKobY');
    $componentTag = $_instance->getRenderedChildComponentTagName('Z5PKobY');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Z5PKobY');
} else {
    $response = \Livewire\Livewire::mount('finance.customers.index');
    $html = $response->html();
    $_instance->logRenderedChild('Z5PKobY', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/contacts/index.blade.php ENDPATH**/ ?>