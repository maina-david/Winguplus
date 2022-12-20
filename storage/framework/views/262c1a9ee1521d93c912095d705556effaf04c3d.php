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

         <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 mb-3">
               <div class="black-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class=""><?php echo $module->name; ?></h2>
                        <p class="font-bold text-black"><?php echo $module->caption; ?></p>
                        <div class="mb-2"><?php echo $module->icon; ?></div>
                        <p class="small"><?php echo $module->introduction; ?></p>
                        <a href="<?php echo route($module->link); ?>" class="btn btn-black btn-sm">
                           <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/dashboard/dashboard.blade.php ENDPATH**/ ?>