<ul class="nav nav-pills mb-4">
   <li class="nav-items {{ Nav::isRoute('finance.contact.show') }}">
      <a href="{!! route('finance.contact.show', $customerID) !!}">
         <span class="d-sm-none"><i class="fas fa-chart-bar"></i> Overview</span>
         <span class="d-sm-block d-none"><i class="fas fa-chart-bar"></i> Overview</span>
      </a>
   </li>
   <li class="nav-items {{ Nav::isRoute('finance.contact.comments') }}">
      <a href="{!! route('finance.contact.comments', $customerID) !!}">
         <span class="d-sm-none"><i class="fas fa-comment"></i> Comments</span>
         <span class="d-sm-block d-none"><i class="fas fa-comment"></i> Comments</span>
      </a>
   </li>
   <li class="nav-items {{ Nav::isRoute('finance.contact.invoices') }}">
      <a href="{!! route('finance.contact.invoices', $customerID) !!}">
         <span class="d-sm-none"><i class="fas fa-file-invoice-dollar"></i> invoices</span>
         <span class="d-sm-block d-none"><i class="fas fa-file-invoice-dollar"></i> invoices</span>
      </a>
   </li>

   <li class="nav-items {{ Nav::isRoute('finance.contact.creditnotes') }}">
      <a href="{!! route('finance.contact.creditnotes', $customerID) !!}">
         <span class="d-sm-none"><i class="fas fa-funnel-dollar"></i> Credits</span>
         <span class="d-sm-block d-none"><i class="fas fa-funnel-dollar"></i> Credits</span>
      </a>
   </li>
   {{-- <li class="nav-items">
      <a href="#nav-pills-tab-4">
         <span class="d-sm-none"><i class="fas fa-hammer"></i> Projects</span>
         <span class="d-sm-block d-none"><i class="fas fa-hammer"></i> Projects</span>
      </a>
   </li> --}}
   <li class="nav-items {{ Nav::isRoute('finance.contact.contacts') }}">
      <a href="{!! route('finance.contact.contacts',$customerID) !!}">
         <span class="d-sm-none"><i class="fas fa-address-book"></i> Contacts</span>
         <span class="d-sm-block d-none"><i class="fas fa-address-book"></i> Contacts</span>
      </a>
   </li>
   <li class="nav-items">
      <a href="#nav-pills-tab-4">
         <span class="d-sm-none"><i class="fas fa-file-alt"></i> Statement</span>
         <span class="d-sm-block d-none"><i class="fas fa-file-alt"></i> Statement</span>
      </a>
   </li>
   <li class="nav-items">
      <a href="#nav-pills-tab-4">
         <span class="d-sm-none"><i class="fas fa-sync-alt"></i> Subscriptions</span>
         <span class="d-sm-block d-none"><i class="fas fa-sync-alt"></i> Subscriptions</span>
      </a>
   </li>
   
</ul>
