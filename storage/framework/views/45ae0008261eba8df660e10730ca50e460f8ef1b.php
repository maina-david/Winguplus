<?php $__env->startSection('title','Job Management | Discussions'); ?>


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
} elseif ($_instance->childHasBeenRendered('WXRVF51')) {
    $componentId = $_instance->getRenderedChildComponentId('WXRVF51');
    $componentTag = $_instance->getRenderedChildComponentTagName('WXRVF51');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('WXRVF51');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.head', ['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('WXRVF51', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
         <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.discussions', ['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('8QfhEgT')) {
    $componentId = $_instance->getRenderedChildComponentId('8QfhEgT');
    $componentTag = $_instance->getRenderedChildComponentTagName('8QfhEgT');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('8QfhEgT');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.discussions', ['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('8QfhEgT', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
      </div>
   </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
   <script>
      ClassicEditor
      .create( document.querySelector('#comment'))
      .then(editor => {
         document.querySelector('#save_task').addEventListener('click', ()=>{
            let comment = $('#comment').data('comment');
            eval(comment).set('comment', editor.getData());
         });
      })
      .catch( error => {
         console.error( error );
      });
   </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/job/discussions.blade.php ENDPATH**/ ?>