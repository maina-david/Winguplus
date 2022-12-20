@extends('layouts.app')
{{-- page header --}}
@section('title','Deals | Grid | Customer Relationship Management')
@section('stylesheet')
   <link rel="stylesheet" href="{!! asset('assets/css/project.css') !!}" />
   <style>
      .select2-container {
         z-index: 9999 !important;
      }
   </style>
@endsection
{{-- dashboard menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      @include('partials._messages')
      @livewire('crm.deals.grid')
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#dealModal').modal('hide');
         $('#stageModal').modal('hide');
         $('#delete').modal('hide');
      });
   </script>
   <script>
      $(function() {
         var url = "{!! route('crm.deals.stage.change') !!}";
         $('ul[id^="sort"]').sortable({
            connectWith: ".sortable",
            receive: function (e, ui) {
               var stage_code = $(ui.item).parent(".sortable").data("stage-code");
               var deal_code = $(ui.item).data("deal-code");
               $.ajax({
                  url: url+'?stage_code='+stage_code+'&deal_code='+deal_code,
                     success: function(response){
                  }
               });
            }
         }).disableSelection();
      } );
   </script>
   <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
   <script>
      ClassicEditor
      .create( document.querySelector('#details'))
      .then(editor => {
         document.querySelector('#save_task').addEventListener('click', ()=>{
            let details = $('#details').data('details');
            eval(details).set('details', editor.getData());
         });
      })
      .catch( error => {
         console.error( error );
      });
   </script>
@endsection
