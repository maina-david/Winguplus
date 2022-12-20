<?php $__env->startSection('title','Asset Type | Asset Management'); ?>

<?php $__env->startSection('stylesheet'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.assets.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="content">
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fab fa-elementor"></i> Asset Type</h1>
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="row">
      <div class="col-md-6">
         <div class="card">
            <div class="card-header">Asset type list</div>
            <div class="card-body">
               <table id="data-table-default" class="table table-striped table-bordered">
                  <thead>
                     <th width="1%">#</th>
                     <th>Name</th>
                     <th width="25%">Action</th>
                  </thead>
                  <tbody>
                     <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                           <td><?php echo $count+1; ?></td>
                           <td><?php echo $type->name; ?></td>
                           <td>
                              <a href="<?php echo route('assets.type.edit',$type->type_code); ?>" class="btn btn-primary edit-type">Edit</a>
                              <a href="<?php echo route('assets.type.delete',$type->type_code); ?>" class="btn btn-danger delete">Delete</a>
                           </td>
                        </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card">
            <div class="card-header">Add asset type</div>
            <div class="card-body">
               <form action="<?php echo route('assets.type.store'); ?>" method="POST">
                  <?php echo csrf_field(); ?>
                  <div class="form-group form-group-default">
                     <label for="">Name</label>
                     <?php echo Form::text('name',null,['class' => 'form-control', 'required' => '','placeholder' => 'Enter name']); ?>

                  </div>
                  <div class="form-group">
                     <button class="btn btn-pink submit"><i class="fas fa-save"></i> Add type</button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/assets/types/index.blade.php ENDPATH**/ ?>