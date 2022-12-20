<div>
   <div class="row">
      <div class="col-md-12">
         <a href="" class="btn btn-primary float-right mb-3" data-toggle="modal" data-target=".lease"><i class="fa fa-plus-circle"></i> Add Lease</a>
      </div>
      <div class="col-md-12">
         <table class="table table-striped table-bordered">
            <thead>
               <th width="1%">#</th>
               <th>Lease Date</th>
               <th>Lease Expires</th>
               <th>Leasing Customer</th>
               <th>Created By</th>
               <th width="12%">Action</th>
            </thead>
            <tbody>
               @foreach($leases as $count=>$lease)
                  <tr>
                     <td>{!! $count+1 !!}</td>
                     <td>{!! date('F jS, Y', strtotime($lease->action_date)) !!}</td>
                     <td>{!! date('F jS, Y', strtotime($lease->due_action_date)) !!}</td>
                     <td>
                        @if($lease->customer)
                           {!! Finance::client($lease->customer)->customer_name !!}
                        @endif
                     </td>
                     <td>
                        @if($lease->updated_by)
                           {!! Wingu::user($lease->updated_by)->name !!}
                        @endif
                     </td>
                     <td>
                        @php
                           $getCode = json_encode($lease->code);
                        @endphp
                        <a wire:click="edit({{$getCode}})" class="btn btn-primary" data-toggle="modal" data-target="#editLease" href="#">Edit</a>
                        <a wire:click="remove({{$getCode}})" class="btn btn-danger" data-toggle="modal" data-target="#delete" href="#">Delete</a>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>

   <div wire:ignore.self class="modal fade" id="editLease" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <form action="{!! route('assets.lease.store',$code) !!}" method="POST" autocomplete="off" id="leaseForm">
               @csrf
               <div class="modal-header">
                  <h3 class="modal-title" id="exampleModalLabel"><i class="fal fa-file-contract"></i> Lease</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="" class="text-danger">Lease Begins</label>
                           <input type="date" wire:model="action_date" class="form-control" required>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="" class="text-danger">Lease Expires</label>
                           <input type="date" wire:model="due_action_date" class="form-control" required>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="" class="text-danger">Leasing Customer </label>
                           <select wire:model="customer" class="form-control" required>
                              @if($this->customer)
                                 <option value="{!! $this->customer !!}">{!! Wingu::user($lease->updated_by)->name !!}</option>
                              @else
                                 <option value="">Choose Customer</option>
                              @endif
                              @foreach($customers as $cust)
                                 <option value="{!! $cust->customer_code !!}">{!! $cust->customer_name !!}</option>
                              @endforeach
                           </select>
                        </div>
                        @error('customer')<span class="error text-danger">{{$message}}</span>@enderror
                     </div>
                     {{-- <div class="col-md-6">
                        <div class="form-group form-group-default">
                           <label for="">Send Email</label>
                           {!! Form::select('send_email',['No' => 'No','Yes' => 'Yes'],null,['class' => 'form-control','id'=>'lease_email']) !!}
                        </div>
                     </div>
                     <div class="col-md-6" id="leaseEmail" style="display: none">
                        <div class="form-group form-group-default required">
                           <label for="">Email</label>
                           {!! Form::email('email',null,['class' => 'form-control', 'placeholder' => 'Enter email']) !!}
                        </div>
                     </div> --}}
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Note </label>
                           <textarea wire:model="note" class="form-control tinymcy" rows="10"></textarea>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <center>
                     <button type="submit" class="btn btn-pink submit" wire:click.prevent="update()">Submit Lease</button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                  </center>
               </div>
            </form>
         </div>
      </div>
   </div>

   <!-- Modal HTML -->
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
