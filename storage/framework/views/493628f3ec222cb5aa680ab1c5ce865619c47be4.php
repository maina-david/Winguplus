<?php $__env->startSection('title','Add Travel Request | Travel | Human Resource'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo e(Nav::isRoute('hrm.dashboard')); ?>">Human resource</a></li>
		<li class="breadcrumb-item"><a href="<?php echo route('hrm.travel.index'); ?>">Travel</a></li>
		<li class="breadcrumb-item active">Add Travel Requests</li>
	</ol>
	<h1 class="page-header"><i class="fal fa-plane"></i> Add Travel Request</h1>
	<!-- end page-header -->
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<!-- begin panel -->
	<form action="<?php echo route('hrm.travel.store'); ?>" method="post" class="row">
		<?php echo csrf_field(); ?>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Travel Details</div>
				<div class="panel-body">
					<div class="form-group form-group-default required">
						<label class="text-danger">Choose Employee(s)</label>
						<?php echo Form::select('employee[]',$employees,null,['class'=>'form-control select2','required'=>'','multiple'=>'']); ?>

					</div>
					<div class="form-group form-group-default required">
						<label class="text-danger">Choose Department(s)</label>
						<?php echo Form::select('department[]',$departments,null,['class'=>'form-control select2','required'=>'','multiple'=>'']); ?>

					</div>
					<div class="form-group form-group-default required">
						<label class="text-danger">Expected date of departure</label>
						<?php echo Form::date('departure_date',null,['class'=>'form-control','required'=>'']); ?>

					</div>
					<div class="form-group form-group-default required">
						<label class="text-danger">Expected date of arrival</label>
						<?php echo Form::date('date_of_arrival',null,['class' =>'form-control','required'=>'']); ?>

					</div>
					<div class="form-group form-group-default required">
						<label class="text-danger">Expected duration in days</label>
						<?php echo Form::number('duration',null,['class' =>'form-control','placeholder'=>'Enter number','required'=>'']); ?>

					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Travel Details</div>
				<div class="panel-body">
					<div class="form-group form-group-default required">
						<label class="text-danger">Purpose of visit</label>
						<?php echo FORM::text('purpose_of_visit',null,['class'=>'form-control','required'=>'','placeholder'=>'Enter purpose of visit']); ?>

					</div>
					<div class="form-group form-group-default required">
						<label class="text-danger">Place of visit</label>
						<?php echo FORM::text('place_of_visit',null,['class'=>'form-control','required'=>'','placeholder'=>'Enter place of visit']); ?>

					</div>
					<div class="form-group form-group-default required">
						<label class="text-danger">Customer name</label>
						<?php echo Form::select('customer',$customers,null,['class'=>'form-control select2','required'=>'']); ?>

					</div>
					<div class="form-group form-group-default required">
						<label class="text-danger">Is billable to customer</label>
						<?php echo Form::select('bill_customer',['' => 'Choose','Yes' => 'Yes','No' => 'No'],null,['class'=>'form-control','required'=>'']); ?>

					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit Information </button>
			<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
		</div>
	</form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/travel/create.blade.php ENDPATH**/ ?>