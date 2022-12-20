@extends('layouts.app')
{{-- page header --}}
@section('title','Jobs Mangement | Create Job')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.jobs.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="{!! route('jobs.dashboard') !!}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{!! route('job.index') !!}">Jobs</a></li>
      <li class="breadcrumb-item active">Create Job</li>
   </ol>
   <h1 class="page-header"><i class="fal fa-rocket-launch"></i> Create Job</h1>
	@include('partials._messages')
   {!! Form::open(array('route' => 'job.store','enctype'=>'multipart/form-data','method'=>'post','autocomplete'=>'off')) !!}
		{!! csrf_field() !!}
		<div class="row">
			<div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Jobs Details</h4>
               </div>
               <div class="panel-body">
                  <div class="form-group form-group-default required ">
                     {!! Form::label('Job name', 'Whats the Jobs Title?', array('class'=>'control-label')) !!}
                     {!! Form::text('job_title', null, array('class' => 'form-control', 'placeholder' => 'Job title', 'required' => '')) !!}
                  </div>
                  <div class="form-group form-group-default required ">
                     {!! Form::label('job_type', 'Is this an Internal or External Job ?', array('class'=>'control-label')) !!}
                     {{ Form::select('job_type',[''=>'Choose','Internal'=>'Internal','External'=>'External'], null, ['class' => 'form-control select2','id' => 'project' ]) }}
                  </div>
                  <div class="form-group form-group-default required" id="company_name" style="display:none">
                     {!! Form::label('Client Name', 'Client Name', array('class'=>'control-label')) !!}
                     {!! Form::select('customer',$clients,null,['class'=>'form-control select2']) !!}
                  </div>
                  <div class="form-group form-group-default" id="notify" style="display:none">
                     <label for="">Notify Client</label>
                     {{ Form::select('notify_client', ['' => 'Choose','Yes' => 'Yes','No' => 'No'], null, ['class' => 'form-control select2']) }}
                  </div>
                  <div class="form-group form-group-default required ">
                     {!! Form::label('project_status', 'Visibility Status', array('class'=>'control-label')) !!}
                     {{ Form::select('visibility_status',[''=>'Choose Status','Public'=>'Public','Private' => 'Private'], null, ['class' => 'form-control select2','required'=> '']) }}
                  </div>
               </div>
            </div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Jobs Details</h4>
               </div>
               <div class="panel-body">
                  <div class="form-group required">
                     {!! Form::label('Choose Job Managers', 'Allocate Job Managers', array('class'=>'control-label')) !!}
                     {{ Form::select('job_leads[]', $users, null, ['class' => 'form-control select2','id'=>'project','multiple' => '','required' =>'']) }}
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('start Date', 'start Date', array('class'=>'control-label')) !!}
                           {!! Form::date('start_date', null, array('class' => 'form-control','required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('End Date', 'End Date', array('class'=>'control-label')) !!}
                           {!! Form::date('end_date', null, array('class' => 'form-control','required' => '')) !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group form-group-default required ">
                     {!! Form::label('project_status', 'Job Status', array('class'=>'control-label')) !!}
                     {{ Form::select('status',[''=>'Choose Job Status',17=>'Started',21 => 'Open',16=>'Complete',22=>'Closed',24=>'Ongoing'], null, ['class' => 'form-control select2','required'=> '']) }}
                  </div>
               </div>
				</div>
			</div>
			<div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-body">
                  <div class="form-group">
                     {!! Form::label('Project name', 'Brief project introduction', array('class'=>'control-label')) !!}
                     {!! Form::textarea('brief_info',null,array('class' => 'form-control','size' => '8 x 8','placeholder' => 'type...............')) !!}
                  </div>
                  <div class="form-group required">
                     {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
                     {!! Form::textarea('description',null,['class'=>'form-control tinymcy', 'rows' => 5, 'placeholder'=>'content']) !!}
                  </div>
               </div>
            </div>
			</div>
         <div class="row">
            <div class="panel-body">
               <div class="col-md-12">
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Create Job</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="20%">
               </div>
            </div>
         </div>
      </div>
   {!! Form::close() !!}
</div>
@endsection
@section('scripts')
	<script>
		$(document).ready(function(){
			$('#project').on('change', function(){
				if(this.value == 'External'){
					$('#company_name').show();
               $('#notify').show();
				}else{
					$('#company_name').hide();
               $('#notify').hide();
				}
			});
		});
   </script>
@endsection
