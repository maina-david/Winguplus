<?php $__env->startSection('title','Add Mileage Expense'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
			<li class="breadcrumb-item"><a href="<?php echo route('finance.expense.index'); ?>">Expences</a></li>
			<li class="breadcrumb-item"><a href="<?php echo route('finance.mileage.index'); ?>">Mileage</a></li>
			<li class="breadcrumb-item active">Add Mileage Expences</li>
		</ol>
		<h1 class="page-header">Add Mileage Expences</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php echo Form::open(array('route' => 'finance.mileage.store', 'enctype'=>'multipart/form-data', 'data-parsley-validate' => '','method' => 'post')); ?>

			<div class="row">
				<div class="col-lg-6 col-md-6 ">
					<div class="panel panel-default">
					 	<div class="panel-heading">						 
						 	<h4 class="panel-title">Mileage Expence Details</h4>
					 	</div>
						<div class="panel-body">
							<div class="form-group form-group-default">
								<?php echo Form::label('Date', 'Date', array('class'=>'control-label')); ?>

								<?php echo Form::text('date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Pick a date', 'required' =>'','autocomplete' => 'off')); ?>

							</div>
							<div class="form-group form-group-default">
								<?php echo Form::label('Expense Title', 'Expense Title', array('class'=>'control-label')); ?>

								<?php echo Form::text('expense_name', null, array('class' => 'form-control', 'placeholder' => 'Expense Title', 'required' =>'' )); ?>

							</div>
							<div class="form-group form-group-default">
								<?php echo Form::label('Expense Category', 'Expense Category', array('class'=>'control-label')); ?>

								<?php echo e(Form::select('expense_category', ['13' => 'Mileage Expense'], null, ['class' => 'form-control','placeholder' => 'Choose Category','required' =>''  ])); ?>

							</div>
							<div class="form-group form-group-default">
								<?php echo Form::label('Calculation Type', 'Calculation Type', array('class'=>'control-label')); ?>

								<?php echo e(Form::select('calculate_type',['' => 'Choose Calculation','Kilometers' => 'Kilometers','Odometer' => 'Odometer' ], null, ['class' => 'form-control','placeholder' => 'Calculation Type','required' =>''  ])); ?>

							</div>
							<div class="row clearfix">
								<div class="col-sm-6">
									<div class="form-group form-group-default required" aria-required="true">
										<?php echo Form::label('Odometer Start', 'Odometer Start', array('class'=>'control-label')); ?>

										<?php echo Form::number('odometer_start', null, array('class' => 'form-control', 'placeholder' => 'Odometer Start')); ?>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default required" aria-required="true">
										<?php echo Form::label('Odometer Stop', 'Odometer Stop', array('class'=>'control-label')); ?>

										<?php echo Form::number('odometer_stop', null, array('class' => 'form-control', 'placeholder' => 'Odometer Stop')); ?>

									</div>
								</div>
							</div>
							<div class="form-group form-group-default">
								<?php echo Form::label('Distance', 'Distance', array('class'=>'control-label')); ?>

								<?php echo Form::number('distance', null, array('class' => 'form-control', 'placeholder' => 'Distance', 'required' =>'' )); ?>

							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group required" aria-required="true">
										<?php echo Form::label('Amount', 'Amount', array('class'=>'control-label')); ?>

										<?php echo Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' =>'' )); ?>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<?php echo Form::label('Choose Tax Rate', 'Chosse Tax Rate', array('class'=>'control-label')); ?>

										<?php echo e(Form::select('tax_rate',$tax, null, ['class' => 'form-control default-select2 full-width', 'required' =>''])); ?>

									</div>
								</div>
							</div>
							<div class="form-group form-group-default">
								<?php echo Form::label('Reference', 'Reference', array('class'=>'control-label')); ?>

								<?php echo Form::text('reference', null, array('class' => 'form-control', 'placeholder' => 'Reference', 'required' =>'' )); ?>

							</div>
							<div class="form-group form-group-default">
								<?php echo Form::label('Choose expense status', 'Choose expense status', array('class'=>'control-label')); ?>

								<?php echo e(Form::select('status', [''=>'Choose expense status','Paid'=>'Paid','Pending'=>'Pending','Dept'=>'Dept'], null, ['class' => 'form-control full-width', 'data-init-plugin' => 'select2','placeholder' => 'Choose Claimant','required' =>''  ])); ?>

							</div>
							<div class="form-group">
								<?php echo Form::label('Method of payment', 'Method of payment', array('class'=>'control-label')); ?>

								<?php echo e(Form::select('payment_method', $payment, null, ['class' => 'form-control default-select2','placeholder' => 'Method of payment','required' =>''  ])); ?>

							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 ">
					<div class="panel panel-default">
					 	<div class="panel-heading">
						 	<h4 class="panel-title">Mileage Expence Details</h4>
					 	</div>
						<div class="panel-body">
							<div class="form-group">
								<?php echo Form::label('Choose Claimant', 'Choose Claimant', array('class'=>'control-label')); ?>

								<?php echo e(Form::select('claimant', $employee, null, ['class' => 'form-control default-select2 full-width', 'data-init-plugin' => 'select2','placeholder' => 'Choose Claimant','required' =>''  ])); ?>

							</div>
							<div class="form-group form-group-default">
								<?php echo Form::label('Upload Files', 'Upload Files', array('class'=>'control-label')); ?>

								<?php echo Form::file('files[]', null, array('class' => 'form-control', 'placeholder' => 'Upload Files', 'required' =>'' )); ?>

							</div>
							<div class="form-group">
								<?php echo Form::label('Description', 'Description', array('class'=>'control-label')); ?>

								<?php echo Form::textarea('description',null,['class'=>'form-control ck4standard', 'rows' => 9, 'placeholder'=>'content']); ?>

							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<center><button class="btn btn-info submit" type="submit">Add Mileage Expense</button>
						<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%"></center>
				</div>
			</div>
		<?php echo e(Form::close()); ?>

	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/expense/mileage/create.blade.php ENDPATH**/ ?>