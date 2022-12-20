@extends('layouts.app')
{{-- page header --}}
@section('title','Customer List | Customer Relationship Management')

{{-- dashboard menu --}}
@section('sidebar')
  @include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('crm.customers.create') !!}" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add a Customers</a>
         <a href="{!! route('finance.contact.import') !!}" target="_blank" class="btn btn-primary"><i class="fal fa-file-upload"></i> Import Customer</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> All Customers</h1>
		@include('partials._messages')
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Customer List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="5">Image</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phone Number</th>
                     <th>Category</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($customers as $count=>$contact)
                     <tr {{-- class="success" --}}>
                        <td>{!! $count+1 !!}</td>
                        <td>
                           @if($contact->image)
                              <img src="{!! asset('businesses/'.$contact->business_code.'/customer/'.$contact->customer_code.'/'.$contact->image) !!}" alt="" style="width:40px;height:40px" class="rounded-circle">
                           @else
                              <img src="https://ui-avatars.com/api/?name={!! $contact->customer_name !!}&rounded=true&size=40" alt="">
                           @endif
                        </td>
                        <td>
                           @if($contact->contact_type == 'Individual')
                              {!! $contact->salutation !!} {!! $contact->customer_name !!}
                           @else
                              {!! $contact->customer_name !!}
                           @endif
                        </td>
                        <td>{!! $contact->customer_email !!}</td>
                        <td>{!! $contact->primary_phone_number !!}</td>
                        <td>
                           @if($contact->group && $contact->group != 'null')
                              @php
                                 $groups = json_decode($contact->group,true);
                              @endphp
                              @foreach($groups as $group)
                              <span class="badge badge-primary">{!! $group !!}</span>
                              @endforeach
                           @endif
                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                              <ul class="dropdown-menu">
                                 <li><a href="{{ route('crm.customers.show',$contact->customer_code) }}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                 <li><a href="{{ route('crm.customers.edit', $contact->customer_code) }}"><i class="fas fa-edit"></i> Edit</a></li>
                                 <li><a href="{!! route('crm.customers.delete', $contact->customer_code) !!}" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
                              </ul>
                           </div>
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
