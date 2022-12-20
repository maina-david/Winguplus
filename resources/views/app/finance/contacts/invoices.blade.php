<div class="card mt-3">
   <div class="card-header"><i class="fal fa-file-invoice-dollar"></i> Invoices</div>
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
         <tbody>
            @foreach ($invoices as $crt => $v)
               <tr role="row" class="odd">
                  <td>{{ $crt+1 }}</td>
                  <td>
                     <b>{{ Finance::invoice_settings()->prefix }}{{ $v->invoice_number }}</b>
                  </td>
                  <td><b>{!! $client->currency !!} {!! number_format($v->total) !!}</b></td>
                  <td>{!! $client->currency !!} {!! number_format($v->paid) !!}</td>
                  <td class="v-align-middle">

                     @if( $v->status == 1 )
                        <span class="badge {!! Wingu::status($v->status)->name !!}">{!! ucfirst(Wingu::status($v->status)->name) !!}</span>
                     @else

                        <b>
                     {!! $client->code !!} {{ number_format(round($v->total - $v->paid)) }}</b>
                     @endif
                  </td>
                  <td><p>{!! date('F j, Y',strtotime($v->invoice_due)) !!}</p></td>
                  @if ($v->total - $v->paid < 0)
                     <td><span class="badge {!! Wingu::status($v->status)->name !!}">{!! ucfirst(Wingu::status($v->status)->name) !!}</span></td>
                  @else
                     <td>
                        @if($v->status != "")
                           <span class="badge {!! Wingu::status($v->status)->name !!}">{!! ucfirst(Wingu::status($v->status)->name) !!}</span>
                        @endif
                     </td>
                  @endif
                  <td>
                     <a href="{{ route('finance.invoice.show', $v->id) }}" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> view</a>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
