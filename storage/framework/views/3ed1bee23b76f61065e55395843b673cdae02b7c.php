<?php $__env->startSection('title','Events | Human Resource'); ?>
<?php $__env->startSection('stylesheet'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
         <li class="breadcrumb-item active"><a href=#">Events</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"> <i class="fal fa-calendar"></i> Events</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('hr.events.index')->html();
} elseif ($_instance->childHasBeenRendered('kIbGc9Z')) {
    $componentId = $_instance->getRenderedChildComponentId('kIbGc9Z');
    $componentTag = $_instance->getRenderedChildComponentTagName('kIbGc9Z');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('kIbGc9Z');
} else {
    $response = \Livewire\Livewire::mount('hr.events.index');
    $html = $response->html();
    $_instance->logRenderedChild('kIbGc9Z', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
   <!-- end #content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/events/index.blade.php ENDPATH**/ ?>