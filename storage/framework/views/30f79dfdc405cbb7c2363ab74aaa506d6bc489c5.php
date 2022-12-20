<?php $__env->startSection('title','Sales History'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('backend.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
      <h1 class="page-header">Sales History</h1>
		<?php echo $__env->make('backend.partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
				</div>
				<h4 class="panel-title">Invoice List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
							<th width="1%">#</th>
                     <th>Date</th>
							<th>TransactionID</th>
                     <th>Sold by</th>
                     <th>Customer</th>
                     <th>Note</th>
                     <th>Sale Total</th>
							<th>Payment Method</th>
                     <th>Status</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
							<th width="1%">#</th>
                     <th>Date</th>
							<th>TransactionID</th>
                     <th>Sold by</th>
                     <th>Customer</th>
                     <th>Note</th>
                     <th>Sale Total</th>
							<th>Payment Method</th>
                     <th>Status</th>
                     <th width="7%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
						<?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?php echo date("F j, Y, g:i a", strtotime($sale->created_at)); ?></td>
								<td class="text-uppercase font-weight-bold"><?php echo $sale->transactionID; ?></td>
								<td>
									<?php echo Limitless::user($sale->userID)->name; ?>

								</td>
								<td>
									<?php if($sale->client_id != ""): ?>
										<?php if(Finance::check_client($sale->client_id) == 1): ?>
											<?php if(Finance::client($sale->client_id)->company_name != "" ): ?>
	                                 <?php echo Finance::client($sale->client_id)->company_name; ?>

	                              <?php else: ?>
	                                 <?php echo Finance::client($sale->client_id)->client_name; ?>

	                              <?php endif; ?>
										<?php else: ?>
											<i>Unknown Client</i>
										<?php endif; ?>
									<?php else: ?>
										<i>Unknown Client</i>
									<?php endif; ?>
								</td>
								<td><?php echo $sale->note; ?></td>
								<td>
									<?php if(Limitless::business(Auth::user()->businessID)->base_currency != ""): ?>
										<?php echo Finance::currency(Limitless::business(Auth::user()->businessID)->base_currency)->code; ?>

									<?php endif; ?>
									<?php echo number_format($sale->total); ?>

								</td>
								<td>
									<?php if(Finance::check_payment($sale->id) > 0): ?>
										<?php if(Finance::check_payment_method(Finance::invoice_payment($sale->id)->payment_method) == 1): ?>
											<?php echo Finance::payment_method(Finance::invoice_payment($sale->id)->payment_method)->name; ?>

										<?php else: ?>
											<i>Unknown method</i>
										<?php endif; ?>
									<?php else: ?>
										<i>Unknown method</i>
									<?php endif; ?>
								</td>
								<td>
									<span class="badge <?php echo Limitless::status($sale->statusID)->name; ?>"><?php echo ucfirst(Limitless::status($sale->statusID)->name); ?></span>
								</td>
								<td><a href="<?php echo route('history.details',$sale->id); ?>" class="btn btn-pink btn-sm"><i class="fas fa-eye"></i> view</a></td>
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

<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/sales/history/index.blade.php ENDPATH**/ ?>