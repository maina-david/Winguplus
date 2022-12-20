<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <link rel="stylesheet" href="<?php echo asset('assets/css/dashboard.css'); ?>" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div class="main">
      <div class="row mt-5">
         <div class="col-md-12 mb-5">
            <h1 class="text-center"><b>What would you like to manage ?</b></h1>
         </div>

         <!--- finance -->
         <?php if(Wingu::check_business_modules('finance') == 1): ?>
            <?php
               $module = Wingu::modules('finance');
            ?>
            <div class="col-md-3 mb-3">
               <div class="green-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class=""><?php echo $module->name; ?></h2>
                        <p class="font-bold text-success"><?php echo $module->caption; ?></p>
                        <div class="mb-2"><?php echo $module->icon; ?></div>
                        <p class="small"><?php echo $module->introduction; ?></p>
                        <a href="<?php echo route('finance.index'); ?>" class="btn btn-success btn-sm">
                           <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         <?php endif; ?>

         <!--- human resource -->
         <?php if(Wingu::check_business_modules('human-resource') == 1): ?>
            <?php
               $module = Wingu::modules('human-resource');
            ?>
            <div class="col-md-3 mb-3">
               <div class="blue-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class=""><?php echo $module->name; ?></h2>
                        <p class="font-bold text-info"><?php echo $module->caption; ?></p>
                        <div class="mb-2"><?php echo $module->icon; ?></div>
                        <p class="small"><?php echo $module->introduction; ?></p>
                        <a href="<?php echo route('hrm.dashboard'); ?>" class="btn btn btn-info btn-sm text-white">
                           <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         <?php endif; ?>

         <!-- crm -->
         <?php if(Wingu::check_business_modules('crm') == 1): ?>
            <?php
               $module = Wingu::modules('crm');
            ?>
            <div class="col-md-3 mb-3">
               <div class="black-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class="m-b-xs"><?php echo $module->name; ?></h2>
                        <p class="font-bold"><?php echo $module->caption; ?></p>
                        <div class="mb-2">
                           <?php echo $module->icon; ?>

                        </div>
                        <p class="small"><?php echo $module->introduction; ?></p>
                        <a href="<?php echo route('crm.dashboard'); ?>" class="btn btn btn-black btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                     </div>
                  </div>
               </div>
            </div>
         <?php endif; ?>

         <!-- project management -->
         <?php if(Wingu::check_business_modules('jobs-management') == 1): ?>
            <?php
               $module = Wingu::modules('jobs-management');
            ?>
            <div class="col-md-3 mb-3">
               <div class="greenish-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class="m-b-xs"><?php echo $module->name; ?></h2>
                        <p class="font-bold text-greenish"><?php echo $module->caption; ?></p>
                        <div class="mb-2"><?php echo $module->icon; ?></div>
                        <p class="small"><?php echo $module->introduction; ?></p>
                        <a href="<?php echo route('jobs.dashboard'); ?>" class="btn btn-greenish btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                     </div>
                  </div>
               </div>
            </div>
         <?php endif; ?>

         <!--- Asset Management -->
         <?php if(Wingu::check_business_modules('asset-management') == 1): ?>
            <?php
               $module = Wingu::modules('asset-management');
            ?>
            <?php if($module->status == 15): ?>
               <div class="col-md-3 mb-3">
                  <div class="pink-border">
                     <div class="panel-body">
                        <div class="text-center">
                           <h2 class="m-b-xs"><?php echo $module->name; ?></h2>
                           <p class="font-bold text-pink"><?php echo $module->caption; ?></p>
                           <div class="mb-2"><div class="mb-2"><?php echo $module->icon; ?></div></div>
                           <p class="small"><?php echo $module->introduction; ?></p>
                           <a href="<?php echo route('assets.dashboard'); ?>" class="btn btn-pink btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                        </div>
                     </div>
                  </div>
               </div>
            <?php endif; ?>
         <?php endif; ?>

         <!--- e-commerce -->
         <?php if(Wingu::check_business_modules('wingustore') == 1): ?>
            <?php
               $module = Wingu::modules('wingustore');
            ?>
            <?php if($module->status == 15): ?>
               <div class="col-md-3 mb-3">
                  <div class="border-color-1">
                     <div class="panel-body">
                        <div class="text-center">
                           <h2 class="m-b-xs"><?php echo $module->name; ?></h2>
                           <p class="font-bold text-color-1"><?php echo $module->caption; ?></p>
                           <div class="mb-2"><div class="mb-2"><?php echo $module->icon; ?></div></div>
                           <p class="small"><?php echo $module->introduction; ?></p>
                           <a href="<?php echo route('ecommerce.dashboard'); ?>" class="btn btn-color-1 btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                        </div>
                     </div>
                  </div>
               </div>
            <?php endif; ?>
         <?php endif; ?>

         <!--- POS -->
         <?php if(Wingu::check_business_modules('point-of-sale') == 1): ?>
            <?php
               $module = Wingu::modules('point-of-sale');
            ?>
            <?php if($module->status == 15): ?>
               <div class="col-md-3 mb-3">
                  <div class="border-color-b2">
                     <div class="panel-body">
                        <div class="text-center">
                           <h2 class="m-b-xs"><?php echo $module->name; ?></h2>
                           <p class="font-bold text-color-2"><?php echo $module->caption; ?></p>
                           <div class="mb-2"><div class="mb-2"><?php echo $module->icon; ?></div></div>
                           <p class="small"><?php echo $module->introduction; ?></p>
                           <a href="<?php echo route('pos.dashboard'); ?>" class="btn btn-color-2 btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                        </div>
                     </div>
                  </div>
               </div>
            <?php endif; ?>
         <?php endif; ?>

         <?php if(Wingu::business()->id == 1): ?>
            <!--- Subscription -->
            <?php if(Wingu::check_business_modules('subscription') == 1): ?>
               <?php
                  $module = Wingu::modules('subscription');
               ?>
               <?php if($module->status == 15): ?>
                  <div class="col-md-3 mb-3">
                     <div class="border-color-4">
                        <div class="panel-body">
                           <div class="text-center">
                              <h2 class="m-b-xs"><?php echo $module->name; ?></h2>
                              <p class="font-bold text-color-4"><?php echo $module->caption; ?></p>
                              <div class="mb-2"><div class="mb-2"><?php echo $module->icon; ?></div></div>
                              <p class="small"><?php echo $module->introduction; ?></p>
                              <a href="<?php echo route('subscriptions.dashboard'); ?>" class="btn btn-color-4 btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php endif; ?>
            <?php endif; ?>

            <!--- Sales Flow -->
            <?php if(Wingu::check_business_modules('salesflow') == 1): ?>
               <?php if(Wingu::check_modules('salesflow') == 1): ?>
                  <?php
                     $module = Wingu::modules('salesflow');
                  ?>
                  <?php if($module->status == 15): ?>
                     <div class="col-md-3 mb-3">
                        <div class="orangeish-border">
                           <div class="panel-body">
                              <div class="text-center">
                                 <h2 class="m-b-xs"><?php echo $module->name; ?></h2>
                                 <p class="font-bold text-orangeish"><?php echo $module->caption; ?></p>
                                 <div class="mb-2"><div class="mb-2"><?php echo $module->icon; ?></div></div>
                                 <p class="small"><?php echo $module->introduction; ?></p>
                                 <a href="<?php echo route('salesflow.dashboard'); ?>" class="btn btn-orangeish btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  <?php endif; ?>
               <?php endif; ?>
            <?php endif; ?>

            <!--- Sacco operations -->
            <?php if(Wingu::check_modules('sacco-operations') == 1): ?>
               <?php
                  $module = Wingu::modules('sacco-operations');
               ?>
               <?php if($module->status == 15): ?>
                  <div class="col-md-3 mb-3">
                     <div class="border-color-1">
                        <div class="panel-body">
                           <div class="text-center">
                              <h2 class="m-b-xs"><?php echo $module->name; ?></h2>
                              <p class="font-bold text-color-4"><?php echo $module->caption; ?></p>
                              <div class="mb-2"><div class="mb-2"><?php echo $module->icon; ?></div></div>
                              <p class="small"><?php echo $module->introduction; ?></p>
                              <a href="#" class="btn btn-color-1 btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php endif; ?>
            <?php endif; ?>

            <!--- Property Wingu -->
            <?php if(Wingu::check_modules('property-wingu') == 1): ?>
               <?php
                  $module = Wingu::modules('property-wingu');
               ?>
               <?php if($module->status == 15): ?>
                  <div class="col-md-3 mb-3">
                     <div class="border-color-1">
                        <div class="panel-body">
                           <div class="text-center">
                              <h2 class="m-b-xs"><?php echo $module->name; ?></h2>
                              <p class="font-bold text-color-4"><?php echo $module->caption; ?></p>
                              <div class="mb-2"><div class="mb-2"><?php echo $module->icon; ?></div></div>
                              <p class="small"><?php echo $module->introduction; ?></p>
                              <a href="<?php echo route('propertywingu.dashboard'); ?>" class="btn btn-color-1 btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php endif; ?>
            <?php endif; ?>

            <!--- wingu crowd -->
            <?php if(Wingu::check_modules('event-management') == 1): ?>
               <?php
                  $module = Wingu::modules('event-management');
               ?>
               <?php if($module->status == 15): ?>
                  <div class="col-md-3 mb-3">
                     <div class="border-color-1">
                        <div class="panel-body">
                           <div class="text-center">
                              <h2 class="m-b-xs"><?php echo $module->name; ?></h2>
                              <p class="font-bold text-color-4"><?php echo $module->caption; ?></p>
                              <div class="mb-2"><div class="mb-2"><?php echo $module->icon; ?></div></div>
                              <p class="small"><?php echo $module->introduction; ?></p>
                              <a href="<?php echo route('events.manager.dashboard'); ?>" class="btn btn-color-1 btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php endif; ?>
            <?php endif; ?>
         <?php endif; ?>

         <!--- settings -->
         <?php if(Wingu::check_if_user_has_role(Auth::user()->user_code,'admin')): ?>
            <div class="col-md-3">
               <div class="yellow-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class="m-b-xs">Settings</h2>
                        <p class="font-bold text-yellow">All Configurations</p>
                        <div class="mb-2">
                           <i class="fal fa-tools fa-5x"></i>
                        </div>
                        <p class="small">
                           User roles,user management,payment integration,Telephony integration,business profile
                        </p>
                        <a href="<?php echo route('settings.index'); ?>" class="btn btn-yellow btn-sm">
                           <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         <?php endif; ?>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/dashboard/dashboard_hold.blade.php ENDPATH**/ ?>