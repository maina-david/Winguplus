<?php $__env->startSection('title','Landlords | Create'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 



<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb --> 
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="javascript:void(0)">Landlords</a></li>
      <li class="breadcrumb-item active"><a href="javascript:void(0)">Add</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-users-crown"></i> Landlords</h1>
   <?php echo Form::open(array('route' => 'landlord.store','enctype'=>'multipart/form-data', 'method'=>'post' )); ?>

      <?php echo csrf_field(); ?>
      <div class="row">
         <div class="col-md-6"> 
            <div class="panel panel-default">
               <div class="panel-heading">                       
                  <h4 class="panel-title">Landlords Details</h4>
               </div>
               <div class="panel-body">
                  <div class="form-group form-group-default">
                     <?php echo Form::label('Landlords Type', 'Landlords Type', array('class'=>'control-label text-danger')); ?>

                     <?php echo e(Form::select('contact_type',[''=>'Choose Landlords Type','Individual'=>'Individual','Organization'=>'Company/Organization'], null, ['class' => 'form-control', 'id' => 'tenantType','required'=>''])); ?>

                  </div>
                  <div class="form-group form-group-default">
                     <?php echo Form::label('customer_name', 'Landlord Name', array('class'=>'control-label text-danger')); ?>

                     <?php echo Form::text('customer_name', null, array('class' => 'form-control', 'placeholder' => 'Landlord Names', 'required' => '')); ?>

                  </div>
                  <div class="row" id="individual" style="display: none">
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Identification Type', 'Identification Type', array('class'=>'control-label')); ?>

                           <?php echo Form::select('identification_type', ['' => 'Choose','National ID' => 'National ID','Passport' => 'Passport'] ,null, array('class' => 'form-control')); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Identification Number', 'Identification Number', array('class'=>'control-label')); ?>

                           <?php echo Form::text('identification_number', null, array('class' => 'form-control', 'placeholder' => 'Identification Number',)); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Gender', 'Gender', array('class'=>'control-label')); ?>

                           <?php echo Form::select('gender', ['' => 'Choose','Female' => 'Female','Male' => 'Male'] ,null, array('class' => 'form-control')); ?>

                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Date of Birth', 'Date of Birth', array('class'=>'control-label')); ?>

                           <?php echo Form::date('dob', null, array('class' => 'form-control',)); ?>

                        </div>
                     </div>
                  </div>
                  <div class="form-group form-group-default">
                     <?php echo Form::label('email', 'Primary Contact Email', array('class'=>'control-label')); ?>

                     <?php echo Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Contact Email')); ?>

                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Landlords Details</h4>
               </div>
               <div class="panel-body">                        
                  <div class="form-group form-group-default">
                     <?php echo Form::label('email_cc', 'Email CC', array('class'=>'control-label')); ?>

                     <?php echo Form::email('email_cc', null, array('class' => 'form-control', 'placeholder' => 'Email CC')); ?>

                  </div>
                  
                  <div class="form-group form-group-default">
                     <?php echo Form::label('Tax Pin', 'Tax Pin', array('class'=>'control-label')); ?>

                     <?php echo Form::text('tax_pin', null, array('class' => 'form-control', 'placeholder' => 'Entet Pin',)); ?>

                  </div>                        
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('primary_phone_number', 'Primary Phone Number', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::text('primary_phone_number', null, array('class' => 'form-control','placeholder' => 'e.x 0700 000 000','required' => '')); ?>

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
                     <span class="d-sm-none">Billing Information</span>
                     <span class="d-sm-block d-none">Billing Information</span>
                  </a>
               </li>
               <li class="nav-items">
                  <a href="#contact-person" data-toggle="tab" class="nav-link  show">
                     <span class="d-sm-none">Contact Persons</span>
                     <span class="d-sm-block d-none">Contact Persons</span>
                  </a>
               </li>
               <li class="nav-items">
                  <a href="#Documents" data-toggle="tab" class="nav-link">
                     <span class="d-sm-none">Documents</span>
                     <span class="d-sm-block d-none">Documents</span>
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
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group form-group-default ">
                                 <?php echo Form::label('website', 'Website', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('website', null, array('class' => 'form-control', 'placeholder' => 'Website')); ?>

                              </div>
                           </div>                                       
                           <div class="col-md-12">
                              <div class="form-group form-group-default">
                                 <?php echo Form::label('Facebbok', 'Facebook', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('facebook', null, array('class' => 'form-control', 'placeholder' => 'Facebook')); ?>

                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group form-group-default">
                                 <?php echo Form::label('Twitter', 'Twitter', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('twitter', null, array('class' => 'form-control', 'placeholder' => 'Twitter')); ?>

                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group form-group-default">
                                 <?php echo Form::label('LinkedIn', 'LinkedIn', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('linkedin', null, array('class' => 'form-control', 'placeholder' => 'LinkedIn')); ?>

                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label>Landlords Logo or Image</label>
                        </div>
                        <a href="#" id="set-post-thumbnail">Click here to choose an image</a><br>
                        <input type="file" name="image" id="thumbnail" class="file" style="display: none">
                     </div>
                  </div>
               </div>
               <div class="tab-pane" id="address">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="panel-body">
                           <b>BILLING ADDRESS</b>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="panel-body">                              
                           <div class="form-group form-group-default ">
                              <?php echo Form::label('Attention', 'Attention', array('class'=>'control-label')); ?>

                              <?php echo Form::text('bill_attention', null, array('class' => 'form-control', 'placeholder' => 'Attention')); ?>

                           </div>
                           <div class="form-group form-group-default ">
                              <?php echo Form::label('bill_street', 'Street', array('class'=>'control-label')); ?>

                              <?php echo Form::text('bill_street', null, array('class' => 'form-control', 'placeholder' => 'Street')); ?>

                           </div>
                           <div class="form-group form-group-default ">
                              <?php echo Form::label('bill_city', 'City', array('class'=>'control-label')); ?>

                              <?php echo Form::text('bill_city', null, array('class' => 'form-control', 'placeholder' => 'City')); ?>

                           </div>
                           <div class="form-group form-group-default ">
                              <?php echo Form::label('bill_state', 'State', array('class'=>'control-label')); ?>

                              <?php echo Form::text('bill_state', null, array('class' => 'form-control', 'placeholder' => 'State')); ?>

                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="panel-body">
                           <div class="form-group form-group-default ">
                              <?php echo Form::label('bill_address', 'Billing Address', array('class'=>'control-label')); ?>

                              <?php echo Form::text('bill_address', null, array('class' => 'form-control', 'placeholder' => 'Address')); ?>

                           </div>
                           <div class="form-group form-group-default ">
                              <?php echo Form::label('bill_zip_code', 'Zip Code', array('class'=>'control-label')); ?>

                              <?php echo Form::text('bill_zip_code', null, array('class' => 'form-control', 'placeholder' => 'Zip Code')); ?>

                           </div>
                           <div class="form-group form-group-default">
                              <?php echo Form::label('bill_country', 'Country', array('class'=>'control-label')); ?>

                              <?php echo e(Form::select('bill_country', $country, null, ['class' => 'form-control multiselect'])); ?>

                           </div>
                           <div class="form-group form-group-default ">
                              <?php echo Form::label('bill_fax', 'Fax', array('class'=>'control-label')); ?>

                              <?php echo Form::text('bill_fax', null, array('class' => 'form-control', 'placeholder' => 'Fax')); ?>

                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane" id="contact-person">
                  <div class="row"><br>
                     <div class="col-md-12">
                        <table class="table table-bordered contact_persons">
                           <tr>
                              <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
                              <th>#</th>
                              <th>Salutation</th>
                              <th>Names</th>
                              <th>Email Address</th>
                              <th>Phone number</th>
                              <th>Relationship</th>
                           </tr>
                        </table>
                        <button type="button" class='btn btn-danger delete_contact_persons'> - Delete</button>
                        <button type="button" class='btn btn-success addmore_contact_persons'> + Add More</button>
                     </div>
                  </div>
               </div>
               <div class="tab-pane" id="Documents">
                  <div class="row"><br>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Document title</label>
                           <input type="file" name="documents[]" id="files" class="form-control" multiple>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane" id="remarks">
                  <div class="row"><br>
                     <div class="col-md-12">
                        <div class="form-group">
                           <?php echo Form::label('Remarks', 'Remarks', array('class'=>'control-label')); ?>

                           <?php echo Form::textarea('remarks',null,['class'=>'form-control my-editor', 'rows' => 5, 'placeholder'=>'content']); ?>

                        </div>
                        <br>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row mb-5">
         <div class="col-md-12">
            <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Add Landlords</button>
            <img src="<?php echo url('/'); ?>/public/app/img/btn-loader.gif" class="submit-load none" alt="" width="15%">
         </div>               
      </div>
	<?php echo Form::close(); ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
      $(document).ready(function() {
         $('#tenantType').on('change', function() {
            if (this.value == 'Individual') {
               $('#individual').show();
            } else {
               $('#individual').hide();
            }
         });
      });
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
            i + "' name='cn_names[]'></td><td><input class='form-control' type='text' id='email_address_" + i + "' name='email_address[]'></td><td><input class='form-control' type='text' id='phone_number" + i + "' name='phone_number[]'></td><td><input class='form-control' type='text' id='cn_desgination_" + i + "' name='cn_desgination[]'></td><tr>";
         $('.contact_persons').append(data);
      });

      $("#set-post-thumbnail").click(function() {
			$("input[id='thumbnail']").click();
		});
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/propertywingu/landlord/create.blade.php ENDPATH**/ ?>