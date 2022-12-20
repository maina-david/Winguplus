@extends('layouts.backend')
{{-- page header --}}
@section('title','Sales History')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('backend.pos.partials._menu')
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
      <h1 class="page-header">Sales History</h1>
		@include('backend.partials._messages')
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-heading-btn">
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
				</div>
				<h4 class="panel-title">Invoice List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
							<th width="1%">#</th>
                     <th>Date</th>
							<th>TransactionID</th>
                     <th>Sold by</th>
                     <th>Customer</th>
                     <th>Note</th>
                     <th>Sale Total</th>
							<th>Payment Method</th>
                     <th>Status</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
							<th width="1%">#</th>
                     <th>Date</th>
							<th>TransactionID</th>
                     <th>Sold by</th>
                     <th>Customer</th>
                     <th>Note</th>
                     <th>Sale Total</th>
							<th>Payment Method</th>
                     <th>Status</th>
                     <th width="7%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
						@foreach ($sales as $sale)
							<tr>
								<td>{!! $count++ !!}</td>
								<td>{!! date("F j, Y, g:i a", strtotime($sale->created_at)) !!}</td>
								<td class="text-uppercase font-weight-bold">{!! $sale->transactionID !!}</td>
								<td>
									{!! Limitless::user($sale->userID)->name !!}
								</td>
								<td>
									@if($sale->client_id != "")
										@if(Finance::check_client($sale->client_id) == 1)
											@if(Finance::client($sale->client_id)->company_name != "" )
	                                 {!! Finance::client($sale->client_id)->company_name !!}
	                              @else
	                                 {!! Finance::client($sale->client_id)->client_name !!}
	                              @endif
										@else
											<i>Unknown Client</i>
										@endif
									@else
										<i>Unknown Client</i>
									@endif
								</td>
								<td>{!! $sale->note !!}</td>
								<td>
									@if(Limitless::business(Auth::user()->businessID)->base_currency != "")
										{!! Finance::currency(Limitless::business(Auth::user()->businessID)->base_currency)->code !!}
									@endif
									{!! number_format($sale->total) !!}
								</td>
								<td>
									@if(Finance::check_payment($sale->id) > 0)
										@if(Finance::check_payment_method(Finance::invoice_payment($sale->id)->payment_method) == 1)
											{!! Finance::payment_method(Finance::invoice_payment($sale->id)->payment_method)->name !!}
										@else
											<i>Unknown method</i>
										@endif
									@else
										<i>Unknown method</i>
									@endif
								</td>
								<td>
									<span class="badge {!! Limitless::status($sale->statusID)->name !!}">{!! ucfirst(Limitless::status($sale->statusID)->name) !!}</span>
								</td>
								<td><a href="{!! route('history.details',$sale->id) !!}" class="btn btn-pink btn-sm"><i class="fas fa-eye"></i> view</a></td>
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
