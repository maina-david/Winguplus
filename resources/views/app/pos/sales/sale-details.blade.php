@extends('layouts.app')
@section('title'){!! $invoice->invoice_prefix !!}{!! $invoice->invoice_number !!} | POS @endsection
@section('stylesheet')

@endsection
@section('sidebar')
	@include('app.pos.partials._menu')
@endsection
@section('content')
<div id="content" class="content">
   @include('partials._messages')
   <div class="row">
      <div class="col-md-4 mb-2">
         <div class="mt-4">
            <h4 class="text-center">Payment Summary</h4>
            <div class="widget-list widget-list-rounded m-b-30" data-id="widget">
               @foreach($payments as $payment)
                  <!-- begin widget-list-item -->
                  <div class="widget-list-item mb-2">
                     <div class="widget-list-content">
                        {{-- <h4 class="widget-list-title font-weight-bold">{!! $payment->reference_number !!}</h4> --}}
                        <p class="widget-list-desc">
                           @if($payment->amount != "")
                           Payement date: <b>{!! date('F jS, Y',strtotime($payment->payment_date)) !!}</b><br>
                           @endif
                           @if($payment->amount != "")
                           Amount: <b> {!! $invoice->symbol !!}{!! number_format($payment->amount) !!}</b><br>
                           @endif
                           @if($payment->created_by != "")
                           Recorded by: <b>{!! Wingu::user($payment->created_by)->name !!}</b>
                           @endif
                        </p>
                     </div>
                     {{-- <div class="widget-list-action">
                        <a href="#" data-toggle="dropdown" class="text-muted pull-right" aria-expanded="false"><i class="fa fa-ellipsis-h f-s-14"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(415px, 72px, 0px);">
                           <li><a href="{{ route('finance.payments.show',$payment->id) }}"><i class="far fa-edit"></i> View</a></li>
                           <li><a href="{{ route('finance.payments.delete',$payment->id) }}" class="delete"><i class="fas fa-trash"></i> Delete</a></li>
                        </ul>
                     </div> --}}
                  </div>
               @endforeach
            </div>
         </div>
      </div>
      <div class="col-md-8">
         <div class="row">
            <div class="col-md-12">
                  <button data-toggle="modal" data-target=".bd-example-modal-sm" class="btn btn-sm btn-success m-b-10 p-l-5"> <i class="fal fa-paper-plane t-plus-1 fa-fw fa-lg"></i> Email</button>
               <a href="{!! route('pos.sale.receipt.print', $invoice->invoice_code) !!}" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                  <i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
               </a>
               {{-- <a href="#" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                  <i class="fal fa-gift t-plus-1 fa-fw fa-lg"></i> Gift Receipt
               </a> --}}
               {{-- <a href="#" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                  <i class="fal fa-sync-alt t-plus-1 fa-fw fa-lg"></i> Exchange
               </a> --}}
               <a href="#" class="btn btn-pink btn-sm m-b-10 p-l-5" data-toggle="modal" data-target="#payment"><i class="fa fa-plus"></i> Add Payments</a>

            </div>
            <div class="col-md-12">
               <div class="card">
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-6">
                           <h5><b>Customer Name :</b> {!! $client->customer_name !!}</h5>
                           {{-- <h5>Sales Person : {!! Wingu::user($invoice->created_by)->name !!}</h5> --}}
                        </div>
                        <div class="col-md-6">
                           <h5>Order Date : {!! date('F jS, Y', strtotime($invoice->invoice_date)) !!}</h5>
                        </div>
                        <div class="col-md-12">
                           <hr>
                        </div>
                        <div class="col-md-12">
                           <table class="table  table-striped">
                              <thead>
                                 <th width="1%">#</th>
                                 <th>Product</th>
                                 <th>Qty</th>
                                 <th>Price per Item</th>
                                 <th>Amount</th>
                              </thead>
                              <tbody>
                                 @foreach($products as $product)
                                    <tr>
                                       <td>{!! $count++ !!}</td>
                                       <td>{!! $product->product_name !!}</td>
                                       <td>{!! $product->quantity !!}</td>
                                       <td>{!! $invoice->symbol !!}{!! number_format($product->selling_price,2) !!}</td>
                                       <td>{!! $invoice->symbol !!}{!! number_format($product->total_amount,2) !!}</td>
                                    </tr>
                                 @endforeach
                              </tbody>
                           </table>
                           <div class="row">
                              <div class="col-md-6 offset-md-6">
                                 <table class="table table-striped">
                                    <tr>
                                       <th>Discount</th>
                                       <th>{!! $invoice->symbol !!}{!! number_format($invoice->discount) !!}</th>
                                    </tr>
                                    <tr>
                                       <th>Subtotal</th>
                                       <th>{!! $invoice->symbol !!}{!! number_format($invoice->sub_total) !!}</th>
                                    </tr>
                                    <tr>
                                       <th>Tax ({!! $invoice->taxRate !!}%)</th>
                                       <th>{!! $invoice->symbol !!}{!! number_format($invoice->taxvalue) !!}</th>
                                    </tr>
                                    <tr>
                                       <th>Total</th>
                                       <th>{!! $invoice->symbol !!}{!! number_format($invoice->total) !!}</th>
                                    </tr>
                                    <tr>
                                       <th>Paid</th>
                                       <th>{!! $invoice->symbol !!}{!! number_format($invoice->total) !!}</th>
                                    </tr>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-body">
            <form class="" method="POST" action="{!! route('pos.sale.receipt.mail') !!}">
               @csrf
               <div class="form-group">
                  <label for="">Enter Email</label>
                  <input type="email" class="form-control" name="email" placeholder="email" required>
                  <input type="hidden" name="saleID" value="{!! $invoice->invoice_code !!}" required>
               </div>
               <div class="form-group">
                  <center>
                     <button class="btn btn-success submit btn-sm" type="submit"><i class="fas fa-save"></i> Send Receipt</button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="35%">
                  </center>
               </div>
            </form>
         </div>
      </div>
   </div>
 </div>
@endsection
@section('scripts')

@endsection
