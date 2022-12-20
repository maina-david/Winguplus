@extends('layouts.app')
{{-- page header --}}
@section('title','Edit | Customers')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.pos.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('pos.dashboard') !!}">Point Of Sale</a></li>
			<li class="breadcrumb-item"><a href="{!! route('pos.contact.index') !!}">Customers</a></li>
			<li class="breadcrumb-item"><a href="#">{!! $contact->customer_name !!}</a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user-plus"></i> Update Customers </h1>
      @include('partials._messages')
      {!! Form::model($contact, ['route' => ['pos.contact.update',$contact->customer_code], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
         {!! csrf_field() !!}
         <div class="row">
            <div class="col-md-6">
               <div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Details</h4>
						</div>
                  <div class="panel-body">
							<div class="form-group form-group-default required">
								{!! Form::label('customer_name', 'Customer Name', array('class'=>'control-label')) !!}
								{!! Form::text('customer_name', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter customer names', 'required' => '')) !!}
							</div>
							<div class="form-group form-group-default">
								<label>Customer Category</label>
								{{ Form::select('groups[]', $groups, null, ['class' => 'form-control multiple-select2','multiple' => 'multiple']) }}
							</div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Details</h4>
						</div>
                  <div class="panel-body">
                     <div class="form-group form-group-default">
                        {!! Form::label('email', 'Email', array('class'=>'control-label')) !!}
                        {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Contact email')) !!}
                     </div>
                     <div class="form-group form-group-default">
								<label for="">
									Phone Number
								</label>
								{!! Form::text('primary_phone_number', null, array('class' => 'form-control','placeholder' => 'e.x +254 700 000 000')) !!}
							</div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="panel-body">
					<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Contact</button>
					<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="20%">
            </div>
         </div>
      {!! Form::close() !!}
	</div>
@endsection
{{-- page scripts --}}
@section('scripts')
	<script>
		$(".multiple-select2").select2();
		$(".multiple-select2").select2().val({!! json_encode($connectedGroup) !!}).trigger('change');
	</script>
@endsection
