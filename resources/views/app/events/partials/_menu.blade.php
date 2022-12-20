<div id="sidebar" class="sidebar">
   @php  $module = 'Event Manager' @endphp
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      @include('partials._nav-profile')
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Module Menu</li>
         <li class="has-sub {{ Nav::isResource('dashboard') }}">
            <a href="{!! route('events.manager.dashboard') !!}">
               <i class="fal fa-chart-network"></i>
               <span>Dashboard</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="#">
               <i class="fal fa-users"></i>
               <span>Customers</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isResource('events') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-calendar-alt"></i>
               <span>Events</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isResource('events') }}"><a href="{!! route('events') !!}">Events</a></li>
               <li class="{{ Nav::isResource('events') }}"><a href="{!! route('events.create') !!}">Add Events</a></li>
            </ul>
         </li>
         {{-- <li class="has-sub">
            <a href="#">
               <i class="fal fa-calendar"></i>
               <span>Calender</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="#">
               <i class="fal fa-voicemail"></i>
               <span>Newsletter</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="#">
               <i class="fal fa-phone-volume"></i>
               <span>Inquiries</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-globe"></i>
               <span>Web site</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isResource('products') }}"><a href="#">Slider</a></li>
               <li class="{{ Nav::isResource('products') }}"><a href="#">Contact Page</a></li>
               <li class="{{ Nav::isResource('products') }}"><a href="#">About Page</a></li>
               <li class="{{ Nav::isResource('products') }}"><a href="#">FAQ's Page</a></li>
            </ul>
         </li> --}}
         {{-- <li class="has-sub {{ Nav::isResource('product') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-cube"></i>
               <span>Products</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isResource('products') }}"><a href="{!! route('salesflow.product.index') !!}">Products</a></li>
               <li class="{{ Nav::isRoute('salesflow.products.create') }}"><a href="{!! route('salesflow.products.create') !!}">Add Products</a></li>
               <li class="{{ Nav::isResource('category') }}"><a href="{!! route('salesflow.product.category') !!}">Categories</a></li>
               <li class="{{ Nav::isResource('brand') }}"><a href="{!! route('salesflow.product.brand') !!}">Brands</a></li>
            </ul>
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
