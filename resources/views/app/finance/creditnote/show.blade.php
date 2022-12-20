@extends('layouts.app')
{{-- page header --}}
@section('title')
	Credit note | {!! $show->credit_note_prefix !!}{!! $show->credit_note_number !!}
@endsection

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		@include('partials._messages')
		<div class="row">
			<div class="col-md-4">
				<div class="">
				   <a href="{!! route('finance.creditnote.create') !!}" class="btn btn-pink pull-right"><i class="fas fa-plus"></i> New</a>
				</div>
			</div>
			<div class="col-md-8">
				<div class="invoice">
					<!-- begin invoice-company -->
					<div class="invoice-company text-inverse f-w-600 mb-3">
						<span class="pull-right hidden-print">
                     <a href="{!! route('finance.creditnote.mail',$code) !!}" class="btn btn-sm btn-default m-b-10 p-l-5">
                        <i class="fal fa-envelope"></i> Email Credit note
                     </a>
							@if(!$show->payment_code)
								<a href="{!! route('finance.creditnote.edit',$code) !!}" class="btn btn-sm btn-default m-b-10 p-l-5">
									<i class="fas fa-edit"></i> Edit
								</a>
							@endif
                     <a href="{!! route('finance.creditnote.generate',[$code,'pdf']) !!}" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                        <i class="fal fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
                     </a>
                     <a href="{!! route('finance.creditnote.generate',[$code,'print']) !!}" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                        <i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
                     </a>
                     @if($invoices->count() > 0)
                        <a href="#" data-toggle="modal" data-target="#apply-to-invoice" class="btn btn-sm btn-success m-b-10 p-l-5">
                           Apply To Invoice
                        </a>
                     @endif
							<div class="btn-group">
								<button type="button" class="btn btn-default btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									More
								</button>
								<ul class="dropdown-menu dropdown-menu-right">
									{{-- <li><a href="{!! url('/') !!}/storage/files/finance/creditnote/{!! $show->file !!}" target="_blank">View Credit note as customer</a></li> --}}
									<li><a href="#" data-toggle="modal" data-target="#attach-files">Attach Files</a></li>
									{{-- <li><a href="#">Refund</a></li> --}}
									{{-- <li><a href="#">View journal</a></li> --}}
									<li class="divider"></li>
									{{-- <li><a href="#">Cloan Quotes </a></li> --}}
									<li><a href="{!! route('finance.creditnote.delete',$code) !!}" class="text-danger delete">Delete Credit note</a></li>
								</ul>
							</div>
						</span>

						{!! $show->credit_note_prefix !!}{!! $show->credit_note_number !!}
					</div>
					<!-- end invoice-company -->
					<div class="invoice-content">
						@include('templates.'.$template.'.creditnote.preview')
					</div>
					<!-- begin invoice-footer -->
					<div class="invoice-footer">
						<p class="text-center m-b-5 f-w-600">
							THANK YOU FOR YOUR BUSINESS
						</p>
						<p class="text-center">
							@if($show->business_website != "")
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> {!! $show->business_website !!}</span>
							@endif
							@if($show->phone_number)
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> {!! $show->phone_number !!}</span>
							@endif
							@if($show->email)
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> {!! $show->email !!}</span>
							@endif
						</p>
					</div>
					<!-- end invoice-footer -->
				</div>
			</div>
		</div>
	</div>

	<!-- attach files to Quotes -->
	<div class="modal fade" id="attach-files">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Attachment</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="{!! route('finance.creditnote.attachment.files') !!}" class="dropzone" id="my-awesome-dropzone" method="post">
						@csrf()
						<input type="hidden" value="{!! $code !!}" name="creditnoteID">
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
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($files as $count=>$file)
									<tr>
										<td>{!! $count+1 !!}</td>
										<td>
											@if(stripos($file->file_mime, 'image') !== FALSE)
												<center><i class="fas fa-image fa-4x"></i></center>
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
											<a href="{!! asset('businesses/'.Auth::user()->business_code.'/finance/creditnote/'.$file->file_name) !!}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
											<a href="{!! route('finance.creditnote.attachment.delete',$file->id) !!}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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

	@if($invoices->count() > 0)
		<!--- Apply To Invoice -->
		<div class="modal fade" id="apply-to-invoice">
			<div class="modal-dialog modal-lg">
				<form action="{!! route('finance.creditnote.apply.credit') !!}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Apply credits from {!! $show->prefix !!}{!! $show->number !!}</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<table class="table table-bordered table-striped">
								<tr>
									<th>Invoice#</th>
									<th>Date</th>
									<th>Amount</th>
									<th>Balance</th>
									<th width="20%">Amount to credit</th>
								</tr>
								<tbody>
									@foreach ($invoices as $invoice)
										@if($invoice->total != "")
											<tr>
												<td>{!! $invoice->invoice_prefix !!}{!! $invoice->invoice_number !!}</td>
												<td>{!! date('d F, Y', strtotime($invoice->invoice_date)) !!}</td>
												<td>
													{!! $show->currency !!} {!! number_format($invoice->total) !!}
												</td>
												<td>
													{!! $show->currency !!} {!! number_format($invoice->total - $invoice->paid) !!}
												</td>
												<td>
													<input type="number" class="form-control" name="credit[]" required min="0" max="{!! $invoice->total - $invoice->paid !!}">
													<input type="hidden" class="form-control" name="invoiceID[]" value="{!! $invoice->invoice_code !!}">
													<input type="hidden" class="form-control" name="creditnoteID[]" value="{!!$code !!}">
													<input type="hidden" class="form-control" name="clientID" value="{!! $show->customer_code !!}">
												</td>
											</tr>
										@endif
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-pink submit">Apply Credit</button>
							<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none float-right" alt="" width="15%">
						</div>
					</div>
				</form>
			</div>
		</div>
	@endif

@endsection
{{-- page scripts --}}
@section('scripts')
	<script>
		function change_status() {
			var url = '{!! url('/') !!}';
			var status = document.getElementById("status").value;
			var file = document.getElementById("fileID").value;
			$.get(url+'/finance/creditnote/file/'+status+'/'+file, function(data){
				//success data
				location.reload();
			});
		}
	</script>
@endsection
