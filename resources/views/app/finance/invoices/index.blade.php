@extends('layouts.app')
{{-- page header --}}
@section('title','Invoices | Finance')

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<div class="pull-right">
         <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"> <i class="fas fa-plus-circle"></i> New invoice</button>
            <ul class="dropdown-menu">
               <li><a href="{!! route('finance.invoice.product.create') !!}">Create New Invoice</a></li>
               {{-- <li><a href="{!! route('finance.invoice.recurring.create') !!}">Recurring Invoice</a></li> --}}
            </ul>
         </div>
         {{-- <a href="#" class="btn btn-pink"><i class="fas fa-chart-pie"></i> Reports</a> --}}
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> All Invoices</h1>
      @include('partials._messages')

		@livewire('finance.invoice.invoices')
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('Modal', () => {
         $('#delete').modal('hide');
      });
   </script>
@endsection

