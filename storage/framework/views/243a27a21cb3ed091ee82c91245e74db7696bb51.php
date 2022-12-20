<?php $__env->startSection('title','Website Settings | E-commerce'); ?>

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
         <li class="breadcrumb-item active">Details</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-globe"></i> Website Settings - Details</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.ecommerce.settings._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="card">
               <?php echo $__env->make('app.ecommerce.settings.website._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <div class="card-block">
                  <div class="p-0 m-0">
                     <form class="row" action="<?php echo route('ecommerce.settings.website.details.save'); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="col-md-12">
                           <div class="row">
                              <div class="col-md-3">
                                 <img src="<?php echo asset('businesses/'.$site->business_code .'/documents/images/'.$site->logo); ?>" width="142" alt="">
                              </div>
                              <div class="col-md-9">
                                 <div class="form-group">
                                    <label for="">Website Logo</label>
                                    <input type="file" class="form-control" name="logo">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Website Title</label>
                              <input type="text" class="form-control" name="site_title" value="<?php echo $site->store_title; ?>" required>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Website domain</label>
                              <input type="text" class="form-control" name="domain" value="<?php echo $site->domain; ?>" required>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Meta Description</label>
                              <textarea name="store_meta_description" class="form-control" cols="5" rows="5" maxlength="180"><?php echo $site->store_meta_description; ?></textarea>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">About Website</label>
                              <textarea name="store_description" class="form-control tinymcy" cols="5" rows="30"><?php echo $site->store_description; ?></textarea>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/ecommerce/settings/website/details.blade.php ENDPATH**/ ?>