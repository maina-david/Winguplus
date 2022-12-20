<?php $__env->startSection('title','Job Management | Notes'); ?>


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
         <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.head', ['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('rJ0fWaN')) {
    $componentId = $_instance->getRenderedChildComponentId('rJ0fWaN');
    $componentTag = $_instance->getRenderedChildComponentTagName('rJ0fWaN');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('rJ0fWaN');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.head', ['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('rJ0fWaN', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
         <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.notes', ['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('X3OtZAZ')) {
    $componentId = $_instance->getRenderedChildComponentId('X3OtZAZ');
    $componentTag = $_instance->getRenderedChildComponentTagName('X3OtZAZ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('X3OtZAZ');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.notes', ['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('X3OtZAZ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#addNote').modal('hide');
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/notes/index.blade.php ENDPATH**/ ?>