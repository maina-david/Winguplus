@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Job Openings | Recruitment | Human Resource')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{{ Nav::isRoute('hrm.dashboard') }}">Human resource</a></li>
         <li class="breadcrumb-item"><a href="#">Recruitment</a></li>
         <li class="breadcrumb-item"><a href="{!! route('hrm.recruitment.jobs') !!}">Jobs</a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-briefcase"></i> Edit Job Openings </h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <!-- begin panel -->
            <div class="panel panel-inverse">
               <div class="panel-body">
                  {!! Form::model($edit, ['route' => ['hrm.recruitment.jobs.update',$edit->code], 'method'=>'post','enctype'=>'multipart/form-data','class' => 'row','autocomplete' => 'off']) !!}
                     @csrf
                     <div class="col-sm-12">
                        <div class="form-group form-group-default required">
                           {!! Form::label('names', 'Posting Title', array('class'=>'control-label text-danger')) !!}
                           {!! Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Enter Posting Title', 'required' =>'' )) !!}
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('names', 'Job Status', array('class'=>'control-label text-danger')) !!}
                           {{ Form::select('status',[''=>'Choose status',10=>'Draft',21=>'Open',48=>'On Hold',4=>'Cancelled'], null, ['class' => 'form-control select2']) }}
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('names', 'Employment Type', array('class'=>'control-label text-danger')) !!}
                           {{ Form::select('contract_type',[''=>'Select contract','Permanent'=>'Permanent','On Contract'=>'On Contract','Temporary'=>'Temporary','Trainee'=>'Trainee'], null, ['class' => 'form-control select2']) }}
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('names', 'Hiring Lead', array('class'=>'control-label text-danger')) !!}
                           {{ Form::select('hiring_lead',$users,null, ['class' => 'form-control select2']) }}
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('names', 'Department', array('class'=>'control-label')) !!}
                           {{ Form::select('department',$departments, null, ['class' => 'form-control select2']) }}
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('names', 'Minimum Experience', array('class'=>'text-danger control-label')) !!}
                           {{ Form::select('experience',[''=>'Select Experience','Entry-level'=>'Entry-level','Mid-level'=>'Mid-level','Experienced'=>'Experienced','Trainee'=>'Trainee','Manager/Supervisor'=>'Manager/Supervisor','Senior Manager/Supervisor'=>'Senior Manager/Supervisor','Executive'=>'Executive','Senior Executive'=>'Senior Executive'], null, ['class' => 'form-control select2', 'required'=>'']) }}
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('names', 'Head count', array('class'=>'control-label')) !!}
                           {!! Form::number('headcount', null, array('class' => 'form-control', 'placeholder' => '0')) !!}
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('names', 'Min Salary', array('class'=>'control-label')) !!}
                           {!! Form::number('min_salary', null, array('class' => 'form-control', 'placeholder' => '0')) !!}
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('names', 'Max Salary', array('class'=>'control-label')) !!}
                           {!! Form::number('max_salary', null, array('class' => 'form-control', 'placeholder' => '0')) !!}
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('names', 'Location', array('class'=>'text-danger control-label')) !!}
                           {!! Form::text('location',null, array('class' => 'form-control', 'required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('names', 'Country', array('class'=>'text-danger control-label')) !!}
                           {!! Form::select('country',$country, null, array('class' => 'form-control select2', 'required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('names', 'List Job on winguJobs and Your Personal Site', array('class'=>'text-danger control-label')) !!}
                           {!! Form::select('listed',[''=>'Choose','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control select2','id' => 'listed_options']) !!}
                        </div>
                     </div>
							<div class="col-md-6">
                        @if($edit->listed == 'Yes')
                           <div class="row">
                        @else
                           <div class="row" style="display:none;" id="listed">
                        @endif
									<div class="col-md-6">
		                        <div class="form-group form-group-default required">
		                           {!! Form::label('names', 'Listing Date', array('class'=>'text-danger control-label')) !!}
		                           {{ Form::date('start_date',null, ['class' => 'form-control']) }}
		                        </div>
		                     </div>
									<div class="col-md-6">
		                        <div class="form-group form-group-default required">
		                           {!! Form::label('names', 'Listing End Date', array('class'=>'text-danger control-label')) !!}
		                           {{ Form::date('end_date',null, ['class' => 'form-control']) }}
		                        </div>
		                     </div>
								</div>
							</div>
                     <div class="col-sm-12">
                        <div class="form-group">
                           {!! Form::label('names','Job Description', array('class'=>'control-label')) !!}
                           {!! Form::textarea('job_description', null, array('class' => 'form-control tinymcy', 'placeholder' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <center>
                           <button type="submit" class="btn btn-success btn-sm submit"><i class="fas fa-save"></i> Update Job Opening</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                        </center>
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
<script>
	$(document).ready(function() {
		$('#listed_options').on('change', function(){
			if (this.value == 'Yes') {
				$('#listed').show();
			} else {
				$('#listed').hide();
			}
		});
	});
</script>
@endsection
