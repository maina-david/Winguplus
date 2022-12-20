<div class="row">
   <div class="col-md-7">
      <div class="row">
         <div class="col-md-12 mb-lg-3">
            <a href="" class="btn btn-warning btn-small float-right" data-toggle="modal" data-target="#addSession"><i class="fas fa-plus-circle"></i> Add Session</a>
         </div>
      </div>
      <div class="card">
         <div class="card-header">Sessions</div>
         <div class="card-body">
            <table class="table table-striped table-bordered">
               <thead>
                  <th width="1%">#</th>
                  <th>Title</th>
                  <th width="16%">Action</th>
               </thead>
               <tbody>
                  @foreach ($sessions as $count=>$session)
                     <tr>
                        <td>{!! $count+1 !!}</td>
                        <td>
                           <p class="font-bold">{!! $session->title !!}</p>
                           <p><i class="fal fa-calendar-day"></i> {!! date('F jS, Y', strtotime($schedule->start_date)) !!}</p>
                           <p><i class="fal fa-history"></i> {!! date('g:i a', strtotime($session->start_time)) !!} to {!! date('g:i a', strtotime($session->end_time)) !!}</p>
                           <hr>
                           {!! nl2br($session->details) !!}
                        </td>
                        <td>
                           @php
                              $getcode = json_encode($session->schedule_code);
                           @endphp
                           <a href="" class="btn btn-sm btn-primary" wire:click="edit({{$getcode}})" data-toggle="modal" data-target="#addSession"><i class="fa fa-edit"></i></a>
                           <a href="" class="btn btn-sm btn-danger" wire:click="confirm_delete({{$getcode}})" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-alt"></i></a>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
   <div class="col-md-5">
      <div class="panel">
         <div class="panel-heading text-center"><h3>Schedule</h3></div>
         <div class="panel-body">
            <h4 class="font-bold"> {!! $schedule->title !!}</h4>
            <h5><i class="fal fa-calendar-day"></i> {!! date('F jS, Y', strtotime($schedule->start_date)) !!}</h5>
            <h5><i class="fal fa-history"></i> {!! date('g:i a', strtotime($schedule->start_time)) !!} to {!! date('g:i a', strtotime($schedule->end_time)) !!}</h5>
            <h5><i class="fal fa-map-marker-alt"></i> {!! $schedule->location !!}</h5>
            <hr>
            {!! nl2br($schedule->details) !!}
         </div>
      </div>
   </div>

   <!-- The Modal -->
   <div wire:ignore.self class="modal" id="addSession">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
               @if($this->editCode)
                  <h4 class="modal-title">Edit Session Details</h4>
               @else
                  <h4 class="modal-title">Add Session Details</h4>
               @endif
               <button type="button" class="close" wire:click="close()">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 mb-3">
                     <label for="">Session Title</label>
                     <input type="text" class="form-control" wire:model.defer="title" required>
                     @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                     <label for="">Start Time</label>
                     <input type="time" class="form-control" wire:model.defer="start_time" required>
                     @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                     <label for="">End Time</label>
                     <input type="time" class="form-control" wire:model.defer="end_time" required>
                     @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-md-12 mb-3">
                     <label for="">Details</label>
                     <textarea type="text" class="form-control" wire:model.defer="details" rows="13" required></textarea>
                     @error('details') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
               </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
               <button type="button" class="btn btn-default" wire:click="close()">Close</button>
               @if($this->editCode)
                  <button type="submit" class="btn btn-primary" wire:click="update()"><i class="fas fa-save"></i> Update Information</button>
               @else
                  <button type="submit" class="btn btn-success" wire:click="store()"><i class="fas fa-save"></i> Save Information</button>
               @endif
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
