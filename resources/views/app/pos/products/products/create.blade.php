@extends('layouts.app')
{{-- page header --}}
@section('title','Add Product')
@section('stylesheet')
   <style>
      ul.product li {
         width: 100%;
      }
   </style>
   <link href="{!! asset('assets/plugins/jquery-tags-Input/src/jquery.tagsinput.css') !!}" rel="stylesheet" />
@endsection
{{-- dashboad menu --}}
@section('sidebar')
   @include('app.pos.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('pos.dashboard') !!}">P.O.S</a></li>
         <li class="breadcrumb-item"><a href="{!! route('pos.products') !!}">Products</a></li>
         <li class="breadcrumb-item active">Add</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shopping-basket"></i> New Product</h1>
      <!-- end page-header -->
      @include('partials._messages')
		<div class="row">
        	<!-- shop menu -->
			<div class="col-md-3" style="min-height: 300px;">
				<div class="panel panel-white">
               <div class="panel-body">
                  <ul class="nav nav-pills nav-stacked product">
                     <li class="active mb-2"><a href="#"> <i class="fa fa-info-circle" aria-hidden="true"></i> Information</a></li>
                     <li><a href="#"><i class="fal fa-usd-circle"></i> Price</a></li>
                     <li><a href="#"><i class="fal fa-inventory"></i> Inventory</a></li>
                     <li id="variants" style="display: none"><a href="#"><i class="fal fa-sitemap"></i> Variants</a></li>
                     <li><a href="#"><i class="fal fa-images"></i> Images</a></li>
                  </ul>
               </div>
			    </div>
         </div>
         <div class="col-md-9">
            <!-- end of shop menu -->
            {!! Form::open(array('route' => 'pos.products.store', 'enctype'=>'multipart/form-data','method' => 'post','autocomplete' => 'off')) !!}
            {!! csrf_field() !!}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Information</h4>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required ">
                           {!! Form::label('title', 'Item type', array('class'=>'control-label text-danger')) !!}
                           {{ Form::select('type',['product'=>'Standard Product'], null, ['class' => 'form-control select2', 'required' => '', 'id' => 'type']) }}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('title', 'Is Item Active', array('class'=>'control-label')) !!}
                           {{ Form::select('status',['Yes'=>'Yes','No'=>'No'], null, ['class' => 'form-control select2', 'required' => '']) }}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('title', 'Name', array('class'=>'control-label  text-danger')) !!}
                           {!! Form::text('product_name', null, array('class' => 'form-control', 'placeholder' => 'Enter Product Name','required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('title', 'SKU code', array('class'=>'control-label')) !!}
                           {{ Form::select('code_type',['Auto'=>'Automatically Generate a SKU','Custom'=>'Enter a custom SKU'], null, ['class' => 'form-control select2', 'required' => '', 'id' => 'sku']) }}
                        </div>
                     </div>
                     <div class="col-md-6" style="display:none;" id="custom-sku">
                        <div class="form-group form-group-default">
                           {!! Form::label('title', 'SKU code', array('class'=>'control-label')) !!}
                           {!! Form::text('sku_code', null, array('class' => 'form-control', 'placeholder' => 'SKU code')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('title', 'Brand', array('class'=>'control-label')) !!}
                           {{ Form::select('brand', $brands, null, ['class' => 'form-control select2']) }}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('title', 'Supplier', array('class'=>'control-label')) !!}
                           {!! Form::select('supplier',$suppliers,null,['class' => 'form-control select2']) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('title', 'Sell on eCommerce site', array('class'=>'control-label')) !!}
                           {{ Form::select('ecommerce_item',[''=>'Choose option','No'=>'No','Yes'=>'Yes'], null, ['class' => 'form-control select2']) }}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-body">
                  <div class="col-md-12">
                     <div class="form-group form-group-default">
                        {!! Form::label('title', 'Item category (You can choose multiple categories)', array('class'=>'control-label')) !!}
                        {{ Form::select('category[]',$categories,null,['class' => 'form-control select2', 'multiple' => 'multiple']) }}
                     </div>
                     <div class="form-group form-group-default">
                        {!! Form::label('title', 'Item Tags', array('class'=>'control-label')) !!}
                        {{ Form::select('tags[]',$tags,null,['class' => 'form-control select2', 'multiple' => 'multiple']) }}
                     </div>
                     <div class="form-group mt-3">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Product</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
                        </center>
                     </div>
                  </div>
               </div>
            </div>
            {!! Form::close() !!}
         </div>
      </div>
	</div>
@endsection
{{-- page scripts --}}
@section('scripts')
	<script>
      $(document).ready(function() {
         $('#sku').on('change', function() {
            if (this.value == 'Custom') {
               $('#custom-sku').show();
            }
            if (this.value == 'Auto') {
               $('#custom-sku').hide();
            }
         });
         $('#type').on('change', function(){
            if(this.value == 'variants'){
               $('#variants').show();
               $('#variants-entries').show();
            }else{
               $('#variants').hide();
               $('#variants-entries').hide();
            }
         });
         $('#size').tagsInput({
            'height':'auto',
            'width':'100%',
            'interactive':true,
            'defaultText':'add a size',
            'removeWithBackspace' : true,
            'placeholderColor' : '#666666'
         });
         $('#color').tagsInput({
            'height':'auto',
            'width':'100%',
            'interactive':true,
            'defaultText':'add a color',
            'removeWithBackspace' : true,
            'placeholderColor' : '#666666'
         });
      });
   </script>
   <script src="{!! asset('assets/plugins/jquery-tags-Input/src/jquery.tagsinput.js') !!}"></script>
@endsection
