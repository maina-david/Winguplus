<div>
   <div class="row mt-3">
      <div class="col-md-4">
         <div class="form-group">
            <label for="">Search</label>
            <input type="text" class="form-control" placeholder="Search by meeting title" wire:model.debounce.500ms="search">
         </div>
      </div>
      <div class="col-md-2">
         <div class="form-group">
            <label for="">Filter by date</label>
            <input type="date" class="form-control" wire:model.debounce.500ms="date">
         </div>
      </div>
      <div class="col-md-6">
         <div class="btn-group mt-3 mb-3 ml-2 float-right">
            <button type="button" class="btn btn-outline-black dropdown-toggle mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-list"></i> List view
            </button>
            <ul class="dropdown-menu" role="menu">
               <li><a href="{!! route('crm.leads.events',$code) !!}"><i class="fas fa-th-large"></i> Grid view</a></li>
            </ul>
         </div>
         <a href="#" class="btn btn-pink mt-3 mb-3 float-right" data-toggle="modal" data-target="#eventCreate"><i class="fas fa-calendar-plus"></i> Add Events</a>
      </div>
   </div>

   <div class="row mt-3">
      <div class="col-md-12">
         <table class="table table-striped mb-3">
            <thead>
               <th width="1%">#</th>
               <th>Title</th>
               <th>From</th>
               <th>To</th>
               <th>Host</th>
               <th>Status</th>
               <th></th>
            </thead>
            <tbody>
               @foreach($events as $count=>$event)
                  @if(Auth::user()->business_code == $event->business_code)
                     @php
                        $getEventCode = json_encode($event->event_code);
                     @endphp
                     <tr>
                        <td>{!! $count+1 !!}</td>
                        <td>
                           <a wire:click="details({{ $getEventCode }})" data-toggle="modal" data-target="#detail" href="#">{!! $event->event_name !!}</a><br>
                           <small><b>Meeting Type:</b> {!! ucfirst($event->meeting_type) !!}</small>
                        </td>
                        <td>{!! date("M jS, Y", strtotime($event->start_date)) !!} @if($event->start_time)@ {!! $event->start_time !!}@endif</td>
                        <td>{!! date("M jS, Y", strtotime($event->end_date)) !!} @if($event->end_time)@ {!! $event->end_time !!}@endif</td>
                        <td>
                           @if($event->owner != "")
                              {!! Wingu::user($event->owner)->name !!}
                           @endif
                        </td>
                        <td>
                           @if($event->status)
                              @php
                                 $status = Wingu::status($event->status);
                              @endphp
                              <span class="badge {!! $status->name !!}">{!! $status->name !!}</span>
                           @endif
                        </td>
                        <td>
                           <a wire:click="edit({{ $getEventCode }})" data-toggle="modal" data-target="#eventEdit" class="btn btn-sm btn-primary text-white">Edit</a>
                        </td>
                     </tr>
                  @endif
               @endforeach
            </tbody>
         </table>
         {!! $events->links('pagination.custom') !!}
      </div>
   </div>

   @livewire('crm.leads.events.create', ['leadCode' => $code])
   @if($this->eventCode)
      @livewire('crm.leads.events.edit', ['eventCode'=>$this->eventCode])
   @endif
   @if($this->eventDetailCode)
      @livewire('crm.leads.events.details', ['eventCode' => $eventDetailCode])
   @endif
</div>
