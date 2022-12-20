<?php $__env->startSection('title','Employees | Human Resource Management'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         
            <a href="<?php echo route('hrm.employee.create'); ?>" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add employee</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> All employee </h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('hr.employees.index')->html();
} elseif ($_instance->childHasBeenRendered('7oCMFbo')) {
    $componentId = $_instance->getRenderedChildComponentId('7oCMFbo');
    $componentTag = $_instance->getRenderedChildComponentTagName('7oCMFbo');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('7oCMFbo');
} else {
    $response = \Livewire\Livewire::mount('hr.employees.index');
    $html = $response->html();
    $_instance->logRenderedChild('7oCMFbo', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('Modal', () => {
         $('#delete').modal('hide');
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/employee/index.blade.php ENDPATH**/ ?>