@extends('layouts.app')
{{-- page header --}}
@section('title','List Asset')

{{-- dashboad menu --}}
@section('sidebar')
   @include('app.assets.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div class="content">
	<div class="pull-right">
      <a href="{!! route('assets.create') !!}" class="btn btn-pink"><i class="fal fa-plus-circle"></i> Add Asset</a>
   </div>
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fas fa-barcode"></i> Assets</h1>
	@include('partials._messages')
	@livewire('assets.assets.assets')
</div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
