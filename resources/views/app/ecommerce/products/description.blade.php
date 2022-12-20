@extends('layouts.app')
{{-- page header --}}
@section('title','Product Description')

{{-- dashboad menu --}}
@section('sidebar')
@include('app.ecommerce.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('ecommerce.dashboard') !!}">Finance</a></li>
         <li class="breadcrumb-item"><a href="{!! route('ecommerce.product.index') !!}">Products</a></li>
         <li class="breadcrumb-item active">Description</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-file-alt"></i> Product Description | {!! $product->product_name !!} </h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="row">
         @include('app.ecommerce.products._product_menu')
         <div class="col-md-9">
            {!! Form::model($product, ['route' => ['ecommerce.products.description.update',$productCode], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']) !!}
               {!! csrf_field() !!}
               <div class="panel panel-default">
                  <div class="panel-heading">
                     {!! $product->product_name !!} - Description
                  </div>
                  <div class="panel-body">
                     <div class="col-md-12">
                        <div class="form-group">
                           {!! Form::label('title', 'Short Description', array('class'=>'control-label')) !!}
                           {!! Form::textarea('short_description',null,['class'=>'form-control', 'rows' => 5, 'placeholder'=>'Short Description']) !!}
                        </div>
                        <div class="form-group">
                           {!! Form::label('title', 'Description', array('class'=>'control-label')) !!}
                           {!! Form::textarea('description',null,['class'=>'tinymcy form-control','rows' => 5, 'placeholder'=>'content']) !!}
                        </div>
                        <div class="form-group mt-3">
                           <center>
                              <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Items</button>
                              <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
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
   <script src="{!! asset('assets/plugins/ckeditor/4/basic/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
