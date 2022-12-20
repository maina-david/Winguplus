<div id="sidebar" class="sidebar">
   @php  $module = 'Subscriptions' @endphp
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      @include('partials._nav-profile')
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <li class="has-sub {{ Nav::isRoute('subscriptions.dashboard') }}">
            <a href="{!! route('subscriptions.dashboard') !!}">
               <i class="fa fa-th-large"></i>
               <span>Dashboard</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isResource('products') }} {{ Nav::isResource('plan') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-shopping-basket"></i>
               <span>Products</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('subscriptions.products.index') }}">
                  <a href="{!! route('subscriptions.products.index') !!}">All Products</a>
               </li>
               <li class="{{ Nav::isRoute('subscriptions.products.create') }}">
                  <a href="{!! route('subscriptions.products.create') !!}">Add Products</a>
               </li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('customer') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users"></i>
               <span>Customers</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('subscription.customer.index') }}">
                  <a href="{!! route('subscription.customer.index') !!}">Customer List</a>
               </li>
               <li class="{{ Nav::isRoute('subscription.customer.create') }}">
                  <a href="{!! route('subscription.customer.create') !!}">Add Customer</a>
               </li>
            </ul>
         </li>
         <li class="has-sub {!! Nav::isRoute('subscriptions.index') !!} {!! Nav::isRoute('subscriptions.create') !!} {!! Nav::isRoute('subscriptions.show') !!} {!! Nav::isRoute('subscriptions.invoices') !!}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-sync-alt"></i>
               <span>Subscriptions</span>
            </a>
            <ul class="sub-menu">
               <li class="{!! Nav::isRoute('subscriptions.index') !!}"><a href="{!! route('subscriptions.index') !!}">All Subscriptions</a></li>
               <li class="{!! Nav::isRoute('subscriptions.create') !!}"><a href="{!! route('subscriptions.create') !!}">Add Subscription</a></li>
            </ul>
         </li>
         <li class="has-sub {!! Nav::isRoute('subscription.invoice.index') !!} {!! Nav::isRoute('subscription.invoice.show') !!}">
            <a href="{!! route('subscription.invoice.index') !!}">
               <i class="fal fa-file-invoice-dollar"></i>
               <span>Invoices</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="#">
               <i class="fal fa-file-invoice"></i>
               <span>Credit Note</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="#">
               <i class="fal fa-receipt"></i>
               <span>Transactions</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="#">
               <i class="fal fa-chart-pie"></i>
               <span>Reports</span>
            </a>
         </li>
         <li class="has-sub {!! Nav::isResource('settings') !!}">
            <a href="{!! route('subscriptions.settings.index') !!}">
               <i class="fal fa-cogs"></i>
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
