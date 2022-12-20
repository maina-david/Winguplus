@extends('layouts.app')
{{-- page header --}}
@section('title','Project Details')

{{-- page styles --}}
@section('stylesheet')
	<link rel="stylesheet" href="{!! asset('assets/css/project.css') !!}" />
@endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.prm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('prm.index') !!}">Projects Management</a></li>
         <li class="breadcrumb-item"><a href="#">Projects</a></li>
         <li class="breadcrumb-item active">Projects Details</li>
      </ol>
      <h1 class="page-header">{!! $project->project_name !!}</h1>
      @include('app.prm.partials._project_menu')
      <div class="row mt-3">
         <div class="col-md-8">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Project Details</h4>
               </div>
               <div class="panel-body">
                  <h3>{!! $project->project_name !!}</h3>
                  {!! $project->description !!}
               </div>
            </div>
         </div>
         @section('client')
         <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Client Details</h4>
               </div> 
               <div class="panel-body">
                  @if($project->project_type == 'Internal')
                     <h3 class="m-xs text-success">
                        {!! Wingu::business()->name !!}
                     </h3>
                  @else
                     <h3 class="m-xs text-success">
                        {!! $client->customer_name !!}
                     </h3>
                  @endif
                  @if($project->project_type != 'Internal')
                     <div class="row">
                        <div class="col-xs-6">
                           <small class="stat-label">Email</small>
                           <h5><i class="fa fa-envelope-o" aria-hidden="true"></i> {!! $client->email !!}</h5>
                        </div>
                        <div class="col-xs-6">
                           <small class="stat-label">Phone number</small>
                           <h5><i class="fa fa-phone" aria-hidden="true"></i> {!! $client->primary_phone_number !!}</h5>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-xs-6">
                           <small class="stat-label">Website</small>
                           <h5><i class="fas fa-globe"></i> {!! $client->website !!}</h5>
                        </div>
                     </div>
                  @endif
               </div>
            </div>
         @endsection
         @include('app.prm.partials._project_stats')
      </div>
   </div>
@endsection
@section('script')
@endsection
