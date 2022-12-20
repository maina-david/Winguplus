@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Licenses | Asset Management')
{{-- page styles --}}
@section('stylesheet')
@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.assets.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="{!! route('assets.dashboard') !!}">Assets</a></li>
      <li class="breadcrumb-item"><a href="{!! route('assets.index') !!}">Assets</a></li>
      <li class="breadcrumb-item"><a href="{!! route('assets.index') !!}">License</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fal fa-laptop-code"></i> Edit License </h1>
	@include('partials._messages')
	{!! Form::model($edit, ['route' => ['licenses.assets.update',$edit->asset_code], 'method'=>'post','enctype' => 'multipart/form-data', 'autocomplete' => 'off']) !!}
		@csrf
      <ul class="nav nav-tabs" id="myTab" role="tablist">
         <li class="nav-item">
           <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="fal fa-info-circle"></i> Details</a>
         </li>
         <li class="nav-item">
           <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="fal fa-question-circle"></i> Additional Information </a>
         </li>
         <li class="nav-item">
           <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"><i class="fal fa-file-invoice-dollar"></i>  Finance Information</a>
         </li>
      </ul>
      <div class="tab-content" id="myTabContent">
         <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row">
               <div class="col-md-8">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('title', 'Software Name', array('class'=>'control-label')) !!}
                           {!! Form::text('asset_name', null, array('class' => 'form-control', 'placeholder' => 'Enter name','required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Status', 'Status', array('class'=>'control-label')) !!}
                           {!! Form::select('status', ['' => 'choose status', '37' => 'Allocated', '29' => 'Ready to deploy', '30' => 'Archived'], null, array('class' => 'form-control select2')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Asset Image', 'Asset Image', array('class'=>'control-label')) !!}
                           <input type="file" name="asset_image" id="assetImage"><br>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Product Key', 'Product Key', array('class'=>'control-label')) !!}
                           {!! Form::text('product_key', null, array('class' => 'form-control', 'placeholder' => 'Enter key')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Seats', 'Seats', array('class'=>'control-label')) !!}
                           {!! Form::number('seats', null, array('class' => 'form-control', 'placeholder' => 'Enter Seats')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Manufacture', 'Manufacture', array('class'=>'control-label')) !!}
                           {!! Form::text('manufacture', null, array('class' => 'form-control')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Assigned to', 'Assigned to', array('class'=>'control-label')) !!}
                           {!! Form::select('assigned_to', ['' => 'Choose','Employee' => 'Employee','Customer' => 'Customer'], null, array('class' => 'form-control select2', 'id'=>'assignedTo')) !!}
                        </div>
                     </div>
                     @if($edit->assigned_to == 'Employee')
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('Employees', 'Employees', array('class'=>'control-label')) !!}
                              {!! Form::select('employee', $employees, null, array('class' => 'form-control select2')) !!}
                           </div>
                        </div>
                     @else
                        <div class="col-md-6" style="display: none" id="employee">
                           <div class="form-group form-group-default">
                              {!! Form::label('Employees', 'Employees', array('class'=>'control-label')) !!}
                              {!! Form::select('employee', $employees, null, array('class' => 'form-control select2')) !!}
                           </div>
                        </div>
                     @endif
                     @if($edit->assigned_to == 'Customer')
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('Customers', 'Customers', array('class'=>'control-label')) !!}
                              {!! Form::select('customer', $customers, null, array('class' => 'form-control select2')) !!}
                           </div>
                        </div>
                     @else
                        <div class="col-md-6" style="display: none" id="customer">
                           <div class="form-group form-group-default">
                              {!! Form::label('Customers', 'Customers', array('class'=>'control-label')) !!}
                              {!! Form::select('customer', $customers, null, array('class' => 'form-control select2')) !!}
                           </div>
                        </div>
                     @endif
                     <div class="col-md-12">
                        <div class="form-group">
                           {!! Form::label('Note', 'Note', array('class'=>'control-label')) !!}
                           {!! Form::textarea('note', null, array('class' => 'form-control tinymcy')) !!}
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  @if($edit->asset_image)
                     <img src="{!! asset('businesses/'.Wingu::business()->business_code.'/assets/'.$edit->asset_image) !!}" alt="" class="img-responsive">
                  @else
                     <img src="{!! asset('assets/img/image_placeholder.png') !!}" alt="" class="img-responsive" id="placeholderImage">
                  @endif
                  <div id="previewImage"></div>
               </div>
            </div>
         </div>
         <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row">
               <div class="col-md-8">
                  <div class="row">

                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Licensed to Name', 'Licensed to Name', array('class'=>'control-label')) !!}
                           {!! Form::text('licensed_to_name', null, array('class' => 'form-control', 'placeholder' => 'Enter name')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Licensed to Email', 'Licensed to Email', array('class'=>'control-label')) !!}
                           {!! Form::email('licensed_to_email', null, array('class' => 'form-control', 'placeholder' => 'Enter model')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Reassignable', 'Reassignable', array('class'=>'control-label')) !!}
                           {!! Form::select('reassignable', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control select2')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Termination Date', 'Termination Date', array('class'=>'control-label')) !!}
                           {!! Form::date('end_of_life', null, array('class' => 'form-control', 'placeholder' => 'Chooose date')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Maintained', 'Maintained', array('class'=>'control-label')) !!}
                           {!! Form::select('maintained', ['' => 'Choose','Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control select2')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Next maintenance', 'Next maintenance', array('class'=>'control-label')) !!}
                           {!! Form::date('next_maintenance', null, array('class' => 'form-control', 'placeholder' => 'Chooose date')) !!}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="row">
               <div class="col-md-8">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Supplier', 'supplier', array('class'=>'control-label')) !!}
                           {!! Form::select('supplier', $suppliers, null, array('class' => 'form-control select2')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Order Number', 'Order Number', array('class'=>'control-label')) !!}
                           {!! Form::text('order_number', null, array('class' => 'form-control', 'placeholder' => 'Enter number')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Purchase Cost', 'Purchase Cost', array('class'=>'control-label')) !!}
                           {!! Form::text('purches_cost', null, array('class' => 'form-control', 'placeholder' => 'Enter Cost')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('Purchase date', 'Purchase date', array('class'=>'control-label')) !!}
                           {!! Form::date('purchase_date', null, array('class' => 'form-control', 'placeholder' => 'Chooose date')) !!}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
		<div class="row">
			<div class="col-md-12">
				<center>
					<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Asset</button>
					<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
				</center>
			</div>
		</div>
	{!! Form::close() !!}
</div>
@endsection
{{-- page scripts --}}
@section('scripts')
   <script type="text/javascript">
      $(document).ready(function() {
         if(window.File && window.FileList && window.FileReader) {
            $("#assetImage").on("change",function(e) {
            var files = e.target.files ,
            filesLength = files.length ;
            for (var i = 0; i < filesLength ; i++) {
               var f = files[i]
               var fileReader = new FileReader();
               fileReader.onload = (function(e) {
                  var file = e.target;
                  $("<img></img>",{
                  class : "img-responsive",
                  src : e.target.result,
                  title : file.name
                  }).insertAfter("#previewImage");
               });
               $('#placeholderImage').hide();
               fileReader.readAsDataURL(f);
            }
         });
         } else { alert("Your browser doesn't support to File API") }
      });
   </script>
   <script>
      $(document).ready(function() {
         $('#assignedTo').on('change', function() {
            if (this.value == 'Employee') {
               $('#employee').show();
            } else {
               $('#employee').hide();
            }

            if(this.value == 'Customer') {
               $('#customer').show();
            } else {
               $('#customer').hide();
            }
         });
      });
   </script>
@endsection
