<?php $__env->startSection('title','Create Product | Subscriptions'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <style>
      ul.product li {
         width: 100%;
      }
   </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.subscriptions.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('subscriptions.dashboard'); ?>">Subscriptions</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('subscriptions.products.index'); ?>">Products</a></li>
         <li class="breadcrumb-item active">Create</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shopping-basket"></i> Create Products</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">         
         <div class="col-md-9">
            <!-- end of shop menu -->
            <?php echo Form::open(array('route' => 'subscriptions.products.store', 'enctype'=>'multipart/form-data','method' => 'post','autocomplete' => 'off')); ?>

            <?php echo csrf_field(); ?>

            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Information</h4>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('title', 'Product Name', array('class'=>'control-label')); ?>

                           <?php echo Form::text('product_name', null, array('class' => 'form-control', 'placeholder' => 'Enter Product Name','required' => '')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('title', 'SKU code', array('class'=>'control-label')); ?>

                           <?php echo e(Form::select('code_type',['Auto'=>'Automatically Generate a SKU','Custom'=>'Enter a custom SKU'], null, ['class' => 'form-control multiselect', 'required' => '', 'id' => 'sku'])); ?>

                        </div>
                     </div>
                     <div class="col-md-6" style="display:none;" id="custom-sku">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('title', 'SKU code', array('class'=>'control-label')); ?>

                           <?php echo Form::text('sku_code', null, array('class' => 'form-control', 'placeholder' => 'SKU code')); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('title', 'Notification Mail Address', array('class'=>'control-label')); ?>

                           <?php echo Form::email('notification_email', null, array('class' => 'form-control', 'placeholder' => 'Enter notification mail address')); ?>

                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-body">
                  <div class="col-md-12">
                     
                     <div class="form-group">
                        <?php echo Form::label('title', 'Description', array('class'=>'control-label')); ?>

                        <?php echo Form::textarea('description',null,['class'=>'ckeditor form-control','rows' => 5, 'placeholder'=>'content']); ?>

                     </div>
                     <div class="form-group mt-3">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Product</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                        </center>
                     </div>
                  </div>
               </div>
            </div>
            <?php echo Form::close(); ?>

         </div>
         <div class="col-md-3"></div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script>
      $(document).ready(function() {
         $('#sku').on('change', function() {
            if (this.value == 'Custom') {
               $('#custom-sku').show();
            }
            if (this.value == 'Auto') {
               $('#custom-sku').hide();
            }
         });
      });
   </script>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/basic/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/products/create.blade.php ENDPATH**/ ?>