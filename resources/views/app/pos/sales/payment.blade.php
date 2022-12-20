@extends('layouts.backend')
{{-- page header --}}
@section('title','Complete Payment')
@section('stylesheet')
  
@endsection
{{-- dashboad menu --}}
@section('sidebar')
	@include('backend.pos.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">POS</a></li>
         <li class="breadcrumb-item"><a href="#">Sales</a></li>
         <li class="breadcrumb-item active">Complete Payment</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-money-bill-wave"></i> Complete Payment</h1>
      <div class="paypal">
         <div id="paypal-button"></div>
      </div>
      <div class="mpesa">
         <h3>Mpesa</h3>
         <a href="{!! route('settings.integrations.payments.mpesa.process',$gatewayID) !!}">Process Mpesa</a>
      </div>
   </div>
@endsection
@section('scripts')

<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
   var baseurl = {!! json_encode(url('/')) !!} ;
   var invoiceID = {!! json_encode($invoiceID) !!} ;
   var getwayID = {!! json_encode($gatewayID) !!};
   paypal.Button.render({
      env: 'sandbox', // Or 'production'
      style:{
         size:'large',
         shape: 'pill'
      },
      // Set up the payment:
      // 1. Add a payment callback
      
      payment: function(data, actions) {
         // 2. Make a request to your server
         return actions.request.post(baseurl +'/api/paypal/create-payment')
         .then(function(res) { 
            // 3. Return res.id from the response
            return res.id;
            invoiceID:   invoiceID
         });
      },
      // Execute the payment:
      // 1. Add an onAuthorize callback
      onAuthorize: function(data, actions) {
         // 2. Make a request to your server
         return actions.request.post(baseurl +'/api/paypal/execute-payment', {
            paymentID: data.paymentID,
            payerID:   data.payerID,
            invoiceID:   invoiceID,
            getwayID:   getwayID
         })
         .then(function(res) {
            console.log(res);
            alert(invoiceID);
            // 3. Show the buyer a confirmation message.
         });
      }
   }, '#paypal-button');
</script>
@endsection
