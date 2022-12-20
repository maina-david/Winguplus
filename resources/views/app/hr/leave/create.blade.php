@extends('layouts.app')
@section('title','Assign Leave')
@section('sidebar')
@include('app.hr.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="#">Leave</a></li>
         <li class="breadcrumb-item active">Assign Leave</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-calendar-check"></i> Assign Leave</h1>
      @include('partials._messages')
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  Leave Form
               </div>
               <div class="card-body">
                  <form action="{!! route('hrm.leave.store') !!}" method="post" autocomplete="off">
                     @csrf
                     <div class="form-group form-group-default required">
      						{!! Form::label('names', 'Leave Type', array('class'=>'control-label')) !!}
      						{!! Form::select('type_code', $types, null, array('class' => 'form-control select2', 'required' => '')) !!}
      					</div>
      					<div class="form-group form-group-default required">
      						{!! Form::label('Employee', 'Employee', array('class'=>'control-label')) !!}
      						{!! Form::select('employee_code',$employees, null, array('class' => 'form-control select2', 'required' => '')) !!}
      					</div>
                     <div class="row">
      						<div class="col-sm-6">
      							<div class="form-group form-group-default required">
      								{!! Form::label('names', 'Start', array('class'=>'control-label')) !!}
      								{!! Form::date('start_date', null, array('class' => 'form-control', 'placeholder' => 'Choose date', 'required' => '')) !!}
      							</div>
      						</div>
      						<div class="col-sm-6">
      							<div class="form-group form-group-default required">
      								{!! Form::label('Time', 'End', array('class'=>'control-label')) !!}
      								{!! Form::date('end_date', null, array('class' => 'form-control', 'placeholder' => 'Choose date','required' => '')) !!}
      							</div>
      						</div>
      					</div>
                     <div class="form-group">
      						{!! Form::label('Description', 'Reason', array('class'=>'control-label text-danger')) !!}
      						{{ Form::textarea('reason', null, ['class' => 'form-control','size' => '6x6']) }}
      					</div>
                     <div class="form-group">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit Application</button>
            					<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                        </center>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
