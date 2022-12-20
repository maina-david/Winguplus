<?php $__env->startSection('title','New Customer'); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.salesflow.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Sales Flow</a></li>
         <li class="breadcrumb-item active"><a href="#">Create</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user-plus"></i>  Customers</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end breadcrumb -->
      <?php echo Form::open(array('route' => 'salesflow.customer.store','class'=>'row','enctype'=>'multipart/form-data','method'=>'post' )); ?>

         <?php echo csrf_field(); ?>

         <div class="col-md-8">
            <div class="card card-default">
               <div class="card-body">
                  <div class="row">
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('customer_name', 'Customer names', array('class'=>'control-label')); ?>

                        <?php echo Form::text('customer_name', null, array('class' => 'form-control', 'placeholder' => 'Enter customer name')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('caccount', 'Account Number', array('class'=>'control-label')); ?>

                        <?php echo Form::text('account', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('manufacturer_number', 'Manufacturer number', array('class'=>'control-label')); ?>

                        <?php echo Form::text('manufacturer_number', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('vat_number', 'VAT number', array('class'=>'control-label')); ?>

                        <?php echo Form::text('vat_number', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('delivery_time', 'Delivery time', array('class'=>'control-label')); ?>

                        <input type="time" class="form-control" name="delivery_time">
                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('address', 'Address', array('class'=>'control-label')); ?>

                        <?php echo Form::text('address', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('city', 'City', array('class'=>'control-label')); ?>

                        <?php echo Form::text('city', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('province', 'Province', array('class'=>'control-label')); ?>

                        <?php echo Form::text('province', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('postal_code', 'Postal code', array('class'=>'control-label')); ?>

                        <?php echo Form::text('postal_code', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('country', 'Country', array('class'=>'control-label')); ?>

                        <?php echo Form::text('country', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                    
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('contact_person', 'Contact person	', array('class'=>'control-label')); ?>

                        <?php echo Form::text('contact_person', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('telephone', 'Telephone', array('class'=>'control-label')); ?>

                        <?php echo Form::text('telephone', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('customer_group', 'Customer group', array('class'=>'control-label')); ?>

                        <?php echo Form::text('customer_group', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('customer_secondary_group', 'Customer secondary group', array('class'=>'control-label')); ?>

                        <?php echo Form::text('customer_secondary_group', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('price_group', 'Price group', array('class'=>'control-label')); ?>

                        <?php echo Form::text('price_group', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('route', 'Route', array('class'=>'control-label')); ?>

                        <?php echo Form::text('route', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('branch', 'Branch', array('class'=>'control-label')); ?>

                        <?php echo Form::text('branch', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('email', 'Email', array('class'=>'control-label')); ?>

                        <?php echo Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('phone_number', 'Phone number', array('class'=>'control-label')); ?>

                        <?php echo Form::text('phone_number', null, array('class' => 'form-control', 'placeholder' => 'Enter value')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('zone', 'Zone', array('class'=>'control-label')); ?>

                        <?php echo Form::select('zone',[],null, array('class' => 'form-control')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('Region', 'Region', array('class'=>'control-label')); ?>

                        <?php echo Form::select('region',[], null, array('class' => 'form-control')); ?>

                     </div>
                     <div class="form-group mb-1 col-md-6">
                        <?php echo Form::label('Territory', 'Territory', array('class'=>'control-label')); ?>

                        <?php echo Form::select('territory',[],null, array('class' => 'form-control')); ?>

                     </div>
                     <div class="mb-1 col-md-12">
                        <center><button type="submit" class="btn btn-success">Save Information</button></center>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      <?php echo Form::close(); ?>

   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/customers/hold.blade.php ENDPATH**/ ?>