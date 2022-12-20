<div class="card-header">
   <ul class="nav nav-tabs card-header-tabs">
      <li class="nav-item">
         <a class="{{ Nav::isRoute('ecommerce.settings.website.details') }}" href="{!! route('ecommerce.settings.website.details') !!}"><i class="fal fa-info-circle"></i> Website Details </a>
      </li>
      <li class="nav-item">
         <a class="{{ Nav::isRoute('ecommerce.settings.website.contacts') }}" href="{!! route('ecommerce.settings.website.contacts') !!}"><i class="fal fa-phone-rotary"></i> Contact Details</a>
      </li>
      <li class="nav-item">
         <a class="{{ Nav::isRoute('ecommerce.settings.website.policies') }}" href="{!! route('ecommerce.settings.website.policies') !!}"><i class="fal fa-shield-alt"></i> Policies</a>
      </li>
      <li class="nav-item">
         <a class="{{ Nav::isRoute('ecommerce.settings.website.analytics') }}" href="{!! route('ecommerce.settings.website.analytics') !!}"><i class="fal fa-analytics"></i> Analytics</a>
      </li>
   </ul>
</div>