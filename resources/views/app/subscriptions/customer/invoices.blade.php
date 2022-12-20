<div class="card">
   <div class="card-body">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th width="13%">Invoice #</th>
               <th>Amount</th>
               <th>Paid</th>
               <th>Balance</th>
               <th>Due Date</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th width="1%">#</th>
               <th>Invoice #</th>
               <th>Amount</th>
               <th>Paid</th>
               <th>Balance</th>
               <th>Due Date</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </tfoot>
         <tbody>
            @foreach ($invoices as $crt => $v)
               <tr role="row" class="odd">
                  <td>{{ $crt+1 }}</td>
                  <td>
                     <b>{{ Finance::invoice_settings()->prefix.$v->invoice_number }}</b>
                  </td>
                  <td>{!! number_format($v->total) !!} {!! Finance::currency($v->currencyID)->symbol !!}</td>
                  <td>{!! number_format($v->paid) !!} {!! Finance::currency($v->currencyID)->symbol !!}</td>
                  <td class="v-align-middle">
                     <p>
                        @if( $v->statusID == 1 )
                           <span class="badge {!! Wingu::status($v->statusID)->name !!}">{!! ucfirst(Wingu::status($v->statusID)->name) !!}</span>
                        @else
                           {{ number_format(round($v->total - $v->paid)) }} {!! Finance::currency($v->currencyID)->symbol !!}
                        @endif
                     </p>
                  </td>
                  <td><p>{!! date('F j, Y',strtotime($v->invoice_due)) !!}</p></td>
                  @if ($v->total - $v->paid < 0)
                     <td><span class="badge {!! Wingu::status($v->statusID)->name !!}">{!! ucfirst(Wingu::status($v->statusID)->name) !!}</span></td>
                  @else
                     <td>
                        @if($v->statusID != "")
                           <span class="badge {!! Wingu::status($v->statusID)->name !!}">{!! ucfirst(Wingu::status($v->statusID)->name) !!}</span>
                        @endif
                     </td>
                  @endif
                  <td>
                     <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                        <ul class="dropdown-menu">
                           <li><a href="{{ route('finance.invoice.show', $v->id) }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                           @if ($v->invoice_type == 'Random')
                              <li><a href="{!! route('finance.invoice.random.edit', $v->id) !!}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           @endif
                           @if($v->invoice_type == 'Product')
                              <li><a href="{!! route('finance.invoice.product.edit', $v->id) !!}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           @endif
                           @if($v->invoice_type == 'Recurring')
                              <li><a href="{!! route('finance.invoice.recurring.edit', $v->id) !!}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           @endif
                           <li><a href="{!! route('finance.invoice.delete', $v->id) !!}"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                        </ul>
                     </div>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
