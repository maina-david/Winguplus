@extends('layouts.backend')
{{-- page header --}}
@section('title','Sale Details')
@section('stylesheet')
   <style>
      /*  receipt */
      #invoice-POS{
         box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
         padding:20px;
         margin: 0 auto;
         width: 100%;
         background: #FFF;
      }

      #top, #mid,#bot{ /* Targets all id with 'col-' */
        border-bottom: 1px solid #EEE;
      }

      #top{min-height: 100px;}
      #mid{min-height: 80px;}
      #bot{ min-height: 50px;}

      #top .logo{
         height: 60px;
         width: 60px;
         background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
         background-size: 60px 60px;
      }
      .clientlogo{
        float: left;
         height: 60px;
         width: 60px;
         background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
         background-size: 60px 60px;
        border-radius: 50px;
      }
      .info{
        display: block;
        margin-left: 0;
      }
      .title{
        float: right;
      }
      .title p{text-align: right;}
      table{
        width: 100%;
        border-collapse: collapse;
      }
      th.tabletitle{
        background: #EEE;
      }
      .service{border-bottom: 1px solid #EEE;}
      .item{width: 24mm;}
      .itemtext{font-size: .5em;}

      #legalcopy{
        margin-top: 5mm;
      }
   </style>
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
         <li class="breadcrumb-item"><a href="{!! route('finance.product.index') !!}">Sales History</a></li>
         <li class="breadcrumb-item active">Sale View</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Sale View</h1>

      <div class="d-flex justify-content-center">
         <div class="col-md-6"> 
            <div class="card">
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-4">
                        <a href="#" class="btn btn-pink btn-block"><i class="fas fa-undo"></i> Return Items</a>
                     </div>
                     <div class="col-md-4">
                        <a href="{!! route('pos.print.receipt',$transaction->id) !!}" class="btn btn-pink btn-block"><i class="fas fa-envelope"></i> Email Receipt</a>
                     </div>
                     <div class="col-md-4">
                        <a href="{!! route('pos.print.receipt',$transaction->id) !!}" class="btn btn-pink btn-block"><i class="fas fa-print"></i> Print Receipt</a>
                     </div>
                  </div>
               </div>
            </div>
            <div id="invoice-POS">
               {{-- <center id="top">
                  <div class="logo"></div> f
                  <div class="info">
                     <h2>SBISTechs Inc</h2>
                  </div>
               </center> --}}
               <div id="mid" class="text-center mb-3">
                  <div class="info">
                     <h5>
                        {!! $business->name !!}</br>
                        {!! $business->street !!},{!! $business->city !!}</br>
                        {!! $business->postal_address !!} - {!! $business->zip_code !!}</br>
                        Phone: {!! $business->primary_phonenumber !!}</br>
                        Email: {!! $business->primary_email !!}
                     </h5>
                  </div>
               </div>
               <div class="receipt-info mt-3">
                  <p>
                     <b>TransactionID :</b> <span class="text-uppercase">{!! $transaction->transactionID !!}</span><br>
                     <b>You were served by :</b> {!! Limitless::user($transaction->userID)->name !!} <br>
                     <b>Date Time : </b> {!! date("F j, Y, g:i a", strtotime($transaction->created_at)) !!} </br>
                     <b>Payment method :
                        @if(Finance::check_payment($transaction->id) > 0)
                           @if(Finance::check_payment_method(Finance::invoice_payment($transaction->id)->payment_method) == 1)
                              {!! Finance::payment_method(Finance::invoice_payment($transaction->id)->payment_method)->name !!}
                           @else
                              <i>Unknown method</i>
                           @endif
                        @else
                           <i>Unknown method</i>
                        @endif
                     </b>
                  </p>
               </div>
               <!--End Invoice Mid-->
               <hr>
               <div id="bot">
                  <div id="table">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Item</th>
                              <th>Qty</th>
                              <th>Price</th>
                              <th>Amount</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($items as $item)
                              <tr>
                                 <td class="no">{{ $count++ }}</td>
                                 <td class="desc">
                                    {!! Finance::product($item->productID)->product_name !!}
                                 </td>
                                 <td class="unit">
                                    {!! $item->quantity !!}
                                 </td>
                                 <td class="qty">{{ number_format($item->selling_price) }}</td>
                                 <td class="total">@php echo number_format($item->quantity * $item->selling_price) @endphp
                                    @if($business->base_currency != "")
         										{!! Finance::currency($business->base_currency)->code !!}
         									@endif
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                           <tr>
                              <td colspan="2"></td>
                              <td colspan="2"><strong>Sub Total :</strong></td>
                              <td>
                                 {!! number_format($transaction->total) !!}.00
                                 @if($business->base_currency != "")
                                    {!! Finance::currency($business->base_currency)->code !!}
                                 @endif
                              </td>
                           </tr>
                           {{-- @if(Finance::estimate()->show_tax_tab == 'Yes')
                              <tr>
                                 <td colspan="2"></td>
                                 <td colspan="2"><strong>Tax - {!! $details->tax !!}% :</strong></td>
                                 <td>
                                    {!! $taxed !!}  {!! Finance::currency($details->currencyID)->code !!}
                                 </td>
                              </tr>
                           @endif --}}
                           <tr>
                              <td colspan="2"></td>
                              <td colspan="2"><strong>TOTAL :</strong></td>
                              <td>
                                 {!! number_format($transaction->total) !!}.00
                                 @if($business->base_currency != "")
                                    {!! Finance::currency($business->base_currency)->code !!}
                                 @endif
                              </td>
                           </tr>
                        </tfoot>
                     </table>
                  </div><!--End Table-->
                  {{-- <div id="legalcopy">
                     <p class="legal">
                        <strong>Thank you for your business!</strong> 
                        Payment is expected within 31 days; please process this invoice within that time. There will be a 5% interest charge per month on late invoices.
                     </p>
                  </div> --}}
               </div>
               <!--End InvoiceBot-->
            </div>
            <!--End Invoice-->
         </div>
      </div>
   </div>

@endsection
