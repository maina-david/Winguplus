@extends('layouts.app')
@section('title','Dashboard')
@section('sidebar')
	@include('app.events.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">Events Manager</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.product.index') !!}">Item</a></li>
         <li class="breadcrumb-item active">Edit Item</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-chart-network"></i> Dashboard</h1>
      <!-- end page-header -->
      <div class="row">

      </div>
   </div>
@endsection
@section('scripts')

@endsection
