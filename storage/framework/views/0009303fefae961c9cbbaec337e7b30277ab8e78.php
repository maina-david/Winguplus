<?php $__env->startSection('title','Events | Create | Human Resource'); ?>
<?php $__env->startSection('stylesheet'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
         <li class="breadcrumb-item active"><a href=#">Events</a></li>
         <li class="breadcrumb-item active"><a href=#">Create</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"> <i class="fal fa-calendar-plus"></i> Create Event</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-body">
                  <form action="<?php echo route('hrm.events.store'); ?>" method="POST">
                     <?php echo csrf_field(); ?>
                     <div class="form-group">
                        <label for="">Title</label>
                        <?php echo Form::text('title',null,['class'=>'form-control','required'=>'']); ?>

                     </div>
                     <div class="form-group">
                        <label for="">Event For</label>
                        <?php echo Form::select('event_for',['general'=>'Every one','departments'=>'Departments','employee'=>'Employee'],null,['class'=>'form-control','required'=>'']); ?>

                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="">Start Date</label>
                              <?php echo Form::date('start_date',null,['class'=>'form-control','required'=>'']); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="">End Date</label>
                              <?php echo Form::date('end_date',null,['class'=>'form-control','required'=>'']); ?>

                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="">Event For</label>
                        <?php echo Form::textarea('note',null,['class'=>'form-control tinymcy']); ?>

                     </div>

                     <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Add Event</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end #content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/events/create.blade.php ENDPATH**/ ?>