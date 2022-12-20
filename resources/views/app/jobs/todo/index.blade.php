@extends('layouts.app')
{{-- page header --}}
@section('title','All To do items')

{{-- page styles --}}
@section('stylesheet')
	<link rel="stylesheet" href="{!! assets('assets/css/project.css') !!}" />
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
      <li class="breadcrumb-item"><a href="{!! route('project.index') !!}">to-do list</a></li>
      <li class="breadcrumb-item active">All To do items</li>
   </ol>
   <h1 class="page-header">All To do items</h1>
   @include('partials._messages')
   <div class="row mt-3">
      <div class="col-md-8">
         <div class="panel panel-inverse">
            <div class="panel-heading">
               <h4 class="panel-title">All Tasks</h4>
            </div>
            <div class="panel-body">
               @foreach($tasks as $task)
                  <div class="widget-list-item">
                     <div class="widget-list-media">
                        @if($task->tasks_status_id == 1)
                           @if($task->tasks_priority_id == 1)
                              <img src="{!! asset('assets/img/urgent.png') !!}" alt="" class="rounded">
                           @elseif($task->tasks_priority_id == 2)
                              <img src="{!! asset('assets/img/high.png') !!}" alt="" class="rounded">
                           @elseif($task->tasks_priority_id == 5)
                              <img src="{!! asset('assets/img/medium.png') !!}" alt="" class="rounded">
                           @else
                              <img src="{!! asset('assets/img/deafult.png') !!}" alt="" class="rounded">
                           @endif
                        @elseif($task->tasks_status_id == 7)
                        <img src="{!! asset('assets/img/complete.png') !!}" alt="" class="rounded">
                        @else
                        <img src="{!! asset('assets/img/blank-check.png') !!}" alt="" class="rounded">
                        @endif
                     </div>
                     <div class="widget-list-content">
                        <h4 class="widget-list-title"> @if($task->tasks_status_id == 7)<strike>{!! $task->name !!}</strike>@else {!! $task->name !!} @endif</h4>
                        <p class="widget-list-desc font-bold">
                           Priority :
                           @if($task->tasks_priority_id == 1)
										<span class="badge badge-danger">{!! prm::tasks_priority($task->tasks_priority_id)->name !!}</span>
									@elseif($task->tasks_priority_id == 2)
										<span class="badge badge-warning">{!! prm::tasks_priority($task->tasks_priority_id)->name !!}</span>
									@elseif($task->tasks_priority_id == 5)
										<span class="badge badge-primary">{!! prm::tasks_priority($task->tasks_priority_id)->name !!}</span>
									@else
                              <span class="badge badge-default">{!! prm::tasks_priority($task->tasks_priority_id)->name !!}</span>
                           @endif |
									Status :
									@if($task->tasks_status_id == 1)
										<span class="badge badge-success">{!! prm::task_status($task->tasks_status_id)->name !!}</span>
									@else
										<span class="text-primary">{!! prm::task_status($task->tasks_status_id)->name !!}</span>
									@endif |
									Assigned To :
									<span class="text-primary">@foreach(prm::task_allocations($task->taskID) as $alloc) {!! Hr::employee($alloc->employeeID)->names !!} @endforeach</span> |
										Due Date : <b>{!! date('d F Y', strtotime($task->due_date)) !!}</b> |
										Project : <b> {!! prm::project_info($task->projectID)->project_name !!} </b>
                        </p>
                     </div>
                     <div class="widget-list-action">
                        <a href="#" data-toggle="dropdown" class="text-muted pull-right"><i class="fa fa-ellipsis-h f-s-14"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                           <li><a href="{!! route('task.edit',$task->taskID) !!}"><i class="fas fa-pen-square"></i> Edit</a></li>
                           <li><a href="#"><i class="fas fa-eye"></i> View</a></li>
                           <li><a href="#"><i class="fas fa-trash"></i> Delete</a></li>
                        </ul>
                     </div>
                  </div>
               @endforeach
               <nav aria-label="..." class="mt-3">
                  <center>
                     <ul class="pagination">
                        @if ($tasks->lastPage() > 1)
                           <li class="page-item">
                              <a class="page-link" href="{{ $tasks->url(1) }}">Previous</a>
                           </li>
                           @for ($i = 1; $i <= $tasks->lastPage(); $i++)
                           <li class="page-item {{ ($tasks->currentPage() == $i) ? 'active' : '' }}"><a class="page-link" href="{{ $tasks->url($i) }}">{{ $i }}</a></li>
                           @endfor
                           <li class="page-item">
                              <a class="page-link" href="{{ $tasks->url($tasks->currentPage()+1) }}">Next</a>
                           </li>
                        @endif
                     </ul>
                  </center>
               </nav>
            </div>
         </div>
         <!--- \\\\\\\Post-->
      </div>
      <div class="col-md-4">
         <div class="panel panel-inverse">
            <div class="panel-heading">
               <h4 class="panel-title">Task Statistics</h4>
            </div>
            <div class="panel-body">
               <div class="table-scrollable">
                  <table class="table table-bordered table-hover table-item-details">
                     <tbody>
                        <tr>
                           <th>Total Tasks :</th>
                           <td><span class="text-uppercase"></td>
                        </tr>
                        <tr>
                           <th>Total Tasks Completed :</th>
                           <td><span class="text-uppercase"></td>
                        </tr>
                        <tr>
                           <th>Total Tasks Due :</th>
                           <td><span class="text-uppercase"></td>
                        </tr>
                        <tr>
                           <th>Due today:</th>
                           <td><span class="text-uppercase"></td>
                        </tr>
                        <tr>
                           <th>Due in the next 1 week :</th>
                           <td><span class="text-uppercase"></td>
                        </tr>
                        <tr>
                           <th>Due in the next 2 week :</th>
                           <td><span class="text-uppercase"></td>
                        </tr>
                        <tr><th>Status :</th><td><span class="badge badge-primary"></span></td></tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
