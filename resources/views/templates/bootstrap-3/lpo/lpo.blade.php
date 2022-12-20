<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Purchase Order | {!! $details->lpo_prefix !!}{!! $details->lpo_number !!}</title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="{!! asset('assets/templates/bootstrap-3/style.css') !!}" media="all" />

   <style>
      .text-right {
         text-align: right;
      }
   </style>
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
            <strong>{!! $details->business_name !!}</strong>
            @if($details->street != "")
            <br>{!! $details->street !!}
            @endif
            @if($details->city != "")
            <br>{!! $details->city !!},
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
         <div class="col-xs-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
            <h4 style="text-align: center">Purchase Order</h4>
         </div>
      </div>
      <br>
      <div class="row">
         <div class="col-xs-6">
            <address>
               <strong>{!! $supplier->supplier_name !!}</strong>
               <span>@if($supplier->bill_state != "")<br>{!! $supplier->bill_state !!},@endif</span>
               <span>@if($supplier->bill_city != "")<br>{!! $supplier->bill_city !!},@endif</span>
               <span>@if($supplier->bill_street != "")<br>{!! $supplier->bill_street !!}<br>@endif</span>
               <span>
                  @if($supplier->bill_street != "")
                     {!! $supplier->bill_zip_code !!}<br>
                  @endif
                  @if($supplier->bill_country != "")
                     {!! Wingu::country($supplier->bill_country)->name !!}<br>
                  @endif
               </span>
               <span><b>Email: </b>@if($supplier->email != ""){!! $supplier->email !!}@endif</span>
            </address>
         </div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr>
                     <th><b>Purchase Order #</b></th>
                     <td>: {!! $details->lpo_prefix !!}{!! $details->lpo_number !!}</td>
                  </tr>
                  @if ($details->reference_number != "")
                     <tr>
                        <th><b>Reference #</b></th>
                        <td class="text-uppercase">: {!! $details->reference_number !!}</td>
                     </tr>
                  @endif
                  <tr>
                     <th><b>Status</b></th>
                     <td>
                        : <span class="badge {!! $details->status_name !!}">{!! $details->status_name !!}</span>
                     </td>
                  </tr>
                  <tr>
                     <th><b>Issue Date</b></th>
                     <td>: {!! date('F j, Y',strtotime($details->lpo_date)) !!}</td>
                  </tr>
                  <tr>
                     <th>Expected Delivery Date</th>
                     <td>: {!! date('F j, Y',strtotime($details->lpo_due)) !!}</td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <table class="table table-striped table-bordered">
         <thead style="background: #F5F5F5 !important;">
            <tr>
               <th width="1%">#</th>
               <th width="30%">Item</th>
               <th>Quantity</th>
               <th>Price</th>
               <th>Total</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($products as $count=>$product)
               <tr class="item-row">
                  <td align="center">{{ $count+1 }}</td>
                  <td class="description">
                     {{ $product->product_name }}
                  </td>
                  <td>{{ $product->quantity }}</td>
                  <td>
                     {!! $details->currency !!}{{ number_format($product->price) }}
                  </td>
                  <td>
                     {!! $details->currency !!}{{ number_format($product->total) }}
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
                     <th style="padding: 5px"><div>Sub Total </div></th>
                     <td style="padding: 5px" class="text-right"><strong>{!! $details->code !!} {!! number_format($details->sub_total) !!}<strong></td>
                  </tr>
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><strong>TOTAL </strong></th>
                     <td style="padding: 5px" class="text-right">
                        <strong>
                           {!! $details->code !!} {!! number_format($details->total) !!}
                        </strong>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div style="margin-bottom: 0px !important">&nbsp;</div>
      <div class="row">
         <div class="col-md-12 invbody-terms">
            @if($details->customer_note != "")
               <div class="notice">
                  <h4><b>Supplier Note</b></h4>
                  {!! $details->customer_note !!}
               </div>
            @endif
            @if($details->terms != "")
               <div class="notice">
                  <h4><b>Terms & Conditions</b></h4>
                  {!! $details->terms !!}
               </div>
            @endif
            <br><br>
            Thank you for your business.
         </div>
      </div>
   </div>
</body>
</html>
