<?php $__env->startSection('title','POS'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin row -->      
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('pos.order')->html();
} elseif ($_instance->childHasBeenRendered('h8kDY7i')) {
    $componentId = $_instance->getRenderedChildComponentId('h8kDY7i');
    $componentTag = $_instance->getRenderedChildComponentTagName('h8kDY7i');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('h8kDY7i');
} else {
    $response = \Livewire\Livewire::mount('pos.order');
    $html = $response->html();
    $_instance->logRenderedChild('h8kDY7i', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>      
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/sales/sale.blade.php ENDPATH**/ ?>