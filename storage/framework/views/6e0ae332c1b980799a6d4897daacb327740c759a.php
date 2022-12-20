<?php $__env->startSection('title','Users'); ?>


<?php $__env->startSection('content'); ?>
   <!-- begin breadcrumb -->
   <div class="row mb-2">
      <div class="col-md-9">
         <h2 class="page-header"> Users </h2>
      </div>
      <div class="col-md-3">
         <center>
            <a href="<?php echo route('user.create'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Add Users</a>
         </center>
      </div>
   </div>
   <!-- end breadcrumb -->
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('users.index')->html();
} elseif ($_instance->childHasBeenRendered('ae7ib5X')) {
    $componentId = $_instance->getRenderedChildComponentId('ae7ib5X');
    $componentTag = $_instance->getRenderedChildComponentTagName('ae7ib5X');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ae7ib5X');
} else {
    $response = \Livewire\Livewire::mount('users.index');
    $html = $response->html();
    $_instance->logRenderedChild('ae7ib5X', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/users/index.blade.php ENDPATH**/ ?>