<?php $__env->startSection('title','Job Management | Goals'); ?>


<?php $__env->startSection('stylesheet'); ?>
   <link rel="stylesheet" href="<?php echo asset('assets/css/project.css'); ?>" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.jobs.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

	<div class="content">
      <!--begin::Container-->
      <div class="container-fluid">
         <!--begin::Navbar-->
         
         <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.goals.goals', ['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('Yct87i4')) {
    $componentId = $_instance->getRenderedChildComponentId('Yct87i4');
    $componentTag = $_instance->getRenderedChildComponentTagName('Yct87i4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Yct87i4');
} else {
    $response = \Livewire\Livewire::mount('jobs.goals.goals', ['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('Yct87i4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#goalModal').modal('hide');
         $('#delete').modal('hide');
         $('#goalDetails').modal('hide');
      });
      window.livewire.on('progress', () => {
         $('#progressModal').modal('hide');
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/goals/goals.blade.php ENDPATH**/ ?>