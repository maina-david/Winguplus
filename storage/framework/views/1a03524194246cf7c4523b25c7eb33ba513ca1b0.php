<?php $__env->startSection('title','Warehousing List'); ?>


<?php $__env->startSection('content'); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Warehousing </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Warehousing</a></li>
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
    $html = \Livewire\Livewire::mount('warehousing.index')->html();
} elseif ($_instance->childHasBeenRendered('dRymoSw')) {
    $componentId = $_instance->getRenderedChildComponentId('dRymoSw');
    $componentTag = $_instance->getRenderedChildComponentTagName('dRymoSw');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('dRymoSw');
} else {
    $response = \Livewire\Livewire::mount('warehousing.index');
    $html = $response->html();
    $_instance->logRenderedChild('dRymoSw', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/warehousing/index.blade.php ENDPATH**/ ?>