@extends('layouts.app')
@section('title','Events | Events Manager')
@section('sidebar')
	@include('app.events.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Wingu Crowd</a></li>
         <li class="breadcrumb-item"><a href="#">Events</a></li>
         <li class="breadcrumb-item active">Event List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-calendar-alt"></i> Event Details</h1>
      <!-- end page-header -->
      @include('app.events.events._menu')
      <div class="row">
         <div class="col-md-3">
            @if($event->cover_image)
               <img class="card-img-top" src="{!! asset('businesses/'.Wingu::business()->business_code.'/events/'.$event->event_code.'/events/images/'.$event->cover_image) !!}" alt="{!! $event->title !!}">
            @else
               <img class="card-img-top" src="{!! asset('assets/img/image_placeholder.png') !!}" alt="{!! $event->title !!}">
            @endif
         </div>
         <div class="col-md-8">
            <div class="card">
               <div class="card-body">
                  {!! $event->details !!}
               </div>
            </div>
            <div class="card">
               <div class="card-body">
                  {!! $event->map !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')

@endsection
