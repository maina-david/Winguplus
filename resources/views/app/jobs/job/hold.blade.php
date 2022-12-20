@extends('layouts.app')
{{-- page header --}}
@section('title','Project Management | Project Timeline')

{{-- page styles --}}
@section('stylesheet')
	<link rel="stylesheet" href="{!! asset('assets/css/project.css') !!}" />
@endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.jobs.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('prm.index') !!}">Projects Management</a></li>
         <li class="breadcrumb-item"><a href="#">Projects</a></li>
         <li class="breadcrumb-item active">Projects Timeline</li>
      </ol>
      <h1 class="page-header">{!! $project->project_name !!}</h1>
      @include('app.prm.partials._project_menu')
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-body">
                  <div class="mb-4">
                     <div class="float-right">
                        <div class="btn-group">
                           <button type="button" class="btn btn-default btn-sm icon-right-12 dropdown-toggle" data-toggle="dropdown" aria-expanded="true"> All Activity <span class="tm-glyph icon-arrow-down-12"></span></button>
                           <ul class="dropdown-menu" role="menu">
                              <li><a href="">All Activity</a></li>
                              <li><a href="">Messages</a></li>
                              <li><a href="">Comments</a></li>
                              <li><a href="">Events</a></li>
                              <li><a href="">Milestone</a></li>
                              <li><a href="">Tasks</a></li>
                              <li><a href="">Files</a></li>
                              <li><a href="">Notes</a></li>
                           </ul>
                        </div>
                     </div>
                     <h4>Activity stream</h4>
                  </div>
                  <hr>
                  <section class="mt-4 project-timeline">
                     <ul class="timeline">
								@foreach ($activities as $activity)
									<li>
	                           <!-- begin timeline-time -->
	                           <div class="timeline-time">
	                              <span class="date">{!! date('F d, Y', strtotime($activity->created_at)) !!}</span>
	                              <span class="time">@ {!! date(' H:i:s', strtotime($activity->created_at)) !!}</span>
	                           </div>
	                           <!-- end timeline-time -->
	                           <!-- begin timeline-icon -->
	                           <div class="timeline-icon">
	                              <a href="javascript:;">&nbsp;</a>
	                           </div>
	                           <!-- end timeline-icon -->
	                           <!-- begin timeline-body -->
	                           <div class="timeline-body">

	                              <div class="timeline-content">
	                                 <p>
	                                   {!! $activity->activity !!}
	                                 </p>
	                              </div>
	                           </div>
	                           <!-- end timeline-body -->
	                        </li>
								@endforeach
                     </ul>
                  </section>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="row">
               <!-- begin col-4 -->
               <div class="col-lg-12">
                  <div class="widget widget-stats bg-gradient-teal m-b-10">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-comments fa-fw"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Discussions</div>
                        <div class="stats-number">{!! Prm::count_project_comments($project->id) !!}</div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width:100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="#" class="text-white">View more information</a></div>
                     </div>
                  </div>
               </div>
					<div class="col-lg-12">
                  <div class="widget widget-stats bg-gradient-blue m-b-10">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-check-square fa-fw"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Tasks</div>
                        <div class="stats-number">{!! Prm::count_project_tasks($project->id) !!}</div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="#" class="text-white">View more information</a></div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-12">
                  <div class="widget widget-stats bg-gradient-purple m-b-10">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-headset fa-fw"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Tickets</div>
                        <div class="stats-number">{!! Prm::count_project_tickets($project->id) !!}</div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="#" class="text-white">View more information</a></div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-12">
                  <div class="widget widget-stats bg-gradient-black m-b-10">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-sticky-note fa-fw"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Notes</div>
                        <div class="stats-number">{!! Prm::count_project_note($project->id) !!}</div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="#" class="text-white">View more information</a></div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-12">
                  <div class="widget widget-stats bg-gradient-orange m-b-10">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-folder fa-fw"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Files</div>
                        <div class="stats-number">{!! Prm::count_project_attachments($project->id) !!}</div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="#" class="text-white">View more information</a></div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-12">
                  <div class="widget widget-stats bg-pink m-b-10">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-calendar-alt fa-fw"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Events</div>
                        <div class="stats-number">{!! Prm::count_project_events($project->id) !!}</div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width:100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="#" class="text-white">View more information</a></div>
                     </div>
                  </div>
               </div>
                     <!-- end col-4 -->
            </div>
         </div>
      </div>
   </div>
@endsection
