@extends('layouts.app')
{{-- page header --}}
@section('title','Add Units | Property Wingu')

@section('sidebar')
   @include('app.propertywingu.partials._menu')
@endsection
{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Details</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-building"></i> {!! $property->title !!} | Add Units </h1>
      <div class="row">
         @include('app.propertywingu.partials._property_menu')
         @include('partials._messages')
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading">
                  Add Unit
               </div>
               <div class="panel-body">
                  {!! Form::open(array('route' => 'propertywingu.property.units.store','enctype'=>'multipart/form-data','method'=>'post' )) !!}
                     {!! csrf_field() !!}
                     <input type="hidden" value="{!! $code !!}" name="parent_code"  required>
                     <div class="row">
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              {!! Form::label('Unit Type', 'Unit Type', array('class'=>'control-label')) !!}
                              {!! Form::select('property_type',['flat' => 'Flat/Apartment','commercial' => 'Commercial Properties', 'offices' => 'Offices'], null, array('class' => 'form-control select2', 'id' => 'unit_type', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required ">
                              {!! Form::label('Unit #', 'Unit #', array('class'=>'control-label')) !!}
                              {!! Form::text('serial', null, array('class' => 'form-control', 'placeholder' => 'Enter unit number', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              {!! Form::label('Landlord', 'Landlord', array('class'=>'control-label')) !!}
                              <select name="landlord" class="form-control select2">
                                 <option value="">Choose Landlord</option>
                                 @foreach ($landlords as $landlord)
                                    <option value="{!! $landlord->customer_code !!}">{!! $landlord->customer_name !!}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              {!! Form::label('Year built', 'Year built', array('class'=>'control-label')) !!}
                              <select name="year_built" class="form-control select2">
                                 <option value=""> Choose Year</option>
                                 @php
                                    for($i = date('Y'); $i >= date('Y') - 80; $i--){
                                       echo '<option value="'.$i.'">'.$i.'</option>';
                                    }
                                 @endphp
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              <label for="">Ownership Type</label>
                              {!! Form::select('ownwership_type', ['' => 'choose type','single' => 'Single Ownership','multi' => 'multi-ownership'],null,['class' => 'form-control select2'] ) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              {!! Form::label('Size, sq.ft', 'Size, sq.ft', array('class'=>'control-label')) !!}
                              {!! Form::number('size', null, array('class' => 'form-control', 'placeholder' => 'Enter size')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default required">
                              {!! Form::label('Market Price', 'Market Price', array('class'=>'control-label')) !!}
                              {!! Form::number('price', null, array('class' => 'form-control', 'placeholder' => 'Enter amount', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-4 remove-on-commercial">
                           <div class="form-group form-group-default required" id="single">
                              {!! Form::label('Bedrooms', 'Bedrooms', array('class'=>'control-label')) !!}
                              {!! Form::number('bedrooms', null, array('class' => 'form-control', 'placeholder' => 'Record bedrooms')) !!}
                           </div>
                        </div>
                        <div class="col-md-4 remove-on-commercial">
                           <div class="form-group form-group-default" id="single">
                              {!! Form::label('Bathrooms', 'Bathrooms', array('class'=>'control-label')) !!}
                              {!! Form::number('bathrooms', null, array('class' => 'form-control', 'placeholder' => 'Record bathrooms')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              {!! Form::label('Furnished', 'Furnished', array('class'=>'control-label')) !!}
                              {!! Form::select('funished', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control')) !!}
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group form-group-default">
                              {!! Form::label('Smoking', 'Smoking', array('class'=>'control-label')) !!}
                              {!! Form::select('smoking', ['' => 'Choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control')) !!}
                           </div>
                        </div>
                        <div class="col-md-4 remove-on-commercial">
                           <div class="form-group form-group-default">
                              {!! Form::label('Laundry', 'Laundry', array('class'=>'control-label')) !!}
                              {!! Form::select('laundry', ['' => 'Choose', 'None' => 'None', 'In unit' => 'In unit', 'Shared' => 'Shared'], null, array('class' => 'form-control')) !!}
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="row">
                        <div class="col-md-12">
                           <p class="font-weight-bold">Features</p>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckAir" value="Air conditioning">
                              <label class="custom-control-label" for="customCheckAir">Air conditioning</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckBalcony" value="Balcony, deck, patio">
                              <label class="custom-control-label" for="customCheckBalcony">Balcony, deck, patio</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCable" value="Cable ready">
                              <label class="custom-control-label" for="customCheckCable">Cable ready</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCarpet" value="Carpet">
                              <label class="custom-control-label" for="customCheckCarpet">Carpet</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCeiling" value="Ceiling">
                              <label class="custom-control-label" for="customCheckCeiling">Ceiling Fans</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckCentral" value="Central Heating">
                              <label class="custom-control-label" for="customCheckCentral">Central Heating</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckDishwasher" value="Dishwasher">
                              <label class="custom-control-label" for="customCheckDishwasher">Dishwasher</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckFenced" value="Fenced yard">
                              <label class="custom-control-label" for="customCheckFenced">Fenced yard</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckFireplace" value="Fireplace">
                              <label class="custom-control-label" for="customCheckFireplace">Fireplace</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckGarbage" value="Garbage Disposal">
                              <label class="custom-control-label" for="customCheckGarbage">Garbage Disposal</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckHardwood" value="Hardwood floors">
                              <label class="custom-control-label" for="customCheckHardwood">Hardwood floors</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckInternet" value="Internet">
                              <label class="custom-control-label" for="customCheckInternet">Internet</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckMicrowave" value="Microwave">
                              <label class="custom-control-label" for="customCheckMicrowave">Microwave</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckOven" value="Oven/range">
                              <label class="custom-control-label" for="customCheckOven">Oven/range</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckRefrigerator" value="Refrigerator">
                              <label class="custom-control-label" for="customCheckRefrigerator">Refrigerator</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStainless" value="Stainless Steel Appliance">
                              <label class="custom-control-label" for="customCheckStainless">Stainless Steel Appliance</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStorage" valu="Storage">
                              <label class="custom-control-label" for="customCheckStorage">Storage</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckStove" value="Stove">
                              <label class="custom-control-label" for="customCheckStove">Stove</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTelephone" value="Telephone">
                              <label class="custom-control-label" for="customCheckTelephone">Telephone</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTile" value="Tile">
                              <label class="custom-control-label" for="customCheckTile">Tile</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckTowels" value="Towels">
                              <label class="custom-control-label" for="customCheckTowels">Towels</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckVacuum" value="Vacuum Cleaner">
                              <label class="custom-control-label" for="customCheckVacuum">Vacuum Cleaner</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckclosets" value="Walk-in closets">
                              <label class="custom-control-label" for="customCheckclosets">Walk-in closets</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckDryer" value="Washer/Dryer">
                              <label class="custom-control-label" for="customCheckDryer">Washer/Dryer</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckWindow" value="Window Coverings">
                              <label class="custom-control-label" for="customCheckWindow">Window Coverings</label>
                           </div>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="customCheckYard" value="Yard">
                              <label class="custom-control-label" for="customCheckYard">Yard</label>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="col-md-12">
                        <div class="form-group">
                           {!! Form::label('Property Description', 'Property Description', array('class'=>'control-label')) !!}
                           {!! Form::textarea('description', null, array('class' => 'form-control tinymcy')) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Add Unit</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      $(document).ready(function() {
         $('#unit_type').on('change', function() {
            if (this.value == 'commercial' || this.value == 'offices') {
               $('.remove-on-commercial').hide();
            }else{
               $('.remove-on-commercial').show();
            }
         });
      });
   </script>
@endsection
