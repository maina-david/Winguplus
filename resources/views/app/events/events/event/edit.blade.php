@extends('layouts.app')
@section('title','Edit Event | Events Manager')
@section('sidebar')
	@include('app.events.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Event Manager</a></li>
         <li class="breadcrumb-item"><a href="#">Events</a></li>
         <li class="breadcrumb-item active"> Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-edit"></i> Edit Event</h1>
      <!-- end page-header -->
      @include('app.events.events._menu')
      {!! Form::model($event, ['route' => ['events.update',$event->event_code],'class' => 'row', 'method'=>'post','enctype'=>'multipart/form-data']) !!}
         @csrf
         <div class="col-md-8">
            <div class="card">
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-12 mb-2">
                        <label for="">Event Title</label>
                        {!! Form::text('title',null,['class'=>'form-control']) !!}
                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">Tag Line</label>
                        {!! Form::text('tagline',null,['class'=>'form-control']) !!}
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Number of available tickets</label>
                        {!! Form::text('available_tickets',null,['class'=>'form-control']) !!}
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Event Type</label>
                        {!! Form::select('type',['Paid'=>'Paid','Free' => 'Free'],null,['class'=>'form-control']) !!}
                     </div>
                     <div class="col-md-6 mb-2">
                        <div class="row">
                           <div class="col-md-6">
                              <label for="">Event Start Date</label>
                              {!! Form::date('start_date',null,['class'=>'form-control','required'=>'']) !!}
                           </div>
                           <div class="col-md-6">
                              <label for="">Event Start Time</label>
                              {!! Form::time('start_time',null,['class'=>'form-control']) !!}
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 mb-2">
                        <div class="row">
                           <div class="col-md-6">
                              <label for="">Event End Date</label>
                              {!! Form::date('end_date',null,['class'=>'form-control']) !!}
                           </div>
                           <div class="col-md-6">
                              <label for="">Event End Time</label>
                              {!! Form::time('end_time',null,['class'=>'form-control']) !!}
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">Location</label>
                        {!! Form::text('location',null,['class'=>'form-control','']) !!}
                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">Embed Map</label>
                        {!! Form::textarea('map',null,['class'=>'form-control','size' => '5 x 5']) !!}
                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">Details</label>
                        {!! Form::textarea('details',null,['class'=>'form-control tinymcy']) !!}
                     </div>

                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label for="">Upload Cover Image</label>
               <input type="file" name="cover_image" id="coverImage" class="form-control">
            </div>
            @if($event->cover_image)
               <img class="card-img-top" src="{!! asset('businesses/'.Wingu::business()->business_code.'/events/'.$event->event_code.'/events/images/'.$event->cover_image) !!}" alt="{!! $event->title !!}">
            @else
               <img class="card-img-top" src="{!! asset('assets/img/image_placeholder.png') !!}" alt="{!! $event->title !!}">
            @endif
         </div>
         <div class="col-md-8">
            <center>
               <button type="submit" class="btn btn-primary submit"><i class="fa fa-save"></i> Update Information</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="20%">
            </center>
         </div>
      {!! Form::close() !!}
   </div>
@endsection
@section('scripts')

@endsection
