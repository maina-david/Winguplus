@extends('layouts.app')
{{-- page header --}}
@section('title','Job Management | Goals')

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
         {{-- @livewire('jobs.job.head', ['jobCode' => $code]) --}}
         @include('partials._messages')
         @livewire('jobs.goals.goals', ['jobCode' => $code])
      </div>
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#goalModal').modal('hide');
         $('#delete').modal('hide');
         $('#goalDetails').modal('hide');
      });
      window.livewire.on('progress', () => {
         $('#progressModal').modal('hide');
      });
   </script>
@endsection
