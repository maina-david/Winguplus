<?php $__env->startSection('title','Customer | Point Of Sale'); ?>

<?php $__env->startSection('stylesheets'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="<?php echo route('pos.contact.create'); ?>" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add a Customer</a>
         
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> All Customers</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('pos.customers')->html();
} elseif ($_instance->childHasBeenRendered('0FHDEce')) {
    $componentId = $_instance->getRenderedChildComponentId('0FHDEce');
    $componentTag = $_instance->getRenderedChildComponentTagName('0FHDEce');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('0FHDEce');
} else {
    $response = \Livewire\Livewire::mount('pos.customers');
    $html = $response->html();
    $_instance->logRenderedChild('0FHDEce', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/contacts/index.blade.php ENDPATH**/ ?>