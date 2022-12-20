@extends('layouts.app')
{{-- page header --}}
@section('title','Jobs | Jobs Management')
{{-- page styles --}}
@section('stylesheet')
	<link rel="stylesheet" href="{!! asset('assets/css/job.css') !!}" />
@endsection

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.jobs.partials._menu')
@endsection
{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('jobs.dashboard') !!}">Jobs Management</a></li>
         <li class="breadcrumb-item"><a href="{!! route('job.index') !!}">Jobs</a></li>
         <li class="breadcrumb-item active">All Jobs</li>
      </ol>
      <h1 class="page-header"><i class="fal fa-rocket-launch"></i> All Jobs</h1>
		<div class="row mb-2">
         <div class="col-sm-4">
            <a href="{!! route('job.create') !!}" class="btn btn-pink mb-3"><i class="fas fa-plus"></i> Create Job</a>
         </div>
         <div class="col-sm-8">
            {{-- <div class="text-sm-right">
               <div class="btn-group mb-3">
                  <a href="{!! route('job.index',['all']) !!}" class="btn btn-pink">All</a>
               </div>
               <div class="btn-group mb-3 ml-1">
                  <button type="button" class="btn btn-light">Ongoing</button>
                  <button type="button" class="btn btn-light">Complete</button>
               </div>
               <div class="btn-group mb-3 ml-2 d-none d-sm-inline-block">
                  <button type="button" class="btn btn-dark"><i class="fab fa-buromobelexperte"></i></button>
               </div>
               <div class="btn-group mb-3 d-none d-sm-inline-block">
                  <button type="button" class="btn btn-link text-dark"><i class="fas fa-list"></i></button>
               </div>
            </div> --}}
         </div><!-- end col-->
      </div>
      <!-- end row-->
      @livewire('jobs.jobs')
   </div>
@endsection
