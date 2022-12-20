<?php $__env->startSection('title','Allocated Items'); ?>

<?php $__env->startSection('content'); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0"> Inventory | Allocated Items </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                     <li class="breadcrumb-item active">Allocated Items</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('inventory.items',['code'=>$code])->html();
} elseif ($_instance->childHasBeenRendered('pkZvW3o')) {
    $componentId = $_instance->getRenderedChildComponentId('pkZvW3o');
    $componentTag = $_instance->getRenderedChildComponentTagName('pkZvW3o');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('pkZvW3o');
} else {
    $response = \Livewire\Livewire::mount('inventory.items',['code'=>$code]);
    $html = $response->html();
    $_instance->logRenderedChild('pkZvW3o', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/inventory/allocate_items.blade.php ENDPATH**/ ?>