@extends('layouts.app')
@section('title','Create Event | Events Manager')
@section('sidebar')
	@include('app.events.partials._menu')
@endsection
@section('stylesheet')
   <style>
      .imageCover{
         width: 100%;
         margin-top: 20px;
      }
   </style>
@endsection
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('events.manager.dashboard') !!}">Events Manager</a></li>
         <li class="breadcrumb-item"><a href="{!! route('events') !!}">Events</a></li>
         <li class="breadcrumb-item active">Create Event</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-calendar-plus"></i> Create Event</h1>
      <!-- end page-header -->
      <form class="row" method="POST" action="{!! route('events.store') !!}" enctype="multipart/form-data">
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
            {{-- <div class="card">
               <div class="card-body">
                  <p class="text-center">Event Cover</p>
               </div>
            </div> --}}
         </div>
         <div class="col-md-8">
            <center>
               <button type="submit" class="btn btn-success submit"><i class="fa fa-save"></i> Submit Information</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="20%">
            </center>
         </div>
      </form>
   </div>
@endsection
@section('scripts')
<script type="text/javascript">
   $(document).ready(function() {
      if(window.File && window.FileList && window.FileReader) {
      $("#coverImage").on("change",function(e) {
      var files = e.target.files ,
      filesLength = files.length ;
      for (var i = 0; i < filesLength ; i++) {
         var f = files[i]
         var fileReader = new FileReader();
         fileReader.onload = (function(e) {
            var file = e.target;
            $("<img></img>",{
            class : "imageCover",
            src : e.target.result,
            title : file.name
            }).insertAfter("#coverImage");
         });
         fileReader.readAsDataURL(f);
      }
   });
   } else { alert("Your browser doesn't support to File API") }
   });
</script>
@endsection
