<?php $__env->startSection('title','Assets'); ?>

<?php $__env->startSection('stylesheet'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.assets.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <div class="row">
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-teal">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-boxes-alt"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Total Assets</div>
                  <div class="stats-number"><?php echo number_format($assets->count()); ?></div>
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
            <div class="widget widget-stats bg-gradient-blue">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-door-open"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Checked-out</div>
                  <div class="stats-number"><?php echo number_format($checkedOut->count()); ?></div>
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
            <div class="widget widget-stats bg-gradient-yellow">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-tools"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Under repair</div>
                  <div class="stats-number"><?php echo number_format($underRepair->count()); ?></div>
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
            <div class="widget widget-stats bg-gradient-purple">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-search"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Lost/Missing</div>
                  <div class="stats-number"><?php echo number_format($missing->count()); ?></div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
      </div>
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Total Assets By Type</div>
               <div class="card-body">
                  <?php echo $assetByType->container(); ?>

               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Total Assets By Status</div>
               <div class="card-body">
                  <?php echo $assetByStatus->container(); ?>

               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end #content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <?php echo $assetByType->script(); ?>

   <?php echo $assetByStatus->script(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/assets/dashboard/dashboard.blade.php ENDPATH**/ ?>