@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $details->product_name !!} | Items| Finance  @endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection


{{-- content section --}}
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <a href="{{ route('finance.products.edit', $details->productCode) }}"  class="btn btn-primary ml-1"><i class="fal fa-pen-fancy"></i></a>
      <a href="" class="btn btn-warning ml-1">Mark as inactive</a>
      <a href="{!! route('finance.products.destroy', $details->productCode) !!}" class="btn btn-danger ml-1 delete">Delete</a>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header">{!! $details->product_name !!}</h1>
   <div class="row">
      <div class="col-md-12">
         <ul class="nav nav-tabs">
            <li class="nav-item {!! Nav::isRoute('finance.products.details') !!}">
               <a class="nav-link {!! Nav::isRoute('finance.products.details') !!}" href="#"><i class="fal fa-info-circle"></i> Overview</a>
            </li>
            <li class="nav-item">
               <a class="nav-link {!! Nav::isRoute('subscriptions.invoices') !!}" href="#"><i class="fal fa-file-invoice-dollar"></i> Invoice History</a>
            </li>
         </ul>
      </div>
      @if(Request::is('finance/items/'.$details->productCode.'/details'))
         @include('app.finance.products.details.overview')
      @endif
   </div>
</div>
@endsection
{{-- page scripts --}}
