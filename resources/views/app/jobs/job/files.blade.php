@extends('layouts.app')
{{-- page header --}}
@section('title','Job Management | Files')

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
         @livewire('jobs.job.files', ['jobCode' => $code])
         <!--begin::Modal - Users Search-->
      </div>
   </div>

   {{-- add file --}}
   <div class="modal fade add-file" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <form action="{!! route('job.files.store') !!}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title group-title" id="exampleModalLongTitle"><i class="fal fa-folder-plus"></i> Upload File</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('File Title', 'File Title', array('class'=>'control-label')) !!}
                           {!! Form::text('title', null, array('class' => 'form-control','required' => '','placeholder' => 'Enter File title')) !!}
                           <input type="hidden" value="{!! $code !!}" name="jobcode" required>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           {!! Form::label('File', 'Choose File', array('class'=>'control-label')) !!}
                           <input type="file" name="attachment[]" id="files"  class="form-control" multiple>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-pink submit" id="submit"><i class="fas fa-save"></i> Upload Files</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </div>
            </div>
         </form>
      </div>
   </div>

@endsection
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#delete').modal('hide');
      });
   </script>
@endsection
