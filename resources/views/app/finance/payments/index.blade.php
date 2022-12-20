@extends('layouts.app')
{{-- page header --}}
@section('title','Payments | Finance')
{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <div class="pull-right">
      <a href="{{ route('finance.payments.create') }}" title="" class="btn btn-pink"><i class="fas fa-plus-circle"></i> Add Payment</a>
   </div>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-cash-register"></i> Payments</h1>
   @include('partials._messages')
   @livewire('finance.invoice.payments')
</div>
@endsection

