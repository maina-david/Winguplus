@extends('layouts.app')
{{-- page header --}}
@section('title','Items List | Finance')

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('finance.products.create') !!}" class="btn btn-success"><i class="fas fa-plus"></i> Add New Items</a>
         <a href="{!! route('finance.products.import') !!}" class="btn btn-warning"><i class="fas fa-file-upload"></i> Import Items</a>
         <a href="{!! route('finance.products.export','csv') !!}" class="btn btn-pink"><i class="fas fa-file-download"></i> Export Items</a>
		</div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"> <i class="fal fa-cube"></i> All Items </h1>
      <!-- end page-header -->
		@include('partials._messages')
		@livewire('finance.products.products')
	</div>
@endsection
