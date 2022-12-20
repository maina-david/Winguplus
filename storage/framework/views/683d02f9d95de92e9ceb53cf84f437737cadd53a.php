<?php $__env->startSection('title','Create Job Openings | Recruitment | Human Resource'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo e(Nav::isRoute('hrm.dashboard')); ?>">Human resource</a></li>
         <li class="breadcrumb-item"><a href="#">Recruitment</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.recruitment.jobs'); ?>">Jobs</a></li>
         <li class="breadcrumb-item active">Create</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-briefcase"></i> Add Job Openings </h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-8">
            <!-- begin panel -->
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <form class="row" action="<?php echo route('hrm.recruitment.jobs.store'); ?>" method="POST">
                     <?php echo csrf_field(); ?>
                     <div class="col-sm-12">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('names', 'Posting Title', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Enter Posting Title', 'required' =>'' )); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('names', 'Job Status', array('class'=>'control-label text-danger')); ?>

                           <?php echo e(Form::select('status',[''=>'Choose status',10=>'Draft',21=>'Open',48=>'On Hold',4=>'Cancelled'], null, ['class' => 'form-control select2'])); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('names', 'Employment Type', array('class'=>'control-label text-danger')); ?>

                           <?php echo e(Form::select('contract_type',[''=>'Select contract','Permanent'=>'Permanent','On Contract'=>'On Contract','Temporary'=>'Temporary','Trainee'=>'Trainee'], null, ['class' => 'form-control select2'])); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('names', 'Hiring Lead', array('class'=>'control-label text-danger')); ?>

                           <?php echo e(Form::select('hiring_lead',$users,null, ['class' => 'form-control select2'])); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('names', 'Department', array('class'=>'control-label')); ?>

                           <?php echo e(Form::select('department',$departments, null, ['class' => 'form-control select2'])); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('names', 'Minimum Experience', array('class'=>'text-danger control-label')); ?>

                           <?php echo e(Form::select('experience',[''=>'Select Experience','Entry-level'=>'Entry-level','Mid-level'=>'Mid-level','Experienced'=>'Experienced','Trainee'=>'Trainee','Manager/Supervisor'=>'Manager/Supervisor','Senior Manager/Supervisor'=>'Senior Manager/Supervisor','Executive'=>'Executive','Senior Executive'=>'Senior Executive'], null, ['class' => 'form-control select2', 'required'=>''])); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('names', 'Head count', array('class'=>'control-label')); ?>

                           <?php echo Form::number('headcount', null, array('class' => 'form-control', 'placeholder' => '0')); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('names', 'Min Salary', array('class'=>'control-label')); ?>

                           <?php echo Form::number('min_salary', null, array('class' => 'form-control', 'placeholder' => '0')); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('names', 'Max Salary', array('class'=>'control-label')); ?>

                           <?php echo Form::number('max_salary', null, array('class' => 'form-control', 'placeholder' => '0')); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('names', 'Location', array('class'=>'text-danger control-label')); ?>

                           <?php echo Form::text('location',null, array('class' => 'form-control', 'placeholder' => 'Enter location', 'required' => '')); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('names', 'Country', array('class'=>'text-danger control-label')); ?>

                           <?php echo Form::select('country',$country, null, array('class' => 'form-control select2', 'required' => '')); ?>

                        </div>
                     </div>
							<div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('names', 'List Job on winguJobs and Your Personal Site', array('class'=>'text-danger control-label')); ?>

									<select name="listed" class="form-control select2" id="listed_options" required>
										<option value="">Choose</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
                        </div>
                     </div>
							<div class="col-md-6">
								<div class="row" style="display:none;" id="listed">
									<div class="col-md-6">
		                        <div class="form-group form-group-default required">
		                           <?php echo Form::label('names', 'Listing Date', array('class'=>'text-danger control-label')); ?>

		                           <?php echo e(Form::date('start_date',null, ['class' => 'form-control'])); ?>

		                        </div>
		                     </div>
									<div class="col-md-6">
		                        <div class="form-group form-group-default required">
		                           <?php echo Form::label('names', 'Listing End Date', array('class'=>'text-danger control-label')); ?>

		                           <?php echo e(Form::date('end_date',null, ['class' => 'form-control'])); ?>

		                        </div>
		                     </div>
								</div>
							</div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <?php echo Form::label('names','Job Description', array('class'=>'control-label')); ?>

                           <?php echo Form::textarea('job_description', null, array('class' => 'form-control tinymcy', 'placeholder' => '')); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <center>
                           <button type="submit" class="btn btn-success btn-sm submit"><i class="fas fa-save"></i> Save Job Opening</button>
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
<?php $__env->startSection('scripts'); ?>
<script>
	$(document).ready(function() {
		$('#listed_options').on('change', function(){
			if (this.value == 'Yes') {
				$('#listed').show();
			} else {
				$('#listed').hide();
			}
		});
	});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/recruitment/jobs/create.blade.php ENDPATH**/ ?>