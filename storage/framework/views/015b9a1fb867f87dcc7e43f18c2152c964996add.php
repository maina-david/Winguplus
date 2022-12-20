<?php $__env->startSection('title','Edit | Customers'); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.ecommerce.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
			<li class="breadcrumb-item"><a href="<?php echo route('finance.contact.index'); ?>">Customers</a></li>
			<li class="breadcrumb-item"><a href="<?php echo e(route('finance.contact.show', $code)); ?>"><?php echo $contact->customer_name; ?></a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user"></i> Update Customers </h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo Form::model($contact, ['route' => ['finance.contact.update',$code], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

         <?php echo csrf_field(); ?>

         <div class="row">
            <div class="col-md-6">
               <div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Details</h4>
						</div>
                  <div class="panel-body">
							<div class="form-group form-group-default required">
								<?php echo Form::label('customer_name', 'Customer Name', array('class'=>'control-label')); ?>

								<?php echo Form::text('customer_name', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter customer names')); ?>

							</div>
                     <?php if($contact->contact_type == "Individual"): ?>
                        <div class="row">
                           <div class="col-sm-6">
                              <div class="form-group form-group-default">
                                 <?php echo Form::label('Salutation', 'Salutation', array('class'=>'control-label')); ?>

                                 <?php echo e(Form::select('salutation',[''=>'Choose Salutation','Mr'=>'Mr','Mrs'=>'Mrs','Ms' => 'Ms','Miss' => 'Miss','Dr' => 'Dr'], null, ['class' => 'form-control multiselect'])); ?>

                              </div>
                           </div>
                           <div class="col-md-6">
										<div class="form-group form-group-default">
												<?php echo Form::label('Designation', 'Designation', array('class'=>'control-label')); ?>

												<?php echo Form::text('designation', null, array('class' => 'form-control', 'placeholder' => 'Enter job designation')); ?>

										</div>
									</div>
                        </div>
							<?php endif; ?>


                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Details</h4>
						</div>
                  <div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<?php echo Form::label('email', 'Email', array('class'=>'control-label')); ?>

										<?php echo Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Contact email', 'readonly' => '')); ?>

									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label for="">
											Phone Number
										</label>
										<?php echo Form::text('primary_phone_number', null, array('class' => 'form-control','placeholder' => 'e.x +254 700 000 000')); ?>

									</div>
								</div>
							</div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               
					<div class="tab-content">
						<div class="tab-pane active" id="address">
							<div class="row">
								<div class="col-md-6">
									<div class="panel-body">
										<p><b>BILLING ADDRESS</b></p>
										<div class="form-group form-group-default">
											<?php echo Form::label('Attention', 'Attention', array('class'=>'control-label')); ?>

											<?php echo Form::text('bill_attention', null, array('class' => 'form-control', 'placeholder' => 'Attention')); ?>

										</div>
										<div class="form-group form-group-default">
											<?php echo Form::label('bill_street', 'Street', array('class'=>'control-label')); ?>

											<?php echo Form::text('bill_street', null, array('class' => 'form-control', 'placeholder' => 'Street')); ?>

										</div>
										<div class="form-group form-group-default">
											<?php echo Form::label('bill_city', 'City', array('class'=>'control-label')); ?>

											<?php echo Form::text('bill_city', null, array('class' => 'form-control', 'placeholder' => 'City')); ?>

										</div>
										<div class="form-group form-group-default">
											<?php echo Form::label('bill_state', 'State', array('class'=>'control-label')); ?>

											<?php echo Form::text('bill_state', null, array('class' => 'form-control', 'placeholder' => 'State')); ?>

										</div>
										<div class="form-group form-group-default">
												<?php echo Form::label('bill_postal_address', 'Billing postal address', array('class'=>'control-label')); ?>

												<?php echo Form::text('bill_postal_address', null, array('class' => 'form-control', 'placeholder' => 'Address')); ?>

										</div>
										<div class="form-group form-group-default">
												<?php echo Form::label('bill_zip_code', 'Zip Code', array('class'=>'control-label')); ?>

												<?php echo Form::text('bill_zip_code', null, array('class' => 'form-control', 'placeholder' => 'Zip Code')); ?>

										</div>
										<div class="form-group form-group-default">
												<?php echo Form::label('bill_country', 'Country', array('class'=>'control-label')); ?>

												<?php echo e(Form::select('bill_country', $country, null, ['class' => 'form-control multiselect'])); ?>

										</div>
										<div class="form-group form-group-default">
												<?php echo Form::label('bill_fax', 'Fax', array('class'=>'control-label')); ?>

												<?php echo Form::text('bill_fax', null, array('class' => 'form-control', 'placeholder' => 'Fax')); ?>

										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="panel-body">
										<p><b>SHIPPING ADDRESS</b></p>
										<div class="form-group form-group-default">
												<?php echo Form::label('Attention', 'Attention', array('class'=>'control-label')); ?>

												<?php echo Form::text('ship_attention', null, array('class' => 'form-control', 'placeholder' => 'Attention')); ?>

										</div>
										<div class="form-group form-group-default">
												<?php echo Form::label('ship_street', 'Street', array('class'=>'control-label')); ?>

												<?php echo Form::text('ship_street', null, array('class' => 'form-control', 'placeholder' => 'Street')); ?>

										</div>
										<div class="form-group form-group-default">
												<?php echo Form::label('ship_city', 'City', array('class'=>'control-label')); ?>

												<?php echo Form::text('ship_city', null, array('class' => 'form-control', 'placeholder' => 'City')); ?>

										</div>
										<div class="form-group form-group-default">
											<?php echo Form::label('postal_address', 'Shipping postal address', array('class'=>'control-label')); ?>

											<?php echo Form::text('ship_postal_address', null, array('class' => 'form-control', 'placeholder' => 'Address')); ?>

										</div>
										<div class="form-group form-group-default">
												<?php echo Form::label('ship_state', 'State', array('class'=>'control-label')); ?>

												<?php echo Form::text('ship_state', null, array('class' => 'form-control', 'placeholder' => 'State')); ?>

										</div>
										<div class="form-group form-group-default">
											<?php echo Form::label('ship_zip_code', 'Zip Code', array('class'=>'control-label')); ?>

											<?php echo Form::text('ship_zip_code', null, array('class' => 'form-control', 'placeholder' => 'Zip Code')); ?>

										</div>
										<div class="form-group form-group-default">
											<?php echo Form::label('ship_country', 'Country', array('class'=>'control-label')); ?>

											<?php echo e(Form::select('ship_country', $country, null, ['class' => 'form-control multiselect'])); ?>

										</div>
										<div class="form-group form-group-default">
												<?php echo Form::label('ship_fax', 'Fax', array('class'=>'control-label')); ?>

												<?php echo Form::text('ship_fax', null, array('class' => 'form-control', 'placeholder' => 'Fax')); ?>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
            </div>
         </div>
         <div class="row">
            <div class="panel-body">
					<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Contact</button>
					<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="20%">
            </div>
         </div>
      <?php echo Form::close(); ?>

	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
      $(".delete_contact_persons").on('click', function() {
         $('.case:checkbox:checked').parents("tr").remove();
         $('.check_all').prop("checked", false);
         check();
      });

      var i=$('.contact_persons tr').length;
      var n = 1;
		$(".addmore_contact_persons").on('click', function() {
			count = $('.contact_persons tr').length;
			var data = "<tr><td><input type='checkbox' class='case'/></td><td><span id='snum" + i + "'>" + n++ + ".</span></td>";
			data +=
				"<td><select id='cn_salutation' class='form-control' name='cn_salutation[]'><option value='' selected='selected'>Choose Salutation</option><option value='Mr'>Mr</option><option value='Mrs'>Mrs</option><option value='Ms'>Ms</option><option value='Miss'>Miss</option><option value='Dr'>Dr</option></select></td><td><input class='form-control' type='text' id='cn_names" +
				i + "' name='cn_names[]'></td><td><input class='form-control' type='text' id='email_address_" + i + "' name='email_address[]'></td><td><input class='form-control' type='text' id='phone_number_" + i +
				"' name='phone_number[]'></td><td><input class='form-control' type='text' id='cn_desgination_" + i + "' name='cn_desgination[]'></td><tr>";
			$('.contact_persons').append(data);
		});

      $("#set-post-thumbnail").click(function() {
			$("input[id='thumbnail']").click();
		});

		$(".multiple-select2").select2();
		$(".multiple-select2").select2().val(<?php echo json_encode($jointcategories); ?>).trigger('change');
	</script>
	<script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/ecommerce/contacts/edit.blade.php ENDPATH**/ ?>