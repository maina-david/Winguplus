<?php $__env->startSection('title','Notes'); ?>


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
         <li class="breadcrumb-item"><a href="#">Tasks</a></li>
         <li class="breadcrumb-item active">Tasks List</li>
      </ol>
      <h1 class="page-header"><i class="fas fa-sticky-note"></i> Notes</h1>
      <?php echo $__env->make('app.prm.partials._project_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row mt-3">
         <div class="col-md-8">
				<form action="<?php echo route('project.notes.store'); ?>" method="post">
               <?php echo csrf_field(); ?>
               <div class="form-group">
                  <label for="">Title</label>
                  <input type="text" name="title" class="form-control" required>
                  <input type="hidden" name="projectID" value="<?php echo $project->id; ?>" required>
               </div>
               <div class="form-group">
                  <label for="">Status</label>
                  <?php echo Form::select('status', ['Choose status' => '', 'Public' => 'Public', 'Private' => 'Private'], null ,['class' => 'form-control']); ?>

               </div>
               <div class="form-group">
                  <label for="">Note</label>
                  <textarea name="content" cols="30" rows="10" class="form-control ckeditor"></textarea>
               </div>
               <div class="form-group">
                  <center><button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Save Note</button></center>
                  <center><img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%"></center>
               </div>
            </form>
         </div>
         <?php echo $__env->make('app.prm.partials._project_stats', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>
   </div>
   <?php $__env->stopSection(); ?>
   <?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
   <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/notes/create.blade.php ENDPATH**/ ?>