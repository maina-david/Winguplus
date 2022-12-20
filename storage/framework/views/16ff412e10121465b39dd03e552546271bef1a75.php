<?php $__env->startSection('title','POS Terminal'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <link href="<?php echo asset('assets/css/pos.css'); ?>" rel="stylesheet" />
   <style>
      .accordion p{
         margin-bottom: 0px;
      }
   </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin row -->
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('pos.terminal')->html();
} elseif ($_instance->childHasBeenRendered('G3BXQ6p')) {
    $componentId = $_instance->getRenderedChildComponentId('G3BXQ6p');
    $componentTag = $_instance->getRenderedChildComponentTagName('G3BXQ6p');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('G3BXQ6p');
} else {
    $response = \Livewire\Livewire::mount('pos.terminal');
    $html = $response->html();
    $_instance->logRenderedChild('G3BXQ6p', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>

 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/sales/hold.blade.php ENDPATH**/ ?>