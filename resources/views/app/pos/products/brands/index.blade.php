@extends('layouts.app')
{{-- page header --}}
@section('title','Product Brands | Point Of Sale')
{{-- page styles --}}

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
         <li class="breadcrumb-item"><a href="{!! route('pos.product.brand') !!}">Brands</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-certificate"></i> All Brands</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <table id="data-table-default" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th width="1%">#</th>
                              <th>Name</th>
                              {{-- <th>Products</th> --}}
                              <th width="20%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($brands as $count=>$all)
                              <tr>
                                 <td>{!! $count+1 !!}</td>
                                 <td>{!! $all->name !!}</td>
                                 {{-- <td>{!! Finance::products_by_brand_count($all->id) !!}</td> --}}
                                 <td>
                                    <a href="{{ route('pos.product.brand.edit', $all->brand_code) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                                    <a href="{!! route('pos.product.brand.destroy', $all->brand_code) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Add brand</h4>
               </div>
               <div class="panel-body">
                  <div class="panel-body">
                     {!! Form::open(array('route' => 'pos.product.brand.store')) !!}
                        @csrf
                        <div class="form-group form-group-default required">
                           {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                           {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Brand Name','required' => '')) !!}
                        </div>
                        <div class="form-group mt-4">
                           <center>
                              <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add brand</button>
                              <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
                           </center>
                        </div>
                     {!! Form::close() !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
