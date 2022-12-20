@extends('layouts.app')
{{-- page header --}}
@section('title','Job Management | Tasks')

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
<div id="content" class="content">
   <!--begin::Navbar-->
   @livewire('jobs.job.head',['jobCode' => $code])
   @livewire('jobs.job.tasks',['jobCode' => $code])
   <!--begin::Modal - Users Search-->
   @livewire('jobs.job.add-member-modal',['jobCode' => $code])
   <!--end::Modal - Users Search-->
</div>
@endsection
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#addTaskGroup').modal('hide');
         $('#addTask').modal('hide');
         $('#editTask').modal('hide');
         $('#updateTaskGroup').modal('hide');
         $('#add-section').modal('hide');
         $('#delete').modal('hide');
         $('#taskview').modal('hide');
      });
   </script>
   <script>
      $(function() {
         var url = "{!! route('task.group.change') !!}";
         $('ul[id^="sort"]').sortable({
            connectWith: ".sortable",
            receive: function (e, ui) {
               var group_code = $(ui.item).parent(".sortable").data("status-id");
               var task_code = $(ui.item).data("task-id");
               $.ajax({
                  url: url+'?group_code='+group_code+'&task_code='+task_code,
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
