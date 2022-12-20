<?php $__env->startSection('title','Subscription | Settings'); ?>

<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('settings.index'); ?>">Dashboard</a></li>
         <li class="breadcrumb-item active">Subscription</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> Subscription</h1>
      <!-- begin row -->
      <div class="row">
         <div class="col-md-6">
            <div class="panel">
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-9">
                        <h5>This is your current plan:</h5>
                        <h2><?php echo $subscription->title; ?></h2>
                        <?php echo $subscription->intro; ?>

                        <div class="row">
                           <div class="col-md-6">
                              <a href="<?php echo route('winguplus.plans'); ?>" class="btn btn-primary mt-3">Select a Plan</a>
                           </div>
                           <?php if($subscription->plan_code != 'UnyfV9RP1rMFhuBWKO4sjCcZyg12xp'): ?>
                              <div class="col-md-6">
                                 <form action="https://payments.ipayafrica.com/v3/ke">
                                    <input name="hsh" type="hidden" value="<?php echo Wingu::ipay($business->plan_code); ?>">
                                    <input type="hidden" name="live" value="1" class="form-control">
                                    <input type="hidden" name="oid" value="<?php echo Auth::user()->business_code; ?>" class="form-control">
                                    <input type="hidden" name="inv" value="<?php echo Wingu::business()->business_code; ?>" class="form-control">
                                    <input type="hidden" name="ttl" value="<?php echo $subscription->price * 100; ?>" class="form-control">
                                    <input type="hidden" name="tel" value="0700000000" class="form-control">
                                    <input type="hidden" name="eml" value="<?php echo Wingu::business()->email; ?>" class="form-control">
                                    <input type="hidden" name="vid" value="treeb" class="form-control">
                                    <input type="hidden" name="curr" value="KES" class="form-control">
                                    <input type="hidden" name="p1" value="Plan Payment" class="form-control">
                                    <input type="hidden" name="p2" value="<?php echo Auth::user()->business_code; ?>" class="form-control">
                                    <input type="hidden" name="p3" value="KES" class="form-control">
                                    <input type="hidden" name="p4" value="" class="form-control">
                                    <input type="hidden" name="cbk" value="<?php echo route('wingu.application.payment'); ?>" class="form-control">
                                    <input type="hidden" name="cst" value="1" class="form-control">
                                    <input type="hidden" name="crl" value="0" class="form-control">
                                    <center><button type="submit" class="btn btn-success btn-block mt-3"><i class="fas fa-credit-card"></i> Renew Your Subscription </button></center>
                                 </form>
                              </div>
                           <?php endif; ?>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <h2><b><?php echo max(number_format(Helper::date_difference($business->due_date,date('Y-m-d'))),0); ?></b> Days Left</h2>
                        
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php if($subscription->plan_code == 'UnyfV9RP1rMFhuBWKO4sjCcZyg12xp'): ?>
            <div class="col-md-6">
               <div class="panel">
                  <div class="panel-body">
                     <div class="row mb-3">
                        <div class="col-md-12">
                           <h4>Go PRO <a href="<?php echo route('winguplus.plans'); ?>" class="btn btn-sm btn-success float-right">Select a Plan</a></h4>
                        </div>
                     </div>
                     <p>Read about our plans and select the one that adapts the best to your business needs.</p>
                     <div class="row">
                        <div class="col-md-6">
                           <p><b>Basic.</b> The basic features to start organizing your business, no strings attached.</p>
                        </div>
                        <div class="col-md-6">
                           <p><b>Standard.</b> Automate your book keeping and accounting, get more user seats, and assign predefined roles.</p>
                        </div>
                        <div class="col-md-6">
                           <p><b>Advanced.</b> Get all feature in WinguPlus plus extra personalized support</p>
                        </div>
                        <div class="col-md-6">
                           <p><b>Premium.</b> Get all feature in WinguPlus plus extra personalized support</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         <?php endif; ?>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/settings/subscription.blade.php ENDPATH**/ ?>