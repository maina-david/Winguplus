@extends('layouts.app')
{{-- page header --}}
@section('title','Job Openings | Recruitment | Human Resource')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         {{-- <a href="#" class="btn btn-white mr-1 active"><i class="fa fa-bars"></i></a>
         <a href="#" class="btn btn-white mr-1"><i class="fa fa-th"></i></a> --}}
         <a href="{!! route('hrm.recruitment.jobs.create') !!}" class="btn btn-pink"><i class="fal fa-plus-circle"></i> Add Job Openings</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-briefcase"></i> Job Openings </h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-responsive">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Candidates</th>
                     <th>Job Opening</th>
                     <th>Hiring Lead</th>
                     <th>Status</th>
                     <th>Created On</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($jobs as $job)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td>0</td>
                        <td>{!! $job->title !!}</td>
                        <td>
                           @if($job->hiring_lead != "")
                              @if(Wingu::check_user($job->hiring_lead) == 1)
                                 {!! Wingu::user($job->hiring_lead)->name !!}
                              @endif
                           @endif
                        </td>
                        <td><span class="badge {!! $job->name !!}">{!! $job->name !!}</td>
                        <td>{!! date('F jS, Y', strtotime($job->job_date)) !!}</td>
                        <td>
                           <a href="{!! route('hrm.recruitment.jobs.show',$job->code) !!}" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                           <a href="{!! route('hrm.recruitment.jobs.edit',$job->code) !!}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
      <!-- end panel -->
   </div>
@endsection
