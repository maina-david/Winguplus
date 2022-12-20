<div class="panel panel-default">
   <div class="panel-body">
      <div class="row mb-3">
         <div class="col-md-10">
            <label for="">Search</label>
            <input type="text" class="form-control" wire:model="search" placeholder="Search by supplier name">
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
      <table class="table table-striped table-bordered">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th width="5">Image</th>
               <th>Name</th>
               <th>Email</th>
               <th>Phone number</th>
               <th>Date Added</th>
               <th width="8%">Action</th>
            </tr>
         </thead>
         <tbody>
            @foreach($suppliers as $count=>$supplier)
               @if($supplier->business_code == Auth::user()->business_code)
                  <tr {{-- class="success" --}}>
                     <td>{!! $count+1 !!}</td>
                     <td>
                        @if($supplier->image == "")
                           <img src="https://ui-avatars.com/api/?name={!! $supplier->supplier_name !!}&rounded=true&size=32"  class="img-circle"  alt="{!! $supplier->supplier_name !!}" width="40" height="40">
                        @else
                           <img width="40" height="40" alt="" class="img-circle" src="{!! asset('businesses/'.$supplier->business_code.'/suppliers/'.$supplier->supplierCode.'/images/'.$supplier->image) !!}">
                        @endif
                     </td>
                     <td>{!! $supplier->supplier_name !!}</td>
                     <td>{!! $supplier->email !!}</td>
                     <td>{!! $supplier->primary_phone_number !!}</td>
                     <td>{!! date('d F, Y', strtotime($supplier->created_at)) !!}</td>
                     <td>
                        <div class="btn-group">
                           <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                           <ul class="dropdown-menu">
                              {{-- <li><a href="{{ route('finance.supplier.show', $supplier->supplierCode) }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li> --}}
                              <li><a href="{{ route('finance.supplier.edit', $supplier->supplierCode) }}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                              <li><a href="{!! route('finance.supplier.delete', $supplier->supplierCode) !!}" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                           </ul>
                        </div>
                     </td>
                  </tr>
               @endif
            @endforeach
         </tbody>
      </table>
      {!! $suppliers->links() !!}
   </div>
</div>
