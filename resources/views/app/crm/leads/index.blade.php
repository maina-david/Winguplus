 @extends('layouts.app')
{{-- page header --}}
@section('title','Leads | Customer Relationship Management')

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="float-right">
         <div class="btn-group">
            <button type="button" class="btn btn-outline-black dropdown-toggle mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fal fa-list"></i> List view
            </button>
            <ul class="dropdown-menu" role="menu">
               <li><a href="{!! route('crm.leads.canvas') !!}"><i class="fal fa-grip-horizontal"></i> Canvas view</a></li>
            </ul>
         </div>
         <a href="{!! route('crm.leads.create') !!}" class="btn btn-pink"><i class="fas fa-user-plus"></i> New Leads</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-phone-volume"></i> All Leads</h1>
      @include('partials._messages')
      @livewire('crm.leads.index')
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
