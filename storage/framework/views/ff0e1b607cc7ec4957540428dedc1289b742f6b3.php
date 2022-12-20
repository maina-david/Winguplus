<?php $__env->startSection('title','Jobs Mangement | Create Job'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.jobs.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo route('jobs.dashboard'); ?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?php echo route('job.index'); ?>">Jobs</a></li>
      <li class="breadcrumb-item active">Create Job</li>
   </ol>
   <h1 class="page-header"><i class="fal fa-rocket-launch"></i> Create Job</h1>
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <?php echo Form::open(array('route' => 'job.store','enctype'=>'multipart/form-data','method'=>'post','autocomplete'=>'off')); ?>

		<?php echo csrf_field(); ?>

		<div class="row">
			<div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Jobs Details</h4>
               </div>
               <div class="panel-body">
                  <div class="form-group form-group-default required ">
                     <?php echo Form::label('Job name', 'Whats the Jobs Title?', array('class'=>'control-label')); ?>

                     <?php echo Form::text('job_title', null, array('class' => 'form-control', 'placeholder' => 'Job title', 'required' => '')); ?>

                  </div>
                  <div class="form-group form-group-default required ">
                     <?php echo Form::label('job_type', 'Is this an Internal or External Job ?', array('class'=>'control-label')); ?>

                     <?php echo e(Form::select('job_type',[''=>'Choose','Internal'=>'Internal','External'=>'External'], null, ['class' => 'form-control select2','id' => 'project' ])); ?>

                  </div>
                  <div class="form-group form-group-default required" id="company_name" style="display:none">
                     <?php echo Form::label('Client Name', 'Client Name', array('class'=>'control-label')); ?>

                     <?php echo Form::select('customer',$clients,null,['class'=>'form-control select2']); ?>

                  </div>
                  <div class="form-group form-group-default" id="notify" style="display:none">
                     <label for="">Notify Client</label>
                     <?php echo e(Form::select('notify_client', ['' => 'Choose','Yes' => 'Yes','No' => 'No'], null, ['class' => 'form-control select2'])); ?>

                  </div>
                  <div class="form-group form-group-default required ">
                     <?php echo Form::label('project_status', 'Visibility Status', array('class'=>'control-label')); ?>

                     <?php echo e(Form::select('visibility_status',[''=>'Choose Status','Public'=>'Public','Private' => 'Private'], null, ['class' => 'form-control select2','required'=> ''])); ?>

                  </div>
               </div>
            </div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Jobs Details</h4>
               </div>
               <div class="panel-body">
                  <div class="form-group required">
                     <?php echo Form::label('Choose Job Managers', 'Allocate Job Managers', array('class'=>'control-label')); ?>

                     <?php echo e(Form::select('job_leads[]', $users, null, ['class' => 'form-control select2','id'=>'project','multiple' => '','required' =>''])); ?>

                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('start Date', 'start Date', array('class'=>'control-label')); ?>

                           <?php echo Form::date('start_date', null, array('class' => 'form-control','required' => '')); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('End Date', 'End Date', array('class'=>'control-label')); ?>

                           <?php echo Form::date('end_date', null, array('class' => 'form-control','required' => '')); ?>

                        </div>
                     </div>
                  </div>
                  <div class="form-group form-group-default required ">
                     <?php echo Form::label('project_status', 'Job Status', array('class'=>'control-label')); ?>

                     <?php echo e(Form::select('status',[''=>'Choose Job Status',17=>'Started',21 => 'Open',16=>'Complete',22=>'Closed',24=>'Ongoing'], null, ['class' => 'form-control select2','required'=> ''])); ?>

                  </div>
               </div>
				</div>
			</div>
			<div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-body">
                  <div class="form-group">
                     <?php echo Form::label('Project name', 'Brief project introduction', array('class'=>'control-label')); ?>

                     <?php echo Form::textarea('brief_info',null,array('class' => 'form-control','size' => '8 x 8','placeholder' => 'type...............')); ?>

                  </div>
                  <div class="form-group required">
                     <?php echo Form::label('Description', 'Description', array('class'=>'control-label')); ?>

                     <?php echo Form::textarea('description',null,['class'=>'form-control tinymcy', 'rows' => 5, 'placeholder'=>'content']); ?>

                  </div>
               </div>
            </div>
			</div>
         <div class="row">
            <div class="panel-body">
               <div class="col-md-12">
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Create Job</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="20%">
               </div>
            </div>
         </div>
      </div>
   <?php echo Form::close(); ?>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script>
		$(document).ready(function(){
			$('#project').on('change', function(){
				if(this.value == 'External'){
					$('#company_name').show();
               $('#notify').show();
				}else{
					$('#company_name').hide();
               $('#notify').hide();
				}
			});
		});
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/job/create.blade.php ENDPATH**/ ?>