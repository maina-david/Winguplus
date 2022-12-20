@extends('layouts.app')
{{-- page header --}}
@section('title','Expenses List | Finance')

{{-- dashboards menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection


{{-- content section --}}
@section('content')
	<div class="content">
      <div class="pull-right">
         <a href="{!! route('finance.expense.create') !!}" class="btn btn-pink"><i class="fal fa-plus"></i> New Expense</a>
      </div>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-receipt"></i> Expenses</h1>
		@include('partials._messages')
      @livewire('finance.expenses.expenses')
	</div>
@endsection
