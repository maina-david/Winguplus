<ul class="nav nav-tabs">
   <li class="nav-item {!! Nav::isRoute('crm.leads.show') !!}">
      <a class="nav-link {!! Nav::isRoute('crm.leads.show') !!}" href="{!! route('crm.leads.show',$code) !!}"><i class="fal fa-info-circle"></i> Overview</a>
   </li>
   <li class="nav-item {{ Nav::isResource('events') }}">
      <a class="nav-link {{ Nav::isResource('events') }}" href="{!! route('crm.leads.events',$code) !!}"><i class="fal fa-calendar-alt"></i>  Meetings / Events</a>
   </li>
   <li class="nav-item {{ Nav::isRoute('crm.leads.calllog') }}">
      <a class="nav-link {{ Nav::isRoute('crm.leads.calllog') }}" href="{!! route('crm.leads.calllog',$code) !!}"><i class="fal fa-phone-office"></i>  Call log</a>
   </li>
   <li class="nav-item {{ Nav::isResource('tasks') }}">
      <a class="nav-link {{ Nav::isResource('tasks') }}" href="{!! route('crm.leads.tasks',$code) !!}"><i class="fal fa-check-square"></i>  Tasks</a>
   </li>
   <li class="nav-item {{ Nav::isResource('notes') }}">
      <a class="nav-link {{ Nav::isResource('notes') }}" href="{!! route('crm.leads.notes',$code) !!}"><i class="fal fa-feather-alt"></i>  Notes</a>
   </li>
   {{-- <li class="nav-item {{ Nav::isResource('sms') }}">
      <a class="nav-link {{ Nav::isResource('sms') }}" href="{!! route('crm.leads.sms',$code) !!}"><i class="fal fa-sms"></i>  Sms</a>
   </li> --}}
   {{-- <li class="nav-item {{ Nav::isResource('mail') }} {!! Nav::isRoute('crm.leads.send') !!}">
      <a class="nav-link {{ Nav::isResource('mail') }} {!! Nav::isRoute('crm.leads.send') !!}" href="{!! route('crm.leads.mail',$code) !!}"><i class="fal fa-paper-plane"></i> Email</a>
   </li> --}}
   {{-- <li class="nav-item {{ Nav::isResource('documents') }}">
      <a class="nav-link {{ Nav::isResource('documents') }}" href="{!! route('crm.leads.documents',$code) !!}"><i class="fal fa-folder"></i>  Documents</a>
   </li> --}}
</ul>
