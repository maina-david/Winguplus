@extends('layouts.app')
{{-- page header --}}
@section('title','Leave Settings')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
   @include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('hrm.dashboard') !!}">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-tools"></i> Settings</h1>
      @include('partials._messages')
      <div class="row">
         @include('app.hr.partials._settings_nav')
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     {{-- <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.leave.settings.holiday') }}" href="{!! route('hrm.leave.settings.holiday') !!}"><i class="fas fa-calendar-alt"></i> Holidays</a>
                     </li> --}}
                     <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.leave.type') }}" href="{!! route('hrm.leave.type') !!}"><i class="fal fa-user-clock"></i> Leave Types</a>
                     </li>
                     {{-- <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.leave.settings.workdays') }}" href="{!! route('hrm.leave.settings.workdays') !!}"><i class="fas fa-history"></i> Hours & Workweek</a>
                     </li> --}}
                  </ul>
               </div>
               <div class="card-block">
                  @if(Request::is('hrm/leave/holiday'))
                     @include('app.hr.leave.settings.holiday')
                  @endif
                  @if(Wingu::check_if_user_has_role(Auth::user()->user_code,'admin') == 1 || Wingu::check_user_permission('read-leavetype') == 1 )
                     @if(Request::is('hrm/leave/type'))
                        @livewire('hr.leave.types')
                     @endif
                  @endif
                  @if(Request::is('hrm/leave/workdays'))
                     @include('app.hr.leave.settings.workdays')
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#typeModal').modal('hide');
         $('#delete').modal('hide');
      });
   </script>
@endsection
