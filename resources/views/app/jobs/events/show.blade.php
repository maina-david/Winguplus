@extends('layouts.app')
{{-- page header --}}
@section('title') View Event @endsection
{{-- page styles --}}

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.jobs.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      @livewire('jobs.job.head',['jobCode' => $code])
      @include('partials._messages')
      <div class="row mb-3">
         <div class="col-md-12">
            <h4><i class="fal fa-calendar-alt"></i> {!! $event->title !!} |  Details</h4>
         </div>
      </div>
      <div class="row mt-3">
         <div class="col-md-8">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Event information</h4>
               </div>
               <div class="panel-body">
                  <div class="task-details">
                     <h3>{!! $event->title !!}</h3>
                     <p>
                        <b>Event date :</b> {!! date('jS F, Y', strtotime($event->start_date)) !!}<br>
                        <b>Event end date :</b> {!! date('jS F, Y', strtotime($event->end_date)) !!}<br>
                        <b>Venu :</b> {!! $event->venue !!}<br>
                        <b>Status :</b> {!! $event->status !!}<br>
                        <b>Priority : </b> {!! $event->priority !!}
                     </p>
                  </div>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Event Details</h4>
               </div>
               <div class="panel-body">
                  <div class="task-details">
                     {!! $event->description !!}
                  </div>
               </div>
            </div>
            <a href="#" class="btn btn-pink mb-3" id="record-results"><i class="fas fa-file"></i> Record event results</a>
            <div class="card" style="display:none" id="record-results-section">
               <div class="card-body">
                  {!! Form::model($event, ['route' => ['job.events.results', $event->event_code], 'method' => 'post', 'class' => 'row']) !!}
                     @csrf
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Event Result details</label>
                           {!! Form::textarea('results',null,['class' => 'form-control tinymcy', 'required' => '']) !!}
                        </div>
                     </div>
                     <div class="form-group">
                        <center>
                           <button type="submit" class="btn btn-pink submit ml-2">Update Results</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                        </center>
                     </div>
                  </form>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Event Results</h4>
               </div>
               <div class="panel-body">
                  <div class="task-details">
                     {!! $event->results !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
<script>
   $(document).ready(function(){
      $('#record-results').click(function(){
         $('#record-results-section').toggle('show');
      });
   });
</script>
@endsection
