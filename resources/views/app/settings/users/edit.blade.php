@extends('layouts.app')
{{-- page header --}}
@section('title') Settings | Update User @endsection

{{-- dashboard menu --}}
@section('sidebar')
   @include('app.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">{!! trans('general.settings') !!}</a></li>
         <li class="breadcrumb-item"><a href="{!! route('settings.users.index') !!}">Users</a></li>
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user-edit"></i> Update User</h1>
      @include('partials._messages')
	   <div class="panel panel-default" data-sortable-id="ui-widget-1">
         <div class="panel-heading">
            <h4 class="panel-title">Update User</h4>
         </div>
         <div class="panel-body">
            {!! Form::model($user, ['route' => ['settings.users.update',$user->user_code], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
               {{ csrf_field() }}
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}" required>
                     </div>
                     @if($user->id != Wingu::business()->userID)
                        <div class="form-group">
                           <label for="email" class="">Email:</label>
                           <input type="text" class="form-control" name="email" id="email" value="{{$user->email}}" required>
                        </div>
                     @endif
                     <div class="form-group">
                        <label for="">Branch</label>
                        {!! Form::select('branch_code',$branches,null,['class'=>'form-control select2','required'=>'']) !!}
                     </div>
                  </div>
                  @if($user->email != Wingu::business()->email)
                     <div class="col-md-6">
                        <label for="roles" class="">Roles:</label>
                        <div class="row">
                           @foreach($roles as $role)
                              <div class="col-md-4">
                                 <input type="checkbox" name="roles[]" value="{{$role->role_code}}" @if(Wingu::check_if_user_has_role($user->user_code,$role->role_code) == 1) checked @endif> {!! $role->display_name !!}</input>
                              </div>
                           @endforeach
                        </div>
                     </div>
                  @else
                  <div class="col-md-6">
                     <label for="roles" class="">Roles:</label>
                     <div class="row">
                        <div class="col-md-4">
                           <input type="checkbox" checked> Admin</input>
                        </div>
                     </div>
                  </div>
                  @endif
               </div>
               <div class="col-md-12">
                  <div class="column">
                     <hr />
                     <button class="btn btn-pink pull-right submit" type="submit"><i class="fas fa-save"></i> Update user</button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                  </div>
               </div>
            {!! Form::close() !!}
         </div>
      </div>
   </div>
@endsection
@section('script')

@endsection
