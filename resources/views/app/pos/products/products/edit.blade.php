@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Product | Point Of Sale')
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
      <li class="breadcrumb-item active">Edit</li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-shopping-basket"></i> Edit | {!! $product->product_name !!}</h1>
   <!-- end page-header -->
   @include('partials._messages')
   <div class="row">
      @include('app.pos.products.products._menu')
      <div class="col-md-9">
         {!! Form::model($product, ['route' => ['pos.products.update',$productCode], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
            {!! csrf_field() !!}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">{!! $product->product_name !!} - Information</h4>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
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
                           {!! Form::label('title', 'Name', array('class'=>'control-label text-danger')) !!}
                           {!! Form::text('product_name', null, array('class' => 'form-control', 'placeholder' => 'Enter Product Name','required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('title', 'SKU code', array('class'=>'control-label')) !!}
                           {!! Form::text('sku_code', null, array('class' => 'form-control', 'placeholder' => 'SKU code', 'required' => '')) !!}
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
                     <div class="form-group required form-group-default">
                        {!! Form::label('title', 'Product category', array('class'=>'control-label')) !!}
                        {{ Form::select('category[]',$categories,null,['class' => 'form-control multiple-select2','multiple' => 'multiple']) }}
                     </div>
                     <div class="form-group form-group-default">
                        {!! Form::label('title', 'Product Tags', array('class'=>'control-label')) !!}
                        {{ Form::select('tags[]',$tags,null,['class' => 'form-control multiple-tag', 'multiple' => 'multiple']) }}
                     </div>
                     <div class="form-group mt-3">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Product</button>
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
   <script type="text/javascript">
		$(".multiple-select2").select2().val({!! json_encode($jointCategories) !!}).trigger('change');
		$(".multiple-tag").select2();
		$(".multiple-tag").select2().val({!! json_encode($jointTags) !!}).trigger('change');
	</script>
@endsection
