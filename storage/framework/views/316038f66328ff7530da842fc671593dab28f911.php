<?php $__env->startSection('title','Add Survey'); ?>

<?php $__env->startSection('content'); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Survey </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Survey</a></li>
                     <li class="breadcrumb-item active">Create</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="card">
      <div class="card-body">
         <?php echo Form::open(array('route' => 'survey.store','enctype'=>'multipart/form-data')); ?>

            <div class="row">
               <div class="col-md-6">
                  <div class="form-group mb-1">
                     <?php echo Form::label('title', 'Title', array('class'=>'control-label')); ?>

                     <?php echo Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Title')); ?>

                  </div>
                  
                  
                  <div class="form-group mb-1">
                     <?php echo Form::label('type','Type', array('class'=>'control-label')); ?>

                     <?php echo e(Form::select('type',['online'=>'Online'], null, ['class' => 'form-control'])); ?>

                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group mb-1">
                     <?php echo Form::label('type','Visibility', array('class'=>'control-label')); ?>

                     <?php echo e(Form::select('visibility',['Public'=>'Public','Private'=>'Private'], null, ['class' => 'form-control'])); ?>

                  </div>
                  <div class="form-group mb-1">
                     <?php echo Form::label('title','Category Status', array('class'=>'control-label')); ?>

                     <?php echo e(Form::select('status',[15=>'Active',22=>'Closed'], null, ['class' => 'form-control', 'required' => ''])); ?>

                  </div>
                  
               </div>
               <div class="col-md-12 mb-1">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Start Date</label>
                           <?php echo Form::date('start_date',null,['class'=>'form-control']); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">End Date</label>
                           <?php echo Form::date('end_date',null,['class'=>'form-control']); ?>

                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12 mb-1">
                  <div class="panel-body">
                     <div class="form-group">
                        <label for="">Link to sales person</label>
                        <?php echo Form::select('description',[],null,['class'=>'form-control my-editor']); ?>

                     </div>
                  </div>
               </div>
               <div class="col-md-12 mb-1">
                  <div class="panel-body">
                     <div class="form-group">
                        <label for="">Description</label>
                        <?php echo Form::textarea('description',null,['class'=>'form-control my-editor', 'size' => '6x6', 'placeholder'=>'caption']); ?>

                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <center>
                        <?php echo Form::submit('Add Survey',array('class' =>'btn btn-success btn-sm submit')); ?>

                        <img src="<?php echo asset('assets/images/loader.gif'); ?>" alt="" class="submit-load" style="width: 10%">
                     </center>
                  </div>
               </div>
            </div>
         <?php echo Form::close(); ?>

      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/survey/survey/create.blade.php ENDPATH**/ ?>