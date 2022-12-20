@extends('layouts.app')
{{-- page header --}}
@section('title','Notes')

{{-- page styles --}}
@section('stylesheet')
	<link rel="stylesheet" href="{!! asset('assets/css/project.css') !!}" />
@endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.prm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('prm.index') !!}">Projects Management</a></li>
         <li class="breadcrumb-item"><a href="#">Projects</a></li>
         <li class="breadcrumb-item"><a href="#">Tasks</a></li>
         <li class="breadcrumb-item active">Tasks List</li>
      </ol>
      <h1 class="page-header"><i class="fas fa-sticky-note"></i> Notes</h1>
      @include('app.prm.partials._project_menu')
      @include('partials._messages')
      <div class="row mt-3">
         <div class="col-md-8">
				<form action="{!! route('project.notes.store') !!}" method="post">
               @csrf
               <div class="form-group">
                  <label for="">Title</label>
                  <input type="text" name="title" class="form-control" required>
                  <input type="hidden" name="projectID" value="{!! $project->id !!}" required>
               </div>
               <div class="form-group">
                  <label for="">Status</label>
                  {!! Form::select('status', ['Choose status' => '', 'Public' => 'Public', 'Private' => 'Private'], null ,['class' => 'form-control']) !!}
               </div>
               <div class="form-group">
                  <label for="">Note</label>
                  <textarea name="content" cols="30" rows="10" class="form-control ckeditor"></textarea>
               </div>
               <div class="form-group">
                  <center><button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Save Note</button></center>
                  <center><img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%"></center>
               </div>
            </form>
         </div>
         @include('app.prm.partials._project_stats')
      </div>
   </div>
   @endsection
   @section('scripts')
   <script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
   @endsection