@extends('layouts.app')
@section('title','POS')
@section('sidebar')
	@include('app.pos.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin row -->      
      @livewire('pos.order')      
   </div>
@endsection
@section('scripts')
   
@endsection
