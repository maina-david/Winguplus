<?php $__env->startSection('title','Edit | Customers'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
			<li class="breadcrumb-item"><a href="<?php echo route('finance.contact.index'); ?>">Customers</a></li>
			<li class="breadcrumb-item"><a href="<?php echo e(route('finance.contact.show', $contact->customer_code)); ?>"><?php echo $contact->customer_name; ?></a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user-edit"></i> Edit Customers </h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo Form::model($contact, ['route' => ['finance.contact.update',$contact->customer_code], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

         <?php echo csrf_field(); ?>

         <div class="row">
            <div class="col-md-6">
               <div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Details</h4>
						</div>
                  <div class="panel-body">
                     <div class="form-group form-group-default">
                        <?php echo Form::label('Client Type', 'Customer Type', array('class'=>'control-label')); ?>

                        <?php echo e(Form::select('contact_type',[''=>'Choose Client Type','Individual'=>'Individual','Organization'=>'Company/Organization'], null, ['class' => 'form-control multiselect', 'id' => 'contact_type', 'required' => '' ])); ?>

                        <input type="hidden" name="client_type" id="" value="Client">
							</div>
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
                     <div class="form-group form-group-default">
                        <?php echo Form::label('email', 'Primary email', array('class'=>'control-label')); ?>

                        <?php echo Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Contact email')); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <?php echo Form::label('email_cc', 'Email CC', array('class'=>'control-label')); ?>

                        <?php echo Form::email('email_cc', null, array('class' => 'form-control', 'placeholder' => 'Email CC')); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <?php echo Form::label('website', 'Website', array('class'=>'control-label')); ?>

                        <?php echo Form::text('website', null, array('class' => 'form-control', 'placeholder' => 'Website')); ?>

                     </div>
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
										<label for="">
											Primary Phone Number
											<span class="pull-right" data-toggle="tooltip" data-placement="top" title="Make sure the number starts with the country code, this will be required if you want to send an sms to the contact">
												<i class="fas fa-info-circle"></i>
											</span>
										</label>
                              <?php echo Form::text('primary_phone_number', null, array('class' => 'form-control','placeholder' => 'e.x +254 700 000 000')); ?>

                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
										<label for="">
											Other Phone Number
											<span class="pull-right" data-toggle="tooltip" data-placement="top" title="Make sure the number starts with the country code, this will be required if you want to send an sms to the contact">
												<i class="fas fa-info-circle"></i>
											</span>
										</label>
                              <?php echo Form::text('other_phone_number', null, array('class' => 'form-control', 'placeholder' => 'e.x +254 700 000 000')); ?>

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
							<a href="#contact-person" data-toggle="tab" class="nav-link  show">
								<span class="d-sm-none">Contact Persons</span>
								<span class="d-sm-block d-none">Contact Persons</span>
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
							<div class="row ">
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label>Customer Category</label>
										<?php echo e(Form::select('category[]', $category, null, ['class' => 'form-control select2','multiple' => 'multiple'])); ?>

									</div>
									
									
									
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group form-group-default">
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
									<div class="form-group">
										<label>Contact Logo or Image</label>
									</div>
									<a href="#" id="set-post-thumbnail">Click here to update image</a><br>
									<input type="file" name="image" id="thumbnail" class="file" style="display: none" accept="image/*">
									<div class="row">
										<div class="col-md-12">
											<center>
												<img src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/customer/'.$contact->customer_code.'/'.$contact->image); ?>" alt="" style="width:30%">
											</center>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="address">
							<div class="row">
									<div class="col-md-6">
										<div class="panel-body">
											<p><b>BILLING ADDRESS</b></p>
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
						<div class="tab-pane" id="contact-person">
							<div class="row"><br>
								<div class="col-md-12">
									<table class="table table-bordered">
										<tr>
											<th width="1%">#</th>
											<th>Names</th>
											<th>Email Address</th>
											<th>Phone number</th>
											<th>Designation</th>
											<th width="1%">Action</th>
										</tr>
										<?php $__currentLoopData = $persons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$cp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<tr>
												<td><?php echo $count+1; ?></td>
												<td>
													<?php echo $cp->salutation; ?> <?php echo $cp->names; ?>

												</td>
												<td><?php echo $cp->contact_email; ?></td>
												<td><?php echo $cp->phone_number; ?></td>
												<td><?php echo $cp->designation; ?></td>
												<td>
													<a class="btn btn-danger delete" href="<?php echo e(route('finance.contactperson.delete',$cp->id)); ?>"><i class="fas fa-trash-alt"></i> Delete</a>
												</td>
											</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</table>
									<br><br>
									<p><b>Add Contact person</b></p>
									<table class="table table-bordered contact_persons">
										<tr>
											<th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
											<th>#</th>
											<th>Salutation</th>
											<th>Names</th>
											<th>Email Address</th>
											<th>Phone number</th>
											<th>Designation</th>
										</tr>
									</table>
									<button type="button" class='btn btn-danger delete_contact_persons'> - Delete</button>
									<button type="button" class='btn btn-success addmore_contact_persons'> + Add More</button>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="remarks">
							<div class="row"><br>
								<div class="col-md-12">
									<div class="form-group">
										<?php echo Form::label('Remarks', 'Remarks', array('class'=>'control-label')); ?>

										<?php echo Form::textarea('remarks',null,['class'=>'form-control ckeditor', 'id'=>'editor1', 'rows' => 5, 'placeholder'=>'content']); ?>

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

		$(".select2").select2().val(<?php echo json_encode($jointcategories); ?>).trigger('change');
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/contacts/edit.blade.php ENDPATH**/ ?>