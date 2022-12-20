@extends('layouts.app')
@section('title','Events | Edit | Human Resource')
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
         <li class="breadcrumb-item active"><a href=#">Edit</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"> <i class="fal fa-calendar"></i> Event Edit</h1>
		@include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-body">
                  {!! Form::model($edit, ['route' => ['hrm.events.update',$edit->event_code], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
                     @csrf
                     <div class="form-group">
                        <label for="">Title</label>
                        {!! Form::text('title',null,['class'=>'form-control','required'=>'']) !!}
                     </div>
                     <div class="form-group">
                        <label for="">Event For</label>
                        {!! Form::select('event_for',['general'=>'Every one','departments'=>'Departments','employee'=>'Employee'],null,['class'=>'form-control','required'=>'']) !!}
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="">Start Date</label>
                              {!! Form::date('start_date',null,['class'=>'form-control','required'=>'']) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="">End Date</label>
                              {!! Form::date('end_date',null,['class'=>'form-control','required'=>'']) !!}
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="">Event For</label>
                        {!! Form::textarea('note',null,['class'=>'form-control tinymcy']) !!}
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Update Event</button>
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end #content -->
@endsection
@section('scripts')
@endsection
