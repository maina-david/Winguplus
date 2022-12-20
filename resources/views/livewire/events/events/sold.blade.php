<div>
   <div class="row mb-2">
      <div class="col-md-12">
         <a href="" class="btn btn-pink float-right" data-toggle="modal" data-target="#sellTicket"><i class="fa fa-plus-circle"></i> Sale Ticket</a>
      </div>
   </div>
   <div class="card">
      <div class="card-body">
         <table class="table table-striped table-bordered">
            <thead>
               <th width="1%">#</th>
               <th>Ticket</th>
               <th>Price</th>
               <th>Sold</th>
               <th>Amount</th>
            </thead>
            <tbody>
               @foreach($tickets as $count=>$ticket)
                  <tr>
                     <td>{!! $count+1 !!}</td>
                     <td>{!! $ticket->product_name !!}</td>
                     <td>{{ $currency }}{!! number_format($ticket->selling_price) !!}</td>
                     <td>{!! Events::tickets_sold($ticket->productCode) !!}</td>
                     <td>{{ $currency }}{!! number_format($ticket->total_sales) !!}</td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>

   <!-- Modal -->
   <div wire:ignore.self class="modal fade" id="sellTicket" tabindex="-1" role="dialog" aria-labelledby="sellTicketTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">Sale Ticket</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 mb-2">
                     <div class="row">
                        <div class="col-md-6">
                           <input type="radio" wire:model="member_type" value="new">
                           New Member
                        </div>
                        <div class="col-md-6">
                           <input type="radio" wire:model="member_type" value="member">
                           Member
                        </div>
                     </div>
                  </div>
                  @if($this->member_type == 'new')
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Customer Name</label>
                           <input type="text" wire:model.defer="customer_name" class="form-control" required>
                           @error('customer_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Email</label>
                           <input type="text" wire:model.defer="email" class="form-control" required>
                           @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Phone Number</label>
                           <input type="number" wire:model.defer="phone_number" class="form-control">
                           @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                     </div>
                  @else
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Choose Customer</label>
                           <select class="form-control" wire:model.defer="customer">
                              <option value="">Choose Customer</option>
                              @foreach($customers as $customer)
                                 <option value="{!! $customer->customer_code !!}">{!! $customer->customer_name !!}</option>
                              @endforeach
                           </select>
                           @error('customer') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                     </div>
                  @endif
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Choose ticket</label>
                        <select class="form-control" wire:model.defer="ticket" required>
                           <option value="">Choose ticket</option>
                           @foreach($ticketItems as $item)
                              <option value="{{ $item->product_code }}">
                                 {!! $item->product_name !!} ({{ $currency }}{{number_format($item->selling_price)}}) - qty {{ $item->current_stock }}
                              </option>
                           @endforeach
                        </select>
                        @error('ticket') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Quantity</label>
                        <input type="number" wire:model.defer="quantity" class="form-control" min="1" required>
                        @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Choose payment status</label>
                        <select class="form-control" wire:model="status" required>
                           <option value="">Choose status</option>
                           <option value="1">Paid</option>
                           <option value="2">Unpaid</option>
                           <option value="3">Partially paid</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                  </div>
                  @if($this->status == 1 || $this->status == 3)
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Choose payment method</label>
                           <select class="form-control" wire:model="payment_method" required>
                              <option value="">Choose method</option>
                              <option value="cash">Cash</option>
                              <option value="banktransfer">Bank transfer</option>
                              <option value="cheque">Cheque</option>
                              <option value="mpesa">Mpesa</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Transaction Number</label>
                           <input type="text" wire:model.defer="transaction_number" class="form-control">
                        </div>
                     </div>
                  @endif
                  @if($this->status == 3)
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Partial Amount paid</label>
                           <input type="text" wire:model.defer="amount_paid" class="form-control">
                           @error('amount_paid') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                     </div>
                  @endif
                  {{-- @if($this->status == 2)
                     <div class="col-md-12 mb-2">
                        <div class="row">
                           <div class="col-md-6">
                              <input type="checkbox" wire:model.defer="payment_link" value="send_link">
                              Send Payment Link
                           </div>
                        </div>
                     </div>
                  @endif --}}
               </div>
            </div>
            <div class="modal-footer">
               <div wire:loading.class="none">
                  <button type="button" class="btn btn-secondary" wire:model="close()">Close</button>
                  <button type="button" class="btn btn-success" wire:click.prevent="sell_ticket()">Save changes</button>
               </div>
               <div wire:loading wire:target="sell_ticket">
                 <center> <img src="{!! asset('assets/img/btn-loader.gif') !!}" alt="loding" width="25%"></center>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
