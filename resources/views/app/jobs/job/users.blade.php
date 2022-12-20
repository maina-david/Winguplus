@extends('layouts.app')
{{-- page header --}}
@section('title','Job Management | Users')

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
         @livewire('jobs.job.users', ['jobCode' => $code])
      </div>
   </div>

@endsection
@section('scripts')
   <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
   <script>
      ClassicEditor
      .create( document.querySelector('#comment'))
      .then(editor => {
         document.querySelector('#save_task').addEventListener('click', ()=>{
            let comment = $('#comment').data('comment');
            eval(comment).set('comment', editor.getData());
         });
      })
      .catch( error => {
         console.error( error );
      });
   </script>
@endsection

