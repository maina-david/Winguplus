<div class="panel panel-default">
   <div class="panel-body">
      <div class="row">
         <div class="col-md-10">
            <label for="">Search</label>
            <input type="text" wire:model="search" class="form-control" placeholder="Search by customer name, email or phone number">
         </div>
         <div class="col-md-2">
            <div class="form-group">
               @php
                  $currentYear = date("Y");
               @endphp
               <label for="">Year</label>
               <select wire:model="year" class="form-control">
                  <option value="{!! $currentYear !!}">{!! $currentYear !!}</option>
                  <option value="{!! $currentYear-1 !!}">{!! $currentYear-1 !!}</option>
                  <option value="{!! $currentYear-2 !!}">{!! $currentYear-2 !!}</option>
                  <option value="{!! $currentYear-3 !!}">{!! $currentYear-3 !!}</option>
                  <option value="{!! $currentYear-4 !!}">{!! $currentYear-4 !!}</option>
                  <option value="{!! $currentYear-5 !!}">{!! $currentYear-5 !!}</option>
               </select>
            </div>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th width="10%">Invoice #</th>
               <th width="21%">Customer</th>
               <th>Paid</th>
               <th>Balance</th>
               <th>Issue Date</th>
               <th>Due Date</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </thead>
         <tbody>
            @foreach($invoices as $count => $invoice)
               @if($invoice->business_code == Auth::user()->business_code)
                  <tr role="row" class="odd">
                     <td>{{ $count+1 }}</td>
                     <td>
                        @if($invoice->invoice_prefix == ""){{ $invoice->prefix }}@else{{ $invoice->invoice_prefix }}@endif{{ $invoice->invoice_number }}
                     </td>
                     <td>
                        {!! $invoice->customer_name !!}
                     </td>
                     <td>
                        @if( $invoice->paid < 0 )
                           <b class="text-info">{!! $invoice->currency !!}{!! number_format((float)$invoice->main_amount) !!} </b>
                        @else
                           <b class="text-info">{!! $invoice->currency !!}{!! number_format((float)$invoice->paid) !!} </b>
                        @endif
                     </td>
                     <td>
                        @if( $invoice->statusID == 1 )
                           <span class="badge {!! $invoice->statusName !!}">{!! ucfirst($invoice->statusName) !!}</span>
                        @else
                           @if($invoice->balance < 0)
                              <b class="text-primary">0 {!! $invoice->currency !!}</b>
                           @else
                              <b class="text-primary">{!! $invoice->currency !!}{{ number_format(round($invoice->balance)) }}</b>
                           @endif
                        @endif
                     </td>
                     <td>@if($invoice->invoice_date != ""){!! date('M j, Y',strtotime($invoice->invoice_date)) !!}@endif</td>
                     <td>@if($invoice->invoice_due != ""){!! date('M j, Y',strtotime($invoice->invoice_due)) !!}@endif</td>
                     @if((int)$invoice->total - (int)$invoice->paid < 0)
                        <td><span class="badge {!! $invoice->statusName !!}">{!! ucfirst($invoice->statusName) !!}</span></td>
                     @else
                        <td>
                           <span class="badge {!! Helper::seoUrl($invoice->statusName) !!}">{!! ucfirst($invoice->statusName) !!}</span>
                        </td>
                     @endif
                     <td>
                        <div class="btn-group">
                           <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                           <ul class="dropdown-menu">
                              <li><a href="{{ route('finance.invoice.show', $invoice->invoiceCode) }}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                              <li><a href="{!! route('finance.invoice.product.edit', $invoice->invoiceCode) !!}"><i class="fas fa-edit"></i> Edit</a></li>
                              {{-- @if($invoice->subscription_code)
                                 <li><a href="{!! route('subscriptions.edit',$invoice->invoiceCode) !!}" target="_blank"><i class="fas fa-edit"></i> Edit</a></li>
                              @endif --}}
                              <li><a href="{!! route('finance.invoice.delete', $invoice->invoiceCode) !!}" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
                           </ul>
                        </div>
                     </td>
                  </tr>
               @endif
            @endforeach
         </tbody>
      </table>
   </div>
</div>
