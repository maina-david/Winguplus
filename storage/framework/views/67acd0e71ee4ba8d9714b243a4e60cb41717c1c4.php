<?php $__env->startSection('title','Invoices | Finance'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<div class="pull-right">
         <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"> <i class="fas fa-plus-circle"></i> New invoice</button>
            <ul class="dropdown-menu">
               <li><a href="<?php echo route('finance.invoice.product.create'); ?>">Create New Invoice</a></li>
               
            </ul>
         </div>
         
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> All Invoices</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.invoices')->html();
} elseif ($_instance->childHasBeenRendered('tVt54tT')) {
    $componentId = $_instance->getRenderedChildComponentId('tVt54tT');
    $componentTag = $_instance->getRenderedChildComponentTagName('tVt54tT');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('tVt54tT');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.invoices');
    $html = $response->html();
    $_instance->logRenderedChild('tVt54tT', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('Modal', () => {
         $('#delete').modal('hide');
      });
   </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/invoices/index.blade.php ENDPATH**/ ?>