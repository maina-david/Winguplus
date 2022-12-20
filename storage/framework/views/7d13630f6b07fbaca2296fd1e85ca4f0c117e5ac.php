<?php $__env->startSection('title','Customer | E-commerce'); ?>

<?php $__env->startSection('stylesheets'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.ecommerce.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('ecommerce.dashboard'); ?>">E-commerce</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('ecommerce.customers.index'); ?>">Customers</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users-crown"></i> All Customers</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('ecommerce.customers.index')->html();
} elseif ($_instance->childHasBeenRendered('K2Vlht7')) {
    $componentId = $_instance->getRenderedChildComponentId('K2Vlht7');
    $componentTag = $_instance->getRenderedChildComponentTagName('K2Vlht7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('K2Vlht7');
} else {
    $response = \Livewire\Livewire::mount('ecommerce.customers.index');
    $html = $response->html();
    $_instance->logRenderedChild('K2Vlht7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/ecommerce/contacts/index.blade.php ENDPATH**/ ?>