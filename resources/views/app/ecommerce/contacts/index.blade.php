@extends('layouts.app')
{{-- page header --}}
@section('title','Customer | E-commerce')
{{-- page styles --}}
@section('stylesheets')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.ecommerce.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('ecommerce.dashboard') !!}">E-commerce</a></li>
         <li class="breadcrumb-item"><a href="{!! route('ecommerce.customers.index') !!}">Customers</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users-crown"></i> All Customers</h1>
		@include('partials._messages')
      @livewire('ecommerce.customers.index')
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
