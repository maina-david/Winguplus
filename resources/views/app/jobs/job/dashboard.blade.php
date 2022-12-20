@extends('layouts.app')
{{-- page header --}}
@section('title','Job Management | Dashboard')

{{-- page styles --}}
@section('stylesheet')
	<link rel="stylesheet" href="{!! asset('assets/css/project.css') !!}" />
@endsection

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.jobs.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div class="content">
      <!--begin::Container-->
      <div class="container-fluid">
         <!--begin::Navbar-->
         @livewire('jobs.job.head', ['jobCode' => $code])
         <div class="row">
            @livewire('jobs.job.dashboard.task-summary',['jobCode' => $code])
            @livewire('jobs.job.dashboard.tasksperuser',['jobCode' => $code])
            @livewire('jobs.job.dashboard.task-overtime',['jobCode' => $code])
            @livewire('jobs.job.dashboard.files',['jobCode' => $code])
            @livewire('jobs.job.dashboard.team-members',['jobCode' => $code])
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#kt_modal_users_search').modal('hide');
      });
   </script>
   <script>
      window.livewire.on('chartUpdate', () => {
         let chart = window[chartId].chart;

         chart.data.datasets.forEach((dataset, key) => {
            dataset.data = datasets[key];
         });

         chart.data.labels = labels;

         chart.update();
      });
   </script>
@endsection
