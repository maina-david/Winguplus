<?php $__env->startSection('title','Edit Plan'); ?>
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
         <li class="breadcrumb-item"><a href="<?php echo route('subscriptions.plan.index',$productID); ?>">Plan</a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-file-alt"></i> Edit Plan</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">
            <!-- shop menu -->
         <div class="col-md-9">
            <?php echo Form::model($edit, ['route' => ['subscriptions.plan.update',$edit->proID], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

               <?php echo csrf_field(); ?>

               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Plan Information</h4>
                  </div>
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('title', 'Plan Name', array('class'=>'control-label')); ?>

                              <?php echo Form::text('product_name', null, array('class' => 'form-control', 'placeholder' => 'Enter plan name','required' => '')); ?>

                              <input type="hidden" value="<?php echo $productID; ?>" name="parentID">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('title', 'Plan code', array('class'=>'control-label')); ?>

                              <?php echo Form::text('sku_code', null, array('class' => 'form-control', 'placeholder' => 'Plan code', 'required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('title', 'Plan price', array('class'=>'control-label')); ?>

                              <?php echo Form::number('selling_price', null, array('class' => 'form-control', 'placeholder' => 'Enter plan price','required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('title', 'Bill Every', array('class'=>'control-label')); ?>

                              <?php echo Form::number('bill_count', null, array('class' => 'form-control', 'placeholder' => 'Enter billing count','required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('title', 'Bill period', array('class'=>'control-label')); ?>

                              <?php echo Form::select('billing_period', ['Month' => 'Month(s)','Week' => 'Week(s)','Year' => 'Year(s)'], null, array('class' => 'form-control multiselect','required' => '')); ?>

                           </div>
                        </div>                        
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('title', 'Billing type', array('class'=>'control-label')); ?>

                              <?php echo Form::select('billing_type', ['auto renew' => 'Auto renews until canceled','specified' => 'Expires after a specified no. of billing cycles'], null, array('class' => 'form-control multiselect','required' => '')); ?>

                           </div>
                        </div>                     
                        <?php if($edit->specified_bill_cycle != ""): ?>
                           <div class="col-md-6">
                              <div class="form-group form-group-default">
                                 <?php echo Form::label('title', 'Specified billing cycle', array('class'=>'control-label')); ?>

                                 <?php echo Form::number('specified_bill_cycle', null, array('class' => 'form-control', 'placeholder' => 'Enter billing count')); ?>

                              </div>
                           </div>
                        <?php endif; ?>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('title', 'Free Trial (in days)', array('class'=>'control-label')); ?>

                              <?php echo Form::number('trial_days', null, array('class' => 'form-control', 'placeholder' => 'Enter days')); ?>

                           </div>
                        </div>
                        
                        
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <?php echo Form::label('title', 'Description', array('class'=>'control-label')); ?>

                              <?php echo Form::textarea('description',null,['class'=>'ckeditor form-control','rows' => 5, 'placeholder'=>'content']); ?>

                           </div>
                        </div>
                        <div class="col-md-12 mt-4">
                           <center>
                              <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Plan</button>
                              <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                           </center>
                        </div>
                     </div>
                  </div>
               </div>
            <?php echo Form::close(); ?>

         </div>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/plan/edit.blade.php ENDPATH**/ ?>