<?php $__env->startSection('title','Product Attributes'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.product.attributes'); ?>">Product Attributes</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">All Attributes</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-6">
               <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <table id="data-table-default" class="table table-striped table-bordered">
                           <thead>
                              <tr>
                                 <th width="1%">#</th>
                                 <th>Name</th>
                                 <th>Values</th>
                                 <th width="26%">Actions</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                       <td><?php echo $count++; ?></td>
                                       <td><?php echo $attribute->name; ?></td>
                                       <td><?php echo Finance::values_per_attribute($attribute->id); ?></td>
                                       <td>
                                          <?php if (app('laratrust')->isAbleTo('update-productattributevalues')) : ?>
                                          <a href="<?php echo e(route('finance.product.attributes.edit', $attribute->id)); ?>" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                          <?php endif; // app('laratrust')->permission ?>
                                          <?php if (app('laratrust')->isAbleTo('create-productattributevalues')) : ?>
                                          <a href="<?php echo route('finance.product.attributes.value.create', $attribute->id); ?>" class="btn btn-info"><i class="fas fa-plus"></i></a>
                                          <?php endif; // app('laratrust')->permission ?>
                                          <?php if (app('laratrust')->isAbleTo('delete-productattributevalues')) : ?>
                                          <a href="<?php echo route('finance.product.attributes.delete', $attribute->id); ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                          <?php endif; // app('laratrust')->permission ?>
                                       </td>
                                 </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </tbody>
                     </table>
                  </div>
               </div>
               </div>
         </div>
         <div class="col-md-6">
               <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Add Attributes</h4>
               </div>
               <div class="panel-body">
                  <div class="panel-body">
                     <?php echo Form::open(array('route' => 'finance.product.attributes.store')); ?>

                           <?php echo csrf_field(); ?>
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('name', 'Name', array('class'=>'control-label')); ?>

                              <?php echo Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Attribute Name','required' => '')); ?>

                           </div>
                           <div class="form-group mt-4">
                              <center>
                                 <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Attributes</button>
                                 <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="25%">
                              </center>
                           </div>
                     <?php echo Form::close(); ?>

                  </div>
               </div>
               </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/items/attributes/index.blade.php ENDPATH**/ ?>