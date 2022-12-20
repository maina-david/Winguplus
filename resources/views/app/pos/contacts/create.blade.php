@extends('layouts.app')
{{-- page header --}}
@section('title','New Customer')
{{-- page styles --}}
@section('stylesheet')
<script type="text/javascript">
	.nav > li {
		position: relative;
		display: block;
		/* width: 100%; */
	}
</script>
@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.pos.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="javascript:;">Point Of Sale</a></li>
		<li class="breadcrumb-item"><a href="{!! route('pos.contact.index') !!}">Customer</a></li>
		<li class="breadcrumb-item active">Add</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fal fa-user-plus"></i> Add Customers </h1>
	@include('partials._messages')
	{!! Form::open(array('route' => 'pos.contact.store','enctype'=>'multipart/form-data','data-parsley-validate' => '', 'method'=>'post' )) !!}
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
							{{ Form::select('groups[]', $groups, null, ['class' => 'form-control multiselect','multiple' => 'multiple']) }}
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
				<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Create Contact</button>
				<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
			</div>
		</div>
	{!! Form::close() !!}
</div>
@endsection
{{-- page scripts --}}
@section('scripts')
<script type="text/javascript">
	CKEDITOR.replaceClass="ckeditor";
</script>
<script>
	$(document).ready(function() {
		$('#contact_type').on('change', function() {
			if (this.value == 'Individual') {
				$('#individual').show();
			} else {
				$('#individual').hide();
			}

			if (this.value == 'Organization') {
				$('#company').show();
			} else {
				$('#company').hide();
			}
		});
	});

	$(".delete_contact_persons").on('click', function() {
		$('.case:checkbox:checked').parents("tr").remove();
		$('.check_all').prop("checked", false);
		check();
	});

	var i = $('.contact_persons tr').length;
	var n = 1;
	$(".addmore_contact_persons").on('click', function() {
		count = $('.contact_persons tr').length;
		var data = "<tr><td><input type='checkbox' class='case'/></td><td><span id='snum" + i + "'>" + n++ + ".</span></td>";
		data +=
			"<td><select id='cn_salutation' class='form-control' name='cn_salutation[]'><option value='' selected='selected'>Choose Salutation</option><option value='Mr'>Mr</option><option value='Mrs'>Mrs</option><option value='Ms'>Ms</option><option value='Miss'>Miss</option><option value='Dr'>Dr</option></select></td><td><input class='form-control' type='text' id='cn_names" +
			i + "' name='cn_names[]'></td><td><input class='form-control' type='text' id='email_address_" + i + "' name='email_address[]'></td><td><input class='form-control' type='text' id='phone_number_" + i +
			"' name='phone_number[]'></td><td><input class='form-control' type='text' id='cn_desgination_" + i + "' name='cn_desgination[]'></td><tr>";
		$('.contact_persons').append(data);
	});

	$("#set-post-thumbnail").click(function() {
		$("input[id='thumbnail']").click();
	});

</script>
@endsection
