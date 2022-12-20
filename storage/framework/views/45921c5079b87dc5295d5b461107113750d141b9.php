<?php $__env->startSection('title','Customer Category | Sales Flow'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.salesflow.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Sale Flow</a></li>
         <li class="breadcrumb-item"><a href="#">Customer</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.contact.groups.index'); ?>">Category</a></li>
         <li class="breadcrumb-item active">List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-sitemap"></i> Customer Category</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('salesflow.customers.groups')->html();
} elseif ($_instance->childHasBeenRendered('7H7PDki')) {
    $componentId = $_instance->getRenderedChildComponentId('7H7PDki');
    $componentTag = $_instance->getRenderedChildComponentTagName('7H7PDki');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('7H7PDki');
} else {
    $response = \Livewire\Livewire::mount('salesflow.customers.groups');
    $html = $response->html();
    $_instance->logRenderedChild('7H7PDki', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/customers/groups.blade.php ENDPATH**/ ?>