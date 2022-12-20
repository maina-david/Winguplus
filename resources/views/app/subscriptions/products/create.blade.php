@extends('layouts.app')
@section('title','Create Product | Subscriptions')
@section('stylesheet')
   <style>
      ul.product li {
         width: 100%;
      }
   </style>
@endsection
@section('sidebar')
@include('app.subscriptions.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('subscriptions.dashboard') !!}">Subscriptions</a></li>
         <li class="breadcrumb-item"><a href="{!! route('subscriptions.products.index') !!}">Products</a></li>
         <li class="breadcrumb-item active">Create</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shopping-basket"></i> Create Products</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">         
         <div class="col-md-9">
            <!-- end of shop menu -->
            {!! Form::open(array('route' => 'subscriptions.products.store', 'enctype'=>'multipart/form-data','method' => 'post','autocomplete' => 'off')) !!}
            {!! csrf_field() !!}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Information</h4>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('title', 'Product Name', array('class'=>'control-label')) !!}
                           {!! Form::text('product_name', null, array('class' => 'form-control', 'placeholder' => 'Enter Product Name','required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('title', 'SKU code', array('class'=>'control-label')) !!}
                           {{ Form::select('code_type',['Auto'=>'Automatically Generate a SKU','Custom'=>'Enter a custom SKU'], null, ['class' => 'form-control multiselect', 'required' => '', 'id' => 'sku']) }}
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
                           {!! Form::label('title', 'Notification Mail Address', array('class'=>'control-label')) !!}
                           {!! Form::email('notification_email', null, array('class' => 'form-control', 'placeholder' => 'Enter notification mail address')) !!}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-body">
                  <div class="col-md-12">
                     {{-- <div class="form-group">
                        {!! Form::label('title', 'Short Description (displayed on invoice)', array('class'=>'control-label')) !!}
                        {!! Form::textarea('short_description',null,['class'=>'form-control', 'rows' => 5, 'placeholder'=>'Short Description']) !!}
                     </div> --}}
                     <div class="form-group">
                        {!! Form::label('title', 'Description', array('class'=>'control-label')) !!}
                        {!! Form::textarea('description',null,['class'=>'ckeditor form-control','rows' => 5, 'placeholder'=>'content']) !!}
                     </div>
                     <div class="form-group mt-3">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Product</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                        </center>
                     </div>
                  </div>
               </div>
            </div>
            {!! Form::close() !!}
         </div>
         <div class="col-md-3"></div>
      </div>
   </div>
@endsection
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
      });
   </script>
   <script src="{!! asset('assets/plugins/ckeditor/4/basic/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection