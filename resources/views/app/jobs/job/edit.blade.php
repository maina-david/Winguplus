@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Project')


{{-- dashboad menu --}}
@section('sidebar')
	@include('app.jobs.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div class="content">
      @livewire('jobs.job.head', ['jobCode' => $code])
      @include('partials._messages')
      <div class="row mb-3">
         <div class="col-md-12">
            <h4><i class="fal fa-file-edit"></i> Edit Job</h4>
         </div>
      </div>
      {!! Form::model($project, ['route' => ['job.update',$code], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
         {!! csrf_field() !!}
         <div class="row">
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-body">
                     <div class="form-group form-group-default required ">
                        {!! Form::label('Project name', 'Whats the Project Name?', array('class'=>'control-label')) !!}
                        {!! Form::text('job_title', null, array('class' => 'form-control', 'placeholder' => 'Project Name', 'required' => '')) !!}
                     </div>
                     <div class="form-group form-group-default required ">
                        {!! Form::label('job_type', 'Is this an Internal or External project ?', array('class'=>'control-label')) !!}
                        {{ Form::select('job_type',[''=>'Choose','Internal'=>'Internal','External'=>'External'], null, ['class' => 'form-control','id' => 'project' ]) }}
                     </div>
                     @if($project->job_type == 'External')
                        <div class="form-group form-group-default required" id="company_name">
                           {!! Form::label('Client', 'Client', array('class'=>'control-label')) !!}
                           {!! Form::select('customer',$clients,null,['class'=>'form-control select2']) !!}
                        </div>

                        <div class="form-group form-group-default">
                           <label for="">Notify Client</label>
                           {{ Form::select('notify_client', ['' => 'Choose','Yes' => 'Yes','No' => 'No'], null, ['class' => 'form-control']) }}
                        </div>
                     @endif
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-body">

                     <div class="form-group form-group-default required">
                        {!! Form::label('Choose Employee', 'Allocate Job Managers', array('class'=>'control-label')) !!}
                        {{ Form::select('job_leads[]', $users, null, ['class' => 'form-control multiple-select2','required' =>'','multiple' => ''  ]) }}
                     </div>
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('start Date', 'start Date', array('class'=>'control-label')) !!}
                              {!! Form::date('start_date', null, array('class' => 'form-control', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('End Date', 'Due Date', array('class'=>'control-label')) !!}
                              {!! Form::date('end_date', null, array('class' => 'form-control', 'required' => '')) !!}
                           </div>
                        </div>
                     </div>
                     <div class="form-group form-group-default required ">
                        {!! Form::label('project_status', 'Project Status', array('class'=>'control-label')) !!}
                        {{ Form::select('status',[''=>'Choose Project Status',17=>'Started',21 => 'Open',16=>'Complete',22=>'Closed',24=>'Ongoing'], null, ['class' => 'form-control multiselect','required'=> '']) }}
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                  {!! Form::label('Project name', 'Brief project introduction', array('class'=>'control-label')) !!}
                  {!! Form::textarea('brief_info', null, array('class' => 'form-control', 'size' => '5 x 5','placeholder' => 'type...............')) !!}
               </div>
               <div class="form-group required">
                  {!! Form::label('Description', 'Description', array('class'=>'control-label mb-3')) !!}
                  {!! Form::textarea('description',null,['class'=>'form-control tinymcy', 'rows' => 5, 'placeholder'=>'content']) !!}
               </div>
            </div>
         </div>
         <div class="row">
            <div class="panel-body">
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Project</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
            </div>
         </div>
      {!! Form::close() !!}
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      $(".multiple-select2").select2().val({!! json_encode($currentemp) !!}).trigger('change');
	</script>
@endsection
