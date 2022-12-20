@extends('layouts.app')
{{-- page header --}}
@section('title','Product Category')
{{-- dashboad menu --}}
@section('sidebar')
   @include('app.ecommerce.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('ecommerce.dashboard') !!}">E-commerce</a></li>
         <li class="breadcrumb-item"><a href="{!! route('ecommerce.product.index') !!}">Products</a></li>
         <li class="breadcrumb-item"><a href="{!! route('ecommerce.product.category') !!}">Category</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-sitemap"></i> All Categories</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      @livewire('ecommerce.products.category')
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
