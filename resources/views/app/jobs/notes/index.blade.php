@extends('layouts.app')
{{-- page header --}}
@section('title','Job Management | Notes')

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

	<div class="content">
      <!--begin::Container-->
      <div class="container-fluid">
         <!--begin::Navbar-->
         @livewire('jobs.job.head', ['jobCode' => $code])
         @include('partials._messages')
         @livewire('jobs.job.notes', ['jobCode' => $code])
      </div>
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#addNote').modal('hide');
      });
   </script>
@endsection
