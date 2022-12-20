<?php $__env->startSection('title','Edit Department | Human Resource'); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.dashboard'); ?>">Human resource</a></li>
         <li class="breadcrumb-item"><a href="#">Organization</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.departments'); ?>">Departments</a></li>
         <li class="breadcrumb-item active"><a href="<?php echo route('hrm.departments'); ?>">Edit</a></li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-sitemap"></i> Edit Department</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin widget-list -->
      <div class="row">
         <?php echo Form::model($edit, ['route' => ['hrm.departments.update',$edit->department_code], 'method'=>'post','class' => 'col-md-12']); ?>

            <?php echo csrf_field(); ?>
            <div class="card">
               <div class="card-header">Department Details</div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('names', 'Department Name', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Enter name', 'required' =>'' )); ?>

                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('names', 'Department Code', array('class'=>'control-label')); ?>

                           <?php echo Form::text('code', null, array('class' => 'form-control', 'placeholder' => 'Enter code')); ?>

                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('names', 'Choose Parent Department', array('class'=>'control-label')); ?>

                           <?php echo Form::select('parent_code', $departments, null, array('class' => 'form-control multiselect')); ?>

                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('head', 'Choose Department Head', array('class'=>'control-label')); ?>

                           <?php echo Form::select('head', $employees, null, array('class' => 'form-control multiselect')); ?>

                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <?php echo Form::label('names', 'Department details', array('class'=>'control-label')); ?>

                     <?php echo Form::textarea('description', null, array('class' => 'form-control ckeditor')); ?>

                  </div>
                  <div class="form-group mt-4">
                     <center>
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Edit Department</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </div>
            </div>
         <?php echo Form::close(); ?>

      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/basic/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/organization/departments/edit.blade.php ENDPATH**/ ?>