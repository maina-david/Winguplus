@extends('layouts.app')
{{-- page header --}}
@section('title','Settings | Roles')

{{-- dashboad menu --}}
@section('sidebar')
   @include('app.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <a href="{!! route('settings.roles.create') !!}" class="btn btn-success"><i class="fal fa-plus-circle"></i> Add Roles</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shield-alt"></i> All Roles </h1>
      <!-- begin row -->
      @include('partials._messages')
		<div class="panel panel-inverse">
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Role Name</th>
                     <th>Description</th>
                     <th width="12%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($roles as $count=>$role)
                     <tr>
                        <td>{!! $count+1 !!}</td>
                        <td>{{ $role->display_name }}</td>
                        <td>{!! $role->description !!}</td>
                        <td>
                           @if($role->role_code != 'admin')
                              <a href="{!! route('settings.roles.edit',$role->role_code) !!}" class="btn btn-primary">Edit</a>
                              <a href="{!! route('settings.roles.delete',$role->role_code) !!}" class="btn btn-danger delete">Delete</a>
                           @endif
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
@endsection
