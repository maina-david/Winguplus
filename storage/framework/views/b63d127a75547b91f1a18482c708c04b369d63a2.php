<?php $__env->startSection('title','License List'); ?>

<?php $__env->startSection('stylesheet'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.assets.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="content">
	<div class="pull-right">
	   <a href="<?php echo route('licenses.assets.create'); ?>" class="btn btn-pink"><i class="fal fa-plus-circle"></i> Add License</a>
   </div>
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fas fa-laptop-code"></i> License List</h1>
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="panel panel-default">
      <div class="panel-heading">
         <h4 class="panel-title">License List</h4>
      </div>
      <div class="panel-body">
         <table id="data-table-default" class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                  <th>#</th>
                  <th>License</th>
                  <th>Product Key</th>
                  <th>Expiration Date</th>
                  <th>Licensed to Email</th>
                  <th>Licensed to Name</th>
                  <th>Manufacturer</th>
                  <th>Avail</th>
                  <th width="12%">Actions</th>
               </tr>
            </thead>
            <tbody>
               <?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                     <td><?php echo $count+1; ?></td>
                     <td><?php echo $asset->asset_name; ?></td>
                     <td><?php echo $asset->product_key; ?></td>
                     <td><?php echo $asset->end_of_life; ?></td>
                     <td><?php echo $asset->licensed_to_email; ?></td>
                     <td><?php echo $asset->licensed_to_name; ?></td>
                     <td><?php echo $asset->manufacture; ?></td>
                     <td><?php echo $asset->seats; ?></td>
                     <td>
                        <a href="<?php echo route('licenses.assets.edit',$asset->asset_code); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="<?php echo route('licenses.assets.show',$asset->asset_code); ?>" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                        <a href="<?php echo route('licenses.assets.delete',$asset->asset_code); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
                     </td>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/assets/licenses/index.blade.php ENDPATH**/ ?>