@extends('layouts.app')
@section('title','Subscriptions')
@section('sidebar')
@include('app.subscriptions.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- end page-header -->
      <!-- begin row -->
      <div class="row">
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-teal">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-check-circle"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Active</div>
                  <div class="stats-number">{!! $liveCount !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-blue">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-times-circle"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Closed</div>
                  <div class="stats-number">{!! $closedCount !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-purple">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-tachometer-fastest"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Trials</div>
                  <div class="stats-number">{!! $trialCount !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-black">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-sync"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Subscriptions</div>
                  <div class="stats-number">{!! $subscriptionsCount !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="{!! route('subscriptions.index') !!}" class="text-white">view all</a></div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
      </div>
      <!-- end row -->
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">Subscription VS Month</div>
               <div class="card-body">
                  {!! $subscriptionPerMonth->container() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end #content -->
@endsection
@section('scripts')
	<script src="{!! asset('assets/plugins/chart.js/2.7.1/Chart.min.js') !!}" charset="utf-8"></script>
	{!! $subscriptionPerMonth->script() !!} 
@endsection
