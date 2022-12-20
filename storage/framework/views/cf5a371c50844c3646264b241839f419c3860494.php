<?php $__env->startSection('title','Orders List'); ?>


<?php $__env->startSection('content'); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Orders </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Orders</a></li>
                     <li class="breadcrumb-item active">List</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('orders.index')->html();
} elseif ($_instance->childHasBeenRendered('Zny6ybb')) {
    $componentId = $_instance->getRenderedChildComponentId('Zny6ybb');
    $componentTag = $_instance->getRenderedChildComponentTagName('Zny6ybb');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Zny6ybb');
} else {
    $response = \Livewire\Livewire::mount('orders.index');
    $html = $response->html();
    $_instance->logRenderedChild('Zny6ybb', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/orders/index.blade.php ENDPATH**/ ?>