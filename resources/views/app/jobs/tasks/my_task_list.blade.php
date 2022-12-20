@extends('layouts.app')
{{-- page header --}}
@section('title','My Tasks | Job Management')

{{-- page styles --}}
@section('stylesheet')
   <link rel="stylesheet" href="{!! asset('assets/css/task_inbox.css') !!}" />
   <link rel="stylesheet" href="{!! asset('assets/css/project.css') !!}" />
@endsection
{{-- dashboard menu --}}
@section('sidebar')
   @include('app.jobs.partials._menu')
   <style>
      ul.product li {
         width: 100%;
      }
   </style>
@endsection

{{-- content section --}}
@section('content')
   @livewire('jobs.my-task-list')
@endsection
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#addTaskGroup').modal('hide');
         $('#taskview').modal('hide');
      });
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
