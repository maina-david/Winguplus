<?php $__env->startSection('title','Customer Category'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
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
    $html = \Livewire\Livewire::mount('finance.customers.category')->html();
} elseif ($_instance->childHasBeenRendered('COqZBxd')) {
    $componentId = $_instance->getRenderedChildComponentId('COqZBxd');
    $componentTag = $_instance->getRenderedChildComponentTagName('COqZBxd');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('COqZBxd');
} else {
    $response = \Livewire\Livewire::mount('finance.customers.category');
    $html = $response->html();
    $_instance->logRenderedChild('COqZBxd', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/contacts/groups/index.blade.php ENDPATH**/ ?>