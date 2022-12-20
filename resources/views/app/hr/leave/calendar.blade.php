@extends('layouts.app')
{{-- page header --}}
@section('title','Leave Calendar')
@section('stylesheet')
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/locales-all.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.css"/>
@endsection
@section('sidebar')
@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="#">Leave</a></li>
         <li class="breadcrumb-item active">Calendar</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fad fa-calendar-alt"></i> Calendar</h1>
      @include('partials._messages')
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  {!! $calendar->calendar() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   {!! $calendar->script() !!}
@endsection
