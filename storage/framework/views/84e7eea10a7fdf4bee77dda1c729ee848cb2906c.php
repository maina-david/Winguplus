<?php $__env->startSection('title','Expenses List | Finance'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
	<div class="content">
      <div class="pull-right">
         <a href="<?php echo route('finance.expense.create'); ?>" class="btn btn-pink"><i class="fal fa-plus"></i> New Expense</a>
      </div>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-receipt"></i> Expenses</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.expenses.expenses')->html();
} elseif ($_instance->childHasBeenRendered('J33VKaW')) {
    $componentId = $_instance->getRenderedChildComponentId('J33VKaW');
    $componentTag = $_instance->getRenderedChildComponentTagName('J33VKaW');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('J33VKaW');
} else {
    $response = \Livewire\Livewire::mount('finance.expenses.expenses');
    $html = $response->html();
    $_instance->logRenderedChild('J33VKaW', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/expense/expense/index.blade.php ENDPATH**/ ?>