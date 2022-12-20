@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $property->title !!} | Property Details @endsection
{{-- page styles --}}
@section('sidebar')
	@include('app.propertywingu.partials._menu')
@endsection
{{-- content section --}}
@section('content')
   <div class="row">
      @include('app.propertywingu.partials._property_menu')
      @if(request()->route()->getName() == 'propertywingu.property.rental.billing.edit')
         @include('app.propertywingu.accounting.invoices.edit')
      @endif

      {{-- invoices --}}
      @if(request()->route()->getName() == 'propertywingu.property.invoice.index')
         @include('app.propertywingu.accounting.invoices.index')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.invoice.create')
         @include('app.propertywingu.accounting.invoices.create')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.invoice.edit')
         @include('app.propertywingu.accounting.invoices.edit')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.invoice.settings')
         @include('app.propertywingu.accounting.invoices.settings')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.invoice.create.bulk')
         @include('app.propertywingu.accounting.invoices.bulk')
      @endif

      @if(request()->route()->getName() == 'propertywingu.property.mpesaapi.integration')
         @include('app.propertywingu.property.integration.payments.mpesaapi')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.mpesatill.integration')
         @include('app.propertywingu.property.integration.payments.mpesatill')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.mpesapaybill.integration')
         @include('app.propertywingu.property.integration.payments.paybill')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.bank1.integration')
         @include('app.propertywingu.property.integration.payments.bank1')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.bank2.integration')
         @include('app.propertywingu.property.integration.payments.bank2')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.bank3.integration')
         @include('app.propertywingu.property.integration.payments.bank3')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.bank4.integration')
         @include('app.propertywingu.property.integration.payments.bank4')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.bank5.integration')
         @include('app.propertywingu.property.integration.payments.bank5')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.images')
         @include('app.propertywingu.property.images')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.tenants.create')
         @include('app.propertywingu.tenants.create')
      @endif
      {{-- lease list --}}
      @if(request()->route()->getName() == 'propertywingu.property.leases')
         @include('app.propertywingu.property.lease.index')
      @endif
      @if(request()->route()->getName() == 'propertywingu.property.leases.create')
         @include('app.propertywingu.property.lease.create')
      @endif
   </div>
@endsection
