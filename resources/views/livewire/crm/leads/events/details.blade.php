<div>
   <div wire:ignore.self class="modal right fade modal-side-draw" id="detail" tabindex="-1" role="dialog" aria-labelledby="detail" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-xl" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  {!! $details->event_name !!}<br>
                  <small>Hosted by @if($details->owner != ""){!! Wingu::user($details->owner)->name !!} @endif</small>
               </h4><br>
               <button type="button" class="close" wire:click="close()" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="modal-row row">
                  <div class="col-md-9 modal-col-left" style="background: #f7f7f7">
                     <ul class="nav nav-pills">
                        <li class="nav-item">
                           <a  class="nav-link pointer-cursor @if($this->currentView == 'details') active @endif" wire:click="change_view('details')">Overview</a>
                        </li>
                        <li class="nav-item">
                           <a  class="nav-link pointer-cursor @if($this->currentView == 'notes') active @endif" wire:click="change_view('notes')">Notes</a>
                        </li>
                     </ul>

                     @if($this->currentView == 'details')
                        <div class="card">
                           <div class="card-body">
                              <h5>
                                 <i class="fal fa-calendar-alt"></i> {!! date('F jS, Y', strtotime($details->start_date)) !!} @ {!! date('g:i A', strtotime($details->start_time)) !!} <b><i>Until</i></b> {!! date('F jS, Y', strtotime($details->end_date)) !!} @ {!! date('g:i A', strtotime($details->start_time)) !!}
                              </h5>
                              <h5>
                                 <b>Meeting Type :</b> {!! ucfirst($details->meeting_type) !!}
                              </h5>
                              @if($details->location)
                                 <h5>
                                    <i class="fal fa-map-marker-alt"></i> {!! $details->location !!}
                                 </h5>
                              @endif
                              @if($details->meeting_link)
                                 <h5>
                                    <i class="fal fa-globe"></i> <a href="{!! $details->meeting_link !!}" target="_blank">Meeting Link</a>
                                 </h5>
                              @endif
                              <h5>
                                 <b><i class="fal fa-exclamation-circle"></i> Status :</b>  @if($details->status)
                                    @php
                                       $status = Wingu::status($details->status);
                                    @endphp
                                    <span class="badge {!! $status->name !!}">{!! $status->name !!}</span>
                              @endif
                              </h5>
                           </div>
                        </div>

                        <div class="card">
                           <div class="card-body">
                              {!! nl2br($details->description) !!}
                           </div>
                        </div>
                     @endif
                     @if($this->currentView == 'notes')
                        <div class="card">
                           <div class="card-header">Notes</div>
                           <div class="card-body">
                              <table class="table table-striped">
                                 @foreach ($notes as $note)
                                    @php
                                       $theCode = json_encode($note->note_code);
                                    @endphp
                                    <tr>
                                       <td>

                                       </td>
                                       <td>
                                          <b>{!! $note->subject !!}</b><br>
                                          <p>{!! nl2br($note->note) !!}</p>
                                          <a href="#noteArea" class="badge badge-primary float-right ml-2" wire:click="edit_note({{$theCode}})">Edit</a>
                                          <a href="#" class="badge badge-danger float-right" data-toggle="modal" data-target="#delete" wire:click="delete_note({{$theCode}})">Delete</a>
                                       </td>
                                    </tr>
                                 @endforeach
                              </table>
                           </div>
                           <div class="card-footer">
                              <div class="" id="noteArea">
                                 <input type="text" class="form-control mb-2" wire:model.defer="subject" placeholder="Enter Note title">
                                 <textarea class="form-control" cols="4" rows="4" wire:model.defer="note" placeholder="type here ...... "></textarea>
                                 @error('note')<span class="error text-danger">{{$message}}</span>@enderror
                                 @if($this->noteCode)
                                    <button class="btn btn-primary mt-2" wire:click.prevent="update_note()"><i class="fa fa-save"></i> Update Note</button>
                                 @else
                                    <button class="btn btn-success mt-2" wire:click.prevent="add_note()"><i class="fa fa-save"></i> Add Note</button>
                                 @endif
                              </div>
                           </div>
                        </div>
                     @endif
                  </div>
                  <div class="col-md-3 modal-col-right" style="background: #fff">
                     <a href="#" data-toggle="modal" data-target="#eventEdit" class="btn btn-block btn-outline-black"><i class="fa fa-edit"></i> Edit </a>
                     <a data-toggle="modal" data-target="#delete" wire:click="delete_event()" class="btn btn-block btn-outline-black"><i class="fas fa-trash-alt"></i>  Delete</a>
                  </div>
               </div>
            </div>
            <div class="modal-footer modal-footer-fixed">
               <button type="button" class="btn btn-secondary" wire:click="close()">Close</button>
            </div>
         </div>
      </div>
   </div>

   <!-- delete modal -->
   <div wire:ignore.self id="delete" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
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
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_delete()">Cancel</button>
               @if($this->deleteNoteCode)
                  <button type="button" class="btn btn-danger" wire:click="remove_note()">Delete</button>
               @endif
               @if($this->deleteEventCode)
                  <button type="button" class="btn btn-danger" wire:click="remove_event()">Delete</button>
               @endif
            </div>
         </div>
      </div>
   </div>

   @if($this->eventCode)
      @livewire('crm.leads.events.edit', ['eventCode'=>$this->eventCode])
   @endif

</div>
