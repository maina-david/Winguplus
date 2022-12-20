<div class="row mb-2">
   <div class="col-md-12">
      <ul class="nav nav-pills">
         <li class="nav-item"><a href="{!! route('events.show',$code) !!}" class="nav-link {!! Nav::isResource('details') !!}"><i class="fal fa-analytics"></i> Overview</a></li>
         @if($event->type == 'Paid')
         <li class="nav-item"><a href="{!! route('events.ticket.sold',$code) !!}" class="nav-link {!! Nav::isResource('sold') !!}"><i class="fal fa-usd-circle"></i> Tickets sold</a></li>
         @endif
         <li class="nav-item"><a href="{!! route('events.attendance',$code) !!}" class="nav-link {!! Nav::isResource('attendance') !!}"><i class="fal fa-users"></i> Attendance</a></li>
         <li class="nav-item"><a href="{!! route('events.speakers',$code) !!}" class="nav-link {!! Nav::isResource('speakers') !!}"><i class="fal fa-podium-star"></i> Speakers</a></li>
         <li class="nav-item"><a href="{!! route('events.sponsors',$code) !!}" class="nav-link {!! Nav::isResource('sponsors') !!}"><i class="fal fa-tags"></i> Sponsors/Partners</a></li>
         <li class="nav-item"><a href="{!! route('events.tickets',$code) !!}" class="nav-link {!! Nav::isResource('tickets') !!}"><i class="fal fa-ticket-alt"></i> Tickets</a></li>
         <li class="nav-item"><a href="{!! route('events.schedules',$code) !!}" class="nav-link {!! Nav::isResource('schedules') !!}"><i class="fal fa-clipboard-list-check"></i> Schedules</a></li>
         <li class="nav-item"><a href="{!! route('events.edit',$code) !!}" class="nav-link {!! Nav::isResource('edit') !!}"><i class="fal fa-edit"></i> Edit Event</a></li>
      </ul>
   </div>
</div>
