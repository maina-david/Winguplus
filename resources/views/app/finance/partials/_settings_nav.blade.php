<div class="col-md-3">
   <div class="list-group">
      <a href="{!! route('settings.business.index') !!}" class="list-group-item {{ Nav::isResource('business') }}">
         <i class="fal fa-globe"></i> Business Profile
      </a>
      <a href="{!! route('finance.settings.invoice') !!}" class="list-group-item {{ Nav::isResource('invoice') }}">
         <i class="fal fa-file-invoice-dollar"></i> Invoice
      </a>
      <a href="{!! route('finance.settings.taxes') !!}" class="list-group-item {{ Nav::isResource('taxes') }}">
         <i class="fal fa-coins"></i> Tax Rates
      </a>
      <a href="{!! route('finance.income.category') !!}" class="list-group-item {{ Nav::isResource('income') }}">
         <i class="fal fa-money-bill-alt"></i> Income Categories
      </a>
      <a href="{!! route('finance.expense.category.index') !!}" class="list-group-item {{ Nav::isResource('expense') }}">
         <i class="fal fa-sitemap"></i> Expense Categories
      </a>
      <a href="{!! route('finance.settings.lpo') !!}" class="list-group-item {{ Nav::isResource('lpo') }}">
         <i class="fal fa-file-contract"></i> Purchase Order
      </a>
      <a href="{!! route('finance.settings.quote') !!}" class="list-group-item {{ Nav::isResource('quote') }}">
         <i class="far fa-file-alt"></i> Quotes
      </a>
      <a href="{!! route('finance.settings.salesorders') !!}" class="list-group-item {{ Nav::isResource('salesorders') }}">
         <i class="fal fa-cart-arrow-down"></i> Sales orders
      </a>
      <a href="{!! route('finance.settings.creditnote') !!}" class="list-group-item {{ Nav::isResource('creditnote') }}">
         <i class="fal fa-credit-card"></i> Credit Note
      </a>
      <a href="{!! route('finance.payment.mode') !!}" class="list-group-item {{ Nav::isResource('mode') }}">
      <i class="fab fa-amazon-pay"></i> Payment Modes
      </a>
      {{-- <a href="{!! route('finance.settings.invoice') !!}" class="list-group-item">
      <i class="fal fa-upload"></i> Import | Export
      </a> --}}
      {{-- <a href="{!! route('finance.settings.currency') !!}" class="list-group-item {{ Nav::isResource('currency') }}">
      <i class="fal fa-university"></i> Credit Cards & Banking
      </a> --}}
   </div>
</div>
