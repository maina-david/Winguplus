<div>
   <div wire:ignore.self class="modal right fade" id="eventCreate" tabindex="-1" role="dialog" aria-labelledby="eventCreateEditModal" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Event Information</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Title</label>
                        <input type="text" class="form-control" placeholder="Enter meeting title" wire:model.defer="title">
                        @error('title')<span class="error text-danger">{{$message}}</span>@enderror
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        <label for="">Meeting Type</label>
                        <select wire:model.defer="meeting_type" class="form-control" wire:change="change">
                           <option value="">Choose Type</option>
                           <option value="online">Online Meeting</option>
                           <option value="physical">Physical Meeting</option>
                        </select>
                        @error('meeting_type')<span class="error text-danger">{{$message}}</span>@enderror
                     </div>
                  </div>
                  @if($this->typeView == 'physical')
                     <div class="col-md-12">
                        <div class="form-group form-group-default">
                           <label for="">Location</label>
                           <input type="text" class="form-control" placeholder="Enter meeting location" wire:model.defer="location">
                        </div>
                     </div>
                  @endif
                  @if($this->typeView == 'online')
                     <div class="col-md-12">
                        <div class="form-group form-group-default">
                           <label for="">Meeting Link</label>
                           <input type="text" class="form-control" placeholder="Enter meeting link" wire:model.defer="meeting_link">
                        </div>
                     </div>
                  @endif
                  <div class="col-md-6">
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('names', 'Start Date', array('class'=>'control-label text-danger')) !!}
                              <input type="date" wire:model.defer="start_date" class="form-control">
                              @error('start_date')<span class="error text-danger">{{$message}}</span>@enderror
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('Start Time', 'Start Time', array('class'=>'control-label text-danger')) !!}
                              <input type="time" wire:model.defer="start_time" class="form-control">
                              @error('start_time')<span class="error text-danger">{{$message}}</span>@enderror
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('End Date', 'End Date', array('class'=>'control-label')) !!}
                              <input type="date" wire:model="end_date" class="form-control">
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('End Time', 'End Time', array('class'=>'control-label')) !!}
                              <input type="time" wire:model="end_time" class="form-control">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group form-group-default">
                        {!! Form::label('Time', 'Priority', array('class'=>'control-label')) !!}
                        <select wire:model.defer="priority" class="form-control">
                           <option value="">Choose Priority</option>
                           <option value="High">High</option>
                           <option value="Normal">Normal</option>
                           <option value="Low">Low</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group form-group-default">
                        {!! Form::label('Status', 'Status', array('class'=>'control-label')) !!}
                        <select wire:model.defer="status" class="form-control">
                           <option value="">Choose status</option>
                           <option value="16">Completed</option>
                           <option value="4">Cancelled</option>
                           <option value="65">No Show</option>
                           <option value="66">Still to meet</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group form-group-default">
                        {!! Form::label('names', 'Host', array('class'=>'control-label')) !!}
                        <select wire:model.defer="host" class="form-control">
                           <option value="">Choose Host</option>
                           @foreach($users as $user)
                              <option value="{!! $user->user_code !!}">{!! $user->name !!}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group form-group-default">
                        {!! Form::label('Reminder', 'Reminder', array('class'=>'control-label')) !!}
                        <select wire:model.defer="reminder" class="form-control">
                           <option value="">None</option>
                           <option value="5">5 minutes before</option>
                           <option value="15">15 minutes before</option>
                           <option value="30">30 minutes before</option>
                           <option value="1">1 day before</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="form-group">
                        {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
                        <textarea wire:model.defer="description" class="form-control" cols="4" rows="4"></textarea>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-check form-switch ml-3">
                        <input class="form-check-input" type="checkbox" id="Invitation" value="yes" wire:model="send_invitation"/>
                        <label class="form-check-label" for="Invitation">Send Email Invitation</label>
                      </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer modal-footer-fixed ">
               <button type="button" class="btn btn-secondary" wire:click="close()">Cancel</button>
               <button class="btn btn-primary" wire:click.prevent="save_event()"><i class="fas fa-save"></i> Save Information</button>
            </div>
         </div>
      </div>
   </div>
</div>
