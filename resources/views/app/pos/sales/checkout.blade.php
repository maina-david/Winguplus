@extends('layouts.app')
@section('title','Sale Checkout | Point Of Sale')
@section('stylesheet')
   <link href="{!! asset('assets/css/pos.css') !!}" rel="stylesheet" />
   <style>
      .accordion p{
         margin-bottom: 0px;
      }
   </style>
@endsection
@section('sidebar')
	@include('app.pos.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">Point Of Sale</a></li>
         <li class="breadcrumb-item"><a href="{!! route('pos.sell') !!}">Sales</a></li>
         <li class="breadcrumb-item active">Checkout</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shopping-basket"></i> Checkout</h1>
      <!-- begin row -->
      <div class="container">
         <div class="row justify-content-md-center mt-5">
            <div class="col col-md-6">
               <div class="card">
                  <div class="card-body" style="min-height:350px">
                     <h2 class="text-center">Sale Summary</h2>
                     <div class="row mt-3">
                        <div class="col-md-6">
                           <h4 class="float-left">Quantity:</h4>
                        </div>
                        <div class="col-md-6">
                           <h4 class="float-right">{!! number_format($cartItems->sum('qty')) !!}</h4>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <h4 class="float-left">Subtotal:</h4>
                        </div>
                        <div class="col-md-6">
                           <h4 class="float-right">{!! $symbol !!}{!! number_format($cartItems->sum('amount'),2) !!}</h4>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <h4 class="float-left">Discount:</h4>
                        </div>
                        <div class="col-md-6">
                           <h4 class="float-right">{!! $symbol !!}{!! number_format($cartItems->sum('discount'),2) !!}</h4>
                        </div>
                     </div>
                     @if(Session::has('taxRate'))
                        <div class="row">
                           <div class="col-md-6">
                              <h4 class="float-left">Tax:</h4>
                           </div>
                           <div class="col-md-6">
                              <h4 class="float-right">{!! Session::get('taxRate')['rate'] !!}%</h4>
                           </div>
                        </div>
                     @endif
                     <div class="row">
                        <div class="col-md-12">
                          <hr>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <h4 class="float-left font-weight-bold">Total:</h4>
                        </div>
                        <div class="col-md-6">
                           @if(Session::has('taxRate'))
                              @php
                                 $rate = session()->get('taxRate')['rate']/100;
                                 $amount = $cartItems->sum('total_amount') * $rate;
                                 $total = $amount + $cartItems->sum('total_amount');
                              @endphp
                              <h4 class="float-right">{!! $symbol !!}{!! number_format($total,2) !!}</h4>
                           @else
                              <h4 class="float-right">{!! $symbol !!}{!! number_format($cartItems->sum('total_amount'),2) !!}</h4>
                           @endif
                        </div>
                     </div>
                     <div class="row mt-5">
                        <div class="col-md-12 mt-4">
                           <a href="{!! route('pos.sell') !!}" class="btn btn-pink float-right"><i class="fal fa-long-arrow-left"></i> Back To Sale</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col col-md-6">
               <div class="card">
                  <div class="card-body">
                     <h2 class="text-center">Checkout</h2>
                     <form class="col-md-12" method="post" action="{!! route('pos.save.order') !!}">
                        @csrf
                        <div class="form-group">
                           <label for="" class="text-danger">Amount Received</label>
                           @if(Session::has('taxRate'))
                              @php
                                 $rate = session()->get('taxRate')['rate']/100;
                                 $amount = $cartItems->sum('total_amount') * $rate;
                                 $total = $amount + $cartItems->sum('total_amount');
                              @endphp
                              <input type="number" name="amountReceived" value="{!! $total !!}" class="form-control" placeholder="Enter Amount Paid" step="0.01" required>
                           @else
                              <input type="number" name="amountReceived" value="{!! $cartItems->sum('total_amount') !!}" class="form-control" placeholder="Enter Amount Paid" step="0.01" required>
                           @endif
                        </div>
                        <div class="form-group">
                           <label for="">Customer</label>
                           <select class="form-control select2" id="customer" name="customer" required>
                              <option value="">Choose Customer</option>
                              <option value="New" style="color: rgb(5, 129, 47)"><span class="text-success font-weight-bold">New Customer</span></option>
                              @foreach ($customer as $cli)
                                 <option value="{{ $cli->customer_code }}"> {!! $cli->customer_name !!} </option>
                              @endforeach
                           </select>
                        </div>
                        <div id="new-customer" style="display: none">
                           <div class="form-group">
                              <label for="" class="text-danger">Customer Name</label>
                              <input type="text" name="customer_name" class="form-control">
                           </div>
                           <div class="form-group">
                              <label for="">Customer Phone Number</label>
                              <input type="text" name="customer_phone_number" class="form-control">
                           </div>
                           <div class="form-group">
                              <label for="">Customer Email</label>
                              <input type="text" name="customer_email" class="form-control">
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="">Select payment method</label>
                           <select name="payment_method" class="form-control select2" required>
										<option value="">Choose payment method</option>
										@foreach($defaultPaymentTypes as $dp)
											<option value="{!! $dp->method_code !!}">{!! $dp->name !!}</option>
										@endforeach
										@foreach($paymentTypes as $ap)
											<option value="{!! $ap->method_code !!}">{!! $ap->name !!}</option>
										@endforeach
									</select>
                        </div>
                        <div class="form-group mt-3">
                           <center>
                              <button class="btn btn-success submit">Make Payment</button>
                              <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
                           </center>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
<script>
   $(document).ready(function() {
		$('#customer').on('change', function() {
			if (this.value == 'New') {
				$('#new-customer').show();
			} else {
				$('#new-customer').hide();
			}
		});
	});
</script>
@endsection


