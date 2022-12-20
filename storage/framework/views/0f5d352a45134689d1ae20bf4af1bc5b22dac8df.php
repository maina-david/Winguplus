<?php $__env->startSection('title','Leave application | Human Resource'); ?>
<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="#">Leave</a></li>
         <li class="breadcrumb-item active">Apply</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fad fa-calendar-check"></i> Leave Application</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  Leave Form
               </div>
               <div class="card-body">
                  <form action="<?php echo route('hrm.leave.apply.store'); ?>" method="post" autocomplete="off">
                     <?php echo csrf_field(); ?>
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Leave Type</label>
                        <?php echo Form::select('type_code', $types, null, array('class' => 'form-control select2', 'required' => '','id' => 'type')); ?>

                     </div>
                     <div class="row">
      						<div class="col-sm-6">
      							<div class="form-group form-group-default required">
      								<?php echo Form::label('names', 'Start', array('class'=>'control-label text-danger')); ?>

      								<?php echo Form::date('start_date', null, array('class' => 'form-control', 'placeholder' => 'Choose date', 'required' => '')); ?>

      							</div>
      						</div>
      						<div class="col-sm-6">
      							<div class="form-group form-group-default">
      								<?php echo Form::label('Time', 'End', array('class'=>'control-label text-danger')); ?>

      								<?php echo Form::date('end_date', null, array('class' => 'form-control', 'placeholder' => 'Choose date','required' => '')); ?>

      							</div>
      						</div>
      					</div>
                     <div class="form-group">
      						<?php echo Form::label('Description', 'Reason', array('class'=>'control-label')); ?>

      						<?php echo e(Form::textarea('reason', null, ['class' => 'form-control','size' => '3x4'])); ?>

      					</div>
                     <div class="form-group">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit Application</button>
            					<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                        </center>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/leave/application/create.blade.php ENDPATH**/ ?>