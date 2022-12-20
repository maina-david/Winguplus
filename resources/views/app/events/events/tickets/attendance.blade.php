@extends('layouts.app')
@section('title','Attendance | Events Manager')
@section('sidebar')
	@include('app.events.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Event Manager</a></li>
         <li class="breadcrumb-item"><a href="#">Events</a></li>
         <li class="breadcrumb-item">Events Details</li>
         <li class="breadcrumb-item active">Attendance</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-ticket-alt"></i> Attendance</h1>
      <!-- end page-header -->
      @include('app.events.events._menu')
      @if($event->type == 'Paid')
         @livewire('events.events.attendance', ['eventCode' => $code])
      @endif
      @if($event->type == 'Free')
         @livewire('events.events.attendance-free', ['eventCode' => $code])
      @endif
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#checkInCustomer').modal('hide');
         $('#delete').modal('hide');
         $('#checkInDetails').modal('hide');
      });
   </script>
@endsection
