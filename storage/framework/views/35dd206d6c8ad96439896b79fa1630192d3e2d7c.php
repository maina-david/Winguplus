<?php $__env->startSection('title','Jobs | Jobs Management'); ?>

<?php $__env->startSection('stylesheet'); ?>
	<link rel="stylesheet" href="<?php echo asset('assets/css/job.css'); ?>" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.jobs.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('jobs.dashboard'); ?>">Jobs Management</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('job.index'); ?>">Jobs</a></li>
         <li class="breadcrumb-item active">All Jobs</li>
      </ol>
      <h1 class="page-header"><i class="fal fa-rocket-launch"></i> All Jobs</h1>
		<div class="row mb-2">
         <div class="col-sm-4">
            <a href="<?php echo route('job.create'); ?>" class="btn btn-pink mb-3"><i class="fas fa-plus"></i> Create Job</a>
         </div>
         <div class="col-sm-8">
            
         </div><!-- end col-->
      </div>
      <!-- end row-->
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.jobs')->html();
} elseif ($_instance->childHasBeenRendered('VLED8Va')) {
    $componentId = $_instance->getRenderedChildComponentId('VLED8Va');
    $componentTag = $_instance->getRenderedChildComponentTagName('VLED8Va');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('VLED8Va');
} else {
    $response = \Livewire\Livewire::mount('jobs.jobs');
    $html = $response->html();
    $_instance->logRenderedChild('VLED8Va', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/job/index.blade.php ENDPATH**/ ?>