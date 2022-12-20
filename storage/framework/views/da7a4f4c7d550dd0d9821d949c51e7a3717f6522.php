<?php $__env->startSection('title','Payments | Finance'); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <div class="pull-right">
      <a href="<?php echo e(route('finance.payments.create')); ?>" title="" class="btn btn-pink"><i class="fas fa-plus-circle"></i> Add Payment</a>
   </div>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-cash-register"></i> Payments</h1>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.payments')->html();
} elseif ($_instance->childHasBeenRendered('pNrZSGj')) {
    $componentId = $_instance->getRenderedChildComponentId('pNrZSGj');
    $componentTag = $_instance->getRenderedChildComponentTagName('pNrZSGj');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('pNrZSGj');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.payments');
    $html = $response->html();
    $_instance->logRenderedChild('pNrZSGj', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/payments/index.blade.php ENDPATH**/ ?>