@extends('layouts.app')
@section('title','Events | Human Resource')
@section('stylesheet')
@endsection
@section('sidebar')
   @include('app.hr.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
         <li class="breadcrumb-item active"><a href=#">Events</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"> <i class="fal fa-calendar"></i> Events</h1>
		@include('partials._messages')
      @livewire('hr.events.index')
   </div>
   <!-- end #content -->
@endsection
@section('scripts')
@endsection
