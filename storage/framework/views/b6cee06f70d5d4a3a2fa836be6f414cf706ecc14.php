<?php $__env->startSection('title','Job Management | Users'); ?>


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
} elseif ($_instance->childHasBeenRendered('sQnKDh1')) {
    $componentId = $_instance->getRenderedChildComponentId('sQnKDh1');
    $componentTag = $_instance->getRenderedChildComponentTagName('sQnKDh1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('sQnKDh1');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.head', ['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('sQnKDh1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
         <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.users', ['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('78rnzSZ')) {
    $componentId = $_instance->getRenderedChildComponentId('78rnzSZ');
    $componentTag = $_instance->getRenderedChildComponentTagName('78rnzSZ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('78rnzSZ');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.users', ['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('78rnzSZ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/job/users.blade.php ENDPATH**/ ?>