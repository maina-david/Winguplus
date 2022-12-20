<?php $__env->startSection('title','Sales History | Pos'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">POS</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.product.index'); ?>">Sales History</a></li>
         <li class="breadcrumb-item active">List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-history"></i> Sales History</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-default">
			<div class="panel-heading">

				<h4 class="panel-title">Sales History</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
							<th width="1%">#</th>
                     <th>Date</th>
							<th>Sale#</th>
                     <th>Customer</th>
                     <th>Status</th>
                     <th>Amount</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
						<?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo $count+1; ?></td>
								<td><?php echo date('F jS, Y', strtotime($sale->invoice_date)); ?></td>
								<td><?php echo $sale->invoice_prefix; ?><?php echo $sale->invoice_number; ?></td>
								<td><?php echo $sale->customer_name; ?></td>
								<td>
									<span class="badge <?php echo $sale->statusName; ?>"><?php echo ucfirst($sale->statusName); ?></span>
								</td>
								<td><?php echo $sale->currency; ?><?php echo number_format((int)$sale->main_amount,2); ?></td>
								<td><a href="<?php echo route('pos.sale.details',$sale->invoice_code); ?>" class="btn btn-sm btn-pink"><i class="fas fa-eye"></i> view</a></td>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/sales/index.blade.php ENDPATH**/ ?>