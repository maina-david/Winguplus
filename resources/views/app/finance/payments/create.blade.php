@extends('layouts.app')
{{-- page header --}}
@section('title','Add Payments | Finance')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">Finance</a></li>
      <li class="breadcrumb-item"><a href="{!! route('finance.payments.received') !!}">Payments Received</a></li>
      <li class="breadcrumb-item active">Add Payments</li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-cash-register"></i> Add Payment</h1>
   @include('partials._messages')
   {!! Form::open(array('route' => 'finance.payments.store', 'enctype'=>'multipart/form-data','method' => 'post','autocomplete' => 'off')) !!}
      <div class="row">
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Payment Details</h4>
               </div>
               <div class="panel-body">
                  <div class="form-group form-group-default required">
                     <label class="text-danger">Customer Name</label>
                     <select class="form-group form-control select2" id="client_select" name="customer" required="">
                        <option value="">Choose Customer</option>
                        @foreach ($contacts as $cli)
                           <option value="{{ $cli->customer_code }}">{!! $cli->customer_name !!}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('Amount', 'Amount', array('class'=>'control-label text-danger')) !!}
                           {!! Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' =>'' )) !!}
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
                           <label for="account" class="control-label"> Choose Deposit Account</label>
                           {!! Form::select('account',$accounts, null, array('class' => 'form-control select2')) !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group form-group-default">
                     {!! Form::label('Payment Date', 'Payment Date', array('class'=>'control-label')) !!}
                     {!! Form::date('payment_date', null, array('class' => 'form-control')) !!}
                  </div>
                  <div class="form-group form-group-default">
                     {!! Form::label('Method of payment', 'Method of payment', array('class'=>'control-label')) !!}
                     {!! Form::select('payment_method',$paymentMethod,null,['class'=>'form-control select2']) !!}
                  </div>
                  <div class="form-group form-group-default required">
                     <label class="text-danger">Invoice Number</label>
                     <select class="form-control select2" id="invoice_no" name="invoice" required="">

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
                     <label>Upload Payment Documents</label><br>
                     <input type="file" name="files[]" multiple>
                  </div>
                  <div class="form-group mt-4">
                     {!! Form::label('Notes (Internal use. Not visible to customer)', 'Notes (Internal use. Not visible to customer)', array('class'=>'control-label')) !!}
                     {!! Form::textarea('note',null,['class'=>'form-control tinymcy', 'rows' => 9, 'placeholder'=>'content']) !!}
                  </div>
                  <div class="form-group">
                     <div class="checkbox ">
                        <input type="checkbox" value="yes" id="" name="send_email">
                        <label for="">Send a "thank you" note for this payment</label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="btn-toolbar col-md-12">
            <button type="submit" id="" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit Payment</button>
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
         var url = "{{ url('/') }}"
         var code = "{!! $currency !!}"
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
