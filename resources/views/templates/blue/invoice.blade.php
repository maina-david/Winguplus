<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Invoice | {!! Finance::invoice_settings()->prefix !!}00{!! $details->number !!}</title>
      <link rel="stylesheet" href="{!! url('/') !!}/resources/views/templates/blue/style.css" media="all" />
   </head>
   <body>
      <header class="clearfix">
         <div id="logo">
            @if (Limitless::business(Auth::user()->businessID)->logo != "")
               <img src="{!! url('/') !!}/storage/files/business/{!! Limitless::business(Auth::user()->businessID)->primary_email !!}/documents/images/{!! Limitless::business(Auth::user()->businessID)->logo !!}">
            @endif
         </div>
         <div id="company">
            <h2 class="name">{!! Limitless::business(Auth::user()->businessID)->name !!}</h2>
            <div>{!! Limitless::business(Auth::user()->businessID)->street !!},{!! Limitless::business(Auth::user()->businessID)->city !!}</div>
            <div> {!! Limitless::business(Auth::user()->businessID)->zip_code !!}</div>
            <div>Phone: {!! Limitless::business(Auth::user()->businessID)->primary_phonenumber !!}</div>
            <div>Email: {!! Limitless::business(Auth::user()->businessID)->primary_email !!}</div>
         </div>
      </header>
      <main>
         <div id="details" class="clearfix">
            <div id="client">
               <div class="to">INVOICE TO:</div>
               <h2 class="name">@if($client->company_name != ""){!! $client->company_name !!}@else{!! $client->client_name !!}@endif</h2>
               <div class="address">
                  @if($client->bill_street != ""){!! $client->bill_street !!}<br>@endif
                  @if($client->bill_country != "")
                     {!! Limitless::country($client->countryID)->name !!}
                  @endif
               </div>
               <div class="email"><a href="mailto:{!! $client->email !!}">{!! $client->email !!}</a></div>
            </div>
            <div id="invoice">
               <h1>INVOICE</h1>
               @if($details->status == 1)
                  <a href="#" class="btn btn-success">Paid</a>
               @endif
               <h3>#{!! Finance::invoice_settings()->prefix !!}00{!! $details->invoice_number !!}</h3>
               <div class="date"><b>Date of Invoice:</b> {!! date('F j, Y',strtotime($details->invoice_date)) !!}</div>
               <div class="date"><b>Due Date:</b> {!! date('F j, Y',strtotime($details->invoice_due)) !!}</div>
            </div>
         </div>
         <table border="0" cellspacing="0" cellpadding="0">
            <thead>
               <tr>
                  <th class="no">#</th>
                  <th class="desc">DESCRIPTION</th>
                  <th class="unit">UNIT PRICE</th>
                  <th class="qty">QUANTITY</th>
                  <th class="total">TOTAL</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($products as $product)
                  <tr>
                     <td class="no">{{ $count++ }}</td>
                     <td class="desc">

                        @if($product->productID == 0)
                           {{ $product->product_name }}
                        @else
                           @if(Finance::check_product($product->productID) == 1 )
                              <strong>{!! Finance::product($product->productID)->product_name !!}</strong>
                           @else
                              <i>Unknown Product</i>
                           @endif
                        @endif
                     </td>
                     <td class="unit">{{ number_format($product->selling_price) }} {!! Finance::currency($details->currencyID)->code !!}</td>
                     <td class="qty">{{ $product->quantity }}</td>
                     <td class="total">@php echo number_format($product->quantity * $product->selling_price) @endphp {!! Finance::currency($details->currencyID)->code !!}</td>
                  </tr>
               @endforeach
            </tbody>
            <tfoot>
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2"><strong>Sub Total :</strong></td>
                  <td>{!! number_format($details->sub_total) !!}.00 {!! Finance::currency($details->currencyID)->code !!}</td>
               </tr>
               @if(Finance::invoice_settings()->show_discount_tab == 'Yes')
                  <tr>
                     <td colspan="2"></td>
                     <td colspan="2"><strong>Discount :</strong></td>
                     <td>
                        @php echo $details->sub_total * ($details->discount / 100)  @endphp {!! Finance::currency($details->currencyID)->code !!}
                     </td>
                  </tr>
               @endif
               @if(Finance::invoice_settings()->show_tax_tab == 'Yes')
                  <tr>
                     <td colspan="2"></td>
                     <td colspan="2"><strong>Tax - {!! $details->tax !!}% :</strong></td>
                     <td>
                        {!! $taxed !!}  {!! Finance::currency($details->currencyID)->code !!}
                     </td>
                  </tr>
               @endif
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2"><strong>TOTAL :</strong></td>
                  <td>{!! number_format($details->total) !!}.00 {!! Finance::currency($details->currencyID)->code !!}</td>
               </tr>
            </tfoot>
         </table>
         @if($details->invoice_note != "")
            <div class="notice">
               Client Note
               {!! $details->invoice_note !!}
            </div>
         @endif
         @if($details->terms != "")
            <div class="notice">
               <h4>Terms & Conditions</h4>
               {!! $details->terms !!}
            </div>
         @endif
         <div id="thanks">Thank you!</div>
         <center><button class='btn btn-pink no-print'  onClick="window.print();">Click Here to Print or save as print-to-PDF</button></center>
      </main>
   </body>
</html>
