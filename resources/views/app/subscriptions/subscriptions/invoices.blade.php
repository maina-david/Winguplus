<div class="row mt-3">
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <table class="table table-bordered table-striped">
               <thead>
                  <th width="1%">#</th>
                  <th>Invoice #</th>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Balance</th>
                  <th>Paid</th>
                  <th>Status</th>
                  <th>Action</th>
               </thead>
               <tbody>
                  @foreach($invoices as $invoice)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td><b>{{ $invoice->prefix }}{{ $invoice->invoice_number }}</b></td>
                        <td>{!! date('M j, Y',strtotime($invoice->invoice_date)) !!}</td>
                        <td><b class="text-info">{!! $invoice->symbol !!} {!! number_format((float)$invoice->total) !!} </b></td>
                        <td class="v-align-middle">
                           @if($invoice->statusID == 1 )
                              <span class="badge {!! $invoice->statusName !!}">{!! ucfirst($invoice->statusName) !!}</span>
                           @else
                              <b class="text-primary"> {!! $invoice->symbol !!} @if($invoice->balance < 0)0 @else{{ number_format(round($invoice->balance)) }}@endif</b>
                           @endif
                        </td>
                        <td><b class="text-info">{!! $invoice->symbol !!} {!! number_format((float)$invoice->paid) !!} </b></td>
                        @if((int)$invoice->total - (int)$invoice->paid < 0)
                           <td><span class="badge {!! $invoice->statusName !!}">{!! ucfirst($invoice->statusName) !!}</span></td>
                        @else
                           <td>
                              <span class="badge {!! Helper::seoUrl($invoice->statusName) !!}">{!! ucfirst($invoice->statusName) !!}</span>
                           </td>
                        @endif
                        <td><a href="{!! route('finance.invoice.show', $invoice->invoiceID) !!}" class="btn btn-sm btn-success btn-block" target="_blank"><i class="fal fa-eye"></i> view</a></td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>