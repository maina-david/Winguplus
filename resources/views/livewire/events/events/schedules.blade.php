<div class="row">
   <div class="col-md-12 mb-lg-3">
      <a href="" class="btn btn-pink btn-small float-right" data-toggle="modal" data-target="#addSchedule"><i class="fas fa-plus-circle"></i> Add Schedule</a>
   </div>
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <table class="table table-striped table-bordered">
               <thead>
                  <th width="1%">#</th>
                  <th>Title</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Location</th>
                  <th>Sessions</th>
                  <th width="16%">Action</th>
               </thead>
               <tbody>
                  @foreach ($schedules as $count=>$schedule)
                     @php
                        $data = Events::get_schedule_sessions($schedule->schedule_code)->getData();
                     @endphp
                     <tr>
                        <td>{!! $count+1 !!}</td>
                        <td>{!! $schedule->title !!}</td>
                        <td>{!! date('F jS, Y', strtotime($schedule->start_date)) !!}</td>
                        <td>{!! date('g:i a', strtotime($schedule->start_time)) !!} to {!! date('g:i a', strtotime($schedule->end_time)) !!}</td>
                        <td>{!! $schedule->location !!}</td>
                        <td>{!! $data->count !!}</td>
                        <td>
                           @php
                              $getCode = json_encode($schedule->schedule_code);
                           @endphp
                           <a href="" class="btn btn-sm btn-primary" wire:click="edit({{$getCode}})" data-toggle="modal" data-target="#addSchedule">Edit</a>
                           <a href="{!! route('events.schedule.sessions',[$this->eventCode,$schedule->schedule_code]) !!}" class="btn btn-sm btn-warning">View</a>
                           <a href="" wire:click="confirm_delete({{$getCode}})" data-toggle="modal" data-target="#delete" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>

   <!-- The Modal -->
   <div wire:ignore.self class="modal" id="addSchedule">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
               @if($this->editCode)
                  <h4 class="modal-title">Edit Schedule Details</h4>
               @else
                  <h4 class="modal-title">Schedule Details</h4>
               @endif
               <button type="button" class="close" wire:click="close()">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 mb-3">
                     <label for="">Schedule Title</label>
                     <input type="text" class="form-control" wire:model.defer="title" required>
                     @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                     <label for="">Date</label>
                     <input type="date" class="form-control" wire:model.defer="start_date" required>
                     @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-md-3 mb-3">
                     <label for="">Start Time</label>
                     <input type="time" class="form-control" wire:model.defer="start_time" required>
                     @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-md-3 mb-3">
                     <label for="">End Time</label>
                     <input type="time" class="form-control" wire:model.defer="end_time" required>
                     @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-md-12 mb-3">
                     <label for="">Location</label>
                     <input type="text" class="form-control" wire:model.defer="location" required>
                     @error('location') <span class="text-danger">{{ $message }}</span> @enderror
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
