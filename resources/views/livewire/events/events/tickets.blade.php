<div class="row">
   <div class="col-md-12">
      <a href="" class="btn btn-primary btn-small float-right" data-toggle="modal" data-target="#addTicket"><i class="fas fa-plus-circle"></i> Add Tickets</a>
   </div>
   <div class="col-md-10">
      <div class="card">
         <div class="card-body">
            <table class="table table-striped table-bordered">
               <thead>
                  <th width="1%">#</th>
                  <th>Ticket Name</th>
                  <th>Price</th>
                  <th>Available Tickets</th>
                  <th>Dates</th>
                  <th>Is Ticket Active</th>
                  <th width="15%">Action</th>
               </thead>
               <tbody>
                  @foreach ($tickets as $count=>$ticket)
                     <tr>
                        <td>{!! $count+1 !!}</td>
                        <td>{!! $ticket->product_name !!}</td>
                        <td>{{$currency}} {!! number_format($ticket->selling_price) !!}</td>
                        <td>{!! $ticket->current_stock !!}</td>
                        <td>
                           @if($ticket->event_start_date)
                              {!! date('F jS, Y', strtotime($ticket->event_start_date)) !!}
                           @endif
                           @if($ticket->event_due_date)
                              <b>to</b>
                              {!! date('F jS, Y', strtotime($ticket->event_due_date)) !!}
                           @endif
                        </td>
                        <td>
                           @if($ticket->active == 'Yes')
                              <span class="badge badge-success">{!! $ticket->active !!}</span>
                           @endif
                           @if($ticket->active == 'No')
                              <span class="badge badge-danger">{!! $ticket->active !!}</span>
                           @endif
                        </td>
                        <td>
                           @php
                              $getCode = json_encode($ticket->product_code);
                           @endphp
                           <a href="" class="btn btn-sm btn-primary" wire:click="edit({{$getCode}})" data-toggle="modal" data-target="#addTicket">Edit</a>
                           <a href="" class="btn btn-sm btn-danger" wire:click="confirm_delete({{$getCode}})" data-toggle="modal" data-target="#delete">Delete</a>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>

   <!-- Ticket modal-->
   <div wire:ignore.self class="modal" id="addTicket">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
               @if($this->editCode)
                  <h4 class="modal-title">Edit Ticket Details</h4>
               @else
                  <h4 class="modal-title">Ticket Details</h4>
               @endif
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data">
               <!-- Modal body -->
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6 mb-2">
                        <label for="">Ticket Name</label>
                        <input type="text" class="form-control" wire:model.defer="ticket_name" required>
                        @error('ticket_name') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Price</label>
                        <input type="number" class="form-control" wire:model.defer="price" required>
                        @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-md-4 mb-2">
                        <label for="">Quantity</label>
                        <input type="number" class="form-control" wire:model="qty" required>
                        @error('qty') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-md-4 mb-2">
                        <label for="">Is Item Active</label>
                        <select wire:model="status" class="form-control" required>
                           <option value="">Choose</option>
                           <option value="Yes">Yes</option>
                           <option value="No">No</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-md-4 mb-2">
                        <label for="">Track Quantity</label>
                        <select wire:model="track_ticket_quantity" class="form-control" required>
                           <option value="">Choose</option>
                           <option value="Yes">Yes</option>
                           <option value="No">No</option>
                        </select>
                        @error('track_ticket_quantity') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Start Date</label>
                        <input type="date" class="form-control" wire:model="start_date">
                        @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Due Date</label>
                        <input type="date" class="form-control" wire:model="due_date">
                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">Details</label>
                        <textarea type="text" class="form-control" wire:model="description" rows="10"></textarea>
                     </div>
                  </div>
               </div>
               <!-- Modal footer -->
               <div class="modal-footer">
                  @if($this->editCode)
                     <button type="submit" class="btn btn-primary" wire:click.prevent="update()"><i class="fas fa-save"></i> Update Information</button>
                  @else
                     <button type="submit" class="btn btn-success" wire:click.prevent="add_ticket()"><i class="fas fa-save"></i> Save Information</button>
                  @endif
               </div>
            </form>
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
