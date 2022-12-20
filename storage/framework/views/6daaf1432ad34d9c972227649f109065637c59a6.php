<?php $__env->startSection('title','Route Scheduling'); ?>



<?php $__env->startSection('content'); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Route Scheduling</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Route</a></li>
                     <li class="breadcrumb-item active">Scheduling</li>
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
               <?php echo Form::open(array('route' => 'routes.store','class'=>'row','enctype'=>'multipart/form-data','method'=>'post' )); ?>

                  <?php echo csrf_field(); ?>

                  <div class="form-group col-md-12 mb-1">
                     <label for="">Route name</label>
                     <?php echo Form::text('name',null,['class'=>'form-control','placeholder'=>'Enter route name','required'=>'']); ?>

                  </div>
                  <div class="row mb-1">
                     <div class="form-group col-md-4">
                        <label for="">Start Date</label>
                        <?php echo Form::date('start_date',null,['class'=>'form-control','required'=>'']); ?>

                     </div>
                     <div class="form-group col-md-4">
                        <label for="">End Date</label>
                        <?php echo Form::date('end_date',null,['class'=>'form-control','required'=>'']); ?>

                     </div>
                     <div class="form-group col-md-4">
                        <label for="">Status</label>
                        <?php echo Form::select('status',[''=>'Choose status','Active'=>'Active','Close'=>'Close'],null,['class'=>'form-control','required'=>'']); ?>

                     </div>
                  </div>
                  <div class="form-group col-md-12 mb-1">
                     <label for="">Add Customer to Route</label>
                     <?php echo Form::select('customers[]',$customers,null,['class'=>'form-control select2','multiple'=>'']); ?>

                  </div>
                  <div class="form-group col-md-12 mb-1">
                     <label for="">Add sales people to Route</label>
                     <?php echo Form::select('sales_persons[]',$salesPeople,null,['class'=>'form-control select2','multiple'=>'']); ?>

                  </div>
                  <div class="form-group mb-1">
                     <button class="btn btn-success" type="submit">Save Information</button>
                  </div>
               <?php echo Form::close(); ?>

            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/routes/create.blade.php ENDPATH**/ ?>