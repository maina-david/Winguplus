<div>
   <div class="row mb-3">
      <div class="col-md-10">
         <label for="">Search</label>
         <input type="text" wire:model.debounce.300ms="search" class="form-control" placeholder="Enter customer name, email address or phone number">
      </div>
      <div class="col-md-2">
         <label for="">Items Per</label>
         <select wire:model="perPage" class="form-control">`
            <option value="30" selected>30</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
         </select>
      </div>
   </div>
   <div class="panel panel-default">
      <div class="panel-heading">
         <h4 class="panel-title">Customers List</h4>
      </div>
      <div class="panel-body">
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th width="1%">#</th>
                  <th width="5"></th>
                  <th>Customer/Company</th>
                  <th>Email</th>
                  <th>Phone Number</th>
                  <th width="10%">Action</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($contacts as $count=>$contact)
                  @if($contact->business_code == Auth::user()->business_code)
                     @if($contact->customerCode)
                        <tr>
                           <td>{!! $count+1 !!}</td>
                           <td>
                              @if($contact->image == "")
                                 <img src="https://ui-avatars.com/api/?name={!! $contact->customer_name !!}&rounded=true&size=32" alt="">
                              @else
                                 <img width="40" height="40" alt="" class="img-circle" src="{!! asset('businesses/'.$contact->business_code.'/customer/'. $contact->customerCode.'/'.$contact->image) !!}">
                              @endif
                           </td>
                           <td>
                              @if($contact->salutation)
                                 {!! $contact->salutation !!}
                              @endif
                              {!! $contact->customer_name !!}
                           </td>
                           <td>{!! $contact->customer_email !!}</td>
                           <td>{!! $contact->primary_phone_number !!}</td>
                           <td>
                              <div class="btn-group">
                                 <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                                 <ul class="dropdown-menu">
                                    <li><a href="{{ route('finance.contact.show',$contact->customerCode) }}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                    <li><a href="{{ route('salesflow.customer.edit',$contact->customerCode) }}"><i class="fas fa-edit"></i> Edit</a></li>
                                    <li><a href="{!! route('salesflow.customer.delete',$contact->customerCode) !!}" class="delete"><i class="fal fa-trash-alt"></i> Delete</a></li>
                                 </ul>
                              </div>
                           </td>
                        </tr>
                     @endif
                  @endif
               @endforeach
            </tbody>
         </table>
         {!! $contacts->links() !!}
      </div>
   </div>
</div>
