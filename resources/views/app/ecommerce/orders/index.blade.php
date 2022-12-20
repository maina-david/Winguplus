@extends('layouts.app')
{{-- page header --}}
@section('title','All Orders | eCommerce')

{{-- dashboard menu --}}
@section('sidebar')
   @include('app.ecommerce.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('ecommerce.dashboard') !!}">E-commerce</a></li>
         <li class="breadcrumb-item"><a href="{!! route('ecommerce.orders.index') !!}">Orders</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> All Orders</h1>
      @include('partials._messages')
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="10%">Order #</th>
                     <th>Title </th>
                     <th>Customer</th>
                     <th>Balance</th>
                     <th>Order Date</th>
                     <th>Status</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
						@foreach ($invoices as $crt => $v)
                     <tr role="row" class="odd">
                        <td>{{ $crt+1 }}</td>
                        <td>
                           @if($v->invoice_prefix == ""){{ $v->prefix }}@else{{ $v->invoice_prefix }}@endif{{ $v->invoice_number }}
                        </td>
                        <td>{!! $v->invoice_title !!} </td>
                        <td>
							      {!! $v->customer_name !!}
                        </td>
                        <td>
                           <b class="text-primary">{!! $v->currency !!}{{ number_format(round($v->total)) }}</b>
                        </td>
                        <td>@if($v->invoice_date != ""){!! date('M j, Y',strtotime($v->invoice_date)) !!}@endif</td>
                        @if((int)$v->total - (int)$v->paid < 0)
                           <td><span class="badge {!! $v->statusName !!}">{!! ucfirst($v->statusName) !!}</span></td>
                        @else
                           <td>
                              <span class="badge {!! Helper::seoUrl($v->statusName) !!}">{!! ucfirst($v->statusName) !!}</span>
                           </td>
                        @endif
                        <td>
                           <a href="{{ route('ecommerce.orders.show', $v->invoice_code) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                           <a href="{!! route('ecommerce.orders.delete', $v->invoice_code) !!}" class="delete btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
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
@section('scripts')

@endsection
