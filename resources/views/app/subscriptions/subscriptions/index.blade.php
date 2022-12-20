@extends('layouts.app')
@section('title','Subscriptions')
@section('sidebar')
@include('app.subscriptions.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         @if(Subscription::count_subscriptions() != Wingu::plan()->subscriptions && Subscription::count_subscriptions() < Wingu::plan()->subscriptions)
            @permission('create-subscription')
               <a href="{!! route('subscriptions.create') !!}" class="btn btn-pink float-right mr-2"><i class="fas fa-plus"></i> Add Subscriptions</a>
            @endpermission
         @endif
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-sync-alt"></i> Subscriptions</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">All Plans</h4>
               </div>
               <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th> Created</th>
                           <th> Activated</th>
                           <th> Subscription#</th>
                           <th> Customer Name</th>
                           <th> Plan Name</th>
                           <th> Status</th>
                           <th> Amount</th>
                           <th> Last Billed</th>
                           <th> Next Billing</th>
                           <th width="9%">Action</th>
                        </tr>
                     </thead> 
                     <tbody>
                        @foreach ($subscriptions as $subscription)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td>{!! date('d M, Y', strtotime($subscription->created_at)) !!}</td>
                              <td>
                                 @if($subscription->starts_on != ""){!! date('d M, Y', strtotime($subscription->starts_on)) !!}@endif
                              </td>
                              <td>
                                 <b>{!! $subscription->prefix !!}{!! $subscription->subscription_number !!}</b>
                              </td>
                              <td>{!! $subscription->customer_name !!}</td>
                              <td>{!! $subscription->product_name !!}</td>
                              <td>
                                 @if($subscription->statusID != "")
                                    <span class="badge {!! $subscription->statusName !!}">{!! $subscription->statusName !!}</span>
                                 @endif
                              </td>
                              <td>
                                 <b>{!! $subscription->code !!} {!! number_format($subscription->amount) !!}</b>
                              </td>
                              <td>
                                 @if($subscription->last_billing)
                                    {!! date('d M, Y', strtotime($subscription->last_billing)) !!}
                                 @endif
                              </td>
                              <td>
                                 @if($subscription->next_billing != "")
                                    {!! date('d M, Y', strtotime($subscription->next_billing)) !!}
                                 @endif
                              </td>
                              <td>
                                 @permission('read-subscription')
                                    <a href="{!! route('subscriptions.show',$subscription->subscriptionID) !!}" class="btn btn-sm btn-pink"><i class="fas fa-eye"></i></a>
                                 @endpermission
                                 @permission('delete-subscription')
                                    <a href="{!! route('subscriptions.edit',$subscription->subscriptionID) !!}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                 @endpermission
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')

@endsection
