@extends('layouts.app')
@section('title','Edit Category | Wingu CMS')
@section('breadcrumb')
   <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1 breadcrumb-new">
         <h3 class="content-header-title mb-0 d-inline-block">Category</h3>
         <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{!! url('/') !!}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{!! url('/') !!}">Trivia</a></li>
                  <li class="breadcrumb-item"><a href="{!! route('trivia.category.index') !!}">Category</a></li>
                  <li class="breadcrumb-item active">Edit</li>
               </ol>
            </div>
         </div>
      </div>
      <div class="content-header-right col-md-6 col-12"></div>
   </div>
@endsection
@section('content')
@include('partials._messages')
<!-- begin panel -->
<div class="card">
   <div class="card-body">
      {!! Form::model($category, ['route' => ['trivia.category.update',$category->id], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
      <div class="row">
         <div class="col-md-6">
            <!-- Text inputs -->
            <div class="panel-body">
               <div class="form-group form-group-default required">
                  {!! Form::label('title', 'Title', array('class'=>'control-label')) !!}
                  {!! Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Title')) !!}
               </div>
               <div class="form-group form-group-default required">
                  {!! Form::label('title','Slide Status', array('class'=>'control-label')) !!}
                  {{ Form::select('status',[''=>'Choose Status',15=>'Active',7=>'Pending'], null, ['class' => 'form-control', 'required' => '']) }}
               </div>
               <div class="form-group form-group-default required">
                  <label>Image</label>
                  {!! Form::file('image',array('class' => 'form-control', 'id' => 'thumbnail', 'files'=> true)) !!}
               </div>
            </div>
            <!-- /text inputs -->
         </div>
         <div class="col-md-6">
            <!-- Text inputs -->
            <div class="panel-body">
               <div class="form-group">
                  <label for="">Caption</label>
                  {!! Form::textarea('description',null,['class'=>'form-control my-editor', 'size' => '6x6', 'placeholder'=>'caption']) !!}
               </div>
            </div>
            <!-- /text inputs -->
         </div>
      </div>
      <div class="col-md-12">
         <center>
            {!! Form::submit('Update Category',array('class' =>'btn btn-success btn-sm submit')) !!}
            <img src="{!! asset('assets/images/loader.gif') !!}" alt="" class="submit-load" style="width: 10%">
         </center>
      </div>
      {!! Form::close() !!}
   </div>
</div>
@endsection
