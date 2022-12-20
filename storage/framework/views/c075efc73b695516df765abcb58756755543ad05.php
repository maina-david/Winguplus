<?php $__env->startSection('title','Product List'); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.ecommerce.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
			<a href="<?php echo route('ecommerce.products.create'); ?>" class="btn btn-success"><i class="fas fa-plus"></i> Add New Products</a>
			
		</div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-boxes"></i> All Products </h1>
      <!-- end page-header -->
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		
		<div class="panel panel-default">
			<div class="panel-body">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th width="1%">#</th>
							<th width="5%">Image</th>
							<th>Name</th>
							<th width="10%">Price</th>
							<th width="13%">Current Stock</th>
							<th width="15%">Created at</th>
							<th width="10%">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($product->business_code == Auth::user()->business_code): ?>
								<tr>
									<td><?php echo $key + 1; ?></td>
									<td>
										<center>
											<?php if(Finance::check_product_image($product->proID) == 1): ?>
												<img src="<?php echo asset('businesses/'.Wingu::business()->business_code .'/finance/products/'.Finance::product_image($product->proID)->file_name); ?>" width="80px" height="60px">
											<?php else: ?>
												<img src="<?php echo asset('assets/img/product_placeholder.jpg'); ?>" width="80px" height="60px">
											<?php endif; ?>
										</center>
									</td>
									<td><?php echo $product->product_name; ?></td>
									<td>
										<?php echo $product->currency; ?><?php echo number_format($product->price); ?>

									</td>
									<td>
										<?php if($product->type != 'service'): ?>
											<?php echo $product->stock; ?>

										<?php endif; ?>
									</td>
									<td><?php echo date('F d, Y', strtotime($product->date)); ?></td>
									<td>
										<a href="<?php echo e(route('ecommerce.products.edit', $product->proID)); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
										<a href="<?php echo route('ecommerce.products.destroy', $product->proID); ?>" class="btn btn-danger delete btn-sm"><i class="fas fa-trash"></i></a>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/ecommerce/products/index.blade.php ENDPATH**/ ?>