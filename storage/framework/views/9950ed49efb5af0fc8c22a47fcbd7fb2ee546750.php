<?php $__env->startSection('title','Create Warehouse'); ?>


<?php $__env->startSection('content'); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Add Warehouse </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Warehouse</a></li>
                     <li class="breadcrumb-item active">Create</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="row">
      <div class="col-md-6">
         <div class="card">
            <div class="card-body">
               <form action="<?php echo route('warehousing.store'); ?>" method="POST">
                  <?php echo csrf_field(); ?>
                  <div class="form-group mb-1">
                     <label for="">Name</label>
                     <?php echo Form::text('name',null,['class'=>'form-control','required'=>'']); ?>

                  </div>
                  <div class="form-group mb-1">
                     <label for="">Email</label>
                     <?php echo Form::email('email',null,['class'=>'form-control']); ?>

                  </div>
                  <div class="form-group mb-1">
                     <label for="">Phone number</label>
                     <?php echo Form::text('phone_number',null,['class'=>'form-control']); ?>

                  </div>
                  <div class="form-group mb-1">
                     <label for="">Country</label>
                     <?php echo Form::select('country',$country,null,['class'=>'form-control']); ?>

                  </div>
                  <div class="form-group mb-1">
                     <label for="">City</label>
                     <?php echo Form::text('city',null,['class'=>'form-control']); ?>

                  </div>
                  <div class="form-group mb-1">
                     <label for="">Location</label>
                     <?php echo Form::text('location',null,['class'=>'form-control']); ?>

                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group mb-1">
                           <label for="">Longitude</label>
                           <?php echo Form::text('longitude',null,['class'=>'form-control']); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group mb-1">
                           <label for="">Latitude</label>
                           <?php echo Form::text('latitude',null,['class'=>'form-control']); ?>

                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-check form-switch">
                           <label class="form-check-label" for="customSwitch1">Is main warehouse</label>
                           <input type="checkbox" class="form-check-input" name="is_main" id="customSwitch1" value="Yes" />
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-check form-switch">
                           <label class="form-check-label mb-50" for="customSwitch4">Is Active</label>
                           <input type="checkbox" class="form-check-input" name="status" id="customSwitch4" value="Active" />
                        </div>
                     </div>
                  </div>
                  <center><button class="btn btn-success mt-2" type="submit"><i data-feather='save'></i> Save Information</button></center>
               </form>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/warehousing/create.blade.php ENDPATH**/ ?>