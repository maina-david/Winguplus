@extends('layouts.app')
{{-- page header --}}
@section('title','Sales History | Pos')
{{-- page styles --}}
@section('stylesheet')

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
			<li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">POS</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.product.index') !!}">Sales History</a></li>
         <li class="breadcrumb-item active">List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-history"></i> Sales History</h1>
		@include('partials._messages')
		<div class="panel panel-default">
			<div class="panel-heading">

				<h4 class="panel-title">Sales History</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
							<th width="1%">#</th>
                     <th>Date</th>
							<th>Sale#</th>
                     <th>Customer</th>
                     <th>Status</th>
                     <th>Amount</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
						@foreach($sales as $count=>$sale)
							<tr>
								<td>{!! $count+1 !!}</td>
								<td>{!! date('F jS, Y', strtotime($sale->invoice_date)) !!}</td>
								<td>{!! $sale->invoice_prefix!!}{!! $sale->invoice_number!!}</td>
								<td>{!! $sale->customer_name !!}</td>
								<td>
									<span class="badge {!! $sale->statusName !!}">{!! ucfirst($sale->statusName) !!}</span>
								</td>
								<td>{!! $sale->currency !!}{!! number_format((int)$sale->main_amount,2) !!}</td>
								<td><a href="{!! route('pos.sale.details',$sale->invoice_code) !!}" class="btn btn-sm btn-pink"><i class="fas fa-eye"></i> view</a></td>
							</tr>
						@endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
