@extends('layouts.app')
{{-- page header --}}
@section('title','Customer Category | Customer Relationship Management')
{{-- page styles --}}

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="{!! route('crm.dashboard') !!}">CRM</a></li>
         <li class="breadcrumb-item"><a href="{!! route('crm.customers.index') !!}">Customer</a></li>
         <li class="breadcrumb-item"><a href="{!! route('crm.customers.groups.index') !!}">Category</a></li>
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-sitemap"></i> Update Category</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <table id="data-table-default" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th width="1%">#</th>
                              <th>Name</th>
                              <th width="34%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($groups as $count=>$group)
                           <tr>
                              <td>{!! $count+1 !!}</td>
                              <td>{!! $group->name !!}</td>
                              <td>
                                 <a href="{!! route('crm.customers.groups.edit',$group->group_code) !!}" class="btn btn-pink btn-sm"><i class="far fa-edit"></i> Edit</a>
                                 <a href="{!! route('crm.customers.groups.delete',$group->group_code) !!}" class="btn btn-danger delete btn-sm"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Update Category</h4>
               </div>
               <div class="panel-body">
                  <div class="panel-body">
                     {!! Form::model($edit, ['route' => ['crm.customers.groups.update',$edit->group_code], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
                        @csrf
                        <div class="form-group form-group-default required">
                           {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                           {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Group Name','required' => '')) !!}
                        </div>
                        <div class="form-group mt-4">
                           <center>
										<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Group</button>
										<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
									</center>
                        </div>
                     {!! Form::close() !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
