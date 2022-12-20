<div id="sidebar" class="sidebar">
   @php  $module = 'E-commerce' @endphp
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      @include('partials._nav-profile')
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <li class="has-sub {{ Nav::isResource('dashboard') }}">
            <a href="{!! route('ecommerce.dashboard') !!}">
               <i class="fa fa-th-large"></i>
               <span>Dashboard</span>
            </a>
         </li>
         
         <li class="has-sub {{ Nav::isResource('products') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-boxes"></i>
               <span>Products</span>
            </a>
            <ul class="sub-menu">
               <li class="has-sub closed {{ Nav::isRoute('ecommerce.product.index') }}">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Products
                  </a>
                  <ul class="sub-menu" style="display: none;">
                     <li class="{{ Nav::isResource('products') }}"><a href="{!! route('ecommerce.product.index') !!}">All Products</a></li>
                     <li><a href="{!! route('ecommerce.products.create') !!}">Add Products</a></li>
                  </ul>
               </li>
               <li class="has-sub closed {{ Nav::isRoute('ecommerce.product.category') }}">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Category
                  </a>
                  <ul class="sub-menu" style="display: none;">
                     <li><a href="{!! route('ecommerce.product.category') !!}">All Category</a></li>
                     <li><a href="{!! route('ecommerce.product.category') !!}">Add Category</a></li>
                  </ul>
               </li>
            </ul>
         </li>        
         <li class="has-sub {{ Nav::isResource('orders') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-cart-plus"></i>
               <span>Orders</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isResource('orders') }}"><a href="{!! route('ecommerce.orders.index') !!}">All Orders</a></li>
            </ul>
         </li>      
         <li class="has-sub {!! Nav::isResource('customer') !!}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users-crown"></i>
               <span>Customers</span>
            </a>
            <ul class="sub-menu">
               <li class="{!! Nav::isResource('customers') !!}"><a href="{!! route('ecommerce.customers.index') !!}">All Customers</a></li>
               {{-- <li class="{!! route('ecommerce.customers.create') !!}"><a href="#">Add Licenses</a></li> --}}
            </ul>
         </li>  
         <li class="has-sub {{ Nav::isResource('website') }}">
            <a href="{!! route('ecommerce.settings.website.details') !!}">
               <i class="fal fa-globe"></i>
               <span>Website settings</span>
            </a>
         </li>      
         {{-- <li class="has-sub {{ Nav::isResource('licenses') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-laptop-code"></i>
               <span>Cupons</span>
            </a>
            <ul class="sub-menu">
               <li class="#"><a href="#">All Licenses</a></li>
               <li class="#"><a href="#">Add Licenses</a></li>
            </ul>
         </li>       --}}
         {{-- <li class="has-sub closed">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-globe"></i>
               <span>CMS</span>
            </a>
            <ul class="sub-menu" style="display: none;">
               <li class="has-sub closed">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Sliders
                  </a>
                  <ul class="sub-menu" style="display: none;">
                     <li><a href="javascript:;">Menu 2.2</a></li>
                     <li><a href="javascript:;">Menu 2.3</a></li>
                  </ul>
               </li>
               <li class="has-sub closed">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Pages
                  </a>
                  <ul class="sub-menu" style="display: none;">
                     <li><a href="javascript:;">All Pages</a></li>
                     <li><a href="javascript:;">Add Page</a></li>
                  </ul>
               </li>
            </ul>
         </li>     --}}
         <li class="has-sub {{ Nav::isResource('licenses') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-tools"></i>
               <span>Settings</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isResource('businessprofile') }}"> <a href="{!! route('settings.business.index') !!}">Business Profile</a></li>
               <li class="{{ Nav::isResource('integrations') }}"><a href="{!! route('settings.integrations.payments') !!}">Payment Integration</a></li>
            </ul>
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
