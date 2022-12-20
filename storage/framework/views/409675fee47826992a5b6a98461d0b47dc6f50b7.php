<?php $__env->startSection('title','Price | Point of Sale'); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo route('pos.dashboard'); ?>">P.O.S</a></li>
      <li class="breadcrumb-item"><a href="<?php echo route('pos.products'); ?>">Products</a></li>
		<li class="breadcrumb-item active">Edit Product</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fal fa-usd-circle"></i> Price | <?php echo $product->product_name; ?></h1>
	<!-- end page-header -->
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="row">
		<?php echo $__env->make('app.pos.products.products._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="col-md-9">
         <?php if($product->same_price != 'No'): ?>
            <?php echo Form::model($defaultPrice,['route' =>['pos.products.price.update',$productCode],'method'=>'post','enctype'=>'multipart/form-data','data-parsley-validate' => '']); ?>

					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title"><?php echo $product->product_name; ?> - Product Price</h4>
						</div>
						<div class="panel-body">
							<div class="col-md-12">
								<div class="form-group form-group-default">
									<?php echo Form::label('title', 'Buying Price Per Unit', array('class'=>'control-label')); ?>

									<?php echo Form::number('buying_price', null, array('class' => 'form-control','step' => '0.01','placeholder' => 'Buying Price')); ?>

                           <input type="hidden" name="price_id" value="<?php echo $defaultPrice->id; ?>">
								</div>
								<div class="form-group form-group-default required">
									<?php echo Form::label('title', 'Selling Price Per Unit', array('class'=>'control-label')); ?>

									<?php echo Form::number('selling_price', null, array('class' => 'form-control', 'step' => '0.01','placeholder' => 'Selling Price','required' => '')); ?>

								</div>
                        <div class="form-group form-group-default">
									<?php echo Form::label('title', 'Offer Price', array('class'=>'control-label')); ?>

									<?php echo Form::number('offer_price', null, array('class' => 'form-control', 'step' => '0.01','placeholder' => 'Enter offer price','required' => '')); ?>

								</div>
								<div class="form-group">
									<center>
										<button type="submit" class="btn btn-pink submit mt-4"><i class="fas fa-save"></i> Update Price</button>
										<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="25%">
									</center>
								</div>
							</div>
						</div>
					</div>
				<?php echo Form::close(); ?>

			<?php endif; ?>

			<?php if($product->same_price == 'No'): ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title mb-1">Prices</h4>
					</div>
					<div class="panel-body">
						<div class="col-md-12 mt-3">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-striped">
										<thead>
											<th width="25%">Out Let</th>
											<th>Buying price</th>
											<th>Selling price</th>
											<th>Offer price</th>
											<th width="13%"></th>
										</thead>
										<tbody>
											<?php $__currentLoopData = $prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo Form::model($price,['route' =>['pos.products.price.update',$productCode],'method'=>'post']); ?>

                                       <input type="hidden" name="price_id" value="<?php echo $price->id; ?>">
                                       <tr>
                                          <td>
                                             <?php if($price->default_price == 'Yes'): ?>
                                                <?php echo $mainBranch->name; ?>

                                             <?php else: ?>
                                                <?php if(Hr::check_branch($price->branch_code) == 1): ?>
                                                   <?php echo Hr::branch($price->branch_code)->name; ?>

                                                <?php endif; ?>
                                             <?php endif; ?>
                                          </td>
                                          <td><input type="text" class="form-control" name="buying_price" value="<?php echo $price->buying_price; ?>"></td>
                                          <td><input type="text" class="form-control" name="selling_price" value="<?php echo $price->selling_price; ?>" required></td>
                                          <td><input type="text" class="form-control" name="offer_price" value="<?php echo $price->offer_price; ?>"></td>
                                          <td>
                                             <button type="submit" class="btn btn-pink btn-block"><i class="fas fa-edit"></i> Update Price</button>
                                          </td>
                                       </tr>
												<?php echo Form::close(); ?>

											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/products/products/price.blade.php ENDPATH**/ ?>