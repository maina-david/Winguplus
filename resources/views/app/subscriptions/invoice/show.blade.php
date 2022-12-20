@extends('layouts.app')
{{-- page header --}}
@section('title')
	Invoice | {!! $client->customer_name !!} | {!! $invoice->prefix !!}{!! $invoice->invoice_number !!}
@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.subscriptions.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		@include('partials._messages')
      <div class="row">
			<div class="col-md-4 mb-2">
				<div class="row">
					<div class="col-md-6">
						@if(Finance::count_invoice() != Wingu::plan()->invoices && Finance::count_invoice() < Wingu::plan()->invoices)
							@permission('create-invoice')
								<div class="btn-group">
									<button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"> <i class="fal fa-plus"></i> Create invoice</button>
									<ul class="dropdown-menu">
										<li><a href="{!! route('finance.invoice.product.create') !!}">Create Invoice</a></li>
										{{-- <li><a href="{!! route('finance.invoice.random.create') !!}">Random Invoice</a></li> --}}
										{{-- <li><a href="{!! route('finance.invoice.recurring.create') !!}">Recurring Invoice</a></li> --}}
									</ul>
								</div>
							@endpermission
						@endif
					</div>
				</div>
				<div class="mt-4">
					<h4 class="text-center">All Invoice Payments to #{!! $invoice->prefix !!}{!! $invoice->invoice_number !!}</h4>
					<div class="widget-list widget-list-rounded m-b-30" data-id="widget">
						@foreach($payments as $payment)
							<!-- begin widget-list-item -->
							<div class="widget-list-item mb-2">
								<div class="widget-list-content">
									<h4 class="widget-list-title font-weight-bold">{!! $payment->reference_number !!}</h4>
									<p class="widget-list-desc">
										@if($payment->amount != "")
										Payement date: <b>{!! date('M j, Y',strtotime($payment->payment_date)) !!}</b><br>
										@endif
										@if($payment->amount != "")
										Amount: <b>ksh {!! number_format($payment->amount) !!}</b><br>
										@endif
										@if($payment->userID != "")
										Recorded by: <b>{!! Wingu::user($payment->userID)->name !!}</b>
										@endif
									</p>
								</div>
								<div class="widget-list-action">
									<a href="#" data-toggle="dropdown" class="text-muted pull-right" aria-expanded="false"><i class="fa fa-ellipsis-h f-s-14"></i></a>
									<ul class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(415px, 72px, 0px);">
										<li><a href="{{ route('finance.payments.show',$payment->id) }}"><i class="far fa-edit"></i> View</a></li>
										<li><a href="{{ route('finance.payments.delete',$payment->id) }}" class="delete"><i class="fas fa-trash"></i> Delete</a></li>
									</ul>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
         <div class="col-md-8">
				<div class="invoice">
					<!-- begin invoice-company -->
					<div class="invoice-company text-inverse f-w-600">
						<span class="col-md-12">
							@permission('read-invoice')
								<div class="btn-group">
									<button type="button" class="btn btn-default btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-envelope"></i> Email Invoice
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="{!! route('finance.invoice.mail',$invoice->invoiceID) !!}" id="mail_invoice_created">Invoice Created</a></li>
										{{-- <li><a href="#" id="mail_invoice_reminder">Invoice Payment Reminder</a></li>
										<li><a href="#" id="mail_invoice_overdue">Invoice Overdue Notice</a></li>
										<li><a href="#" id="mail_invoice_confirm">Invoice Payment Confirmation</a></li>
										<li><a href="#" id="mail_invoice_refund">Invoice Refund Confirmation</a></li> --}}
									</ul> 
								</div>
							@endpermission
							@permission('update-invoice')
                        <a href="{!! route('subscriptions.edit', $invoice->invoiceID) !!}" class="btn btn-sm btn-default m-b-10 p-l-5">
                           <i class="fas fa-edit"></i> Edit
                        </a>
							@endpermission
							@permission('read-invoice')
								<a href="{!! route('finance.invoice.pdf', $invoice->invoiceID) !!}" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
									<i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
								</a>
							@endpermission
							@permission('read-invoice')
								<a href="{!! route('finance.invoice.print', $invoice->invoiceID) !!}" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
									<i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print
								</a>
							@endpermission
							<div class="btn-group">
								<button type="button" class="btn btn-default btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									More
								</button>
								<ul class="dropdown-menu">
									{{-- <li><a href="">Share Invoice Link</a></li>
									<li><a href="">Use Credits</a></li>
									<li><a href="">Send Reminder</a></li>
									<li><a href="">Expected Payment Date</a></li>
									<li class="divider"></li>
									<li><a href="">Make Recurring</a></li>
									<li><a href="">Create Credit Note</a></li>
									<li><a href="">Clone</a></li>
									<li><a href="">Write Off</a></li>
									<li class="divider"></li> --}}
									@permission('create-invoice')
										<li><a href="#" data-toggle="modal" data-target="#attach-files">Attach Files</a></li>
									@endpermission
									@permission('create-invoice')
										<li><a href="{!! route('finance.invoice.deliverynote', $invoice->invoiceID) !!}" target="_blank">Print Delivery Note</a></li>
									@endpermission
									{{-- <li><a href="">Print Packing Slip</a></li> --}}
									<li class="divider"></li>
									@permission('delete-invoice')
										<li><a href="{!! route('finance.invoice.delete', $invoice->invoiceID) !!}" class="delete">Delete</a> </li>
									@endpermission
								</ul>
							</div>
							@if($invoice->statusID != 1)
								@permission('create-invoice')
									<a href="#" class="btn btn-pink btn-sm m-b-10 p-l-5" data-toggle="modal" data-target="#payment"><i class="fa fa-plus"></i> Add Payments</a>
								@endpermission
							@endif
						</span>
					</div>
					<hr>
					<div class="invoice-content">
						@include('templates.'.$template.'.invoice.preview')
					</div>
					
					<!-- begin invoice-footer -->
					<div class="invoice-footer">
						<p class="text-center m-b-5 f-w-600">
							THANK YOU FOR YOUR BUSINESS
						</p>
						<p class="text-center">
							@if($invoice->website != "")
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> {!! $invoice->website !!}</span>
							@endif
							@if($invoice->primary_phonenumber != "")
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> {!! $invoice->primary_phonenumber !!}</span>
							@endif
							@if($invoice->primary_email != "")
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> {!! $invoice->primary_email !!}</span>
							@endif
						</p>
					</div>
					<!-- end invoice-footer -->
				</div>
         </div>
      </div>
	</div>

	{{-- Invoice payment --}}
	<form action="{!! route('finance.invoice.payment') !!}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="modal fade" id="payment">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Record Payment for {!! $invoice->prefix !!}{!! $invoice->invoice_number !!}</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="amount" class="control-label"> Account </label>
									{!! Form::select('accountID', $accounts, null, array('class' => 'form-control')) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="amount" class="control-label"> Income Category </label>
									{!! Form::select('incomeID',$categories, null, array('class' => 'form-control')) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default required">
									<label for="amount" class="control-label"> Amount Received </label>
									{!! Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Enter amount', 'required' => '')) !!}
									<input type="hidden" name="invoiceID" value="{!! $invoice->invoiceID !!}">
									<input type="hidden" name="clientID" value="{!! $invoice->customerID !!}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-group-default">
									<label for="transactionID" class="control-label"> Transaction ID </label>
									{!! Form::text('transactionID', null, array('class' => 'form-control','placeholder' => 'Enter Transaction NO')) !!}
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
									{!! Form::select('payment_method', $paymenttypes, null, array('class' => 'form-control')) !!}
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-gruoup">
									<label for="note" class="control-label">Leave a note</label>
									{!! Form::textarea('note', null, array('class' => 'form-control', 'placeholder' => 'Admin Note', 'spellcheck' => 'true', 'size' => '5x5')) !!}
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
						<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
					</div>
				</div>
			</div>
		</div>
	</form>

	{{-- attach files to Invoice --}}
	<div class="modal fade" id="attach-files">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Attachment</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="{!! route('finance.invoice.attachment.files') !!}" class="dropzone" id="my-awesome-dropzone" method="post">
						@csrf()
						<input type="hidden" value="{!! $invoice->invoiceID !!}" name="invoiceID">
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
								@foreach ($files as $file)
									<tr>
										<td>{!! $filec++ !!}</td>
										<td>
											@if(stripos($file->file_mime, 'image') !== FALSE)
												<center><img src="{!! asset('businesses/'.$invoice->businessID.'/finance/invoices/'.$file->file_name) !!}" alt="" style="width:30px;height:30px"></center>
											@endif
											@if(stripos($file->file_mime, 'pdf') !== FALSE)
												<center><i class="fas fa-file-pdf fa-4x"></i></center>
											@endif
											@if(stripos($file->file_mime, 'octet-stream') !== FALSE)
												<center><i class="fas fa-file-alt fa-4x"></i></center>
											@endif
										</td>
										<td width="10%">{!! $file->file_name !!}</td>
										<td>{!! $file->file_mime !!}</td>
										<td>
											<div class="form-group">
												<input type="hidden" value="{!! $file->id !!}" name="fileID" id="fileID">
												<select name="status" class="form-control" onchange='change_status()' id="status">
													@if($file->status == "")
														<option value="">Choose</option>
													@else
														<option value="{!! $file->status !!}">{!! $file->status !!}</option>
													@endif
													<option value="No">No</option>
													<option value="Yes">Yes</option>
												</select>
											</div>
										</td>
										<td>
											<a href="{!! route('finance.invoice.attachment.delete',$file->id) !!}" class="btn btn-danger delete"><i class="fas fa-trash"></i></a>
										</td>
									</tr>
								@endforeach
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
@endsection
{{-- page scripts --}}
@section('scripts')
	<script>
		function change_status() {
			var url = '{!! url('/') !!}';
			var status = document.getElementById("status").value;
			var file = document.getElementById("fileID").value;
			$.get(url+'/finance/invoice/file/'+status+'/'+file, function(data){
				//success data
				location.reload();
			});
		}
	</script>
@endsection
