@extends('layouts.app')
{{-- page header --}}
@section('title','View Order')

{{-- dashboad menu --}}
@section('sidebar')
   @include('app.ecommerce.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('ecommerce.dashboard') !!}">E-commerce</a></li>
         <li class="breadcrumb-item"><a href="{!! route('ecommerce.orders.index') !!}">Orders</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Order #{!! $order->invoice_code !!}</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-8">
            <table class="table table-bordered bg-white">
               <tr>
                  <td>
                     <p>Order Date<br>{!! date('F jS, Y', strtotime($order->invoice_date)) !!}</p>
                  </td>
                  <td>
                     <p>Payment Status<br>
                        @if((int)$order->total - (int)$order->paid < 0)
                           <span class="badge {!! $order->status_name !!}">{!! ucfirst($order->status_name) !!}</span>
                        @else
                           <span class="badge {!! Helper::seoUrl($order->status_name) !!}">{!! ucfirst($order->status_name) !!}</span>
                        @endif
                     </p>
                  </td>
                  <td>
                     <p>Delivery Date<br>
                        @if($order->delivery_date != "")
                           {!! date('F jS, Y', strtotime($order->delivery_date)) !!}
                        @endif
                     </p>
                  </td>
                  <td>
                     <p>
                        Delivery Status<br>

                     </p>
                  </td>
               </tr>
            </table>
            <div class="panel panel-default">
               <div class="panel-heading">Order details <a href="#" class="badge badge-primary float-right">Change status</a></div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th>Product</th>
                              <th>Price</th>
                              <th>Qty</th>
                              <th>Total</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($products as $item)
                              <tr>
                                 <td>
                                    @if(Finance::check_product_image($item->proID) == 1)
                                       <img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID .'/finance/products/'.Finance::product_image($item->proID)->file_name) !!}" width="80px" height="60px">
                                    @else
                                       <img src="{!! asset('assets/img/product_placeholder.jpg') !!}" width="80px" height="60px">
                                    @endif<br>
                                    {!! $item->product_name !!}
                                 </td>
                                 <td>{!! $order->currency !!}{!! number_format($item->selling_price,2) !!}</td>
                                 <td>{!! $item->quantity !!}</td>
                                 <td>{!! $order->currency !!}{!! number_format($item->total_amount,2) !!}</td>
                              </tr>
                           @endforeach
                           <tr>
                              <td colspan="1">&nbsp;</td>
                              <td colspan="4"><b>TOTAL AMOUNT</b></td>
                           </tr>

                           <tr>
                              <td colspan="1">&nbsp;</td>
                              <td colspan="1"><b>Subtotal</b></td>
                              <td class="" colspan="2">:{!! $order->currency !!}{!! number_format($order->main_amount,2)  !!}</td>
                           </tr>
                           <tr>
                              <td colspan="1">&nbsp;</td>
                              <td colspan="1"><b>Discount</b></td>
                              <td class="" colspan="2">:{!! $order->currency !!}{!! number_format($order->discount,2)  !!}</td>
                           </tr>
                           <tr>
                              <td colspan="1">&nbsp;</td>
                              <td colspan="1"><b>Tax</b></td>
                              <td class="" colspan="2">:{!! $order->currency !!}{!! number_format($order->tax_value,2)  !!}</td>
                           </tr>
                           {{-- <tr class="mw-ui-table-footer">
                              <td colspan="2">&nbsp;</td>
                              <td colspan="2">Shipping price</td>
                              <td class="" colspan="2">$ 0.00</td>
                           </tr>              --}}
                           <tr class="mw-ui-table-footer last">
                              <td colspan="1">&nbsp;</td>
                              <td colspan="1" class=""><strong><b>Total</b></strong></td>
                              <td class="" colspan="2"><strong>:{!! $order->currency !!} {!! number_format($order->total,2)  !!}</strong></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">Order Note</div>
               <div class="panel-body">
                  {!! $order->note_1 !!}
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="panel panel-default">
               <div class="panel-heading">Billing Details </div>
               <div class="panel-body">
                  <ul class="order-table-info-list">
                     <li><strong>Name:</strong> {!! $client->customer_name !!}</li>
                     <li><strong>Email:</strong> {!! $client->email !!}</li>
                     <li><strong>Phone Number:</strong> {!! $client->primary_phone_number !!}</li>
                  </ul>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">Shipping Address </div>
               <div class="panel-body">
                  <ul class="order-table-info-list">
                     <li><strong>Country:</strong> @if($order->shipping_country != ""){!! Wingu::country($order->shipping_country)->name !!}@endif</li>
                     <li><strong>Shipping Address:</strong> {!! $order->note_2 !!}</li>
                  </ul>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">Client Information</div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td width="40%"><b>Customer Name</b></td>
                              <td>: <a href="#">{!! $client->customer_name !!}</a></td>
                           </tr>
                           <tr>
                              <td width="40%"><b>Email</b></td>
                              <td>: <a href="{!! $client->email !!}">{!! $client->email !!}</a></td>
                           </tr>
                           <tr>
                              <td width="40%"><b>Phone Number</b></td>
                              <td>: <b>{!! $client->phone_number !!}</b></td>
                           </tr>
                           <tr>
                              <td width="40%"><b>Gender</b></td>
                              <td>: <b>{!! $client->gender !!}</b></td>
                           </tr>
                           <tr>
                              <td width="40%"><b>User IP</b></td>
                              <td>: {!! $client->ip !!}</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
