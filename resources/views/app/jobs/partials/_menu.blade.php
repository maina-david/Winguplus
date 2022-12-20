<div id="sidebar" class="sidebar">
   @php  $module = 'Jobs Management' @endphp
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      @include('partials._nav-profile')
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">My Menu</li>
         {{-- <li class="has-sub">
            <a href="#">
               <i class="fal fa-hand-holding-usd"></i>
               <span>My Projects</span>
            </a>
         </li> --}}
         <li class="has-sub {{ Nav::isResource('my-tasks') }}">
            <a href="{!! route('job.mytask.list') !!}">
               <i class="far fa-list-ul"></i>
               <span>My Tasks</span>
            </a>
         </li>
         {{-- <li class="has-sub">
            <a href="#">
               <i class="fal fa-hand-holding-usd"></i>
               <span>My Goals</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="#">
               <i class="fal fa-hand-holding-usd"></i>
               <span>My Tickets</span>
            </a>
         </li> --}}

         <li class="nav-header">Module Menu</li>
         <li class="has-sub {{ Nav::isResource('dashboard') }}">
            <a href="{!! route('jobs.dashboard') !!}">
               <i class="fal fa-chart-network"></i>
               <span>Dashboard</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-rocket-launch"></i>
               <span>Jobs</span>
            </a>
            <ul class="sub-menu">
               <li><a href="{!! route('job.index') !!}">All Jobs</a></li>
               <li><a href="{!! route('job.create') !!}">Add Job</a></li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('client') }}">
            <a href="{!! route('job.clients.index') !!}">
               <i class="fal fa-users"></i>
               <span>Clients</span>
            </a>
         </li>
         {{-- <li class="has-sub">
            <a href="javascript:;">
               <i class="fal fa-calendar-alt"></i>
               <span>Calendar</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="javascript:;">
               <i class="fal fa-flag"></i>
               <span>Milestones</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="javascript:;">
               <i class="fal fa-chart-pie"></i>
               <span>Report</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="javascript:;">
               <i class="fal fa-cogs"></i>
               <span>Settings</span>
            </a>
         </li> --}}
         <!-- begin sidebar minify button -->
         <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
         <!-- end sidebar minify button -->
      </ul>
      <!-- end sidebar nav -->
   </div>
   <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
