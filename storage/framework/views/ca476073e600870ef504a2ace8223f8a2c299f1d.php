<?php $__env->startSection('title','Tasks | Job Management'); ?>


<?php $__env->startSection('stylesheet'); ?>
   <link rel="stylesheet" href="<?php echo asset('assets/css/project.css'); ?>" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.jobs.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!--begin::Navbar-->
   
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.task-section',['jobCode' => $code, 'sectionCode' => $section])->html();
} elseif ($_instance->childHasBeenRendered('6C3QgyH')) {
    $componentId = $_instance->getRenderedChildComponentId('6C3QgyH');
    $componentTag = $_instance->getRenderedChildComponentTagName('6C3QgyH');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('6C3QgyH');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.task-section',['jobCode' => $code, 'sectionCode' => $section]);
    $html = $response->html();
    $_instance->logRenderedChild('6C3QgyH', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <!--begin::Modal - Users Search-->
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.add-member-modal',['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('KU4jzwl')) {
    $componentId = $_instance->getRenderedChildComponentId('KU4jzwl');
    $componentTag = $_instance->getRenderedChildComponentTagName('KU4jzwl');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('KU4jzwl');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.add-member-modal',['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('KU4jzwl', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <!--end::Modal - Users Search-->
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#addTaskGroup').modal('hide');
         $('#addTask').modal('hide');
         $('#editTask').modal('hide');
         $('#updateTaskGroup').modal('hide');
         $('#add-section').modal('hide');
         $('#edit-section').modal('hide');
         $('#delete').modal('hide');
         $('#taskview').modal('hide');
      });
   </script>
   <script>
      $(function() {
         var url = "<?php echo route('task.group.change'); ?>";
         $('ul[id^="sort"]').sortable({
            connectWith: ".sortable",
            receive: function (e, ui) {
               var group_code = $(ui.item).parent(".sortable").data("status-id");
               var task_code = $(ui.item).data("task-id");
               $.ajax({
                  url: url+'?group_code='+group_code+'&task_code='+task_code,
                     success: function(response){
                  }
               });
            }
         }).disableSelection();
      } );
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/tasks/section.blade.php ENDPATH**/ ?>