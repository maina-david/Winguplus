<div>
   <div class="card">
      <div class="card-body">
         <div class="row mb-3">
            <div class="col-md-5">
               <input type="text" class="form-control" wire:model="search" placeholder="Search by customer name">
            </div>
            <div class="col-md-7">
               @if($event->type == 'Free')
                  <a href="#" class="btn btn-warning float-right" data-toggle="modal" data-target="#checkInCustomer">CheckIn</a>
               @endif
            </div>
         </div>
         <table class="table table-striped table-bordered">
            <thead>
               <th width="1%">#</th>
               <th>Customer</th>
               <th>Ticket</th>
               <th>Qty</th>
               <th>Amount</th>
               <th>Payment Status</th>
               <th width="10%">Action</th>
            </thead>
            <tbody>
               @foreach($customers as $count=>$customer)
                  @if($customer->business_code ==  Auth::user()->business_code)
                     <tr>
                        <td>{!! $count+1 !!}</td>
                        <td>{!! $customer->customer_name !!}</td>
                        <td>{!! $customer->product_name !!}</td>
                        <td>{!! $customer->quantity !!} / {{ $customer->checked_in }}</td>
                        <td>{{ $currency }}{!! number_format($customer->total_amount) !!}</td>
                        <td>
                           @if($event->type == 'Paid')
                              <span class="badge {!! $customer->name !!}">{!! $customer->name !!}</span>
                           @else
                              <span class="badge badge-warning">Fee Event</span>
                           @endif
                        </td>
                        <td>
                           @php
                              $productCode = json_encode($customer->productCode);
                              $customerCode = json_encode($customer->customerCode);
                              $invoice = json_encode($customer->invoiceCode);
                           @endphp
                           @if($event->type == 'Paid')
                              @if($customer->statusID == 1)
                                 @if($customer->checked_in != $customer->quantity)
                                    <a wire:click="ticket_details({{$customerCode}},{{$productCode}},{{$invoice}})" href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#checkInCustomer">Check in</a>
                                 @endif
                              @endif
                              @if($customer->checked_in > 0)
                                 <a wire:click="check_in_details({{$productCode}})" href="" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#checkInDetails"><i class="far fa-eye"></i></a>
                              @endif
                           @endif
                        </td>
                     </tr>
                  @endif
               @endforeach
            </tbody>
         </table>
      </div>
   </div>

   <!-- check-in -->
   <div wire:ignore.self class="modal fade" id="checkInCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Check-in Customer</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="">Customer Name</label>
                  <input type="text" wire:model.defer="names" class="form-control" required>
                  @error('names') <span class="text-danger">{{ $message }}</span> @enderror
               </div>
               <div class="form-group">
                  <label for="">Customer Email</label>
                  <input type="email" wire:model.defer="email" class="form-control">
                  @error('email') <span class="text-danger">{{ $message }}</span> @enderror
               </div>
               <div class="form-group">
                  <label for="">Phone number</label>
                  <input type="number" wire:model.defer="phone_number" class="form-control" required>
                  @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
               </div>
            </div>
            <div class="modal-footer">
               <div wire:click="paid_check_in" wire:loading.class="none">
                  <a href="" class="btn btn-secondary" wire:click="close()">Close</a>
                  @if($event->type == 'Paid')
                     <a href="" class="btn btn-success" wire:click.prevent="paid_check_in()">Submit Information</a>
                  @endif
               </div>
               <div wire:loading wire:target="paid_check_in">
                  <center> <img src="{!! asset('assets/img/btn-loader.gif') !!}" alt="loader" width="25%"></center>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div wire:ignore.self class="modal right fade" id="checkInDetails" tabindex="-1" role="dialog" aria-labelledby="right_modal_xl" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-xl" role="document">
         <div class="modal-content">
            @if($checkInDetails)
               <div class="modal-header">
                  <h5 class="modal-title">Check-in details</h5>
                  <button type="button" class="close" wire:click="close()" data-dismiss="modal">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     @foreach($checkInDetails as $checks)
                        <div class="col-md-3">
                           <div class="panel">
                              <div class="panel-body">
                                 <div>
                                    <p>
                                       <b>Name:</b> {!! $checks->names !!}<br>
                                       <b>Email:</b> <a href="">{!! $checks->email !!}</a><br>
                                       <b>Phone Number:</b> <a href="">{!! $checks->phone_number !!}</a><br>
                                       <b>Check in time:</b> {!! date('F jS, Y', strtotime($checks->created_at)) !!} @ {{ date('g:i A', strtotime($checks->created_at)) }}<br>
                                       @if($checks->created_by)
                                          @php
                                             $user = Wingu::user($checks->created_by)->getData();
                                          @endphp
                                          @if($user->check == 1)
                                             <b>Checked in by:</b> <span class="text-warning">{!! $user->user->name !!}</span><br>
                                          @endif
                                       @endif
                                    </p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     @endforeach
                  </div>
               </div>
               <div class="modal-footer modal-footer-fixed">
                  <button type="button" class="btn btn-secondary" wire:click="close" wire:loading.class="none" wire:click="close()" data-dismiss="modal">Close</button>
                  <div wire:loading wire:target="close">
                     <center> <img src="{!! asset('assets/img/btn-loader.gif') !!}" alt="loader" width="25%"></center>
                  </div>
               </div>
            @else
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load float-right" alt="" style="width: 70%; justify-content: center;align-items: center;padding-left: 30%; padding-top: 30%">
            @endif
         </div>
      </div>
   </div>

   <!-- delete modal -->
   <div wire:ignore.self id="delete" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-confirm">
         <div class="modal-content">
            <div class="modal-header flex-column">
               <div class="icon-box">
                  <i class="fal fa-times"></i>
               </div>
               <h4 class="modal-title w-100">Are you sure?</h4>
            </div>
            <div class="modal-body">
               <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close()">Cancel</button>
               <button type="button" class="btn btn-danger" wire:click="delete()">Delete</button>
            </div>
         </div>
      </div>
   </div>

</div>
