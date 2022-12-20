<?php $__env->startSection('title','Project Details'); ?>


<?php $__env->startSection('stylesheet'); ?>
	<link rel="stylesheet" href="<?php echo asset('assets/css/project.css'); ?>" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.prm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('prm.index'); ?>">Projects Management</a></li>
         <li class="breadcrumb-item"><a href="#">Projects</a></li>
         <li class="breadcrumb-item active">Projects Details</li>
      </ol>
      <h1 class="page-header"><?php echo $project->project_name; ?></h1>
      <?php echo $__env->make('app.prm.partials._project_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row mt-3">
         <div class="col-md-8">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Project Details</h4>
               </div>
               <div class="panel-body">
                  <h3><?php echo $project->project_name; ?></h3>
                  <?php echo $project->description; ?>

               </div>
            </div>
         </div>
         <?php $__env->startSection('client'); ?>
         <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Client Details</h4>
               </div> 
               <div class="panel-body">
                  <?php if($project->project_type == 'Internal'): ?>
                     <h3 class="m-xs text-success">
                        <?php echo Wingu::business()->name; ?>

                     </h3>
                  <?php else: ?>
                     <h3 class="m-xs text-success">
                        <?php echo $client->customer_name; ?>

                     </h3>
                  <?php endif; ?>
                  <?php if($project->project_type != 'Internal'): ?>
                     <div class="row">
                        <div class="col-xs-6">
                           <small class="stat-label">Email</small>
                           <h5><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $client->email; ?></h5>
                        </div>
                        <div class="col-xs-6">
                           <small class="stat-label">Phone number</small>
                           <h5><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $client->primary_phone_number; ?></h5>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-xs-6">
                           <small class="stat-label">Website</small>
                           <h5><i class="fas fa-globe"></i> <?php echo $client->website; ?></h5>
                        </div>
                     </div>
                  <?php endif; ?>
               </div>
            </div>
         <?php $__env->stopSection(); ?>
         <?php echo $__env->make('app.prm.partials._project_stats', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/job/show.blade.php ENDPATH**/ ?>