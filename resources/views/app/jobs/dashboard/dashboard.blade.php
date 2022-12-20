@extends('layouts.app')
{{-- page header --}}
@section('title','Jobs Management')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.jobs.partials._menu')
@endsection

@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Jobs Management</a></li>
         <li class="breadcrumb-item active">Dashboard</li>
      </ol>
      <!-- end breadcrumb -->
      <h1 class="page-header"><i class="fal fa-chart-network"></i> Dashboard </h1>
      <!-- begin #content -->
      <div class="row">
         <div class="col-md-3">
            <div class="widget widget-stats bg-gradient-blue">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-briefcase"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Total Jobs</div>
                  <div class="stats-number">{!! number_format($totalJobs) !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="{!! route('job.index') !!}" class="text-white">View Jobs</a></div>
               </div>
            </div>
            <div class="widget widget-stats bg-gradient-aqua">
               <div class="stats-icon stats-icon-lg"><i class="fas fa-ballot-check"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Total Open Tasks</div>
                  <div class="stats-number">0</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">Jobs</div>
               </div>
            </div>
            <div class="widget widget-stats bg-gradient-green">
               <div class="stats-icon stats-icon-lg"><i class="fas fa-check-square"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Total Completed Tasks</div>
                  <div class="stats-number">0</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">Jobs</div>
               </div>
            </div>
         </div>
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                 Jobs Per Month
               </div>
               <div class="card-body" style="height:383px">
                  {!! $jobOverTime->container() !!}
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  Current Jobs
               </div>
               <div class="card-body" style="min-height:817px;">
                  <ul class="registered-users-list">
                     @foreach($currentJobs as $currentJob)
                        <li>
                           <a href="{{ route('job.dashboard',$currentJob->job_code) }}">
                              @if($currentJob->image)
                                 <img src="{!! asset('businesses/'.Auth::user()->business_code.'/jobs/'.$currentJob->job_code.'/images/'.$currentJob->image) !!}" alt="{!! $currentJob->job_title !!}" class="img-responsive">
                              @else
                                 <img src="https://ui-avatars.com/api/?name={!! $currentJob->job_title !!}&rounded=false&size=120" alt="{!! $currentJob->job_title !!}" class="img-responsive">
                              @endif
                           </a>
                           <h4 class="username text-ellipsis">
                              {!! $currentJob->job_title !!}
                              <small>{!! $currentJob->job_type !!}</small>
                           </h4>
                        </li>
                     @endforeach
                  </ul>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  Over Due Tasks
               </div>
               <div class="card-body" style="min-height:463px;">
                  @foreach($dueTasks as $task)
                     <div class="widget-list-item mb-2">
                        <div class="widget-list-media">
                           @if($task->status == 1)
                              @if($task->priority == 1)
                                 <img src="{!! asset('assets/img/urgent.png') !!}" alt="" class="rounded">
                              @elseif($task->priority == 2)
                                 <img src="{!! asset('assets/img/high.png') !!}" alt="" class="rounded">
                              @elseif($task->priority == 5)
                                 <img src="{!! asset('assets/img/medium.png') !!}" alt="" class="rounded">
                              @else
                                 <img src="{!! asset('assets/img/deafult.png') !!}" alt="" class="rounded">
                              @endif
                           @elseif($task->status == 7)
                              <img src="{!! asset('assets/img/complete.png') !!}" alt="" class="rounded">
                           @else
                              <img src="{!! asset('assets/img/blank-check.png') !!}" alt="" class="rounded">
                           @endif
                        </div>
                        <div class="widget-list-content">
                           <h4 class="widget-list-title mb-1"> @if($task->status == 16)<strike>{!! $task->title !!}</strike>@else {!! $task->title !!} @endif</h4>
                           <p class="widget-list-desc font-bold">
                              @if($task->priority != 0)
                                 <i class="fas fa-exclamation-triangle"></i> Priority :
                                 @if($task->priority == 1)
                                    <span class="badge badge-danger">{!! Wingu::status($task->priority)->name !!}</span>
                                 @elseif($task->priority == 2)
                                    <span class="badge badge-warning">{!! Wingu::status($task->priority)->name !!}</span>
                                 @elseif($task->priority == 5)
                                    <span class="badge badge-primary">{!! Wingu::status($task->priority)->name !!}</span>
                                 @else
                                    <span class="badge badge-default">{!! Wingu::status($task->priority)->name !!}</span>
                                 @endif
                                 |
                              @endif
                              @if($task->status != 0 )
                              <i class="fas fa-heartbeat"></i> Status :
                                 @if($task->status == 1)
                                    <span class="badge badge-success">{!! Wingu::status($task->status)->name !!}</span>
                                 @else
                                    <span class="text-primary">{!! Wingu::status($task->status)->name !!}</span>
                                 @endif
                                 |
                              @endif
                              <i class="fas fa-users-cog"></i> Assigned To :
                              <span class="text-primary">
                                 @foreach(Job::task_allocations($task->task_code) as $alloc)
                                    @if(Wingu::check_user($alloc->user) == 1)
                                       {!! Wingu::user($alloc->user)->name !!},
                                    @endif
                                 @endforeach
                              </span>
                              @if($task->due_date != "")
                              | <i class="fas fa-calendar-times"></i> Due Date : <b>{!! date('d F Y', strtotime($task->due_date)) !!}</b>
                              @endif
                              | <i class="fas fa-paperclip"></i> Attachment : <b>{!! Job::task_attachments($task->task_code)->count() !!}</b>
                              | <i class="fas fa-comments"></i> Comments : <b>{!! Job::task_comments($task->task_code)->count() !!}</b>
                           </p>
                        </div>
                        <div class="widget-list-action">
                           @if($task->status != 16)
                              <a href="#" data-toggle="dropdown" class="text-muted pull-right"><i class="fa fa-ellipsis-h f-s-14"></i></a>
                              <ul class="dropdown-menu dropdown-menu-right">
                                 <li><a href="{!! route('task.complete',[$task->job,$task->task_code]) !!}"><i class="far fa-check-circle"></i> Mark as Complete</a></li>
                              </ul>
                           @endif
                        </div>
                     </div>
                  @endforeach
               </div>
            </div>
         </div>
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  Total Tasks Per Member
               </div>
               <div class="card-body">
                  {!! $membersWithTasks->container() !!}
               </div>
            </div>
         </div>

         {{-- <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  Tasks overview (pie chart i,e tasks by status)
               </div>
               <div class="card-body">

               </div>
            </div>
         </div> --}}
         {{-- <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  Jobs per type (area graph)
               </div>
               <div class="card-body">

               </div>
            </div>
         </div> --}}
      </div>
   </div>
   <!-- end #content -->
@endsection
@section('scripts')
	<script src="{!! asset('assets/plugins/chart.js/2.7.1/Chart.min.js') !!}" charset="utf-8"></script>
   {!! $jobOverTime->script() !!}
   {!! $membersWithTasks->script() !!}
@endsection

