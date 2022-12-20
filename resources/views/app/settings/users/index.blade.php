@extends('layouts.app')
{{-- page header --}}
@section('title','Settings | Users ')
{{-- dashboad menu --}}
@section('sidebar')
   @include('app.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         @if($users->count() == $businessPlan->users)
            <a class="btn btn-pink" href="#"><i class="fal fa-user-plus"></i> Upgrade your plan</a>
         @else
            <a class="btn btn-pink" href="{!! route('settings.users.create') !!}"><i class="fal fa-user-plus"></i> Add New User</a>
         @endif
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> Users </h1>
      <div class="panel panel-default" data-sortable-id="ui-widget-1">
         <div class="panel-heading">
            <h4 class="panel-title">All User</h4>
         </div>
         <div class="panel-body">
            @include('partials._messages')
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr role="row">
                     <th width="1%">#</th>
                     <th></th>
                     <th>Name</th>
                     <th>email</th>
                     <th>Last Login</th>
                     <th>Roles</th>
                     <th width="4%">Status</th>
                     <th width="10%"><center>Action</center></th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($users as $count=>$user)
                     <tr>
                        <td>{!! $count+1 !!}</td>
                        <td>
                           @if($user->avatar != "")
                              <img class="rounded-circle" width="40" height="40" alt="{!! $user->user_name !!}" class="img-circle FL" src="{!! asset('businesses/'.Wingu::business()->business_code.'/users/'.$user->user_code.'/'.$user->avatar) !!}">
                           @else
                              <img src="https://ui-avatars.com/api/?name={!! $user->user_name !!}&rounded=true&size=32" alt="{!! $user->user_name !!}">
                           @endif
                        </td>
                        <td>
                           <p>
                              {!! $user->user_name !!}
                              @if($user->branch_code)
                                 <br>
                                 @if(Hr::check_branch($user->branch_code) == 1)
                                    <span class="badge badge-pink">{!! Hr::branch($user->branch_code)->name !!}</span>
                                 @endif
                              @endif
                           </p>
                        </td>
                        <td>{!! $user->email !!}</td>
                        <td>
                           @if($user->last_login != "" && $user->last_login_ip != "")
                              <p>
                                 <b>Date :</b> {!! date("F jS, Y", strtotime($user->last_login)) !!}@ {!! date("h:i:sa", strtotime($user->last_login)) !!}<br>
                                 <b>IP :</b> {!! $user->last_login_ip !!}
                              </p>
                           @endif
                        </td>
                        <td>
                           @foreach(Wingu::user_roles($user->user_code) as $role)
                              <a href="#" class="badge badge-primary">{{ $role->name }}</a>
                           @endforeach
                        </td>
                        <td>
                           @if($user->status)
                              <span class="badge {!! $user->status_name !!}">{!! $user->status_name !!}</span>
                           @endif
                        </td>
                        <td>
                           <a href="{!! route('settings.users.edit',$user->user_code) !!}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
