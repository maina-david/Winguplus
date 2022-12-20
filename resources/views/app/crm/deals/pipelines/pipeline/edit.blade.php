@extends('layouts.app')
{{-- page header --}}
@section('title','Pipeline | Customer Relationship Management')

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('crm.dashboard') !!}">CRM</a></li>
         <li class="breadcrumb-item"><a href="{!! route('crm.pipeline.index') !!}">Pipeline</a></li>
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-stream"></i>Update Pipeline</h1>
      @include('partials._messages')
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Pipeline list</div>
               <div class="card-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <th width="1%">#</th>
                        <th>Title</th>
                        <th>Deals</th>
                        <th width="34%">Action</th>
                     </thead>
                     <tbody>
                        @foreach ($pipelines as $count=>$pipe)
                           <tr>
                              <td>{!! $count+1 !!}</td>
                              <td>{!! $pipe->title !!}</td>
                              <td>0</td>
                              <td>
                                 <a href="{!! route('crm.pipeline.edit',$pipe->pipeline_code) !!}" class="btn btn-sm btn-pink">Edit</a>
                                 <a href="{!! route('crm.pipeline.show',$pipe->pipeline_code) !!}" class="btn btn-sm btn-primary">View</a>
                                 <a href="{!! route('crm.pipeline.delete',$pipe->pipeline_code) !!}" class="btn btn-sm btn-danger">Delete</a>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Update Pipeline</div>
               <div class="card-body">
                  {!! Form::model($edit, ['route' => ['crm.pipeline.update', $edit->pipeline_code], 'method'=>'post', 'autocomplete' => 'off']) !!}
                     @csrf
                     <div class="form-group form-group-default">
                        <label for="">Title</label>
                        {!! Form::text('title',null,['class'=>'form-control','required'=>'','placeholder'=>'Enter pipeline title']) !!}
                     </div>
                     <div class="form-group">
                        <label for="">Description</label>
                        {!! Form::textarea('description',null,['class'=>'form-control','size'=>'8x8','placeholder'=>'Enter pipeline description']) !!}
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Pipeline</button>
			               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
