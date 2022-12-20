<?php $__env->startSection('title','New Customer'); ?>

<?php $__env->startSection('stylesheet'); ?>
<script type="text/javascript">
	.nav > li {
		position: relative;
		display: block;
		/* width: 100%; */
	}
</script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.subscriptions.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="javascript:;">Subscription</a></li>
		<li class="breadcrumb-item"><a href="<?php echo route('finance.contact.index'); ?>">Customer</a></li>
		<li class="breadcrumb-item active">Add</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fas fa-user-plus"></i> Add Customers </h1>
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo Form::open(array('route' => 'subscription.customer.store','enctype'=>'multipart/form-data','method'=>'post' )); ?>

	<?php echo csrf_field(); ?>

	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">Details</h4>
				</div>
				<div class="panel-body">
					<div class="form-group form-group-default required">
						<?php echo Form::label('Customer Type', 'Customer Type', array('class'=>'control-label')); ?>

						<select name="contact_type" required="" class="form-control multiselect" id="contact_type">
							<option value="">Choose Customer Type</option>
							<option value="Individual">Individual</option>
							<option value="Organization">Company/Organization</option>
						</select>
					</div>
					<div class="row" style="display:none;" id="individual">
						<div class="col-sm-4">
							<div class="form-group form-group-default">
								<?php echo Form::label('Salutation', 'Salutation', array('class'=>'control-label')); ?>

								<?php echo e(Form::select('salutation',[''=>'Choose Salutation','Mr'=>'Mr','Mrs'=>'Mrs','Ms' => 'Ms','Miss' => 'Miss','Dr' => 'Dr'], null, ['class' => 'form-control multiselect'])); ?>

							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group form-group-default">
								<?php echo Form::label('Designation', 'Designation', array('class'=>'control-label')); ?>

								<?php echo Form::text('designation', null, array('class' => 'form-control', 'placeholder' => 'Enter job designation')); ?>

							</div>
						</div>
					</div>
					<div class="form-group form-group-default required">
						<?php echo Form::label('customer_name', 'Customer names', array('class'=>'control-label')); ?>

						<?php echo Form::text('customer_name', null, array('class' => 'form-control', 'placeholder' => 'Enter customer name')); ?>

					</div>
					<div class="form-group form-group-default">
						<?php echo Form::label('Referral', 'Referral', array('class'=>'control-label')); ?>

						<?php echo Form::text('referral', null, array('class' => 'form-control', 'placeholder' => 'Enter referral')); ?>

					</div>
					<div class="form-group form-group-default">
						<?php echo Form::label('department', 'Department', array('class'=>'control-label')); ?>

						<?php echo Form::text('department', null, array('class' => 'form-control', 'placeholder' => 'Enter department')); ?>

					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">Details</h4>
				</div>
				<div class="panel-body">
					<div class="form-group form-group-default required ">
						<?php echo Form::label('email', 'Primary email', array('class'=>'control-label')); ?>

						<?php echo Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Enter customer email', 'required' =>'' )); ?>

					</div>
					<div class="form-group form-group-default ">
						<?php echo Form::label('email_cc', 'Email CC', array('class'=>'control-label')); ?>

						<?php echo Form::email('email_cc', null, array('class' => 'form-control', 'placeholder' => 'Email CC')); ?>

					</div>
					<div class="form-group form-group-default ">
						<?php echo Form::label('website', 'Website', array('class'=>'control-label')); ?>

						<?php echo Form::text('website', null, array('class' => 'form-control', 'placeholder' => 'Website')); ?>

					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group form-group-default required">
								<?php echo Form::label('primary_phone_number', 'Primary Phone Number', array('class'=>'control-label')); ?>

								<?php echo Form::text('primary_phone_number', null, array('class' => 'form-control','placeholder' => 'e.x 0700 000 000', 'required' => '')); ?>

							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group form-group-default">
								<?php echo Form::label('other_phone_number', 'Other Phone Number', array('class'=>'control-label')); ?>

								<?php echo Form::text('other_phone_number', null, array('class' => 'form-control', 'placeholder' => 'e.x 0700 000 000')); ?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<ul class="nav nav-pills">
				<li class="nav-items">
					<a href="#other_details" data-toggle="tab" class="nav-link active">
						<span class="d-sm-none">Other Details</span>
						<span class="d-sm-block d-none">Other Details</span>
					</a>
				</li>
				<li class="nav-items">
					<a href="#address" data-toggle="tab" class="nav-link">
						<span class="d-sm-none">Address</span>
						<span class="d-sm-block d-none">Address</span>
					</a>
				</li>
				<li class="nav-items">
					<a href="#remarks" data-toggle="tab" class="nav-link">
						<span class="d-sm-none">Remarks</span>
						<span class="d-sm-block d-none">Remarks</span>
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="other_details">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-group-default">
								<label>Customer Category</label>
								<?php echo e(Form::select('groups[]', $groups, null, ['class' => 'form-control multiselect','multiple' => 'multiple'])); ?>

							</div>
							
							
							
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default required">
										<?php echo Form::label('Facebook', 'Facebook', array('class'=>'control-label')); ?>

										<?php echo Form::text('facebook', null, array('class' => 'form-control', 'placeholder' => 'Enter facebook link',)); ?>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('Twitter', 'Twitter', array('class'=>'control-label')); ?>

										<?php echo Form::text('twitter', null, array('class' => 'form-control', 'placeholder' => 'Enter twitter link')); ?>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('linkedin', 'Linkedin', array('class'=>'control-label')); ?>

										<?php echo Form::text('linkedin', null, array('class' => 'form-control', 'placeholder' => 'Enter linkedin link')); ?>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('skypeID', 'Skype ID', array('class'=>'control-label')); ?>

										<?php echo Form::text('skypeID', null, array('class' => 'form-control', 'placeholder' => 'Enter Skype ID')); ?>

									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group form-group-default">
								<label>Contact Logo or Image</label>
							</div>
							<a href="#" id="set-post-thumbnail">Click here to choose an image</a>
							<input type="file" name="image" accept="image/*" id="thumbnail" class="file" style="display: none">
						</div>
					</div>
				</div>
				<div class="tab-pane" id="address">
					<div class="row">
						<div class="col-md-6">
							<div class="panel-body">
								<p><b>BILLING ADDRESS</b></p>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('Attention', 'Attention', array('class'=>'control-label')); ?>

									<?php echo Form::text('bill_attention', null, array('class' => 'form-control', 'placeholder' => 'Attention')); ?>

								</div>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('bill_street', 'Street', array('class'=>'control-label')); ?>

									<?php echo Form::text('bill_street', null, array('class' => 'form-control', 'placeholder' => 'Street')); ?>

								</div>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('bill_city', 'City', array('class'=>'control-label')); ?>

									<?php echo Form::text('bill_city', null, array('class' => 'form-control', 'placeholder' => 'City')); ?>

								</div>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('bill_state', 'State', array('class'=>'control-label')); ?>

									<?php echo Form::text('bill_state', null, array('class' => 'form-control', 'placeholder' => 'State')); ?>

								</div>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('bill_postal_address', 'Billing postal address', array('class'=>'control-label')); ?>

									<?php echo Form::text('bill_postal_address', null, array('class' => 'form-control', 'placeholder' => 'Address')); ?>

								</div>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('bill_zip_code', 'Zip Code', array('class'=>'control-label')); ?>

									<?php echo Form::text('bill_zip_code', null, array('class' => 'form-control', 'placeholder' => 'Zip Code')); ?>

								</div>
								<div class="form-group form-group-default">
									<?php echo Form::label('bill_country', 'Country', array('class'=>'control-label')); ?>

									<?php echo e(Form::select('bill_country', $country, null, ['class' => 'form-control multiselect'])); ?>

								</div>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('bill_fax', 'Fax', array('class'=>'control-label')); ?>

									<?php echo Form::text('bill_fax', null, array('class' => 'form-control', 'placeholder' => 'Fax')); ?>

								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="panel-body">
								<p><b>SHIPPING ADDRESS</b></p>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('Attention', 'Attention', array('class'=>'control-label')); ?>

									<?php echo Form::text('ship_attention', null, array('class' => 'form-control', 'placeholder' => 'Attention')); ?>

								</div>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('ship_street', 'Street', array('class'=>'control-label')); ?>

									<?php echo Form::text('ship_street', null, array('class' => 'form-control', 'placeholder' => 'Street')); ?>

								</div>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('ship_city', 'City', array('class'=>'control-label')); ?>

									<?php echo Form::text('ship_city', null, array('class' => 'form-control', 'placeholder' => 'City')); ?>

								</div>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('ship_state', 'State', array('class'=>'control-label')); ?>

									<?php echo Form::text('ship_state', null, array('class' => 'form-control', 'placeholder' => 'State')); ?>

								</div>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('postal_address', 'Shipping postal address', array('class'=>'control-label')); ?>

									<?php echo Form::text('ship_postal_address', null, array('class' => 'form-control', 'placeholder' => 'Address')); ?>

								</div>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('ship_zip_code', 'Zip Code', array('class'=>'control-label')); ?>

									<?php echo Form::text('ship_zip_code', null, array('class' => 'form-control', 'placeholder' => 'Zip Code')); ?>

								</div>
								<div class="form-group form-group-default">
									<?php echo Form::label('bill_country', 'Country', array('class'=>'control-label')); ?>

									<?php echo e(Form::select('bill_country', $country, null, ['class' => 'form-control multiselect'])); ?>

								</div>
								<div class="form-group form-group-default required ">
									<?php echo Form::label('ship_fax', 'Fax', array('class'=>'control-label')); ?>

									<?php echo Form::text('ship_fax', null, array('class' => 'form-control', 'placeholder' => 'Fax')); ?>

								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="remarks">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<?php echo Form::label('Remarks', 'Remarks', array('class'=>'control-label')); ?>

								<?php echo Form::textarea('remarks',null,['class'=>'form-control ckeditor', 'id'=>'editor1', 'size' =>'5x10', 'placeholder'=>'content']); ?>

							</div>
							<br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel-body">
			<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Create Contact</button>
			<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
		</div>
	</div>
	<?php echo Form::close(); ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
<script type="text/javascript">
	CKEDITOR.replaceClass="ckeditor";
</script>
<script> 
	$(document).ready(function() {
		$('#contact_type').on('change', function() {
			if (this.value == 'Individual') {
				$('#individual').show();
			} else {
				$('#individual').hide();
			}

			if (this.value == 'Organization') {
				$('#company').show();
			} else {
				$('#company').hide();
			}
		});
	});

	$("#set-post-thumbnail").click(function() {
		$("input[id='thumbnail']").click();
	});
	
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/customer/create.blade.php ENDPATH**/ ?>