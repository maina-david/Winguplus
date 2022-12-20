@extends('layouts.app')
@section('title','My Dashboard | Customer relationship management')
@section('stylesheet')
@endsection
@section('sidebar')
   @include('app.crm.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin row -->
      <div class="row">
         <div class="col-lg-3 col-md-3">
            <div class="widget widget-stats bg-gradient-teal">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-badge-dollar"></i></div>
               <div class="stats-content">
                  <div class="stats-title font-bold text-white">My Open Deals</div>
                  <div class="stats-number">8</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">View Deals</div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-3">
            <div class="widget widget-stats bg-gradient-purple">
               <div class="stats-icon stats-icon-lg"><i class="fas fa-badge-dollar"></i></div>
               <div class="stats-content">
                  <div class="stats-title font-bold text-white">My Untouched Deals</div>
                  <div class="stats-number">12</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc">View Deals</div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-3">
            <div class="widget widget-stats bg-gradient-green">
               <div class="stats-icon stats-icon-lg"><i class="far fa-phone-plus"></i></div>
               <div class="stats-content">
                  <div class="stats-title font-bold text-white">My Calls Today</div>
                  <div class="stats-number">9</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc text-white">View Calls</div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-3">
            <div class="widget widget-stats bg-gradient-red">
               <div class="stats-icon stats-icon-lg"><i class="fad fa-funnel-dollar"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white font-bold">My Leads </div>
                  <div class="stats-number">12</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc text-white">View Leads</div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-6">
            <div class="card" style="height: 550px">
               <div class="card-header">My Pipeline Deals By Stage</div>
               <div class="card-body">
                  <img src="{!! asset('assets/img/filter.png') !!}" alt="">
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card" style="height: 550px">
               <div class="card-header">Amount By Stage</div>
               <div class="card-body">
                  <img src="{!! asset('assets/img/sumamount.png') !!}" alt="" class="img-responsive">
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card" style="height: 550px">
               <div class="card-header">My Open Tasks </div>
               <div class="card-body">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <th>Subject</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Related To</th>
                        <th>Contact Name</th>
                     </thead>
                     <tbody>
                        <tr>

                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card" style="height: 550px">
               <div class="card-header">My Meetings </div>
               <div class="card-body">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <th>Title</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Related To</th>
                        <th>Contact Name</th>
                     </thead>
                     <tbody>
                        <tr>

                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card" style="height: 550px">
               <div class="card-header">Today's Leads</div>
               <div class="card-body">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <th>Lead Name</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Lead Source</th>
                        <th>Lead Owner</th>
                     </thead>
                     <tbody>
                        <tr>

                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card" style="height: 550px">
               <div class="card-header"> My Deals Closing This Month</div>
               <div class="card-body">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <th>Deal Name</th>
                        <th>Amount</th>
                        <th>Stage</th>
                        <th>Closing Date</th>
                        <th>Account Name</th>
                        <th>Contact Name</th>
                        <th>Deal Owner</th>
                     </thead>
                     <tbody>
                        <tr>

                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
