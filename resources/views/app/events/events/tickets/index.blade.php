@extends('layouts.app')
@section('title','Event Tickets | Events Manager')
@section('sidebar')
	@include('app.events.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Events Manager</a></li>
         <li class="breadcrumb-item"><a href="#">Events</a></li>
         <li class="breadcrumb-item">Events Details</li>
         <li class="breadcrumb-item active">Tickets</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-ticket-alt"></i> Tickets</h1>
      <!-- end page-header -->
      @include('app.events.events._menu')
     @livewire('events.events.tickets', ['eventCode'=>$code])
   </div>
@endsection
@section('scripts')
<script type="text/javascript">
   window.livewire.on('popModal', () => {
      $('#addTicket').modal('hide');
      $('#delete').modal('hide');
   });
</script>
@endsection
