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
         <li class="breadcrumb-item active">Policies</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shield-alt"></i> Website Settings - Policies</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.ecommerce.settings._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="card">
               <?php echo $__env->make('app.ecommerce.settings.website._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <div class="card-block">
                  <div class="p-0 m-0">
                     <form class="row" action="<?php echo route('ecommerce.settings.website.policies.save'); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="col-md-12">
                           <ul class="nav nav-tabs">
                              <li class="nav-item">
                                 <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                                    <span class="d-sm-none">Return</span>
                                    <span class="d-sm-block d-none">Return policy</span>
                                 </a>
                              </li>
                              <li class="nav-item">
                                 <a href="#default-tab-2" data-toggle="tab" class="nav-link">
                                    <span class="d-sm-none">Refund</span>
                                    <span class="d-sm-block d-none">Refund policy</span>
                                 </a>
                              </li>
                              <li class="nav-item">
                                 <a href="#default-tab-3" data-toggle="tab" class="nav-link">
                                    <span class="d-sm-none">Payment</span>
                                    <span class="d-sm-block d-none">Payment policy</span>
                                 </a>
                              </li>
                              <li class="nav-item">
                                 <a href="#default-tab-4" data-toggle="tab" class="nav-link">
                                    <span class="d-sm-none">Privacy</span>
                                    <span class="d-sm-block d-none">Privacy policy</span>
                                 </a>
                              </li>
                              <li class="nav-item">
                                 <a href="#default-tab-5" data-toggle="tab" class="nav-link">
                                    <span class="d-sm-none">Terms</span>
                                    <span class="d-sm-block d-none">Terms and conditions</span>
                                 </a>
                              </li>
                           </ul>
                           <div class="tab-content">
                              <div class="tab-pane fade active show" id="default-tab-1">
                                 <textarea name="return_policy" class="form-control tinymcy" cols="5" rows="30"><?php echo $site->return_policy; ?></textarea>
                              </div>
                              <div class="tab-pane fade" id="default-tab-2">
                                 <textarea name="refund_policy" class="form-control tinymcy" cols="5" rows="30"><?php echo $site->refund_policy; ?></textarea>
                              </div>
                              <div class="tab-pane fade" id="default-tab-3">
                                 <textarea name="payment_policy" class="form-control tinymcy" cols="5" rows="30"><?php echo $site->payment_policy; ?></textarea>
                              </div>
                              <div class="tab-pane fade" id="default-tab-4">
                                 <textarea name="privacy_policy" class="form-control tinymcy" cols="5" rows="30"><?php echo $site->privacy_policy; ?></textarea>
                              </div>
                              <div class="tab-pane fade" id="default-tab-5">
                                 <textarea name="terms_and_conditions" class="form-control tinymcy" cols="5" rows="30"><?php echo $site->terms_and_conditions; ?></textarea>
                              </div>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/ecommerce/settings/website/policies.blade.php ENDPATH**/ ?>