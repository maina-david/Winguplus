<div class="panel panel-default mt-2">
   <div class="panel-body">
      <div class="row mb-3">
         <div class="col-md-8">
            <label for="">Search</label>
            <input type="text" wire:model="search" class="form-control" placeholder="Search by customer or Reference number">
         </div>
         <div class="col-md-2">
            <label for="">Payment Method</label>
            <select wire:model="paymentMethod" class="form-control">
               <option value="">All Payment Methods</option>
               @foreach($paymentMethods as $method)
                  <option value="{!! $method->method_code !!}">{!! $method->name !!}</option>
               @endforeach
            </select>
         </div>
         <div class="col-md-2">
            <label for="">Per Page</label>
            <select wire:model="perPage" class="form-control">
               <option value="25" selected>25</option>
               <option value="50">50</option>
               <option value="75">75</option>
               <option value="100">100</option>
            </select>
         </div>
      </div>
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead>
            <tr role="row">
               <th width="1%">#</th>
               <th>Date</th>
               <th width="10%">Reference</th>
               <th width="15%">Customer Name</th>
               <th>Invoice#</th>
               <th>Payment Method</th>
               <th>Amount Paid</th>
               <th width="3%">Action</th>
            </tr>
         </thead>
         <tbody>
            @foreach($payments as $count=>$pay)
               @if($pay->business_code == Auth::user()->business_code)
                  <tr role="row" class="odd">
                     <td>{!! $count+1 !!}</td>
                     <td>@if($pay->payment_date != ""){!! date('d F, Y',strtotime($pay->payment_date)) !!}@endif</td>
                     <td><p class="font-weight-bold">{!! $pay->reference_number !!}</p></td>
                     <td>
                        {!! $pay->customer_name !!}
                     </td>
                     <td>
                        {!! $pay->invoice_prefix !!}{!! $pay->invoice_number !!}
                     </td>
                     <td>
                        @if(Finance::check_payment_method($pay->payment_method) == 1)
                           {!! Finance::payment_method($pay->payment_method)->name !!}
                        @endif
                     </td>
                     <td>
                        <b>{!! $pay->currency !!}{!! number_format($pay->amount) !!}</b>
                     </td>
                     <td>
                        <div class="btn-group">
                           <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                           <ul class="dropdown-menu">
                              @if($pay->payment_category == 'Received')
                              <li><a href="{{ route('finance.payments.edit', $pay->payment_code) }}"><i class="far fa-edit"></i> Edit</a></li>
                              @endif
                              @if($pay->payment_category == 'Credited')
                              <li><a href="{{ route('finance.creditnote.edit', $pay->creditnote_code) }}" target="_blank"><i class="far fa-edit"></i> Edit</a></li>
                              @endif
                              <li><a href="{{ route('finance.payments.show', $pay->payment_code) }}"><i class="fas fa-eye"></i> View</a></li>
                              <li><a href="{{ route('finance.payments.delete', $pay->payment_code) }}" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
                           </ul>
                        </div>
                     </td>
                  </tr>
               @endif
            @endforeach
         </tbody>
      </table>
      {!! $payments->links() !!}
   </div>
</div>
