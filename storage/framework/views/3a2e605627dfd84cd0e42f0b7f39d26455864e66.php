<?php $__env->startSection('title','Create Account'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">CRM</a></li>
         <li class="breadcrumb-item"><a href="#">Digital Marketing</a></li>
         <li class="breadcrumb-item active">Create Account</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-share-alt"></i> Create Account</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-6">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Create Account</h4>
            </div>
            <div class="panel-body">
               <form action="<?php echo route('crm.account.store'); ?>" method="post">
                  <?php echo csrf_field(); ?> 
                  <div class="form-group">
                     <label for="">Customer</label>
                     <select name="customer" class="form-control multiselect" name="customer" required> 
                        <option value="">Choose Client</option>  
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo $client->id; ?>"><?php echo $client->customer_name; ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="">Budget Estimate</label>
                     <?php echo Form::text('budget', null,['class' => 'form-control']); ?>

                  </div>
                  <div class="form-group">
                     <label for="">Description</label>
                     <?php echo Form::textarea('description', null,['class' => 'form-control ckeditor']); ?>

                  </div>
                  <div class="form-group">
                     <label for="">Account Date</label>
                     <?php echo Form::text('account_date', null,['class' => 'form-control datepicker','required' => '']); ?>

                  </div>
                  <div class="form-group">
                     <label for="">Status</label>
                     <?php echo Form::select('status',['' => 'Choose status', '15' => 'Active', '4' => 'Cancelled'],null,['class' => 'form-control','required' => '']); ?>

                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Save Account</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/social/account/create.blade.php ENDPATH**/ ?>