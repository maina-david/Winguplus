@extends('layouts.app')
@section('title','POS Terminal')
@section('stylesheet')
   <link href="{!! asset('assets/css/pos.css') !!}" rel="stylesheet" />
   <style>
      .accordion p{
         margin-bottom: 0px;
      }
   </style>
@endsection
@section('sidebar')
	@include('app.pos.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin row -->
      @livewire('pos.terminal')
   </div>
@endsection

 