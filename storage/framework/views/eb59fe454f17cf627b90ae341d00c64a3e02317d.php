<?php $__env->startSection('title','Job Management | Notes'); ?>


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
    $html = \Livewire\Livewire::mount('jobs.job.head', ['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('S7cAPHR')) {
    $componentId = $_instance->getRenderedChildComponentId('S7cAPHR');
    $componentTag = $_instance->getRenderedChildComponentTagName('S7cAPHR');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('S7cAPHR');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.head', ['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('S7cAPHR', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-12 mt-2">
            <div class="row">
               <div class="col-md-12">
                  <h4 class="font-weight-bold"><i class="fal fa-sticky-note"></i> Notes | Edit</h4>
               </div>
            </div>
         </div>
      </div>
      <div class="row mt-2">
         <div class="col-md-8">
            <div class="panel">
               <div class="panel-body">
                  <?php echo Form::model($edit,['route' => ['job.notes.update',[$code,$edit->note_code]], 'method' => 'post']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="form-group">
                        <label for="">Title</label>
                        <?php echo Form::text('title', null, ['class' => 'form-control', 'required' => '']); ?>

                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="">Status</label>
                              <?php echo Form::select('status', ['Choose status' => '', 'Public' => 'Public', 'Private' => 'Private'], null ,['class' => 'form-control']); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="">Label</label>
                              <?php echo Form::select('label',[''=>'Choose Label','bg-blue'=>'Blue','bg-orange'=>'Orange','bg-red'=>'Red','bg-cyan'=>'Cyan / Aqua','bg-gray'=>'Gray','bg-teal'=>'Teal'],null,['class'=>'form-control']); ?>

                           </div>
                        </div>
                     </div>
                     <?php echo Form::textarea('brief', null, ['class' => 'form-control', 'size'=>'4 x 4']); ?>

                     <div class="form-group">
                        <label for="">Note</label>
                        <textarea name="content" class="form-control tinymcy"><?php echo $edit->content; ?></textarea>
                     </div>
                     <div class="form-group">
                        <center><button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Note</button></center>
                        <center><img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%"></center>
                     </div>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/notes/edit.blade.php ENDPATH**/ ?>