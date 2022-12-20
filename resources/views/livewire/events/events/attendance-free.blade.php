<div>
   <div class="card">
      <div class="card-body">
         <div class="row mb-3">
            <div class="col-md-5">
               <input type="text" class="form-control" wire:model="search" placeholder="Search by customer name">
            </div>
            <div class="col-md-7">
               @if($event->type == 'Free')
                  <a href="#" class="btn btn-success float-right" data-toggle="modal" data-target="#checkInCustomer"><i class="fal fa-sign-in"></i> CheckIn</a>
               @endif
            </div>
         </div>
         <table class="table table-striped table-bordered">
            <thead>
               <th width="1%">#</th>
               <th>Customer</th>
               <th>Phone Number</th>
               <th>Email</th>
               <th>Checked in at</th>
               <th>Checked in by</th>
               <th width="10%">Action</th>
            </thead>
            <tbody>
               @foreach($checkIns as $count=>$checkIn)
                  @if($checkIn->business_code ==  Auth::user()->business_code)
                     <tr>
                        <td>{!! $count+1 !!}</td>
                        <td>{!! $checkIn->names !!}</td>
                        <td>{!! $checkIn->phone_number !!}</td>
                        <td>{!! $checkIn->email !!}</td>
                        <td>{!! date('F jS, Y', strtotime($checkIn->created_at)) !!} @ {{ date('g:i A', strtotime($checkIn->created_at)) }}</td>
                        <td>
                           @if($checkIn->created_by)
                              @php
                                 $user = Wingu::user($checkIn->created_by)->getData();
                              @endphp
                              @if($user->check == 1)
                                 <b>Checked in by:</b> <span class="text-warning">{!! $user->user->name !!}</span><br>
                              @endif
                           @else
                              Self check in
                           @endif
                        </td>
                        <td>
                           <a href="" class="btn btn-danger btn-sm"  wire:click="confirm_delete({{$checkIn->id}})"  data-toggle="modal" data-target="#delete"><i class="far fa-trash-alt"></i> Delete</a>
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
               <div wire:click="check_in" wire:loading.class="none">
                  <a href="" class="btn btn-secondary" wire:click="close()">Close</a>
                  <a href="" class="btn btn-success" wire:click.prevent="check_in()">Submit Information</a>
               </div>
               <div wire:loading wire:target="check_in">
                  <center> <img src="{!! asset('assets/img/btn-loader.gif') !!}" alt="loader" width="25%"></center>
               </div>
            </div>
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
