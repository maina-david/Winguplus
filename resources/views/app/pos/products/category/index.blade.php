@extends('layouts.app')
{{-- page header --}}
@section('title','Product Category | Point Of Sale')
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
         <li class="breadcrumb-item"><a href="{!! route('pos.product.category') !!}">Product Category</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-sitemap"></i> All Categories</h1>
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
                              <th width="20%">Parent</th>
                              <th width="13%">Items</th>
                              <th class="text-center" width="18%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($category as $count=>$all)
                              <tr>
                                 <td>{!! $count+1 !!}</td>
                                 <td>{!! $all->name !!}</td>
                                 <td class="font-weight-bold">
												@if($all->parent != "")
													{!! Finance::product_category($all->parent)->name !!}
												@endif
                                 </td>
                                 <td>{!! Finance::products_by_category_count($all->category_code) !!}</td>
                                 <td>
                                    <a href="{{ route('pos.product.category.edit', $all->category_code) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                                    <a href="{!! route('pos.product.category.destroy', $all->category_code) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
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
                  <h4 class="panel-title">Add Category</h4>
               </div>
               <div class="panel-body">
                  <div class="panel-body">
                     {!! Form::open(array('route' => 'pos.product.category.store')) !!}
                        @csrf
                        <div class="form-group form-group-default required">
                           {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                           {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Category Name','required' => '')) !!}
                        </div>
                        <div class="form-group">
                           {!! Form::label('title', 'Parent Category', array('class'=>'control-label')) !!}
                           <select name="parent" class="form-control multiselect">
                              <option value="">Choose parent category</option>
                              @foreach($category as $cat)
                                 <option value="{!! $cat->category_code !!}">{!! $cat->name !!}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="form-group mt-4">
                           <center>
                              <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Category</button>
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
