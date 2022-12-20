<?php $__env->startSection('title','Job Management | Files'); ?>


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
} elseif ($_instance->childHasBeenRendered('DrJq8IP')) {
    $componentId = $_instance->getRenderedChildComponentId('DrJq8IP');
    $componentTag = $_instance->getRenderedChildComponentTagName('DrJq8IP');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('DrJq8IP');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.head', ['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('DrJq8IP', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
         <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.files', ['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('Yr1cFcc')) {
    $componentId = $_instance->getRenderedChildComponentId('Yr1cFcc');
    $componentTag = $_instance->getRenderedChildComponentTagName('Yr1cFcc');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Yr1cFcc');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.files', ['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('Yr1cFcc', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
         <!--begin::Modal - Users Search-->
      </div>
   </div>

   
   <div class="modal fade add-file" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <form action="<?php echo route('job.files.store'); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title group-title" id="exampleModalLongTitle"><i class="fal fa-folder-plus"></i> Upload File</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('File Title', 'File Title', array('class'=>'control-label')); ?>

                           <?php echo Form::text('title', null, array('class' => 'form-control','required' => '','placeholder' => 'Enter File title')); ?>

                           <input type="hidden" value="<?php echo $code; ?>" name="jobcode" required>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <?php echo Form::label('File', 'Choose File', array('class'=>'control-label')); ?>

                           <input type="file" name="attachment[]" id="files"  class="form-control" multiple>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-pink submit" id="submit"><i class="fas fa-save"></i> Upload Files</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </div>
            </div>
         </form>
      </div>
   </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#delete').modal('hide');
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/job/files.blade.php ENDPATH**/ ?>