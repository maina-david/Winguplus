<div id="sidebar" class="sidebar">
   @php  $module = 'Sales Flow' @endphp
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      @include('partials._nav-profile')
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Module Menu</li>
         <li class="has-sub {{ Nav::isResource('dashboard') }}">
            <a href="{!! route('salesflow.dashboard') !!}">
               <i class="fal fa-chart-network"></i>
               <span>Dashboard</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isResource('product') }}">
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
         </li>
         <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-inventory"></i>
               <span>Inventory</span>
            </a>
            <ul class="sub-menu">
               <li><a href="#">Allocate Inventory</a></li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('customer') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users-crown"></i>
               <span>Customers</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('salesflow.customer.index') }}"><a href="{!! route('salesflow.customer.index') !!}">Customers</a></li>
               <li class="{{ Nav::isRoute('salesflow.customer.create') }}"><a href="{!! route('salesflow.customer.create') !!}">Add Customers</a></li>
               <li class="{{ Nav::isRoute('salesflow.customer.category.index') }}"><a href="{!! route('salesflow.customer.category.index') !!}">Categories</a></li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('client') }}">
            <a href="#">
               <i class="fal fa-sign-in"></i>
               <span>Customer Visits</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-user-hard-hat"></i>
               <span>Suppliers</span>
            </a>
            <ul class="sub-menu">
               <li><a href="#">All Suppliers</a></li>
               <li><a href="#">Add Suppliers</a></li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('client') }}">
            <a href="#">
               <i class="fal fa-shopping-cart"></i>
               <span>Orders</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isResource('client') }}">
            <a href="#">
               <i class="fal fa-truck-loading"></i>
               <span>Deliveries</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isResource('client') }}">
            <a href="#">
               <i class="fal fa-calendar-day"></i>
               <span>Scheduled Visits</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-clipboard-list-check"></i>
               <span>Survey</span>
            </a>
            <ul class="sub-menu">
               <li><a href="#">All Surveys</a></li>
               <li><a href="#">Create Survey</a></li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('client') }}">
            <a href="#">
               <i class="fal fa-route"></i>
               <span>Route Scheduling</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isResource('client') }}">
            <a href="#">
               <i class="fal fa-warehouse-alt"></i>
               <span>Warehousing</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isResource('client') }}">
            <a href="#">
               <i class="fal fa-users"></i>
               <span>Users</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isResource('client') }}">
            <a href="#">
               <i class="fal fa-map-marked-alt"></i>
               <span>Territories</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isResource('client') }}">
            <a href="#">
               <i class="fal fa-tools"></i>
               <span>Settings</span>
            </a>
         </li>
         <!-- begin sidebar minify button -->
         <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
         <!-- end sidebar minify button -->
      </ul>
      <!-- end sidebar nav -->
   </div>
   <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
