@extends('layouts.app')
{{-- page header --}}
@section('title','Employees | Human Resource Management')
{{-- page styles --}}

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
            <a href="{!! route('hrm.employee.create') !!}" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add employee</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> All employee </h1>
      <!-- end page-header -->
      @include('partials._messages')
      @livewire('hr.employees.index')
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('Modal', () => {
         $('#delete').modal('hide');
      });
   </script>
@endsection
