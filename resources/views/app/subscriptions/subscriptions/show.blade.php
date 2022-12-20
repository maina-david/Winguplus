@extends('layouts.app')
@section('title','Subscription | details')
@section('sidebar')
@include('app.subscriptions.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         @if(date('Y-m-d') > $subscription->next_billing)
            <a class="btn btn-warning mr-1" href="{!! route('subscriptions.renew',$subscription->subscriptionID) !!}"><i class="fal fa-sync-alt"></i> Renew</a>
         @endif
         <a class="btn btn-primary mr-1" href="{!! route('subscriptions.edit',$subscription->subscriptionID) !!}"><i class="fas fa-edit"></i> Edit</a>
         @permission('delete-subscription')
            <a class="btn btn-danger delete" href="{!! route('subscriptions.delete',$subscription->subscriptionID) !!}"><i class="fas fa-trash"></i> Delete</a>
         @endpermission
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-sync-alt"></i> {!! $subscription->product_name !!} ({!! $subscription->sku_code !!})  <span class="badge {!! $subscription->statusName !!}" style="font-size:8px">{!! $subscription->statusName !!}</span></h1>
      <h4><b>#{!! $subscription->prefix !!}{!! $subscription->subscription_number !!}</b></h4>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-3">
            <div class="card">
               <div class="card-header">
                  Details
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-3">
                        <center>
                           @if($customer->image == "")
                              <img src="https://ui-avatars.com/api/?name={!! $customer->customer_name !!}&rounded=false&size=40" alt="">
                           @else
                              <img width="40" height="40" alt="" class="img-circle" src="{!! asset('businesses/'.$customer->primary_email .'/clients/'.$customer->customer_code.'/images/'.$customer->image) !!}">
                           @endif
                        </center>
                     </div>
                     <div class="col-md-9">
                        <p><a href="">{!! $customer->customer_name !!}</a><br>{!! $customer->email !!}</p>
                     </div>
                  </div>
                  @if($checkContactPerson != 0)
                     <div class="row mt-3">
                        <div class="col-md-12">
                           <h5>Contact Person</h5>
                           <hr>
                           @foreach($contactPersons as $person)
                              <p><a href="">{!! $person->names !!}</a><br>{!! $person->contact_email !!}<br>{!! $person->phone_number !!}</p><br><br>
                           @endforeach
                        </div>
                     </div>
                  @endif
                  <div class="row mt-3">
                     <div class="col-md-12">
                        <h5>Subscriptions</h5>
                        <hr>
                     </div>
                     <div class="col-md-12">
                        <p>
                           Reference # : <span class="text-primary">{!! $subscription->reference !!}</span><br>
                           Sales Person : @if($subscription->sales_person)
                                             <span class="text-primary">
                                                @if(Hr::check_employee($subscription->sales_person != 0))
                                                   {!! Hr::employee($subscription->sales_person)->names !!}
                                                @endif
                                             </span>
                                          @endif<br>
                           Repeat Every : <span class="text-primary">{!! $subscription->bill_count !!} {!! $subscription->billing_period !!}(s)</span><br>
                           Start Date : <span class="text-primary">{!! date('jS F, Y', strtotime($subscription->starts_on)) !!}</span><br>
                           @if($subscription->trial_days != "")
                              Trial Ends At : <span class="text-primary">{!! date('jS F, Y', strtotime($subscription->trial_end_date)) !!}</span><br>
                              Trial Remaining day(s) : <span class="text-primary">{!! number_format(Helper::date_difference($subscription->trial_end_date,$subscription->starts_on)) !!} day(s)</span><br>
                              Activation Date : <span class="text-primary">{!! date('jS F, Y', strtotime($subscription->trial_end_date)) !!}</span>
                           @endif
                        </p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-9">
            <ul class="nav nav-tabs">
               <li class="nav-item">
                  <a class="nav-link {!! Nav::isRoute('subscriptions.show') !!}" href="{!! route('subscriptions.show',$subscription->subscriptionID) !!}"><i class="fal fa-info-circle"></i> Overview</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link {!! Nav::isRoute('subscriptions.invoices') !!}" href="{!! route('subscriptions.invoices',$subscription->subscriptionID) !!}"><i class="fal fa-file-invoice-dollar"></i> Invoice History</a>
               </li>
            </ul>
            @if(Request::is('subscriptions/'.$subscription->subscriptionID.'/details'))
               @include('app.subscriptions.subscriptions.overview')
            @endif
            @if(Request::is('subscriptions/'.$subscription->subscriptionID.'/invoices'))
               @include('app.subscriptions.subscriptions.invoices')
            @endif
         </div>
      </div>
   </div>
@endsection
