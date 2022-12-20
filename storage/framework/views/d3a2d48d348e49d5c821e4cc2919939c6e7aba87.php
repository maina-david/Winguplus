<?php $__env->startSection('title'); ?> Job Management | Events <?php $__env->stopSection(); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.jobs.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.head',['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('hnEJeww')) {
    $componentId = $_instance->getRenderedChildComponentId('hnEJeww');
    $componentTag = $_instance->getRenderedChildComponentTagName('hnEJeww');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('hnEJeww');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.head',['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('hnEJeww', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row mb-3">
         <div class="col-md-12">
            <h4><i class="fal fa-calendar-alt"></i> Edit Events</h4>
         </div>
      </div>
      <div class="row mt-3">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <?php echo Form::model($edit, ['route' => ['job.events.update', [$edit->event_code]], 'method' => 'post', 'class' => 'row']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('Event Title', 'Event Title', array('class'=>'control-label')); ?>

                           <?php echo Form::text('title', null, array('class' => 'form-control','required' => '','placeholder' => 'Enter Event Title')); ?>

                           <input type="hidden" value="<?php echo $code; ?>" name="jobcode">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Venue', 'Venue', array('class'=>'control-label')); ?>

                           <?php echo Form::text('venue', null, array('class' => 'form-control','placeholder' => 'Enter venue')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 <?php echo Form::label('Event Date', 'Event Start Date', array('class'=>'control-label')); ?>

                                 <?php echo Form::date('start_date', null, array('class' => 'form-control')); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 <?php echo Form::label('Event Date', 'Event Start Date', array('class'=>'control-label')); ?>

                                 <?php echo Form::time('start_time', null, array('class' => 'form-control')); ?>

                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 <?php echo Form::label('Event Date', 'Event Start Date', array('class'=>'control-label')); ?>

                                 <?php echo Form::date('end_date', null, array('class' => 'form-control')); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 <?php echo Form::label('Event Date', 'Event Start Date', array('class'=>'control-label')); ?>

                                 <?php echo Form::time('end_time', null, array('class' => 'form-control')); ?>

                              </div>
                           </div>
                        </div>
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('Event Date', 'Event End Date', array('class'=>'control-label')); ?>

                           <?php echo Form::text('end_date', null, array('class' => 'form-control')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Time', 'Priority', array('class'=>'control-label')); ?>

                           <?php echo Form::select('priority', [''=>'Choose Priority','High'=>'High','Normal'=>'Normal','Low' => 'Low'], null, array('class' => 'form-control multiselect','placeholder' => 'Choose date')); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <?php echo Form::label('description', 'Description', array('class'=>'control-label')); ?>

                           <?php echo Form::textarea('description', null, array('class' => 'form-control tinymcy')); ?>

                        </div>
                     </div>
                     <div class="form-group">
                        <center>
                           <button type="submit" class="btn btn-pink submit ml-2"><i class="fas fa-save"></i> Update Event</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                        </center>
                     </div>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/events/edit.blade.php ENDPATH**/ ?>