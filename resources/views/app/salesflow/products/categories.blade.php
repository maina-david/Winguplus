@extends('layouts.app')
{{-- page header --}}
@section('title','Item Category | Finance')
{{-- page styles --}}

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
         <li class="breadcrumb-item"><a href="{!! route('finance.product.category') !!}">Item Category</a></li>
         <li class="breadcrumb-item active">Categories</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-sitemap"></i> All Categories</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      @livewire('finance.products.category')
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#delete').modal('hide');
      });
   </script>
@endsection
