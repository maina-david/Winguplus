@extends('layouts.app')
{{-- page header --}}
@section('title','Deals details | Customer Relationship Management')
@section('stylesheet')
   <style>
      .clearfix:after {
         clear: both;
         content: "";
         display: block;
         height: 0;
      }
      .container {
         font-family: 'Lato', sans-serif;
         width: 100vh;
         margin: 0 auto;
      }
      .wrapper {
         display: table-cell;
         height: 400px;
         vertical-align: middle;
      }
      .nav {
         margin-top: 40px;
      }
      .pull-right {
         float: right;
      }
      a, a:active {
         color: #212121;
         text-decoration: none;
      }
      a:hover {
         color: #999;
      }
      .arrow-steps .step {
         font-size: 14px;
         text-align: center;
         color: #666;
         cursor: default;
         margin: 0 3px;
         padding: 10px 10px 10px 30px;
         min-width: 180px;
         float: left;
         position: relative;
         background-color: #b4e7ff;
         -webkit-user-select: none;
         -moz-user-select: none;
         -ms-user-select: none;
         user-select: none;
      transition: background-color 0.2s ease;
      }
      .arrow-steps .step:after,
      .arrow-steps .step:before {
         content: " ";
         position: absolute;
         top: 0;
         right: -17px;
         width: 0;
         height: 0;
         border-top: 19px solid transparent;
         border-bottom: 17px solid transparent;
         border-left: 17px solid #b4e7ff;
         z-index: 2;
      transition: border-color 0.2s ease;
      }
      .arrow-steps .step:before {
         right: auto;
         left: 0;
         border-left: 17px solid #fff;
         z-index: 0;
      }
      .arrow-steps .step:first-child:before {
         border: none;
      }
      .arrow-steps .step:first-child {
         border-top-left-radius: 4px;
         border-bottom-left-radius: 4px;
      }
      .arrow-steps .step span {
         position: relative;
      }
      .arrow-steps .step span:before {
         opacity: 0;
         content: "âœ”";
         position: absolute;
         top: -2px;
         left: -20px;
         color: #06ac77;
      }
      .arrow-steps .step.done span:before {
         opacity: 1;
         -webkit-transition: opacity 0.3s ease 0.5s;
         -moz-transition: opacity 0.3s ease 0.5s;
         -ms-transition: opacity 0.3s ease 0.5s;
         transition: opacity 0.3s ease 0.5s;
      }
      .arrow-steps .step.current {
         color: #fff;
         background-color: #ff5050;
      }
      .arrow-steps .step.current:after {
         border-left: 17px solid #ff5050;
      }
      @media (max-width: 765px) {
         .arrow-steps .step {
            min-width: 35px;
         }
      }
      .codes{
         bottom: 5%;
         left: 5%;
         position: fixed;
      }
      .codes div {
         border: 2px solid black;
         font-size: 20px;
         padding: 10px;
         background-color: red;
      }
      .codes div a{
         text-decoration: none;
         color: white;
         font-weight: 800;
      }
      .select2-container {
         z-index: 9999 !important;
      }
   </style>
@endsection

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <a href="{!! route('crm.deals.edit',$deal->deal_code) !!}" class="btn btn-primary btn-sm mr-2"><i class="fas fa-edit"></i> Edit</a>
         <a href="{!! route('crm.deals.delete',$deal->deal_code) !!}" class="btn btn-sm btn-danger delete mr-2"><i class="fas fa-trash-alt"></i> Delete</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">
         <i class="fal fa-bullseye"></i>
         @if(Crm::check_pipeline($deal->pipeline) != 0){!! Crm::pipeline($deal->pipeline)->title !!}@endif |
         {!! $deal->title !!}
      </h1>
      @include('partials._messages')
      <div class="row">
         <div class="col-md-12 mb-3">
            <div class="arrow-steps clearfix">
               @foreach ($stages as $stage)
                  <div class="step @if($stage->stage_code == $deal->stage) current @endif"> <span><a href="">{!! $stage->title !!}</a></span> </div>
              @endforeach
            </div>
         </div>
         <div class="col-md-3">
            <div class="panel panel-default">
               <div class="panel-heading"><b>Deal Details</b></div>
               <div class="panel-body">
                  <p>
                     <b>Deal  :</b> <span class="text-primary">Age {!! number_format(Helper::date_difference($deal->close_date,$deal->create_date)) !!} Day(s)</span><br>
                     <b>Closure Date :</b> <span class="text-primary">@if($deal->close_date != ""){!! date('F jS Y', strtotime($deal->close_date)) !!}@endif</span><br>
                     <b>Assign to :</b> <span class="text-primary">@if(Hr::check_employee($deal->owner) != 0){!! Hr::employee($deal->owner)->names !!}@endif</span><br>
                     <b>Pipeline :</b> <span class="text-primary">@if(Crm::check_pipeline($deal->pipeline) != 0){!! Crm::pipeline($deal->pipeline)->title !!}@endif</span> <br>
                     <b>Stage :</b> <span class="text-primary">@if(Crm::check_pipeline_stage($deal->stage) != 0)
                        {!! Crm::pipeline_stage($deal->stage)->title !!}
                     @endif</span> <br>
                     <b>Estimated worth :</b> <span class="text-primary">{!! $deal->currency !!} {!! number_format($deal->value) !!}</span> <br>
                     <b>Created At :</b> <span class="text-primary">{!! date('F jS Y', strtotime($deal->create_date)) !!}</span>
                  </p>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading"><b>Contact Details</b></div>
               <div class="panel-body">
                  <p>
                     <b>Contact Name:</b> {!! $customer->customer_name !!}<br>
                     <b>Phone Number:</b> {!! $customer->primary_phone_number !!}<br>
                     <b>Email:</b> {!! $customer->email !!}<br>
                     <b>Website:</b> <a href="{!! $customer->website !!}" class="text-primary" target="_blank">{!! $customer->website !!}</a>
                  </p>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading"><b>Owner Details</b></div>
               <div class="panel-body">
                  <div class="inbox-widget slimscroll" style="max-height:410px;">
                     <div class="inbox-item">
                        <div class="inbox-item-img">
                           @if($owner->avatar == "")
                              <img src="https://ui-avatars.com/api/?name={!! $owner->name !!}&rounded=true&size=70" class="rounded-circle" alt="">
                           @else
                              <img src="{!! asset('businesses/'.$business->business_code.'/staff/'.$owner->email.'/images/'.$owner->avatar) !!}" class="rounded-circle" alt="">
                           @endif
                        </div>
                        <p class="inbox-item-author">{!! $owner->name !!}</p>
                        <p class="inbox-item-text">{!! $owner->email !!}</p>
                        <p class="inbox-item-date">
                           {{-- <a href="{!! route('hrm.employee.edit', $staff->staffID) !!}" class="btn btn-sm btn-link text-info font-13"> View profile </a> --}}
                        </p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-9">
            <ul class="nav nav-tabs mt-0">
               <li class="nav-item">
                  <a class="nav-link {!! Nav::isRoute('crm.deals.show') !!}" href="{!! route('crm.deals.show',$deal->deal_code) !!}"><i class="fal fa-globe"></i> Overview</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link {!! Nav::isRoute('crm.deals.calllog.index') !!}" href="{!! route('crm.deals.calllog.index',$deal->deal_code) !!}"><i class="fal fa-phone-square-alt"></i> Call logs</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link {!! Nav::isRoute('crm.deals.notes.index') !!}" href="{!! route('crm.deals.notes.index',$deal->deal_code) !!}"><i class="fal fa-sticky-note"></i> Notes</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link {!! Nav::isRoute('crm.deals.task.index') !!}" href="{!! route('crm.deals.task.index',$deal->deal_code) !!}"><i class="fal fa-tasks"></i> Tasks</a>
               </li>
               {{-- <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fal fa-sms"></i> Sms</a>
               </li> --}}
               {{-- <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fal fa-inbox-in"></i> Email</a>
               </li> --}}
               {{-- <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fal fa-file-invoice"></i> Quotes</a>
               </li> --}}
               {{-- <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fal fa-file-invoice-dollar"></i> Invoices</a>
               </li> --}}
               {{-- <li class="nav-item">
                 <a class="nav-link" href="#"><i class="fal fa-folders"></i> Documents</a>
               </li> --}}
               <li class="nav-item">
                  <a class="nav-link {!! Nav::isRoute('crm.deals.appointments.index') !!}" href="{!! route('crm.deals.appointments.index',$deal->deal_code) !!}"><i class="fal fa-calendar-check"></i> Appointments</a>
               </li>
            </ul>
            @if(Request::is('crm/deal/'.$deal->deal_code.'/show'))
               @include('app.crm.deals.deal.dashboard')
            @endif
            @if(Request::is('crm/deal/'.$deal->deal_code.'/call_log'))
               @include('app.crm.deals.deal.call_log')
            @endif
            @if(Request::is('crm/deal/'.$deal->deal_code.'/notes'))
               @include('app.crm.deals.deal.notes')
            @endif
            @if(Request::is('crm/deal/'.$deal->deal_code.'/task'))
               @include('app.crm.deals.deal.task')
            @endif
            @if(Request::is('crm/deal/'.$deal->deal_code.'/appointments'))
               @include('app.crm.deals.deal.appointments')
            @endif
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')
@endsection
