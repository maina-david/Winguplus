@extends('layouts.app')
{{-- page header --}}
@section('title') Job Events @endsection
{{-- page styles --}}

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.jobs.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      @livewire('jobs.job.head',['jobCode' => $code])
      <div class="row mt-3">
         <div class="col-md-12">
            <div class="mb-4">
               <a href="#" class="btn btn-pink mb-1" data-toggle="modal" data-target=".add-events"><i class="fal fa-calendar-plus"></i> Add Event</a>
            </div>
            <div class="row">
               @foreach($events as $event)
                  <div class="col-md-4">
                     <div class="widget-list-item">
                        <div class="widget-list-media">
                           <i class="fas fa-calendar-day fa-3x"></i>
                        </div>
                        <div class="widget-list-content">
                           <h4 class="widget-list-title font-weight-bold">{!! $event->title !!}</h4>
                           <p class="widget-list-desc mt-1">
                              <b>Date :</b> {!! date('d F, Y', strtotime($event->start_date)) !!}<br>
                              <b>Venue :</b> {!! $event->venue !!}<br>
                              <b>Status :</b> {!! $event->status !!}<br>
                              <b>Priority :</b> {!! $event->priority !!}<br>
                           </p>
                        </div>
                        <div class="widget-list-action">
                           <a href="#" data-toggle="dropdown" class="text-muted pull-right">
                           <i class="fa fa-ellipsis-h f-s-14"></i>
                           </a>
                           <ul class="dropdown-menu dropdown-menu-right">
                              <li><a href="{!! route('job.events.show', [$code,$event->event_code]) !!}">View</a></li>
                              <li><a href="{!! route('job.events.edit', [$code,$event->event_code]) !!}">Edit</a></li>
                              <li><a href="{!! route('job.events.delete',[$code,$event->event_code]) !!}" class="delete">Delete</a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>

   {{-- add event --}}
   <div class="modal fade add-events" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <form action="{!! route('job.events.store') !!}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title group-title" id="exampleModalLongTitle"><i class="fas fa-calendar-plus"></i> Add Events</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('Event Title', 'Event Title', array('class'=>'control-label')) !!}
                           {!! Form::text('title', null, array('class' => 'form-control','required' => '','placeholder' => 'Enter Event Title')) !!}
                           <input type="hidden" value="{!! $code !!}" name="jobcode">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Venue', 'Venue', array('class'=>'control-label')) !!}
                           {!! Form::text('venue', null, array('class' => 'form-control','placeholder' => 'Enter venue')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('Event Date', 'Event Start Date', array('class'=>'control-label')) !!}
                           {!! Form::date('start_date', null, array('class' => 'form-control','placeholder' => 'mm/dd/yyyy')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('Event Date', 'Event End Date', array('class'=>'control-label')) !!}
                           {!! Form::date('end_date', null, array('class' => 'form-control','placeholder' => 'mm/dd/yyyy')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('Status', 'Status', array('class'=>'control-label')) !!}
                           {{ Form::select('status',[''=>'Choose status','completed'=>'Completed','rescheduled'=>'Rescheduled','cancelled' => 'Cancelled','No Show' => 'No Show','Still to meet' => 'Still to meet'], null, ['class' => 'form-control', 'required' => '']) }}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Time', 'Priority', array('class'=>'control-label')) !!}
                           {!! Form::select('priority', [''=>'Choose Priority','High'=>'High','Normal'=>'Normal','Low' => 'Low'], null, array('class' => 'form-control','placeholder' => 'Choose date')) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           {!! Form::label('description', 'Description', array('class'=>'control-label')) !!}
                           {!! Form::textarea('description', null, array('class' => 'form-control tinymcy')) !!}
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-pink submit" id="submit"><i class="fas fa-save"></i> Add Event</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </div>
            </div>
         </form>
      </div>
   </div>
@endsection
@section('scripts')
   <script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
