<?php $__env->startSection('title','Customer Visits'); ?>


<?php $__env->startSection('content'); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Customer Visits</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Customer</a></li>
                     <li class="breadcrumb-item active">Visits</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end breadcrumb -->
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('checkin.index')->html();
} elseif ($_instance->childHasBeenRendered('aKyZ4y4')) {
    $componentId = $_instance->getRenderedChildComponentId('aKyZ4y4');
    $componentTag = $_instance->getRenderedChildComponentTagName('aKyZ4y4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('aKyZ4y4');
} else {
    $response = \Livewire\Livewire::mount('checkin.index');
    $html = $response->html();
    $_instance->logRenderedChild('aKyZ4y4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/checkins/index.blade.php ENDPATH**/ ?>