@extends('layouts.app')
{{-- page header --}}
@section('title','Product List')

{{-- dashboad menu --}}
@section('sidebar')
@include('app.ecommerce.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
			<a href="{!! route('ecommerce.products.create') !!}" class="btn btn-success"><i class="fas fa-plus"></i> Add New Products</a>
			{{-- <a href="{!! route('finance.products.import') !!}" class="btn btn-warning"><i class="fas fa-file-upload"></i> Import Items</a>
			<a href="{!! route('finance.products.export','csv') !!}" class="btn btn-pink"><i class="fas fa-file-download"></i> Export Items</a> --}}
		</div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-boxes"></i> All Products </h1>
      <!-- end page-header -->
		@include('partials._messages')
		{{-- <div class="row mb-3">
			<div class="col-md-3">
				<label for="">Search</label>
				<input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Enter Product name">
			</div>
			<div class="col-md-3">
				<label for="">Order By</label>
				<select wire:model="orderBy" class="form-control">
					<option value="proID">ID</option>
					<option value="product_name">Name</option>
					<option value="date">Date</option>
					<option value="price">Price</option>
					<option value="stock">Current Stock</option>
				</select>
			</div>
			<div class="col-md-3">
				<label for="">Order</label>
				<select wire:model="orderAsc" class="form-control">
					<option value="1">Ascending</option>
					<option value="0">Descending</option>
				</select>
			</div>
			<div class="col-md-3">
				<label for="">Items Per</label>
				<select wire:model="perPage" class="form-control">`
					<option value="10" selected>10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
			</div>
		</div> --}}
		<div class="panel panel-default">
			<div class="panel-body">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th width="1%">#</th>
							<th width="5%">Image</th>
							<th>Name</th>
							<th width="10%">Price</th>
							<th width="13%">Current Stock</th>
							<th width="15%">Created at</th>
							<th width="10%">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($products as $key => $product)
							@if($product->business_code == Auth::user()->business_code)
								<tr>
									<td>{!! $key + 1 !!}</td>
									<td>
										<center>
											@if(Finance::check_product_image($product->proID) == 1)
												<img src="{!! asset('businesses/'.Wingu::business()->business_code .'/finance/products/'.Finance::product_image($product->proID)->file_name) !!}" width="80px" height="60px">
											@else
												<img src="{!! asset('assets/img/product_placeholder.jpg') !!}" width="80px" height="60px">
											@endif
										</center>
									</td>
									<td>{!! $product->product_name !!}</td>
									<td>
										{!! $product->currency !!}{!! number_format($product->price) !!}
									</td>
									<td>
										@if($product->type != 'service')
											{!! $product->stock !!}
										@endif
									</td>
									<td>{!! date('F d, Y', strtotime($product->date)) !!}</td>
									<td>
										<a href="{{ route('ecommerce.products.edit', $product->proID) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
										<a href="{!! route('ecommerce.products.destroy', $product->proID) !!}" class="btn btn-danger delete btn-sm"><i class="fas fa-trash"></i></a>
									</td>
								</tr>
							@endif
						@endforeach
					</tbody>
				</table>
				{{-- {!! $products->links() !!} --}}
			</div>
		</div>
	</div>
@endsection
