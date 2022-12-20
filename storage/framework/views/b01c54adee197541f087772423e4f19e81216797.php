<?php $__env->startSection('title'); ?> Job Events <?php $__env->stopSection(); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.jobs.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.head',['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('xRMTvaB')) {
    $componentId = $_instance->getRenderedChildComponentId('xRMTvaB');
    $componentTag = $_instance->getRenderedChildComponentTagName('xRMTvaB');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('xRMTvaB');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.head',['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('xRMTvaB', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
      <div class="row mt-3">
         <div class="col-md-12">
            <div class="mb-4">
               <a href="#" class="btn btn-pink mb-1" data-toggle="modal" data-target=".add-events"><i class="fal fa-calendar-plus"></i> Add Event</a>
            </div>
            <div class="row">
               <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-md-4">
                     <div class="widget-list-item">
                        <div class="widget-list-media">
                           <i class="fas fa-calendar-day fa-3x"></i>
                        </div>
                        <div class="widget-list-content">
                           <h4 class="widget-list-title font-weight-bold"><?php echo $event->title; ?></h4>
                           <p class="widget-list-desc mt-1">
                              <b>Date :</b> <?php echo date('d F, Y', strtotime($event->start_date)); ?><br>
                              <b>Venue :</b> <?php echo $event->venue; ?><br>
                              <b>Status :</b> <?php echo $event->status; ?><br>
                              <b>Priority :</b> <?php echo $event->priority; ?><br>
                           </p>
                        </div>
                        <div class="widget-list-action">
                           <a href="#" data-toggle="dropdown" class="text-muted pull-right">
                           <i class="fa fa-ellipsis-h f-s-14"></i>
                           </a>
                           <ul class="dropdown-menu dropdown-menu-right">
                              <li><a href="<?php echo route('job.events.show', [$code,$event->event_code]); ?>">View</a></li>
                              <li><a href="<?php echo route('job.events.edit', [$code,$event->event_code]); ?>">Edit</a></li>
                              <li><a href="<?php echo route('job.events.delete',[$code,$event->event_code]); ?>" class="delete">Delete</a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         </div>
      </div>
   </div>

   
   <div class="modal fade add-events" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <form action="<?php echo route('job.events.store'); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title group-title" id="exampleModalLongTitle"><i class="fas fa-calendar-plus"></i> Add Events</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
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
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('Event Date', 'Event Start Date', array('class'=>'control-label')); ?>

                           <?php echo Form::date('start_date', null, array('class' => 'form-control','placeholder' => 'mm/dd/yyyy')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('Event Date', 'Event End Date', array('class'=>'control-label')); ?>

                           <?php echo Form::date('end_date', null, array('class' => 'form-control','placeholder' => 'mm/dd/yyyy')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('Status', 'Status', array('class'=>'control-label')); ?>

                           <?php echo e(Form::select('status',[''=>'Choose status','completed'=>'Completed','rescheduled'=>'Rescheduled','cancelled' => 'Cancelled','No Show' => 'No Show','Still to meet' => 'Still to meet'], null, ['class' => 'form-control', 'required' => ''])); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Time', 'Priority', array('class'=>'control-label')); ?>

                           <?php echo Form::select('priority', [''=>'Choose Priority','High'=>'High','Normal'=>'Normal','Low' => 'Low'], null, array('class' => 'form-control','placeholder' => 'Choose date')); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <?php echo Form::label('description', 'Description', array('class'=>'control-label')); ?>

                           <?php echo Form::textarea('description', null, array('class' => 'form-control tinymcy')); ?>

                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-pink submit" id="submit"><i class="fas fa-save"></i> Add Event</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </div>
            </div>
         </form>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/events/index.blade.php ENDPATH**/ ?>