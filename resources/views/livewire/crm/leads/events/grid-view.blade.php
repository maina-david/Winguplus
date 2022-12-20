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
               <i class="fas fa-th-large"></i> Grid view
            </button>
            <ul class="dropdown-menu" role="menu">
               <li><a href="{!! route('crm.leads.events.list',$leadCode) !!}"><i class="fas fa-list"></i> List view</a></li>
            </ul>
         </div>
         <a href="#" class="btn btn-pink mt-3 mb-3 float-right"  data-toggle="modal" data-target="#eventCreate"><i class="fas fa-calendar-plus"></i> Add Events</a>
      </div>
   </div>

   <div class="row mt-3">
      @foreach($events as $event)
         @if(Auth::user()->business_code == $event->business_code)
            @php
               $getEventCode = json_encode($event->event_code);
            @endphp
            <div class="col-md-4">
               <!-- begin widget-list -->
               <div class="widget-list widget-list-rounded mb-2">
                  <!-- begin widget-list-item -->
                  <div class="widget-list-item">
                     <div class="widget-list-content">
                        <h4 class="widget-list-title font-weight-bold"><a wire:click="details({{ $getEventCode }})" data-toggle="modal" data-target="#detail" href="#">{!! $event->event_name !!}</a></h4>
                        <p class="widget-list-desc mt-1">
                           <b><i class="fal fa-calendar-check"></i> From:</b> {!! date("M jS, Y", strtotime($event->start_date)) !!} <b>@</b> {!! $event->start_time !!}<br>
                           <b><i class="fal fa-calendar-times"></i> To :</b> {!! date("M jS, Y", strtotime($event->end_date)) !!} <b>@</b> {!! $event->end_time !!}<br>
                           <b><i class="fal fa-calendar-plus"></i> Added :</b> {!! Helper::get_timeago(strtotime($event->created_at)) !!}<br>
                           <b><i class="fal fa-exclamation-circle"></i> Status :</b> @if($event->status)<span class="badge {!! Wingu::status($event->status)->name !!}">{!! ucfirst(Wingu::status($event->status)->name) !!}</span>@endif<br>
                           @if($event->owner != "")
                              <b><i class="fal fa-user-crown"></i> Owner :</b>  {!! Wingu::user($event->owner)->name !!}
                           @endif
                        </p>
                     </div>
                     <div class="widget-list-action">
                        <a href="#" data-toggle="dropdown" class="text-muted pull-right">
                        <i class="fa fa-ellipsis-h f-s-14"></i>
                        </a>
                        @php
                           $getEventCode = json_encode($event->event_code);
                        @endphp
                        <ul class="dropdown-menu dropdown-menu-right">
                           <li><a wire:click="edit({{ $getEventCode }})" data-toggle="modal" data-target="#eventEdit" href="#">Edit</a></li>
                           {{-- <li><a href="{!! route('crm.leads.events.delete',$event->event_code) !!}" class="delete">Delete</a></li> --}}
                        </ul>
                     </div>
                  </div>
                  <!-- end widget-list-item -->
               </div>
               <!-- end widget-list -->
            </div>
         @endif
      @endforeach
      <div class="col-md-12 mt-3">
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
