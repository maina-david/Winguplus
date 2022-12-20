<div id="sidebar" class="sidebar">
   @php
      $module = 'Finance Management';
   @endphp
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      @include('partials._nav-profile')
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <li class="has-sub {{ Nav::isResource('dashboard') }}">
            <a href="{!! route('finance.index') !!}">
               <i class="fa fa-th-large"></i>
               <span>Dashboard</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isResource('customer') }} {{ Nav::isRoute('finance.contact.index') }} {{ Nav::isRoute('finance.contact.create') }} {{ Nav::isRoute('finance.contact.groups.index') }} {!! Nav::isRoute('finance.contact.edit') !!}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users"></i>
               <span>Customers</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('finance.contact.index') }}"><a href="{!! route('finance.contact.index') !!}">Customer List</a></li>
               <li class="{{ Nav::isRoute('finance.contact.create') }}"><a href="{!! route('finance.contact.create') !!}">Add Customer</a></li>
               <li class="{{ Nav::isRoute('finance.contact.groups.index') }}"><a href="{!! route('finance.contact.groups.index') !!}">Customer category</a></li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('finance/items') }} {{ Nav::isResource('stock') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-cube"></i>
               <span>Items</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isResource('items') }}"><a href="{!! route('finance.product.index') !!}">Items</a></li>
               <li class="{{ Nav::isRoute('finance.products.create') }}"><a href="{!! route('finance.products.create') !!}">Add Item</a></li>
               <li class="{{ Nav::isResource('category') }}"><a href="{!! route('finance.product.category') !!}">Category</a></li>
               <li class="{{ Nav::isResource('stock') }}"><a href="{!! route('finance.product.stock.control') !!}">Stock Control</a></li>
               <li class="{{ Nav::isResource('brand') }}"><a href="{!! route('finance.product.brand') !!}">Brands</a></li>
               {{-- <li class="{{ Nav::isResource('tags') }}"><a href="{!! route('finance.product.tags') !!}">Items Tags</a></li> --}}
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('invoice') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-file-invoice"></i>
               <span>Invoice</span>
            </a>
            <ul class="sub-menu">
               <li><a href="{!! route('finance.invoice.index') !!}">All Invoices</a></li>
               <li class="has-sub {{ Nav::isResource('create') }}">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Create Invoice
                  </a>
                  <ul class="sub-menu">
                     <li><a href="{!! route('finance.invoice.product.create') !!}">Add New Invoice</a></li>
                     {{-- <li><a href="{!! route('finance.invoice.recurring.create') !!}">Recurring Invoice</a></li> --}}
                  </ul>
               </li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isResource('payments') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-cash-register"></i>
               <span>Payments Received</span>
            </a>
            <ul class="sub-menu">
               <li><a href="{!! route('finance.payments.received') !!}">All Payments</a></li>
                  <li><a href="{!! route('finance.payments.create') !!}">Add Payments</a></li>
            </ul>
         </li>
         @if(Wingu::business()->plan_code != 'pNIjNQhri1auVNDwahl2Lbi8TTVIlp')
            <li class="has-sub {{ Nav::isResource('expense') }}">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-receipt"></i>
                  <span>Expenses</span>
               </a>
               <ul class="sub-menu">
                  <li class="{{ Nav::isRoute('finance.expense.index') }}"><a href="{!! route('finance.expense.index') !!}">Expense List</a></li>
                  <li class="{{ Nav::isRoute('finance.expense.create') }}"><a href="{!! route('finance.expense.create') !!}">Add Expense</a></li>
                  <li class="{{ Nav::isRoute('finance.expense.category.index') }}"><a href="{!! route('finance.expense.category.index') !!}">Expense Category</a></li>
               </ul>
            </li>
            <li class="has-sub {{ Nav::isResource('supplier') }}">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-users-cog"></i>
                  <span>Suppliers</span>
               </a>
               <ul class="sub-menu">
                  <li class="{!! Nav::isRoute('finance.supplier.index') !!}"><a href="{!! route('finance.supplier.index') !!}">Suppliers List</a></li>
                  <li class="{!! Nav::isRoute('finance.supplier.create') !!}"><a href="{!! route('finance.supplier.create') !!}">Add Suppliers</a></li>
                  <li class="{{ Nav::isRoute('finance.supplier.groups.index') }}"><a href="{!! route('finance.supplier.groups.index') !!}">Suppliers category</a></li>
               </ul>
            </li>

            <li class="has-sub {{ Nav::isResource('quotes') }}">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-file-alt"></i>
                  <span>Quotes</span>
               </a>
               <ul class="sub-menu">
                  <li><a href="{!! route('finance.quotes.index') !!}">All Quotes</a></li>
                  <li><a href="{!! route('finance.quotes.create') !!}">Create Quotes</a></li>
               </ul>
            </li>
            <li class="has-sub {{ Nav::isResource('purchaseorders') }}">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-file-contract"></i>
                  <span>Purchase Order </span>
               </a>
               <ul class="sub-menu">
                  <li class="{{ Nav::isRoute('finance.lpo.index') }}"><a href="{!! route('finance.lpo.index') !!}">All Purchase Orders</a></li>
                  <li class="{{ Nav::isRoute('finance.lpo.create') }}"><a href="{!! route('finance.lpo.create') !!}">Add Purchase Order</a></li>
               </ul>
            </li>
            {{-- <li class="has-sub {{ Nav::isResource('salesorders') }}">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-cart-arrow-down"></i>
                  <span>Sales Orders</span>
               </a>
               <ul class="sub-menu">
                  <li class="{{ Nav::isRoute('finance.salesorders.index') }}"><a href="{!! route('finance.salesorders.index') !!}">All Orders</a></li>
                  <li class="{{ Nav::isRoute('finance.salesorders.create') }}"><a href="{!! route('finance.salesorders.create') !!}">Add Order</a></li>
               </ul>
            </li> --}}
            <li class="has-sub {{ Nav::isResource('creditnote') }}">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-credit-card"></i>
                  <span>Credit Note</span>
               </a>
               <ul class="sub-menu">
                  <li><a href="{!! route('finance.creditnote.index') !!}">All Credit Note</a></li>
                  <li><a href="{!! route('finance.creditnote.create') !!}">Create Credit Note</a></li>
               </ul>
            </li>
            {{-- <li class="has-sub {{ Nav::isResource('account') }}">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-piggy-bank"></i>
                  <span>Bank & Cash</span>
               </a>
               <ul class="sub-menu">
                     <li class="{!! Nav::isRoute('finance.account') !!}"><a href="{!! Route('finance.account') !!}">List Account</a></li>
                     <li class="{!! Nav::isRoute('finance.account.create') !!}"><a href="{!! Route('finance.account.create') !!}">Add Accounts</a></li>
                     <li class="{!! Nav::isRoute('finance.account') !!}"><a href="{!! Route('finance.account') !!}">Account Balances</a></li>
               </ul>
            </li> --}}
            <li class="has-sub {{ Nav::isResource('report') }}">
               <a href="{!! route('finance.report') !!}">
                  <i class="fal fa-chart-pie"></i>
                  <span>Report</span>
               </a>
            </li>
         @endif
         <li class="has-sub {{ Nav::isResource('settings') }}">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="fal fa-tools"></i>
					<span>Settings</span>
				</a>
				<ul class="sub-menu">
               <li><a href="{!! route('finance.settings.invoice') !!}">Invoice</a></li>
               <li class="{{ Nav::isResource('taxes') }}"><a href="{!! route('finance.settings.taxes') !!}">Tax Rates</a></li>
               @if(Wingu::business()->plan_code != 'pNIjNQhri1auVNDwahl2Lbi8TTVIlp')
                  <li class="{{ Nav::isResource('lpo') }}"><a href="{!! route('finance.settings.lpo') !!}">Purchase order</a></li>
                  <li class="{{ Nav::isResource('quote') }}"><a href="{!! route('finance.settings.quote') !!}">Quotes</a></li>
                  <li><a href="{!! route('finance.expense.category.index') !!}">Expense</a></li>
                  <li><a href="{!! route('finance.income.category') !!}">Income</a></li>
                  <li class="{{ Nav::isResource('creditnote') }}"><a href="{!! route('finance.settings.creditnote') !!}">Credit Note</a></li>
               @endif
               <li class="{!! Nav::isRoute('finance.payment.mode') !!}"><a href="{!! route('finance.payment.mode') !!}">Payment Methods</a></li>
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
