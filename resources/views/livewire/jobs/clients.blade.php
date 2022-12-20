<div>
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="{!! route('jobs.dashboard') !!}">Jobs Management</a></li>
      <li class="breadcrumb-item"><a href="{!! route('job.index') !!}">Clients</a></li>
      <li class="breadcrumb-item active">All</li>
   </ol>
   <h1 class="page-header"><i class="fal fa-users"></i> Clients <a href="" class="btn btn-sm btn-success" data-toggle="modal" data-target="#customerModal"><i class="fa fa-plus-circle"></i> Add client</a></h1>
   <div class="row mb-3">
      <div class="col-md-10">
         <label for="">Search</label>
         <input type="text" wire:model="search" class="form-control" placeholder="Enter client name">
      </div>
      <div class="col-md-2">
         <label for="">Per Page</label>
         <select wire:model="perPage" class="form-control">`
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
         </select>
      </div>
   </div>
   <div class="row">
      @foreach($clients as $client)
         @if($client->business_code = Auth::user()->business_code)
            <div class="col-lg-3 col-md-4 col-sm-6 img_div_modal">
               <div class="staffinfo-box">
                  <div class="staffleft-box">
                     @if($client->image)
                        <img width="40" height="40" alt="{!! $client->customer_name !!}" class="img-circle" src="{!! asset('businesses/'.Wingu::business()->business_code.'/customer/'. $client->customer_code.'/images/'.$client->image) !!}">
                     @else
                        <img src="https://ui-avatars.com/api/?name={!! $client->customer_name !!}&rounded=false&size=120" alt="{!! $client->customer_name !!}" class="img-responsive">
                     @endif
                  </div>
                  <div class="staffleft-content">
                     <h5><span>{!! $client->customer_name !!}</span></h5>
                     <p>{!! $client->primary_phone_number !!}</p>
                     <p>{!! $client->email !!}</p>
                     <p>{!! $client->website !!}</p>
                  </div>
                  @php
                     $geteditCode = json_encode($client->customer_code);
                  @endphp
                  <div class="overlay3">
                     <div class="stafficons">
                        <a title="Show" data-toggle="modal" data-target="#delete" wire:click="delete_notification({{$geteditCode}})" href="#"><i class="fal fa-trash-alt"></i></a>
                        <a title="Edit" data-toggle="modal" data-target="#customerModal" href="#" wire:click="edit_mode({{$geteditCode}})"><i class=" fal fa-pencil"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         @endif
      @endforeach
      {{ $clients->links() }}
   </div>

   {{-- customer modal --}}
   <div wire:ignore.self class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">@if($editCode) Edit Client @else Add Client @endif</h5>
               <button type="button" class="close" wire:click="close()" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label class="col-form-label">Client Name:</label>
                  <input type="text" class="form-control" wire:model="client_name" required>
                  @error('client_name')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
               <div class="form-group">
                  <label class="col-form-label">Email</label>
                  <input type="email" class="form-control" wire:model="email">
                  @error('email')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
               <div class="form-group">
                  <label class="col-form-label">Phone Number</label>
                  <input type="number" class="form-control" wire:model="phone_number">
                  @error('phone_number')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
               <div class="form-group">
                  <label class="col-form-label">Website</label>
                  <input type="text" class="form-control" wire:model="website">
                  @error('website')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" wire:click="close()">Close</button>
               @if($editCode)
                  @php
                     $editCode2 = json_encode($editCode);
                  @endphp
                  <button type="button" class="btn btn-primary" wire:click="update_client({{$editCode2}})"><i class="fa fa-save"></i> Update Client</button>
               @else
                  <button type="button" class="btn btn-success" wire:click="add_client()"><i class="fa fa-save"></i> Add Client</button>
               @endif
            </div>
         </div>
      </div>
   </div>

   <!-- Delete -->
   <div wire:ignore.self id="delete" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-confirm">
         @if($editCode)
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
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="delete_close()">Cancel</button>
                  @php
                     $editCode2 = json_encode($editCode);
                  @endphp
                  <button type="button" class="btn btn-danger" wire:click="delete({{$editCode2}})">Delete</button>
               </div>
            </div>
         @endif
      </div>
   </div>
</div>
