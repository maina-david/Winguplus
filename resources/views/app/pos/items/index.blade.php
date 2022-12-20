@extends('layouts.app')
{{-- page header --}}
@section('title','Items')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.pos.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
				<a href="{!! route('pos.item.create') !!}" class="btn btn-success"><i class="fas fa-plus"></i> Add New Item</a>
				{{-- <a href="{!! route('finance.products.import') !!}" class="btn btn-warning"><i class="fas fa-file-upload"></i> Import Items</a>
				<a href="{!! route('finance.products.export','csv') !!}" class="btn btn-pink"><i class="fas fa-file-download"></i> Export Items</a> --}}
		</div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shopping-basket"></i> All Items </h1>
      <!-- end page-header -->
		@include('partials._messages')
		@livewire('pos.items')
	</div>
@endsection
