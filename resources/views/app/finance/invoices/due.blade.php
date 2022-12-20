@extends('layouts.app')
{{-- page header --}}
@section('title','Due Invoices | Finance')

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.invoice.index') !!}">Invoices</a></li>
         <li class="breadcrumb-item active">Due invoices</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-history"></i> Due Invoice</h1>
      @include('partials._messages')
      @livewire('finance.invoice.due')
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
