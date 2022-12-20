@extends('layouts.app')
{{-- page header --}}
@section('title','Customer Category | Sales Flow')
{{-- page styles --}}

{{-- dashboafd menu --}}
@section('sidebar')
	@include('app.salesflow.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Sale Flow</a></li>
         <li class="breadcrumb-item"><a href="#">Customer</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.contact.groups.index') !!}">Category</a></li>
         <li class="breadcrumb-item active">List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-sitemap"></i> Customer Category</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      @livewire('salesflow.customers.groups')
   </div>
@endsection
