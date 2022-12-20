<div class="panel">
   <div class="panel panel-default mt-3">
      <div class="panel-body">
         <div class="row">
            <div class="col-md-6">
               <div class="form-group">
                  <label for="">Search</label>
                  <input type="text" class="form-control" wire:model="search" placeholder="Search by title">
               </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                  <label for="">Status</label>
                  <select wire:model="status" class="form-control">
                     <option value="">Choose status</option>
                     <option value="1">Paid</option>
                     <option value="2">Unpaid</option>
                     <option value="18">Dept</option>
                  </select>
               </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                  <label for="">Category</label>
                  <select wire:model="category" class="form-control">
                     <option value="">Choose Category</option>
                     @foreach($categories as $cat)
                        <option value="{!! $cat->category_code !!}">{!! $cat->name !!}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                  <label for="">Month</label>
                  <select wire:model="month" class="form-control">
                     <option value="">Choose Month</option>
                     <option value="01">January</option>
                     <option value="02">February</option>
                     <option value="03">March</option>
                     <option value="04">April</option>
                     <option value="05">May</option>
                     <option value="06">June</option>
                     <option value="07">July</option>
                     <option value="08">August</option>
                     <option value="09">September</option>
                     <option value="10">October</option>
                     <option value="11">November</option>
                     <option value="12">December</option>
                  </select>
               </div>
            </div>
         </div>
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th width="1%">#</th>
                  <th width="10%">Date</th>
                  <th>Expense Category</th>
                  <th>Reference#</th>
                  <th>Expense Title</th>
                  <th>Status</th>
                  <th>Amount</th>
                  <th width="14%">Action</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($expense as $count=>$exp)
                  @if($exp->business_code == Auth::user()->business_code)
                     @php
                        $expenseInfo = Finance::expense_category($exp->category)->getData();
                     @endphp
                     <tr>
                        <td>{!! $count+1 !!}</td>
                        <td>{!! date('M j, Y',strtotime($exp->expense_date)) !!}</td>
                        <td>
                           @if($expenseInfo->check == 1)
                              {!! $expenseInfo->expense->name !!}
                           @else
                              <i>Un allocated</i>
                           @endif
                        </td>
                        <td><b>{!! $exp->reference_number !!}</b></td>
                        <td>{!! $exp->expense_name !!}</td>
                        <td>
                           <span class="badge {!! $exp->statusName !!}">
                              {!! $exp->statusName !!}
                           </span>
                         </td>
                        <td><b>{!! $exp->currency !!} {!! number_format($exp->amount) !!}</b></td>
                        <td>
                           <a href="{{ route('finance.expense.edit', $exp->expenseCode) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a>
                           <a href="{!! route('finance.expense.destroy', $exp->expenseCode) !!}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a></li>
                        </td>
                     </tr>
                  @endif
               @endforeach
            </tbody>
         </table>
         {!! $expense->links('pagination.custom') !!}
       </div>
   </div>
</div>
