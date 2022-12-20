<?php $__env->startSection('title'); ?>
	Invoice | <?php echo $client->customer_name; ?> | <?php echo $invoice->prefix; ?><?php echo $invoice->invoice_number; ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.subscriptions.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
			<div class="col-md-4 mb-2">
				<div class="row">
					<div class="col-md-6">
						<?php if(Finance::count_invoice() != Wingu::plan()->invoices && Finance::count_invoice() < Wingu::plan()->invoices): ?>
							<?php if (app('laratrust')->isAbleTo('create-invoice')) : ?>
								<div class="btn-group">
									<button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"> <i class="fal fa-plus"></i> Create invoice</button>
									<ul class="dropdown-menu">
										<li><a href="<?php echo route('finance.invoice.product.create'); ?>">Create Invoice</a></li>
										
										
									</ul>
								</div>
							<?php endif; // app('laratrust')->permission ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="mt-4">
					<h4 class="text-center">All Invoice Payments to #<?php echo $invoice->prefix; ?><?php echo $invoice->invoice_number; ?></h4>
					<div class="widget-list widget-list-rounded m-b-30" data-id="widget">
						<?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<!-- begin widget-list-item -->
							<div class="widget-list-item mb-2">
								<div class="widget-list-content">
									<h4 class="widget-list-title font-weight-bold"><?php echo $payment->reference_number; ?></h4>
									<p class="widget-list-desc">
										<?php if($payment->amount != ""): ?>
										Payement date: <b><?php echo date('M j, Y',strtotime($payment->payment_date)); ?></b><br>
										<?php endif; ?>
										<?php if($payment->amount != ""): ?>
										Amount: <b>ksh <?php echo number_format($payment->amount); ?></b><br>
										<?php endif; ?>
										<?php if($payment->userID != ""): ?>
										Recorded by: <b><?php echo Wingu::user($payment->userID)->name; ?></b>
										<?php endif; ?>
									</p>
								</div>
								<div class="widget-list-action">
									<a href="#" data-toggle="dropdown" class="text-muted pull-right" aria-expanded="false"><i class="fa fa-ellipsis-h f-s-14"></i></a>
									<ul class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(415px, 72px, 0px);">
										<li><a href="<?php echo e(route('finance.payments.show',$payment->id)); ?>"><i class="far fa-edit"></i> View</a></li>
										<li><a href="<?php echo e(route('finance.payments.delete',$payment->id)); ?>" class="delete"><i class="fas fa-trash"></i> Delete</a></li>
									</ul>
								</div>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				</div>
			</div>
         <div class="col-md-8">
				<div class="invoice">
					<!-- begin invoice-company -->
					<div class="invoice-company text-inverse f-w-600">
						<span class="col-md-12">
							<?php if (app('laratrust')->isAbleTo('read-invoice')) : ?>
								<div class="btn-group">
									<button type="button" class="btn btn-default btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-envelope"></i> Email Invoice
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="<?php echo route('finance.invoice.mail',$invoice->invoiceID); ?>" id="mail_invoice_created">Invoice Created</a></li>
										
									</ul> 
								</div>
							<?php endif; // app('laratrust')->permission ?>
							<?php if (app('laratrust')->isAbleTo('update-invoice')) : ?>
                        <a href="<?php echo route('subscriptions.edit', $invoice->invoiceID); ?>" class="btn btn-sm btn-default m-b-10 p-l-5">
                           <i class="fas fa-edit"></i> Edit
                        </a>
							<?php endif; // app('laratrust')->permission ?>
							<?php if (app('laratrust')->isAbleTo('read-invoice')) : ?>
								<a href="<?php echo route('finance.invoice.pdf', $invoice->invoiceID); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
									<i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
								</a>
							<?php endif; // app('laratrust')->permission ?>
							<?php if (app('laratrust')->isAbleTo('read-invoice')) : ?>
								<a href="<?php echo route('finance.invoice.print', $invoice->invoiceID); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
									<i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print
								</a>
							<?php endif; // app('laratrust')->permission ?>
							<div class="btn-group">
								<button type="button" class="btn btn-default btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									More
								</button>
								<ul class="dropdown-menu">
									
									<?php if (app('laratrust')->isAbleTo('create-invoice')) : ?>
										<li><a href="#" data-toggle="modal" data-target="#attach-files">Attach Files</a></li>
									<?php endif; // app('laratrust')->permission ?>
									<?php if (app('laratrust')->isAbleTo('create-invoice')) : ?>
										<li><a href="<?php echo route('finance.invoice.deliverynote', $invoice->invoiceID); ?>" target="_blank">Print Delivery Note</a></li>
									<?php endif; // app('laratrust')->permission ?>
									
									<li class="divider"></li>
									<?php if (app('laratrust')->isAbleTo('delete-invoice')) : ?>
										<li><a href="<?php echo route('finance.invoice.delete', $invoice->invoiceID); ?>" class="delete">Delete</a> </li>
									<?php endif; // app('laratrust')->permission ?>
								</ul>
							</div>
							<?php if($invoice->statusID != 1): ?>
								<?php if (app('laratrust')->isAbleTo('create-invoice')) : ?>
									<a href="#" class="btn btn-pink btn-sm m-b-10 p-l-5" data-toggle="modal" data-target="#payment"><i class="fa fa-plus"></i> Add Payments</a>
								<?php endif; // app('laratrust')->permission ?>
							<?php endif; ?>
						</span>
					</div>
					<hr>
					<div class="invoice-content">
						<?php echo $__env->make('templates.'.$template.'.invoice.preview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
					
					<!-- begin invoice-footer -->
					<div class="invoice-footer">
						<p class="text-center m-b-5 f-w-600">
							THANK YOU FOR YOUR BUSINESS
						</p>
						<p class="text-center">
							<?php if($invoice->website != ""): ?>
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> <?php echo $invoice->website; ?></span>
							<?php endif; ?>
							<?php if($invoice->primary_phonenumber != ""): ?>
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> <?php echo $invoice->primary_phonenumber; ?></span>
							<?php endif; ?>
							<?php if($invoice->primary_email != ""): ?>
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> <?php echo $invoice->primary_email; ?></span>
							<?php endif; ?>
						</p>
					</div>
					<!-- end invoice-footer -->
				</div>
         </div>
      </div>
	</div>

	
	<form action="<?php echo route('finance.invoice.payment'); ?>" method="post" enctype="multipart/form-data">
		<?php echo csrf_field(); ?>
		<div class="modal fade" id="payment">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Record Payment for <?php echo $invoice->prefix; ?><?php echo $invoice->invoice_number; ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="amount" class="control-label"> Account </label>
									<?php echo Form::select('accountID', $accounts, null, array('class' => 'form-control')); ?>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="amount" class="control-label"> Income Category </label>
									<?php echo Form::select('incomeID',$categories, null, array('class' => 'form-control')); ?>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default required">
									<label for="amount" class="control-label"> Amount Received </label>
									<?php echo Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Enter amount', 'required' => '')); ?>

									<input type="hidden" name="invoiceID" value="<?php echo $invoice->invoiceID; ?>">
									<input type="hidden" name="clientID" value="<?php echo $invoice->customerID; ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="transactionID" class="control-label"> Transaction ID </label>
									<?php echo Form::text('transactionID', null, array('class' => 'form-control','placeholder' => 'Enter Transaction NO')); ?>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group required">
									<label class="control-label"> Payment Date </label>
									<div class="input-group">
										<input type="text" name="payment_date" class="form-control datepicker" value="<?php echo date('Y-m-d') ?>" autocomplete="off" aria-invalid="false">
										<div class="input-group-addon">
											<i class="fa fa-calendar calendar-icon"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="amount" class="control-label"> Payment Mode </label>
									<?php echo Form::select('payment_method', $paymenttypes, null, array('class' => 'form-control')); ?>

								</div>
							</div>
							<div class="col-md-12">
								<div class="form-gruoup">
									<label for="note" class="control-label">Leave a note</label>
									<?php echo Form::textarea('note', null, array('class' => 'form-control', 'placeholder' => 'Admin Note', 'spellcheck' => 'true', 'size' => '5x5')); ?>

								</div>
							</div>
							<div class="col-md-12 mt-3">
								<div class="form-group mt-2">
									<input type="checkbox" name="send_email" value="yes">
									<label>Send payment acknowledgment message to client </label>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Save</button>
						<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
					</div>
				</div>
			</div>
		</div>
	</form>

	
	<div class="modal fade" id="attach-files">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Attachment</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="<?php echo route('finance.invoice.attachment.files'); ?>" class="dropzone" id="my-awesome-dropzone" method="post">
						<?php echo csrf_field(); ?>
						<input type="hidden" value="<?php echo $invoice->invoiceID; ?>" name="invoiceID">
					</form>
					<center><h3 class="mt-5">Attachment Files</h3></center>
					<div class="row">
						<div class="col-md-12">
						<table id="data-table-default" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th></th>
									<th width="10%">Name</th>
									<th>Type</th>
									<th>Display attachment</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo $filec++; ?></td>
										<td>
											<?php if(stripos($file->file_mime, 'image') !== FALSE): ?>
												<center><img src="<?php echo asset('businesses/'.$invoice->businessID.'/finance/invoices/'.$file->file_name); ?>" alt="" style="width:30px;height:30px"></center>
											<?php endif; ?>
											<?php if(stripos($file->file_mime, 'pdf') !== FALSE): ?>
												<center><i class="fas fa-file-pdf fa-4x"></i></center>
											<?php endif; ?>
											<?php if(stripos($file->file_mime, 'octet-stream') !== FALSE): ?>
												<center><i class="fas fa-file-alt fa-4x"></i></center>
											<?php endif; ?>
										</td>
										<td width="10%"><?php echo $file->file_name; ?></td>
										<td><?php echo $file->file_mime; ?></td>
										<td>
											<div class="form-group">
												<input type="hidden" value="<?php echo $file->id; ?>" name="fileID" id="fileID">
												<select name="status" class="form-control" onchange='change_status()' id="status">
													<?php if($file->status == ""): ?>
														<option value="">Choose</option>
													<?php else: ?>
														<option value="<?php echo $file->status; ?>"><?php echo $file->status; ?></option>
													<?php endif; ?>
													<option value="No">No</option>
													<option value="Yes">Yes</option>
												</select>
											</div>
										</td>
										<td>
											<a href="<?php echo route('finance.invoice.attachment.delete',$file->id); ?>" class="btn btn-danger delete"><i class="fas fa-trash"></i></a>
										</td>
									</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>
					</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
		function change_status() {
			var url = '<?php echo url('/'); ?>';
			var status = document.getElementById("status").value;
			var file = document.getElementById("fileID").value;
			$.get(url+'/finance/invoice/file/'+status+'/'+file, function(data){
				//success data
				location.reload();
			});
		}
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/invoice/show.blade.php ENDPATH**/ ?>