@extends('layouts.app')
{{-- page header --}}
@section('title','Customer Category')
{{-- page styles --}}

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
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
      @livewire('finance.customers.category')
   </div>
@endsection
