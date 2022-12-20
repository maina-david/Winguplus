<?php $__env->startSection('title'); ?> Plans <?php $__env->stopSection(); ?>
<?php $__env->startSection('url'); ?><?php echo route('home.page'); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('stylesheet'); ?>
   <style>
      .section-container{
         min-height: 350px
      }
      .section-container-plain{
         background-image: none;
      }

      .icon-shape {
         display: -webkit-inline-box;
         display: inline-flex;
         -webkit-box-align: center;
         align-items: center;
         -webkit-box-pack: center;
         justify-content: center;
         text-align: center;
         vertical-align: middle;
      }

      .icon-xs {
         height: 20px;
         width: 20px;
         line-height: 20px;
      }
      .mr-2, .mx-2 {
         margin-right: .5rem!important;
      }

      .rounded-circle {
         border-radius: 50%!important;
      }
      .bg-lightpalegreen {
         background-color: #e4ffcf!important;
      }

      .bg-lightpeach {
         background-color: #ffd7de!important;
      }
   </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   
   <div class="section-container-plain head-section mb-5 mt-5">
      <div class="container">
         <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="row justify-content-center">
            <div class="col-md-12 mb-5">
               <h2 class="text-center"><b>Pick a plan that’s as unique as your business.</b></h2>
            </div>
            <?php $__currentLoopData = Wingu::get_all_plan(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                  <!--  pricing block start -->
                  <div class="card card-body" style="min-height: 350px">
                     <div class="mb-3 text-center">
                        <h3 class="font-14 textspace-lg font-weight-bold text-info mb-3"><?php echo $plan->title; ?></h3>
                        <h4 class="font-weight-bold text-dark">$<?php echo number_format($plan->usd); ?>/month.</h4>
                     </div>
                     <div class="d-flex mb-2">
                        <?php echo $plan->features; ?>

                     </div>
                  </div>
                  <div class="card-footer">
                     <form method="POST" action="<?php echo e(route('wingu.application.flutterwave.pay')); ?>" id="paymentForm">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="planCode" value="<?php echo $plan->plan_code; ?>" class="form-control">
                        <center><button type="submit" class="btn btn-success btn-block"><i class="fas fa-credit-card"></i> Checkout</button></center>
                     </form>
                  </div>
               </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/plan/plans.blade.php ENDPATH**/ ?>