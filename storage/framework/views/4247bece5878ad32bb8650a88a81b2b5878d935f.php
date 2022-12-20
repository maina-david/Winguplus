<?php $__env->startSection('title','Territories'); ?>


<?php $__env->startSection('stylesheets'); ?>
   <link rel="stylesheet" type="text/css" href="<?php echo asset('app-assets/vendors/css/extensions/jstree.min.css'); ?>">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Territory</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item active"><a href="#">Territory</a></li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- begin card -->
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('territory.index')->html();
} elseif ($_instance->childHasBeenRendered('62yZcpk')) {
    $componentId = $_instance->getRenderedChildComponentId('62yZcpk');
    $componentTag = $_instance->getRenderedChildComponentTagName('62yZcpk');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('62yZcpk');
} else {
    $response = \Livewire\Livewire::mount('territory.index');
    $html = $response->html();
    $_instance->logRenderedChild('62yZcpk', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('app-assets/vendors/js/extensions/jstree.min.js'); ?>"></script>
   <!-- BEGIN: Page JS-->
   <script src="<?php echo asset('app-assets/js/scripts/extensions/ext-component-tree.min.js'); ?>"></script>
   <!-- END: Page JS-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/territories/index.blade.php ENDPATH**/ ?>