@extends('layouts.app')
{{-- page header --}}
@section('title','HRM | Salary information')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('hrm.dashboard') !!}">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="{!! route('hrm.employee.index') !!}">Employee</a></li>
         <li class="breadcrumb-item active">Salary</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-money-check-alt"></i> Salary & Bank Information</h1>
      <!-- end page-header -->
		<div class="row">
        	<!-- employee side -->
			@include('app.hr.partials._hr_employee_menu')
			<div class="col-md-9">
				@include('partials._messages')
	        	<!-- employee side -->
	    		{!! Form::model($edit, ['route' => ['hrm.employee.salary.update', $edit->employee_code], 'method'=>'post','autocomplete' => 'off']) !!}
	    			{{ csrf_field() }}
		         <div class="panel panel-default">
						<div class="panel-heading">
                     <div class="panel-title">{!! $employee->names !!} - Salary & Bank Information</div>
						</div>
						<div class="panel-body">
							<div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('type', 'Payment basis', array('class'=>'control-label text-danger')) !!}
                              {!! Form::select('payment_basis', ['' => 'Choose basis','Monthly' => 'Monthly','Bi-weekly' => 'Bi-weekly','Daily' => 'Daily'], null, array('class' => 'form-control select2', )) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('Salary amount', 'Salary amount', array('class'=>'control-label text-danger')) !!}
                              {!! Form::number('salary_amount', null, array('class' => 'form-control', 'placeholder' => 'Enter Salary Amount','steps'=>'any')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('payment_method', 'Payment Method', array('class'=>'control-label text-danger')) !!}
                              <select class="form-control select2" name="payment_method" id="paymentMethod" required>
                                 @if($edit->payment_method != "")
                                    @if(Finance::check_account_payment_method($edit->payment_method) == 1)
                                       <option value="{!! $edit->payment_method !!}">
                                          {!! Finance::account_payment_method($edit->payment_method)->name !!}
                                       </option>
                                    @endif
                                    @if(Finance::check_system_payment($edit->payment_method) == 1)
                                       <option value="{!! $edit->payment_method !!}">
                                          {!! Finance::system_payment($edit->payment_method)->name !!}
                                       </option>
                                    @endif
                                 @else
                                    <option value="">Choose payment method</option>
                                 @endif
                                 @foreach($mainPaymentMethods as $main)
                                    <option value="{!! $main->method_code !!}">{!! $main->name !!}</option>
                                 @endforeach
                                 @foreach($paymentsMethods as $payment)
                                    <option value="{!! $payment->method_code !!}">{!! $payment->name !!}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        @if($edit->payment_method == 'banktransfer' || $edit->payment_method == 'cheque')
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('account_number', 'BanK Account Number', array('class'=>'control-label')) !!}
                                 {!! Form::text('account_number', null, array('class' => 'form-control', 'placeholder' => 'BanK Account Number')) !!}
                              </div>
                           </div>
                        @endif
                        @if($edit->payment_method == 'banktransfer' || $edit->payment_method == 'cheque')
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('bank_name', 'Bank Name', array('class'=>'control-label')) !!}
                                 {!! Form::text('bank_name', null, array('class' => 'form-control', 'placeholder' => 'BanK Name')) !!}
                              </div>
                           </div>
                        @endif
                        @if($edit->payment_method == 'banktransfer' || $edit->payment_method == 'cheque')
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('bank_branch', 'BanK Branch', array('class'=>'control-label')) !!}
                                 {!! Form::text('bank_branch', null, array('class' => 'form-control', 'placeholder' => 'BanK Branch')) !!}
                              </div>
                           </div>
                        @endif
                        @if($edit->payment_method == 'mpesa' || $edit->payment_method == 'phonenumber')
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('mpesa_number', 'Mpesa number', array('class'=>'control-label')) !!}
                                 {!! Form::text('mpesa_number', null, array('class' => 'form-control', 'placeholder' => 'example 254700123456')) !!}
                              </div>
                           </div>
                        @endif
                        <div class="col-md-12 mt-3">
                           <div class="form-group">
                              <center>
                                 <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Information</button>
                                 <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                              </center>
                           </div>
                        </div>
                     </div>
						</div>
					</div>
		      {!! Form::close() !!}
			</div>
      </div>
	</div>
@endsection
{{-- page scripts --}}
@section('scripts')
   <script>
      $(document).ready(function() {
         $('#paymentMethod').on('change', function() {
            if(this.value == 4 || this.value == 2) {
               $('.bank').show();
            } else {
               $('.bank').hide();
            }

            if (this.value == 3) {
               $('.mpesa').show();
            } else {
               $('.mpesa').hide();
            }
         });
      });
   </script>
@endsection
