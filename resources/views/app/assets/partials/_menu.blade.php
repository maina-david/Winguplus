<div id="sidebar" class="sidebar">
   @php  $module = 'Asset Management' @endphp
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      @include('partials._nav-profile')
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         {{-- <li class="nav-header">My Menu</li> --}}
         {{-- <li class="has-sub">
            <a href="#">
               <i class="fal fa-hand-holding-usd"></i>
               <span>My Assets</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="#">
               <i class="fal fa-hand-holding-usd"></i>
               <span>My Work orders</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="#">
               <i class="fal fa-hand-holding-usd"></i>
               <span>My Check-in/check-out</span>
            </a>
         </li> --}}
         <li class="nav-header">Module Menu</li>
         <li class="has-sub {{ Nav::isResource('dashboard') }}">
            <a href="{!! route('assets.dashboard') !!}">
               <i class="fal fa-chart-network"></i>
               <span>Dashboard</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isRoute('assets.create') }} {{ Nav::isRoute('assets.index') }} {{ Nav::isRoute('assets.edit') }} {!! Nav::isRoute('assets.show') !!} {!! Nav::isResource('events') !!} ">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-barcode-alt"></i>
               <span>Assets</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('assets.index') }}"><a href="{!! route('assets.index') !!}">All Assets</a></li>
               <li class="{{ Nav::isRoute('assets.create') }}"><a href="{!! route('assets.create') !!}">Add Asset</a></li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('licenses') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-laptop-code"></i>
               <span>Licenses</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('licenses.assets.index') }}"><a href="{!! route('licenses.assets.index') !!}">All Licenses</a></li>
               <li class="{{ Nav::isRoute('licenses.assets.create') }}"><a href="{!! route('licenses.assets.create') !!}">Add Licenses</a></li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('type') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-list-ul"></i>
               <span>Asset Type</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('assets.type.index') }}"><a href="{!! route('assets.type.index') !!}">All Asset Types</a></li>
               <li class="{{ Nav::isRoute('assets.type.index') }}"><a href="{!! route('assets.type.index') !!}">Add Asset Types</a></li>
            </ul>
         </li>
         {{-- <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-bell-on"></i>
               <span>Alert</span>
            </a>
            <ul class="sub-menu">
               <li class="#"><a href="#"> Assets Past Due <span class="badge badge-primary pull-right">10</span></a></li>
               <li class="#"><a href="#"> Leases Expiring <span class="badge badge-primary pull-right">10</span></a></li>
               <li class="#"><a href="#"> Maintenance Due <span class="badge badge-primary pull-right">10</span></a></li>
               <li class="#"><a href="#"> Warranties Expiring <span class="badge badge-primary pull-right">0</span></a></li>
            </ul>
         </li> --}}
         {{-- <li class="has-sub {{ Nav::isResource('types') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-list-ul"></i>
               <span>Contract management</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('assets.type.index') }}"><a href="{!! route('assets.type.index') !!}">All Asset Types</a></li>
               <li class="{{ Nav::isRoute('assets.type.index') }}"><a href="{!! route('assets.type.index') !!}">Add Asset Types</a></li>
            </ul>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="{!! route('finance.index') !!}">
               <i class="fal fa-cogs"></i>
               <span>Maintenance</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="{!! route('finance.index') !!}">
               <i class="fal fa-map-marker-alt"></i>
               <span>Locations</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="{!! route('finance.index') !!}">
               <i class="fal fa-toolbox"></i>
               <span>Work Orders</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="{!! route('finance.index') !!}">
               <i class="fal fa-users-cog"></i>
               <span>Suppliers</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="{!! route('finance.index') !!}">
               <i class="fal fa-sitemap"></i>
               <span>Departments</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="{!! route('finance.index') !!}">
               <i class="fal fa-users"></i>
               <span>Employees</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="{!! route('finance.index') !!}">
               <i class="fal fa-chart-pie"></i>
               <span>Report</span>
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
