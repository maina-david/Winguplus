@extends('layouts.app')
{{-- page header --}}
@section('title','Product Images | Sales Flow')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.salesflow.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="{!! route('salesflow.dashboard') !!}">Sales Flow</a></li>
         <li class="breadcrumb-item"><a href="{!! route('salesflow.product.index') !!}">Items</a></li>
         <li class="breadcrumb-item active">Product Images</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-images"></i> Product Images | {!! $product->product_name !!} </h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="row">
         @include('app.finance.partials._shop_menu')
         <div class="col-md-9">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">{!! $product->product_name !!} - Product Images</h4>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="col-sm-12">
                           <button class="btn btn-pink" data-toggle="modal" data-target="#custom-width-modal" style="float:right"><i class="fa fa-upload"></i> Upload Images</button>
                        </div>
                     </div>
                  </div>
					   <br>
                  <div class="col-md-12">
                     <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th style="width:2%">#</th>
                              <th>cover</th>
                              <th>File Size</th>
                              <th>File Mime</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($images as $count=>$image)
                              <tr>
                                 <td>{{ $count+1 }}</td>
                                 <td style="width:12%">
                                    <center><img src="{!! asset('businesses/'.Wingu::business()->business_code .'/finance/products/'. $image->file_name) !!}" width="80px" height="60px"></center>
                                 </td>
                                 <td>{!! $image->file_size/100000 !!} mb</td>
                                 <td>{!! $image->file_mime !!}</td>
                                 <td style="width:27%">
                                    @if($image->cover == 0)
                                       <center style="float:left;">
                                          {!! Form::model($image, ['route' => ['finance.product.images.update',$image->id], 'method'=>'post']) !!}
                                          {!! Form::hidden('product_code', $product->product_code) !!}
                                          {!! Form::Submit('Make Cover Image',['class'=>'btn btn-info']) !!}
                                          {!! Form::close() !!}
                                       </center>
                                    @else
                                       <a href="#" class="btn btn-success" style="width:134px;">is cover</a>
                                    @endif
                                    <center style="float:right;">
                                       {!! Form::open(['route' => ['finance.product.images.destroy', $image->id],'method'=>'post']) !!}
                                       {!! Form::hidden('product_image_id', $image->product_image_id) !!}
                                       {!! Form::Submit('Delete',['class'=>'btn btn-danger delete']) !!}
                                       {!! Form::close() !!}
                                    </center>
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
	            </div>
	         </div>
         </div>
      </div>
   </div>
   <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog" style="width:100%;">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" id="custom-width-modalLabel">Upload your images</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               {!! Form::open(array('route' => 'finance.product.images.store','class'=>'dropzone','id'=>'addimages','action' => 'post')) !!}
                  @csrf
                  {{ Form::hidden('product_code',$productCode) }}
               {!! Form::close() !!}
            </div>
            <div class="modal-footer">
               <a href="#" class="btn btn-pink" onClick="window.location.href=window.location.href">Save changes</a>
            </div>
         </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->
@endsection
