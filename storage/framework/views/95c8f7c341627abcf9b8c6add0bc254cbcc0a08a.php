<?php $__env->startSection('title','Subscriptions'); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.subscriptions.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- end page-header -->
      <!-- begin row -->
      <div class="row">
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-teal">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-check-circle"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Active</div>
                  <div class="stats-number"><?php echo $liveCount; ?></div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-blue">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-times-circle"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Closed</div>
                  <div class="stats-number"><?php echo $closedCount; ?></div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-purple">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-tachometer-fastest"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Trials</div>
                  <div class="stats-number"><?php echo $trialCount; ?></div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-black">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-sync"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Subscriptions</div>
                  <div class="stats-number"><?php echo $subscriptionsCount; ?></div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="<?php echo route('subscriptions.index'); ?>" class="text-white">view all</a></div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
      </div>
      <!-- end row -->
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">Subscription VS Month</div>
               <div class="card-body">
                  <?php echo $subscriptionPerMonth->container(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end #content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo asset('assets/plugins/chart.js/2.7.1/Chart.min.js'); ?>" charset="utf-8"></script>
	<?php echo $subscriptionPerMonth->script(); ?> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/dashboard/index.blade.php ENDPATH**/ ?>