@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $lead->customer_name !!} | Lead Details @endsection

{{-- page styles --}}
@section('stylesheet')
   <link rel="stylesheet" href="{!! asset('assets/css/project.css') !!}" />
   <style>
      .select2-container {
         z-index: 9999 !important;
      }
      table{
         background-color: #ffffff !important;
      }
      thead th{
         border-bottom: 1px solid #f2f3f4 !important;
         border-top: 1px solid #f2f3f4 !important;
      }
      th {
         border-left: 1px solid #f2f3f4;
         border-right: 1px solid #f2f3f4;
      }
   </style>
@endsection
{{-- dashboad menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <div class="row">
         {{-- @include('app.crm.leads._sidebar') --}}
         <div class="col-md-12">
            <div class="row mb-3">
               <div class="col-md-6"><h3>{!! $lead->customer_name !!}</h3></div>
               <div class="col-md-6">
                  <div class="float-right">
                     <a href="{!! route('crm.leads.edit',$code) !!}" class="btn btn-primary"><i class="fas fa-phone-volume"></i> Edit</a>
                     <a href="{!! route('crm.leads.send',$code) !!}" class="btn btn-white"><i class="fas fa-paper-plane"></i> Send Email</a>
                     @if($lead->category != "")
                        <a href="{!! route('crm.leads.convert',$code) !!}" class="btn btn-success delete"> Convert to customer</a>
                     @endif
                     <a href="{!! route('crm.leads.delete', $code) !!}" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                  </div>
               </div>
            </div>
            @include('app.crm.leads._nav')
            @include('partials._messages')
            @if(Request::is('crm/leads/'.$code.'/show'))
               @include('app.crm.leads.view')
            @endif
            @if(Request::is('crm/leads/'.$code.'/calllog'))
               @include('app.crm.leads.calllog.index')
            @endif
            @if(Request::is('crm/leads/'.$code.'/notes'))
               @include('app.crm.leads.notes.notes')
            @endif
            @if(Request::is('crm/leads/'.$code.'/tasks'))
               @include('app.crm.leads.tasks.index')
            @endif

            @if(Request::is('crm/leads/'.$code.'/events'))
               @livewire('crm.leads.events.grid-view', ['leadCode' => $code])
            @endif

            @if(Request::is('crm/leads/'.$code.'/events/list'))
               @livewire('crm.leads.events.list-view', ['leadCode' => $code])
            @endif

            @if(Request::is('crm/leads/'.$code.'/mail'))
               @include('app.crm.leads.mail.index')
            @endif

            @if(Request::is('crm/leads/'.$code.'/send'))
               @include('app.crm.leads.mail.send')
            @endif
            @if(Request::route()->getName() == 'crm.leads.details')
               @include('app.crm.leads.mail.details')
            @endif
            @if(Request::is('crm/leads/'.$code.'/sms'))
               @include('app.crm.leads.sms.index')
            @endif
            @if(Request::is('crm/leads/'.$code.'/documents'))
               @include('app.crm.leads.documents.index')
            @endif
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#eventCreate').modal('hide');
      });
   </script>
   <script type="text/javascript">
      window.livewire.on('editModal', () => {
         $('#eventEdit').modal('hide');
      });
   </script>
   <script type="text/javascript">
      window.livewire.on('detailsModal', () => {
         $('#detail').modal('hide');
      });
   </script>
   <script type="text/javascript">
      window.livewire.on('deleteModal', () => {
         $('#delete').modal('hide');
      });
   </script>
@endsection
