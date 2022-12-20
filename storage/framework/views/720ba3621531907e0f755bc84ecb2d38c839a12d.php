<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Utility Billing <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

 
 
<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
      <li class="breadcrumb-item"><a href="#">Accounting</a></li>
      <li class="breadcrumb-item active"><a href="#">Utility Billing</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-home"></i> <?php echo $property->title; ?> | Utility Billing </h1>
   <div class="row">
      <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('property.utility.index',['propertyID' => $property->id])->html();
} elseif ($_instance->childHasBeenRendered('3KYuImW')) {
    $componentId = $_instance->getRenderedChildComponentId('3KYuImW');
    $componentTag = $_instance->getRenderedChildComponentTagName('3KYuImW');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('3KYuImW');
} else {
    $response = \Livewire\Livewire::mount('property.utility.index',['propertyID' => $property->id]);
    $html = $response->html();
    $_instance->logRenderedChild('3KYuImW', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>      
   </div> 
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/propertywingu/accounting/utility/index.blade.php ENDPATH**/ ?>