@extends('layouts.app')
{{-- page header --}}
@section('title','Customer | Finance')
{{-- page styles --}}
@section('stylesheets')

@endsection

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('finance.contact.create') !!}" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add a Customer</a>
         <a href="{!! route('finance.contact.import') !!}" class="btn btn-primary"><i class="fal fa-file-upload"></i> Import Customer</a>
         <a href="{!! route('finance.contact.export','csv') !!}" class="btn btn-warning"><i class="fal fa-file-download"></i> Export Customer</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> All Customers</h1>
		@include('partials._messages')
      @livewire('finance.customers.index')
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
