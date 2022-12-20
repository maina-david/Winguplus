@extends('layouts.app')
@section('title','Events | Event Manager')
@section('sidebar')
	@include('app.events.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Event Manager</a></li>
         <li class="breadcrumb-item"><a href="#">Events</a></li>
         <li class="breadcrumb-item active">Event List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-calendar-alt"></i> Events</h1>
      <!-- end page-header -->
      <div class="row">
         @foreach ($events as $event)
            <div class="col-md-3">
               <div class="card border-0">
                  @if($event->cover_image)
                     <img class="card-img-top" src="{!! asset('businesses/'.Wingu::business()->business_code.'/events/'.$event->event_code.'/events/images/'.$event->cover_image) !!}" alt="{!! $event->title !!}">
                  @else
                     <img class="card-img-top" src="{!! asset('assets/img/image_placeholder.png') !!}" alt="{!! $event->title !!}">
                  @endif
                  <div class="card-body">
                     <h5><b>{!! $event->title !!}</b></h5>
                     <a href="{!! route('events.show',$event->event_code) !!}" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i> View</a>
                     <a href="{!! route('events.show',$event->event_code) !!}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
                     <a href="{!! route('events.show',$event->event_code) !!}" class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i> Delete</a>
                  </div>
               </div>
            </div>
         @endforeach
      </div>
   </div>
@endsection
@section('scripts')

@endsection
