@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Customer | Sales Flow')
{{-- page styles --}}
@section('sidebar')
	@include('app.salesflow.partials._menu')
@endsection
{{-- content section --}}
@section('content')
   <div class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Sales Flow</a></li>
         <li class="breadcrumb-item"><a href="{!! route('salesflow.customer.index') !!}">Customer</a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user-plus"></i> Edit Customers </h1>
      @include('partials._messages')
      {!! Form::model($customer, ['route' => ['salesflow.customer.update',$customer->customer_code], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
         {!! csrf_field() !!}
         <div class="row">
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Details</h4>
                  </div>
                  <div class="panel-body">
                     <div class="form-group form-group-default required">
                        {!! Form::label('customer_name', 'Customer names', array('class'=>'control-label text-danger')) !!}
                        {!! Form::text('customer_name', null, array('class' => 'form-control', 'placeholder' => 'Enter customer name', 'required' => '')) !!}
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('department', 'VAT Number', array('class'=>'control-label')) !!}
                              {!! Form::text('vat_number', null, array('class' => 'form-control', 'placeholder' => 'Enter Number')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('delivery_time', 'Delivery time', array('class'=>'control-label')) !!}
                              {!! Form::time('delivery_time', null, array('class' => 'form-control')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('route', 'Route', array('class'=>'control-label')) !!}
                              {!! Form::select('route',[],null, array('class' => 'form-control select2')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('department', 'Zone', array('class'=>'control-label')) !!}
                              {!! Form::select('zone',[], null, array('class' => 'form-control select2')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('Region', 'Region', array('class'=>'control-label')) !!}
                              {!! Form::select('region',[], null, array('class' => 'form-control select2')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('Territory', 'Territory', array('class'=>'control-label')) !!}
                              {!! Form::select('territory',[],null, array('class' => 'form-control select2')) !!}
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group form-group-default">
                              {!! Form::label('country', 'Country', array('class'=>'control-label')) !!}
                              {{ Form::select('country', $country, null, ['class' => 'form-control select2']) }}
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group form-group-default">
                              {!! Form::label('location', 'Location', array('class'=>'control-label')) !!}
                              {!! Form::text('location', null, array('class' => 'form-control', 'placeholder' => 'Enter Location')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('latitude', 'Latitude', array('class'=>'control-label')) !!}
                              {!! Form::text('latitude', null, array('class' => 'form-control', 'placeholder' => 'Enter Latitude')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('longitude', 'Longitude', array('class'=>'control-label')) !!}
                              {!! Form::text('longitude', null, array('class' => 'form-control', 'placeholder' => 'Enter Longitude')) !!}
                           </div>
                        </div>
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
                        {!! Form::label('email', 'Primary email', array('class'=>'control-label')) !!}
                        {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Enter customer email')) !!}
                     </div>
                     <div class="form-group form-group-default ">
                        {!! Form::label('email_cc', 'Email CC', array('class'=>'control-label')) !!}
                        {!! Form::email('email_cc', null, array('class' => 'form-control', 'placeholder' => 'Email CC')) !!}
                     </div>
                     <div class="form-group form-group-default ">
                        {!! Form::label('website', 'Website', array('class'=>'control-label')) !!}
                        {!! Form::text('website', null, array('class' => 'form-control', 'placeholder' => 'Website')) !!}
                     </div>

                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
                              <label for="">
                                 Primary Phone Number
                                 <span class="pull-right" data-toggle="tooltip" data-placement="top" title="Make sure the number starts with the country code, this will be required if you want to send an sms to the contact">
                                    <i class="fas fa-info-circle"></i>
                                 </span>
                              </label>
                              {!! Form::number('primary_phone_number', null, array('class' => 'form-control','placeholder' => 'e.x 254 700 000 000')) !!}
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
                              <label for="">
                                 Other Phone Number
                                 <span class="pull-right" data-toggle="tooltip" data-placement="top" title="Make sure the number starts with the country code, this will be required if you want to send an sms to the contact">
                                    <i class="fas fa-info-circle"></i>
                                 </span>
                              </label>
                              {!! Form::number('other_phone_number', null, array('class' => 'form-control', 'placeholder' => 'e.x 254 700 000 000')) !!}
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group form-group-default">
                              <label>Customer Category</label>
                              {{ Form::select('category[]', [], null, ['class' => 'form-control select2','multiple' => 'multiple']) }}
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group form-group-default">
                              <label>Contact Logo or Image</label>
                           </div>
                           <a href="#" id="set-post-thumbnail">Click here to choose an image</a>
                           <input type="file" name="image" accept="image/*" id="thumbnail" class="file" style="display: none">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <ul class="nav nav-pills">
                  <li class="nav-items">
                     <a href="#contact-person" data-toggle="tab" class="nav-link  active show">
                        <span class="d-sm-none">Contact Persons</span>
                        <span class="d-sm-block d-none">Contact Persons</span>
                     </a>
                  </li>
                  <li class="nav-items">
                     <a href="#remarks" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Remarks</span>
                        <span class="d-sm-block d-none">Remarks</span>
                     </a>
                  </li>
               </ul>
               <div class="tab-content">
                  <div class="tab-pane active" id="contact-person">
                     <div class="row">
                        <div class="col-md-12">
                           <table class="table table-bordered">
										<tr>
											<th width="1%">#</th>
											<th>Names</th>
											<th>Email Address</th>
											<th>Phone number</th>
											<th>Designation</th>
											<th width="1%">Action</th>
										</tr>
										@foreach($persons as $count=>$cp)
											<tr>
												<td>{!! $count+1 !!}</td>
												<td>
													{!! $cp->salutation !!} {!! $cp->names !!}
												</td>
												<td>{!! $cp->contact_email !!}</td>
												<td>{!! $cp->phone_number !!}</td>
												<td>{!! $cp->designation !!}</td>
												<td>
													<a class="btn btn-danger delete" href="{{ route('finance.contactperson.delete',$cp->id) }}"><i class="fas fa-trash-alt"></i> Delete</a>
												</td>
											</tr>
										@endforeach
									</table>
									<br><br>
									<p><b>Add Contact person</b></p>
                           <table class="table table-bordered contact_persons">
                              <tr>
                                 <th><input class='check_all' type='checkbox' onclick="select_all()" /></th>
                                 <th>#</th>
                                 <th>Salutation</th>
                                 <th>Full Names</th>
                                 <th>Email Address</th>
                                 <th>Phone Number</th>
                                 <th>Designation</th>
                              </tr>
                           </table>
                           <button type="button" class='btn btn-danger delete_contact_persons'>- Delete</button>
                           <button type="button" class='btn btn-success addmore_contact_persons'>+ Add More</button>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="remarks">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              {!! Form::label('Remarks', 'Remarks', array('class'=>'control-label')) !!}
                              {!! Form::textarea('remarks',null,['class'=>'form-control tinymcy', 'size' =>'5x10', 'placeholder'=>'content']) !!}
                           </div>
                           <br>
                        </div>
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
