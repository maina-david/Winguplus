<?php $__env->startSection('title','Route List'); ?>


<?php $__env->startSection('content'); ?>
   <div class="row mb-2">
      <div class="col-md-8">
         <h2 class="page-header"> Route</h2>
      </div>
      <div class="col-md-4">
         <center>
            <a href="<?php echo route('routes.create'); ?>" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Add Route</a>
         </center>
      </div>
   </div>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('routes.index')->html();
} elseif ($_instance->childHasBeenRendered('ayh7Tvl')) {
    $componentId = $_instance->getRenderedChildComponentId('ayh7Tvl');
    $componentTag = $_instance->getRenderedChildComponentTagName('ayh7Tvl');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ayh7Tvl');
} else {
    $response = \Livewire\Livewire::mount('routes.index');
    $html = $response->html();
    $_instance->logRenderedChild('ayh7Tvl', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/routes/index.blade.php ENDPATH**/ ?>