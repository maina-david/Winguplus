@extends('layouts.app')
{{-- page header --}}
@section('title') Job Management | Events @endsection
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
            <h4><i class="fal fa-calendar-alt"></i> Edit Events</h4>
         </div>
      </div>
      <div class="row mt-3">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  {!! Form::model($edit, ['route' => ['job.events.update', [$edit->event_code]], 'method' => 'post', 'class' => 'row']) !!}
                     @csrf
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
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('Event Date', 'Event Start Date', array('class'=>'control-label')) !!}
                                 {!! Form::date('start_date', null, array('class' => 'form-control')) !!}
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('Event Date', 'Event Start Date', array('class'=>'control-label')) !!}
                                 {!! Form::time('start_time', null, array('class' => 'form-control')) !!}
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('Event Date', 'Event Start Date', array('class'=>'control-label')) !!}
                                 {!! Form::date('end_date', null, array('class' => 'form-control')) !!}
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('Event Date', 'Event Start Date', array('class'=>'control-label')) !!}
                                 {!! Form::time('end_time', null, array('class' => 'form-control')) !!}
                              </div>
                           </div>
                        </div>
                        <div class="form-group form-group-default required">
                           {!! Form::label('Event Date', 'Event End Date', array('class'=>'control-label')) !!}
                           {!! Form::text('end_date', null, array('class' => 'form-control')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Time', 'Priority', array('class'=>'control-label')) !!}
                           {!! Form::select('priority', [''=>'Choose Priority','High'=>'High','Normal'=>'Normal','Low' => 'Low'], null, array('class' => 'form-control multiselect','placeholder' => 'Choose date')) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           {!! Form::label('description', 'Description', array('class'=>'control-label')) !!}
                           {!! Form::textarea('description', null, array('class' => 'form-control tinymcy')) !!}
                        </div>
                     </div>
                     <div class="form-group">
                        <center>
                           <button type="submit" class="btn btn-pink submit ml-2"><i class="fas fa-save"></i> Update Event</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                        </center>
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
