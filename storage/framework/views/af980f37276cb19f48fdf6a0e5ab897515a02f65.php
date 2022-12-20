<?php $__env->startSection('title','Edit User'); ?>




<?php $__env->startSection('content'); ?>
   <!-- begin breadcrumb -->

   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Users </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Users</a></li>
                     <li class="breadcrumb-item active">Edit</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-8">
         <div class="card">
            <div class="card-body">
               <?php echo Form::model($edit, ['route' => ['user.update',$edit->id], 'method'=>'post','class' => 'row','enctype'=>'multipart/form-data']); ?>

                  <?php echo csrf_field(); ?>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Name <span class="text-danger">*</span></label>
                     <?php echo Form::text('name',null,['class'=>'form-control']); ?>

                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Email <span class="text-danger">*</span></label>
                     <?php echo Form::email('email',null,['class'=>'form-control']); ?>

                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Phone Number <span class="text-danger">*</span></label>
                     <?php echo Form::number('phone_number',null,['class'=>'form-control']); ?>

                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">User Type <span class="text-danger">*</span></label>
                     <?php echo Form::select('account_type',[''=>'Choose','Sales' => 'Sales', 'Admin'=> 'Admin'],null,['class'=>'form-control']); ?>

                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Status <span class="text-danger">*</span></label>
                     <?php echo Form::select('status',['Active'=>'Active','Suspended' => 'Suspended'],null,['class'=>'form-control']); ?>

                  </div>
                  <div class="form-group mb-1 col-md-12">
                     <center><button class="btn btn-success" type="submit">Save information</button></center>
                  </div>
               <?php echo Form::close(); ?>

            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/users/edit.blade.php ENDPATH**/ ?>