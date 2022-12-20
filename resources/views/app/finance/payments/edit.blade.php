@extends('layouts.app')
{{-- page header --}}
@section('title','Finance | Update Payment')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
			<li class="breadcrumb-item"><a href="{!! route('finance.payments.received') !!}">Payments Received</a></li>
			<li class="breadcrumb-item active">Update Payments</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Update Payment</h1>
		@include('partials._messages')
		{!! Form::model($payment, ['route' => ['finance.payments.update',$payment->payment_code], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Payment Details</h4>
						</div>
						<div class="panel-body">
							<div class="form-group">
								{!! Form::label('Customer Name', 'Customer Name', array('class'=>'control-label text-danger')) !!}
								<select class="form-group form-control select2" id="client_select" name="customer" required="">
									<option value="{!! $payment->customer_code !!}">{!! $payment->customer_name !!}</option>
									@foreach($customers as $customer)
										<option value="{{ $customer->customer_code }}">{!! $customer->customer_name !!}</option>
									@endforeach
								</select>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default required">
										{!! Form::label('Amount', 'Amount', array('class'=>'control-label text-danger')) !!}
										{!! Form::text('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' =>'' )) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('Bank Charges (if any)', 'Bank Charges (if any)', array('class'=>'control-label')) !!}
										{!! Form::text('bank_charges', null, array('class' => 'form-control', 'placeholder' => 'Bank Charges (if any)')) !!}
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group form-group-default">
										<label for="account" class="control-label"> Choose Deposit Account </label>
										{!! Form::select('account',$accounts, null, array('class' => 'form-control select2')) !!}
									</div>
								</div>
							</div>
							<div class="form-group form-group-default required">
								{!! Form::label('Payment Date', 'Payment Date', array('class'=>'control-label text-danger')) !!}
								{!! Form::date('payment_date', null, array('class' => 'form-control','required' =>'' )) !!}
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Method of payment', 'Method of payment', array('class'=>'control-label')) !!}
                        {!! Form::select('payment_method',$paymentMethod,null,['class'=>'form-control select2']) !!}
							</div>
							<div class="form-group form-group-default required">
								<label class="text-danger">Invoice Number</label>
								<select class="form-control select2" id="invoice_no" name="invoice" required>
									<option value="{!! $invoice->invoice_code !!}">{!! $invoice->invoice_title !!} | {!! $invoice->invoice_prefix.$invoice->invoice_number !!} | {!! $payment->currency.$invoice->balance !!}</option>
								</select>
							</div>
                     <div class="form-group form-group-default">
                        <label>Transaction ID / Reference Number</label>
                        {!! Form::text('reference_number', null, array('class' => 'form-control', 'placeholder' => 'Enter Transaction ID / Reference Number')) !!}
                     </div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Payment Details</h4>
						</div>
						<div class="panel-body">
							<div class="form-group">
								{!! Form::label('Notes (Internal use. Not visible to customer)', 'Notes (Internal use. Not visible to customer)', array('class'=>'control-label')) !!}
								{!! Form::textarea('note',null,['class'=>'form-control tinymcy', 'rows' => 10, 'placeholder'=>'content']) !!}
							</div>
							<div class="form-group">
								<label>Upload Payment Documents</label><br>
								<input type="file" name="files[]" multiple>
							</div>
							<div class="row">
                        @foreach ($files as $file)
									<div class="col-md-2">
										@if(stripos($file->file_mime, 'image') !== FALSE)
											<img src="{!! asset('businesses/'.$payment->business_code.'/finance/payments/'.$file->file_name) !!}" alt="" style="width:100%;height:80px">
										@elseif(stripos($file->file_mime, 'pdf') !== FALSE)
											<center><i class="fas fa-file-pdf fa-4x" style="width:100%;height:80px"></i></center>
										@elseif(stripos($file->file_mime, 'octet-stream') !== FALSE)
											<center><i class="fas fa-file-alt fa-4x" style="width:100%;height:80px"></i></center>
										@elseif(stripos($file->file_mime, 'officedocument') !== FALSE)
											<center><i class="fas fa-file-word fa-4x" style="width:100%;height:80px"></i></center>
										@else
											<center><i class="fas fa-file fa-4x" style="width:100%;height:80px"></i></center>
										@endif
										<center>
											<a href="{!! route('finance.payment.file.delete', $file->id) !!}" title="delete" class="label label-danger delete"><i class="fas fa-trash"></i></a>
											<a href="{!! route('finance.payment.file.download', $file->id) !!}" title="download" class="label label-primary mt-1"><i class="fas fa-download"></i></a>
											<a href="{!! asset('businesses/'.$payment->business_code.'/finance/payments/'.$file->file_name) !!}" title="view" class="label label-warning mt-1" target="_blank"><i class="fas fa-eye"></i></a>
										</center>
									</div>
                        @endforeach
                     </div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<button type="submit" id="" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Payment</button>
					<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
				</div>
			</div>
		{{ Form::close() }}
	</div>
@endsection
{{-- page scripts --}}
@section('scripts')
	<script type="text/javascript">
		$('#client_select').on('change',function(e){
			console.log(e);
			var client_code =  e.target.value;
			var url = "{{ url('/') }}";
         var code = "{{ $currency }}";
			//ajax
			$.get(url+'/finance/retrive_client/'+client_code, function(data){
				//success data
				//
				$('#invoice_no').empty();
				$.each(data, function(invoices, info){
					$('#invoice_no').append('<option value="'+ info.invoice_code +'">'+info.invoice_title+' | '+info.invoice_prefix+''+info.invoice_number+' | '+code+''+info.balance+'</option>');
				});
			});
		});
	</script>
@endsection
