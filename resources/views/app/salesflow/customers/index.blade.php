@extends('layouts.app')
{{-- page header --}}
@section('title','Customer | Sales Flow')
@section('sidebar')
	@include('app.salesflow.partials._menu')
@endsection
{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('salesflow.customer.create') !!}" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add a Customer</a>
         <a href="{!! route('salesflow.customer.import') !!}" class="btn btn-primary"><i class="fal fa-file-upload"></i> Import Customer</a>
         <a href="{!! route('salesflow.customer.export','csv') !!}" class="btn btn-warning"><i class="fal fa-file-download"></i> Export Customer</a>
      </div>
      <!-- end breadcrumb -->
      <h1 class="page-header"><i class="fal fa-users"></i> All Customers</h1>
      @include('partials._messages')
      @livewire('salesflow.customers.index')
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
