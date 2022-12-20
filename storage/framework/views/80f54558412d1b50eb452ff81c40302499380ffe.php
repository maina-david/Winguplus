<?php $__env->startSection('title','Account Settings'); ?>
<?php $__env->startSection('stylesheets'); ?>
   <link rel="stylesheet" type="text/css" href="<?php echo asset('app-assets/css/plugins/charts/chart-apex.min.css'); ?>">
   <link rel="stylesheet" type="text/css" href="<?php echo asset('app-assets/css/pages/dashboard-ecommerce.min.css'); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Account Details</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Account</a></li>
                     <li class="breadcrumb-item active">Account Details</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <?php echo $__env->make('app.settings._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

      <div class="col-md-8">
         <div class="card">
            <div class="card-body">
               <?php echo Form::model($account, ['route' => ['settings.account.update',$account->id], 'class'=>'row', 'method'=>'post','enctype'=>'multipart/form-data']); ?>

                  <?php echo csrf_field(); ?>

                  <div class="form-group mb-1 col-md-6">
                     <label for="">Business Name</label>
                     <?php echo Form::text('name',null,['class'=>'form-control','required'=>'']); ?>

                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Email</label>
                     <?php echo Form::text('email',null,['class'=>'form-control','required'=>'']); ?>

                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Location</label>
                     <?php echo Form::text('business_location',null,['class'=>'form-control','required'=>'']); ?>

                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Country</label>
                     <?php echo Form::select('country',$country,null,['class'=>'form-control','required'=>'']); ?>

                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Phone Number</label>
                     <?php echo Form::text('phone_number',null,['class'=>'form-control','required'=>'']); ?>

                  </div>
                  <div class="mb-1 col-md-12">
                     <center><button type="submit" class="btn btn-success">Save Information</button></center>
                  </div>
               <?php echo Form::close(); ?>

            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <link rel="stylesheet" type="text/css" href="<?php echo asset('app-assets/vendors/js/charts/apexcharts.min.js'); ?>">
   <link rel="stylesheet" type="text/css" href="<?php echo asset('app-assets/js/scripts/pages/dashboard-ecommerce.min.js'); ?>">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/settings/account.blade.php ENDPATH**/ ?>