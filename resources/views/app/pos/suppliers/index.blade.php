@extends('layouts.app')
{{-- page header --}}
@section('title','Point of Sale | Supplier List')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.pos.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('pos.supplier.create') !!}" class="btn btn-pink"><i class="fas fa-user-plus"></i> Add A Supplier</a>
         {{-- <a href="{!! route('supplier.import.index') !!}" class="btn btn-pink"><i class="fal fa-file-upload"></i> Import Supplier</a>
         <a href="{!! route('supplier.export','csv') !!}" class="btn btn-pink"><i class="fas fa-file-download"></i> Export Supplier</a> --}}
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users-cog"></i> All Supplier</h1>
		@include('partials._messages')
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Supplier List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="5">Image</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th width="15%">Phone number</th>
                     <th width="15%">Date addded</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($suppliers as $count=>$supplier)
                     <tr {{-- class="success" --}}>
                        <td>{!! $count+1 !!}</td>
                        <td>
                           @if($supplier->image == "")
                              <img src="https://ui-avatars.com/api/?name={!! $supplier->supplier_name !!}&rounded=true&size=32"  class="img-circle"  alt="{!! $supplier->supplier_name !!}" width="40" height="40">
                           @else
                              <img width="40" height="40" alt="" class="img-circle" src="{!! asset('businesses/'.$supplier->business_code.'/suppliers/'.$supplier->supplier_code.'/images/'.$supplier->image) !!}">
                           @endif
                        </td>
                        <td>{!! $supplier->supplier_name !!}</td>
                        <td>{!! $supplier->supplier_email !!}</td>
                        <td>{!! $supplier->primary_phone_number !!}</td>
                        <td>{!! date('d F, Y', strtotime($supplier->date_added)) !!}</td>
                        <td>
                           <a href="{{ route('pos.supplier.edit', $supplier->supplier_code) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                           <a href="{!! route('pos.supplier.delete', $supplier->supplier_code) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
