<div class="card mt-3">
   <div class="card-header"><i class="fal fa-file-invoice"></i> Quotes</div>
   <div class="card-body">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th>Number</th>
               <th>Reference Number</th>
               <th>Amount</th>
               <th>Status</th>
               <th>Date</th>
               <th width="10%">Action</th>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th width="1%">#</th>
               <th>Number</th>
               <th>Subject</th>
               <th>Amount</th>
               <th>Status</th>
               <th>Date</th>
               <th width="10%">Action</th>
            </tr>
         </tfoot>
         <tbody>
            @foreach ($quotes as $crt => $v)
               <tr role="row" class="odd">
                  <td>{{ $crt+1 }}</td>
                  <td>
                     <b>{!! Finance::quote()->prefix !!}{!! $v->estimate_number !!}</b>
                  </td>
                  <td class="text-uppercase font-weight-bold">
                     {!! $v->subject !!}
                  </td>
                  <td>{!! $client->currency !!}  {!! number_format($v->total) !!}</td>
                  <td><span class="badge {!! Wingu::status($v->status)->name !!}">{!! ucfirst(Wingu::status($v->status)->name) !!}</span></td>
                  <td>
                     {!! date('F j, Y',strtotime($v->created_at)) !!}
                  </td>
                  <td>
                     <a href="{{ route('finance.quotes.show', $v->quote_code) }}" target="_blank" class="btn btn-pink btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
