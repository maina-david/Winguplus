@extends('layouts.app')
{{-- page header --}}
@section('title','Supplier List | Finance')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
            <a href="{!! route('finance.supplier.create') !!}" class="btn btn-pink"><i class="fas fa-user-plus"></i> Add A Supplier</a>
            <a href="{!! route('supplier.import.index') !!}" class="btn btn-pink"><i class="fas fa-file-upload"></i> Import Supplier</a>
            <a href="{!! route('supplier.export','csv') !!}" class="btn btn-pink"><i class="fas fa-file-download"></i> Export Supplier</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users-cog"></i> All Supplier</h1>
		@include('partials._messages')
      @livewire('finance.suppliers.suppliers')
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
