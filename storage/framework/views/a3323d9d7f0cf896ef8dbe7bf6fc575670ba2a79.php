<?php $__env->startSection('title'); ?>
	Invoice | <?php echo $client->customer_name; ?> | <?php echo $invoice->prefix; ?><?php echo $invoice->invoice_number; ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('stylesheet'); ?>
   <style>
      .select2-container {
         z-index: 9999 !important;
      }
   </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
			<div class="col-md-4 mb-2">
				<div class="row">
					<div class="col-md-6">
                  <div class="btn-group">
                     <button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"> <i class="fas fa-plus"></i> Create invoice</button>
                     <ul class="dropdown-menu">
                        <li><a href="<?php echo route('finance.invoice.product.create'); ?>">Create Invoice</a></li>
                        <li><a href="<?php echo route('finance.invoice.recurring.create'); ?>">Recurring Invoice</a></li>
                     </ul>
                  </div>
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
										Amount: <b> <?php echo $invoice->currency; ?> <?php echo number_format($payment->amount,2); ?></b><br>
										<?php endif; ?>
                              <?php
                                 $user =  Wingu::user($payment->created_by)->getData();
                              ?>
										<?php if($user->check == 1): ?>
										   Recorded by: <b><?php echo $user->user->name; ?></b>
										<?php endif; ?>
									</p>
								</div>
								<div class="widget-list-action">
									<a href="#" data-toggle="dropdown" class="text-muted pull-right" aria-expanded="false"><i class="fa fa-ellipsis-h f-s-14"></i></a>
									<ul class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(415px, 72px, 0px);">
										<li><a href="<?php echo e(route('finance.payments.show',$payment->payment_code)); ?>"><i class="far fa-edit"></i> View</a></li>
										<li><a href="<?php echo e(route('finance.payments.delete',$payment->payment_code)); ?>" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
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
                     <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fal fa-envelope"></i> Email Invoice
                        </button>
                        <ul class="dropdown-menu" role="menu">
                           <li><a href="<?php echo route('finance.invoice.mail',$invoice->invoiceCode); ?>" id="mail_invoice_created">Invoice Created</a></li>
                           
                           
                           
                           
                        </ul>
                     </div>
                     <div class="btn-group">
                        
                        <ul class="dropdown-menu" role="menu">
                           <li><a href="<?php echo route('finance.invoice.mail',$invoice->invoiceCode); ?>" id="mail_invoice_created">Invoice Created</a></li>
                           
                           
                           
                           
                        </ul>
                     </div>
                     <?php if($invoice->invoice_type == 'Product'): ?>
                        <a href="<?php echo route('finance.invoice.product.edit', $invoice->invoiceCode); ?>" class="btn btn-sm btn-default m-b-10 p-l-5">
                           <i class="fas fa-edit"></i> Edit
                        </a>
                     <?php endif; ?>
                     <?php if($invoice->invoice_type == 'Subscription'): ?>
                        <a href="<?php echo route('subscriptions.edit',$invoice->subscription_code); ?>" target="_blank" class="btn btn-sm btn-default m-b-10 p-l-5"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a>
                     <?php endif; ?>
                     <a href="<?php echo route('finance.invoice.convert',[$invoice->invoiceCode,'pdf']); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                        <i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
                     </a>
                     <a href="<?php echo route('finance.invoice.convert',[$invoice->invoiceCode,'print']); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                        <i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print
                     </a>

							<?php if($invoice->status != 1): ?>
                        <div class="btn-group">
                           <button type="button" class="btn btn-pink btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-plus"></i> Add Payments
                           </button>
                           <ul class="dropdown-menu">
                              <li><a href=""  data-toggle="modal" data-target="#payment">Record Payment</a></li>
                              
                              
                           </ul>
                        </div>
							<?php endif; ?>
                     <div class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="fas fa-sliders-h-square"></i> Invoice settings
                        </button>
                        <ul class="dropdown-menu">
                           <li><a href="<?php echo route('finance.settings.invoice.tabs',$settings->id); ?>" target="_blank">Invoice Tabs</a></li>
                           <li><a href="<?php echo route('finance.settings.invoice.print',$settings->id); ?>" target="_blank">Print Settings</a></li>
                        </ul>
                     </div>
                     <div class="btn-group">
								<button type="button" class="btn btn-default btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									More
								</button>
								<ul class="dropdown-menu">
									
									
									
									
									
									
									
									
									
									
                           <li><a href="#" data-toggle="modal" data-target="#attach-files">Attach Files</a></li>
                           <li><a href="<?php echo route('finance.invoice.deliverynote', $invoice->invoiceCode); ?>" target="_blank">Print Delivery Note</a></li>
									
									
                           <li><a href="<?php echo route('finance.invoice.delete', $invoice->invoiceCode); ?>" class="delete">Delete</a> </li>

								</ul>
							</div>
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
							<?php if($invoice->phone_number != ""): ?>
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> <?php echo $invoice->phone_number; ?></span>
							<?php endif; ?>
							<?php if($invoice->email != ""): ?>
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> <?php echo $invoice->email; ?></span>
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
									<label for="amount" class="control-label"> Choose deposit account </label>
                           <select name="account" class="form-control select2">
                              <option value="">Choose deposit account</option>
                              <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $account->account_code; ?>"><?php echo $account->title; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default required">
									<label for="amount" class="control-label text-danger"> Amount Received </label>
									<input type="number" name="amount" step="0.01" value="<?php echo $invoice->balance; ?>" class="form-control" required>
									<input type="hidden" name="invoice" value="<?php echo $invoice->invoiceCode; ?>">
									<input type="hidden" name="client" value="<?php echo $invoice->customer; ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="transactionID" class="control-label"> Transaction ID </label>
									<?php echo Form::text('transactionID', null, array('class' => 'form-control','placeholder' => 'Enter Transaction NO')); ?>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default required">
									<label class="control-label"> Payment Date </label>
                           <?php echo Form::date('payment_date',null,['class'=>'form-control','required'=>'']); ?>

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="amount" class="control-label"> Payment method </label>
									<select name="payment_method" class="form-control select2">
										<option value="">Choose payment method</option>
										<?php $__currentLoopData = $accountPayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo $ap->method_code; ?>"><?php echo $ap->name; ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-gruoup">
									<label for="note" class="control-label">Leave a note</label>
									<?php echo Form::textarea('note', null, array('class' => 'form-control', 'spellcheck' => 'true', 'size' => '5x5')); ?>

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
						<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
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
						<input type="hidden" value="<?php echo $invoice->invoiceCode; ?>" name="invoice_code">
					</form>
					<center><h3 class="mt-5">Attachment Files</h3></center>
					<div class="row">
						<div class="col-md-12">
						<table id="data-table-default" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="1%">#</th>
									<th></th>
									<th>Name</th>
									<th>Type</th>
									<th width="10%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo $count+1; ?></td>
										<td>
											<?php if(stripos($file->file_mime, 'image') !== FALSE): ?>
												<center><img src="<?php echo asset('businesses/'.$invoice->business_code.'/finance/invoices/'.$file->file_name); ?>" alt="" style="width:30px;height:30px"></center>
											<?php endif; ?>
											<?php if(stripos($file->file_mime, 'pdf') !== FALSE): ?>
												<center><i class="fas fa-file-pdf fa-4x"></i></center>
											<?php endif; ?>
											<?php if(stripos($file->file_mime, 'octet-stream') !== FALSE): ?>
												<center><i class="fas fa-file-alt fa-4x"></i></center>
											<?php endif; ?>
										</td>
										<td width="15%"><?php echo $file->file_name; ?></td>
										<td><?php echo $file->file_mime; ?></td>
										<td>
											<a href="<?php echo asset('businesses/'.$invoice->business_code.'/finance/invoices/'.$file->file_name); ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-eye"></i></a>
											<a href="<?php echo route('finance.invoice.attachment.delete',$file->id); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
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

	<!-- Modal -->
	<div class="modal fade" id="mpesSTK" tabindex="-1" role="dialog" aria-labelledby="mpesaSTKpush" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form class="modal-content" method="POST" action="<?php echo route('finance.invoice.payments.stkpush',$invoice->business_code); ?>">
				<?php echo csrf_field(); ?>
				<div class="modal-header">
					<h5 class="modal-title" id="mpesaSTKpush">Mpesa STK Payment</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="">Enter Phone Number (format 2547xxxxxxxxx)</label>
						<input type="text" name="phone_number" class="form-control" value="<?php echo $client->primary_phone_number; ?>" required>
					</div>
					<div class="form-group">
						<label for="">Payment Amount</label>
						<input type="number" name="amount" step="0.01" class="form-control" min="0" max="<?php echo $invoice->balance; ?>" value="<?php echo $invoice->balance; ?>" required>
					</div>
					<div class="form-group">
						<label for="">Invoice Code</label>
						<input type="text" name="invoice_code" class="form-control" value="<?php echo $invoice->invoice_code; ?>" readonly>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary submit"><i class="fa fa-save"></i> Send payment to customer</button>
					<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
				</div>
			</form>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/invoices/show.blade.php ENDPATH**/ ?>