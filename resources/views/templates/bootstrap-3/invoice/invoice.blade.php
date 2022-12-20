<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Invoice | {!! $details->prefix !!}{!! $details->number !!}</title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="{!! asset('assets/templates/bootstrap-3/style.css') !!}" media="all" />
</head>
<body class="login-page" style="background: white">
   <div>
      <div class="row">
         <div class="col-xs-4">
            @if ($details->logo != "")
               <img src="{!! asset('businesses/'.$details->business_code.'/documents/images/'.$details->logo)!!}" class="logo" alt="{!! $details->businessName !!}">
            @endif
         </div>
         <div class="col-xs-2"></div>
         <div class="col-xs-6">
            <strong>{!! $details->businessName !!}</strong>
            @if($details->street != "")
               <br>{!! $details->street !!}
            @endif
            @if($details->city != "")
               <br>{!! $details->city !!},
            @endif
            @if($details->country != "")
               <br>{!! $details->country !!},
            @endif
            @if($details->postal_address != "" )
               <br>{!! $details->postal_address !!}
            @endif
            @if($details->postal_address != "" && $details->zip_code != "" )
               {!! $details->zip_code !!}
            @endif
            @if($details->phone_number != "" )
               <br><b>Phone:</b> {!! $details->phone_number !!}
            @endif
            @if($details->email != "" )
               <br><b>Email:</b> {!! $details->email !!}
            @endif
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12 mt-3 mb-3" style="border: 1px solid #ccc!important;">
            <h3 style="text-align: center;font-family: 'Source Sans Pro', sans-serif !important;">Invoice</h3>
         </div>
      </div>
      <br>
      <div class="row">
         <div class="col-xs-6">
            <address>
               <strong>{!! $client->customer_name !!}</strong>
               <span><br>@if($client->bill_state != ""){!! $client->bill_state !!},@endif</span>
               <span>@if($client->bill_city != ""){!! $client->bill_city !!},@endif</span>
               <span>@if($client->bill_street != ""){!! $client->bill_street !!}<br>@endif</span>
               <span>
                  @if($client->bill_street != "")
                     {!! $client->bill_zip_code !!}<br>
                  @endif
                  @if($client->bill_country != "")
                     {!! $client->bill_country !!}<br>
                  @endif
               </span>
               <span><b>Email: </b>@if($client->email != ""){!! $client->email !!}@endif</span>
            </address>
         </div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr>
                     <th>Invoice #</th>
                     <td class="text-right"><b>{!! $details->prefix !!}{!! $details->number !!}</b></td>
                  </tr>
                  @if ($details->reference_number != "")
                     <tr>
                        <th>Reference #</th>
                        <td class="text-right text-uppercase"><b>{!! $details->reference_number !!}</b></td>
                     </tr>
                  @endif
                  <tr>
                     <th>Status</th>
                     <td class="text-right">
                        @if($details->invoiceStatusID == 1)
                           <p style="color:green;font-style: normal;font-weight: bolder;">{!! ucfirst($details->status_name) !!}</p>
                        @else
                        <p style="color:blue;font-style: normal;font-weight: bolder;">{!! ucfirst($details->status_name) !!}</p>
                        @endif
                     </td>
                  </tr>
                  <tr>
                     <th>Issue Date</th>
                     <td class="text-right">{!! date('F j, Y',strtotime($details->invoice_date)) !!}</td>
                  </tr>
                  <tr>
                     <th>Due Date</th>
                     <td class="text-right">{!! date('F j, Y',strtotime($details->invoice_due)) !!}</td>
                  </tr>
               </tbody>
            </table>
            @if($details->invoiceStatusID != 1)
               <div style="margin-bottom: 0px">&nbsp;</div>
               <table style="width: 100%; margin-bottom: 20px">
                  <tbody>
                     @if($details->invoiceStatusID == 3)
                        <tr class="well" style="padding: 5px">
                           <th style="padding: 5px"><div> Balance </div></th>
                           <td style="padding: 5px" class="text-right"><strong> {!! $details->currency !!}{!! number_format($details->balance,2) !!}</strong></td>
                        </tr>
                     @elseif($details->invoiceStatusID == 2)
                        <tr class="well" style="padding: 5px">
                           <th style="padding: 5px"><div> Amount Due </div></th>
                           <td style="padding: 5px" class="text-right"><strong> {!! $details->currency !!}{!! number_format($details->total,2) !!} </strong></td>
                        </tr>
                     @endif
                  </tbody>
               </table>
            @endif
         </div>
      </div>
      <table class="table table-striped table-bordered">
         <thead style="background: #F5F5F5 !important;">
            <tr>
               <th width="1%">#</th>
               <th width="30%">Item</th>
               <th>Quantity</th>
               <th>Price</th>
               @if($details->show_discount_tab == 'Yes')
                  @if($details->discount != "")
                     <th>Discount</th>
                  @endif
               @endif
               @if($details->tax_config != 'Exclusive')
                  @if($details->show_item_tax_tab == 'Yes')
                     <th>Tax</th>
                  @endif
               @endif
               <th>Total</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($products as $count=>$product)
               <tr class="item-row">
                  <td align="center">{{ $count+1 }}</td>
                  <td class="description">
                     @if(Finance::check_product($product->product_code) == 1 )
                        {!! Finance::product($product->product_code)->product_name !!}
                     @else
                        <i>Unknown Product</i>
                     @endif
                  </td>
                  <td>{{ $product->quantity }}</td>
                  <td>
                     {!! $details->currency !!}{{ number_format($product->selling_price,2) }}
                  </td>
                  @if($details->show_discount_tab == 'Yes')
                     @if($details->discount != "")
                        <td>
                           {!! $details->currency !!}{!! number_format($product->discount,2) !!}
                        </td>
                     @endif
                  @endif
                  @if($details->tax_config != 'Exclusive')
                     @if($details->show_item_tax_tab == 'Yes')
                        <td>
                           {{ number_format($product->taxrate) }}%
                        </td>
                     @endif
                  @endif
                  <td>
                     {!! $details->currency !!}{{ number_format($product->total_amount,2) }}
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
      <div class="row">
         <div class="col-xs-6"></div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><div>Amount </div></th>
                     <td style="padding: 5px" class="text-right"><strong>: {!! $details->currency !!}{!! number_format($details->main_amount,2) !!} <strong></td>
                  </tr>
                  @if($details->show_discount_tab == 'Yes')
                     <tr class="well" style="padding: 5px">
                        <th style="padding: 5px"><strong>Discount </strong></th>
                        <td style="padding: 5px" class="text-right">
                           <strong>
                              : {!! $details->currency !!}{!! number_format($details->discount,2) !!}
                           </strong>
                        </td>
                     </tr>
                  @endif
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><div>Sub Total </div></th>
                     <td style="padding: 5px" class="text-right"><strong>: {!! $details->currency !!}{!! number_format($details->sub_total,2) !!} <strong></td>
                  </tr>
                  @if($details->tax_config != 'Exclusive')
                     @if($details->show_tax_tab == 'Yes')
                        <tr class="well" style="padding: 5px">
                           <th style="padding: 5px"><strong>Tax</strong></th>
                           <td style="padding: 5px" class="text-right">
                              <strong>
                                 : {!! $details->currency !!}{!! number_format($details->taxvalue,2) !!}
                              </strong>
                           </td>
                        </tr>
                     @endif
                  @endif
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><strong>TOTAL </strong></th>
                     <td style="padding: 5px" class="text-right">
                        <strong>
                           : {!! $details->currency !!}{!! number_format($details->total,2) !!}
                        </strong>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>

      @if($settings->payment_logs == 'Yes')
         <div style="margin-bottom: 0px !important">&nbsp;</div>
         <div class="row">
               <div class="col-md-12">
                  <h4>Transactions</h4>
                  <table class="table table-striped table-bordered">
                     <tr>
                        <th width="20%">Transaction #</th>
                        <th>Mode of payment</th>
                        <th>Date paid</th>
                        <th>Amount paid</th>
                        <th>Balance</th>
                     </tr>
                     <tbody>
                        @foreach ($payments as $payment)
                           <tr>
                              <td>{!! $payment->reference_number !!}</td>
                              <td>
                                 @if($payment->payment_category == 'Credited')
                                    Credited
                                 @else
                                    @if($payment->payment_method != "")
                                       @if(Finance::check_default_payment_method($payment->payment_method) == 1)
                                          {!! Finance::default_payment_method($payment->payment_method)->name !!}
                                       @else
                                          @if(Finance::check_payment_method($payment->payment_method) == 1)
                                             {!! Finance::payment_method($payment->payment_method)->name !!}
                                          @endif
                                       @endif
                                    @endif
                                 @endif
                              </td>
                              <td>{!! date('M d, Y', strtotime($payment->payment_date)) !!}</td>
                              <td>{!! $details->currency !!}{!! number_format($payment->amount,2) !!} </td>
                              <td>{!! $details->currency !!}{!! number_format($payment->balance,2) !!} </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
         </div>
      @endif

      <div style="margin-bottom: 0px !important">&nbsp;</div>
      <div class="row">
         <div class="col-xs-12 invbody-terms">
            Thank you for your business.
            <br><br>
            @if($details->customer_note != "")
               <div class="notice">
                  <h4><b>Customer Note</b></h4>
                  {!! $details->customer_note !!}
               </div>
            @endif
            @if($details->terms != "")
               <div class="notice">
                  <h4><b>Terms & Conditions</b></h4>
                  {!! $details->terms !!}
               </div>
            @endif
         </div>
      </div>
      <div style="margin-bottom: 0px !important">&nbsp;</div>
      <div class="row">
         <div class="col-xs-12">
            <center>
               <a href="https://winguplus.com/?utm_source={!! Helper::seoUrl($details->businessName) !!}&utm_medium=email&utm_campaign=members" target="_blank">
                  <img src="{!! asset('assets/img/logo-black.png') !!}" alt="winguplus" class="img" width="30%">
               </a>
            </center>
         </div>
      </div>
   </div>
</body>
</html>
