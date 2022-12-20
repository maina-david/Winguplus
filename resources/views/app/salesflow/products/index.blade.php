@extends('layouts.app')
{{-- page header --}}
@section('title','Products List | Sales Flow')

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.salesflow.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('salesflow.products.create') !!}" class="btn btn-success"><i class="fas fa-plus"></i> Add New Product</a>
         <a href="{!! route('salesflow.products.import') !!}" class="btn btn-warning"><i class="fas fa-file-upload"></i> Import Product</a>
         <a href="{!! route('salesflow.products.export','csv') !!}" class="btn btn-pink"><i class="fas fa-file-download"></i> Export Product</a>
		</div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"> <i class="fal fa-cube"></i> All Products </h1>
      <!-- end page-header -->
		@include('partials._messages')
		@livewire('salesflow.products.index')
	</div>
@endsection
