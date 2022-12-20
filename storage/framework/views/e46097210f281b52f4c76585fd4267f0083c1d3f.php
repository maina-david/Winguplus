<?php $__env->startSection('title','My Tasks | Job Management'); ?>


<?php $__env->startSection('stylesheet'); ?>
   <link rel="stylesheet" href="<?php echo asset('assets/css/task_inbox.css'); ?>" />
   <link rel="stylesheet" href="<?php echo asset('assets/css/project.css'); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.jobs.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <style>
      ul.product li {
         width: 100%;
      }
   </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.my-task-list')->html();
} elseif ($_instance->childHasBeenRendered('va60Vaq')) {
    $componentId = $_instance->getRenderedChildComponentId('va60Vaq');
    $componentTag = $_instance->getRenderedChildComponentTagName('va60Vaq');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('va60Vaq');
} else {
    $response = \Livewire\Livewire::mount('jobs.my-task-list');
    $html = $response->html();
    $_instance->logRenderedChild('va60Vaq', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#addTaskGroup').modal('hide');
         $('#taskview').modal('hide');
      });
   </script>
   <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
   <script>
      ClassicEditor
      .create( document.querySelector('#details'))
      .then(editor => {
         document.querySelector('#save_task').addEventListener('click', ()=>{
            let details = $('#details').data('details');
            eval(details).set('details', editor.getData());
         });
      })
      .catch( error => {
         console.error( error );
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/tasks/my_task_list.blade.php ENDPATH**/ ?>