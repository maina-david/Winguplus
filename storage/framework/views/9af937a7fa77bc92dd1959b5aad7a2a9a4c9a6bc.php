<?php $__env->startSection('title','Allocated Inventory'); ?>

<?php $__env->startSection('content'); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Allocated Inventory</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                     <li class="breadcrumb-item active">Allocated</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventory.allocated')->html();
} elseif ($_instance->childHasBeenRendered('9DvwJzy')) {
    $componentId = $_instance->getRenderedChildComponentId('9DvwJzy');
    $componentTag = $_instance->getRenderedChildComponentTagName('9DvwJzy');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('9DvwJzy');
} else {
    $response = \Livewire\Livewire::mount('inventory.allocated');
    $html = $response->html();
    $_instance->logRenderedChild('9DvwJzy', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/inventory/allocated.blade.php ENDPATH**/ ?>