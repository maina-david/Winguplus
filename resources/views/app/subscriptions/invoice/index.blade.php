@extends('layouts.app')
@section('title','Invoices')
@section('sidebar')
@include('app.subscriptions.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('subscriptions.dashboard') !!}">Subscriptions</a></li>
         <li class="breadcrumb-item"><a href="{!! route('subscription.invoice.index') !!}">Invoice</a></li>
         <li class="breadcrumb-item active">List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> Invoices</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Invoice List</h4>
            </div>
            <div class="panel-body">
               <table id="data-table-default" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th width="10%">Invoice #</th>
                        <th>Title </th>
                        <th width="21%">Customer</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th width="10%">Action</th>
                     </tr>
                  </thead>
                  <tfoot>
                     <tr>
                        <th width="1%">#</th>
                        <th width="8%">Invoice #</th>
                        <th>Title </th>
                        <th width="18%">Customer</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th width="10%">Issue Date</th>
                        <th width="10%">Due Date</th>
                        <th>Status</th>
                        <th width="10%">Action</th>
                     </tr>
                  </tfoot>
                  <tbody>
                     @foreach ($invoices as $crt => $v)
                        <tr role="row" class="odd">
                           <td>{{ $crt+1 }}</td>
                           <td>
                              <b>{{ $v->prefix }}{{ $v->invoice_number }}</b>
                           </td>
                           <td>{!! $v->invoice_title !!} </td>
                           <td>
                              {!! $v->customer_name !!}
                           </td>
                           <td><b class="text-info">{!! number_format((float)$v->paid) !!} {!! $v->symbol !!}</b></td>
                           <td class="v-align-middle">
                              <p>
                                 @if( $v->statusID == 1 )
                                    <span class="badge {!! $v->statusName !!}">{!! ucfirst($v->statusName) !!}</span>
                                 @else
                                    <b class="text-primary">{{ number_format(round($v->balance)) }} {!! $v->symbol !!}</b>
                                 @endif
                              </p>
                           </td>
                           <td><p>{!! date('M j, Y',strtotime($v->invoice_date)) !!}</p></td>
                           <td>
                              @if($v->invoice_due != "")
                                 <p>{!! date('M j, Y',strtotime($v->invoice_due)) !!}</p>
                              @endif
                           </td>
                           @if((int)$v->total - (int)$v->paid < 0)
                              <td><span class="badge {!! $v->statusName !!}">{!! ucfirst($v->statusName) !!}</span></td>
                           @else
                               <td>
                                   <span class="badge {!! Helper::seoUrl($v->statusName) !!}">{!! ucfirst($v->statusName) !!}</span>
                               </td>
                           @endif
                           <td>
                              <div class="btn-group">
                                 <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                                 <ul class="dropdown-menu">
                                    @permission('read-invoice')
                                       <li><a href="{{ route('subscription.invoice.show', $v->invoiceID) }}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                    @endpermission
                                    @permission('delete-invoice')
                                       <li><a href="{!! route('finance.invoice.delete', $v->invoiceID) !!}" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
                                    @endpermission
                                 </ul>
                              </div>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
@endsection