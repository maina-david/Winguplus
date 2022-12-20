<?php $__env->startSection('title','Website Settings'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.ecommerce.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div id="content" class="content"> 
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('ecommerce.dashboard'); ?>">E-commerce</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item">Website</li>
         <li class="breadcrumb-item active">Contacts</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-phone-rotary"></i> Website Settings - Contacts</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.ecommerce.settings._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="card">
               <?php echo $__env->make('app.ecommerce.settings.website._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <div class="card-block">
                  <div class="p-0 m-0">
                     <form class="row" action="<?php echo route('ecommerce.settings.website.contacts.save'); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="col-md-6">
                           <div class="form-group ">  
                              <label for="">Notification Email</label>
                              <input type="text" class="form-control" name="notification_email" value="<?php echo $site->notification_email; ?>" required>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group ">  
                              <label for="">Phone Number</label>
                              <input type="text" class="form-control" name="phone_number" value="<?php echo $site->phone_number; ?>" required>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group ">  
                              <label for="">Location Address</label>
                              <input type="text" class="form-control" name="location_address" value="<?php echo $site->location_address; ?>">
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group ">  
                              <label for="">Map</label>
                              <textarea type="text" class="form-control" name="map"  cols="5" rows="5" value=""><?php echo $site->map; ?></textarea>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <button type="submit" class="float-left btn btn-pink btn-sm submit"><i class="fa fa-save"></i> Save Information</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="float-left submit-load none" alt="" width="25%">
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/ecommerce/settings/website/contacts.blade.php ENDPATH**/ ?>