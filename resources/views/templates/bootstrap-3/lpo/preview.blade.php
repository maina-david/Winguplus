<div class="row">
   <div class="col-md-4">
      @if ($lpo->logo != "")
         <img src="{!! asset('businesses/'.$lpo->business_code.'/documents/images/'.$lpo->logo) !!}" class="logo" alt="{!! $lpo->business_name !!}" style="width:70%">
      @endif
   </div>
   <div class="col-md-4">
   </div>
   <div class="col-md-4">
      <p>
         <strong>{!! $lpo->business_name !!}</strong>
         @if($lpo->street != "")
         <br>{!! $lpo->street !!}<br>
         @endif
         @if($lpo->city != "")
            {!! $lpo->city !!},
         @endif
         @if($lpo->postal_address != "" )
            {!! $lpo->postal_address !!}
         @endif
         @if($lpo->postal_address != "" && $lpo->zip_code != "" )
            - {!! $lpo->zip_code !!}
         @endif
         <br>
         <b>Phone:</b> {!! $lpo->phone_number !!}<br>
         <b>Email:</b> {!! $lpo->email !!}
      </p>
   </div>
</div>
<div class="row">
   <div class="col-md-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
      <h3 style="text-align: center">Purchase Order</h3>
   </div>
</div>
<div class="row">
   <div class="col-md-4">
      <address>
         <strong>{!! $supplier->supplier_name !!}</strong><br>
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
   <div class="col-md-4"></div>
   <div class="col-md-4">
      <table style="float:left">
         <tbody>
            <tr>
               <th><b>purchase orders #</b></th>
               <td>: {!! $lpo->lpo_prefix !!}{!! $lpo->lpo_number !!}</td>
            </tr>
            @if ($lpo->reference_number != "")
               <tr>
                  <th><b>Reference #</b></th>
                  <td class="text-uppercase">: {!! $lpo->reference_number !!}</td>
               </tr>
            @endif
            <tr>
               <th><b>Status</b></th>
               <td>
                  : <span class="badge {!! $lpo->status_name !!}">{!! $lpo->status_name !!}</span>
               </td>
            </tr>
            <tr>
               <th><b>Issue Date</b></th>
               <td>: {!! date('F j, Y',strtotime($lpo->lpo_date)) !!}</td>
            </tr>
            <tr>
               <th>Expected Delivery Date</th>
               <td>: {!! date('F j, Y',strtotime($lpo->lpo_due)) !!}</td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<table class="table table-striped table-bordered mt-3">
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
               {!! $lpo->currency !!}{{ number_format($product->price) }}
            </td>
            <td>
               {!! $lpo->currency !!}{{ number_format($product->total) }}
            </td>
         </tr>
      @endforeach
   </tbody>
</table>
<div class="row">
   <div class="col-md-6"></div>
   <div class="col-md-6">
      <table class="table table-striped">
         <tbody>
            <tr>
               <th>Sub Total</th>
               <td><strong>: {!! $lpo->currency !!} {!! number_format($lpo->sub_total) !!} <strong></td>
            </tr>
            <tr>
               <th><strong>Total Amount</strong></th>
               <td>
                  <strong>
                     : {!! $lpo->currency !!} {!! number_format($lpo->total) !!}
                  </strong>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<div class="row">
   <div class="col-md-12 invbody-terms">
      @if($lpo->customer_note != "")
         <div class="notice">
            <h4><b>Supplier Note</b></h4>
            {!! $lpo->customer_note !!}
         </div>
      @endif
      @if($lpo->terms != "")
         <div class="notice">
            <h4><b>Terms & Conditions</b></h4>
            {!! $lpo->terms !!}
         </div>
      @endif
      <br><br>
      Thank you for your business.
   </div>
</div>
