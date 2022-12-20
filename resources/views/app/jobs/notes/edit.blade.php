@extends('layouts.app')
{{-- page header --}}
@section('title','Job Management | Notes')

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
   <div id="content" class="content">
      <!--begin::Navbar-->
      @livewire('jobs.job.head', ['jobCode' => $code])
      @include('partials._messages')
      <div class="row">
         <div class="col-md-12 mt-2">
            <div class="row">
               <div class="col-md-12">
                  <h4 class="font-weight-bold"><i class="fal fa-sticky-note"></i> Notes | Edit</h4>
               </div>
            </div>
         </div>
      </div>
      <div class="row mt-2">
         <div class="col-md-8">
            <div class="panel">
               <div class="panel-body">
                  {!! Form::model($edit,['route' => ['job.notes.update',[$code,$edit->note_code]], 'method' => 'post']) !!}
                     @csrf
                     <div class="form-group">
                        <label for="">Title</label>
                        {!! Form::text('title', null, ['class' => 'form-control', 'required' => '']) !!}
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="">Status</label>
                              {!! Form::select('status', ['Choose status' => '', 'Public' => 'Public', 'Private' => 'Private'], null ,['class' => 'form-control']) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="">Label</label>
                              {!! Form::select('label',[''=>'Choose Label','bg-blue'=>'Blue','bg-orange'=>'Orange','bg-red'=>'Red','bg-cyan'=>'Cyan / Aqua','bg-gray'=>'Gray','bg-teal'=>'Teal'],null,['class'=>'form-control']) !!}
                           </div>
                        </div>
                     </div>
                     {!! Form::textarea('brief', null, ['class' => 'form-control', 'size'=>'4 x 4']) !!}
                     <div class="form-group">
                        <label for="">Note</label>
                        <textarea name="content" class="form-control tinymcy">{!! $edit->content !!}</textarea>
                     </div>
                     <div class="form-group">
                        <center><button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Note</button></center>
                        <center><img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%"></center>
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
