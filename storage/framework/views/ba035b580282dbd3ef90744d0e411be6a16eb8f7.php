<?php $__env->startSection('title','Point of Sale | Supplier List'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="<?php echo route('pos.supplier.create'); ?>" class="btn btn-pink"><i class="fas fa-user-plus"></i> Add A Supplier</a>
         
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users-cog"></i> All Supplier</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Supplier List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="5">Image</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th width="15%">Phone number</th>
                     <th width="15%">Date addded</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr >
                        <td><?php echo $count+1; ?></td>
                        <td>
                           <?php if($supplier->image == ""): ?>
                              <img src="https://ui-avatars.com/api/?name=<?php echo $supplier->supplier_name; ?>&rounded=true&size=32"  class="img-circle"  alt="<?php echo $supplier->supplier_name; ?>" width="40" height="40">
                           <?php else: ?>
                              <img width="40" height="40" alt="" class="img-circle" src="<?php echo asset('businesses/'.$supplier->business_code.'/suppliers/'.$supplier->supplier_code.'/images/'.$supplier->image); ?>">
                           <?php endif; ?>
                        </td>
                        <td><?php echo $supplier->supplier_name; ?></td>
                        <td><?php echo $supplier->supplier_email; ?></td>
                        <td><?php echo $supplier->primary_phone_number; ?></td>
                        <td><?php echo date('d F, Y', strtotime($supplier->date_added)); ?></td>
                        <td>
                           <a href="<?php echo e(route('pos.supplier.edit', $supplier->supplier_code)); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                           <a href="<?php echo route('pos.supplier.delete', $supplier->supplier_code); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/suppliers/index.blade.php ENDPATH**/ ?>