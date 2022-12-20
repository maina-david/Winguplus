@extends('layouts.app')
{{-- page header --}}
@section('title','Purchase Orders | Finance')

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
               <a href="{!! route('finance.lpo.create') !!}" class="btn btn-pink"><i class="fas fa-plus"></i> New Purchase Orders</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-contract"></i> Purchase Orders</h1>
		@include('partials._messages')
		<div class="panel panel-inverse">
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Title</th>
                     <th>Number</th>
                     <th>Supplier</th>
                     <th>Reference Number</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Date</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($lpos as $crt => $v)
                     <tr role="row" class="odd">
                        <td>{{ $crt+1 }}</td>
                        <td>
                           {!! $v->lpo_title !!}
                        </td>
                        <td>
                           <b>{!! $v->prefix !!}{!! $v->lpo_number !!}</b>
                        </td>
                        <td>
                           {!! $v->supplier_name !!}
                        </td>
                        <td class="text-uppercase font-weight-bold">
                           {!! $v->reference_number !!}
                        </td>
                        <td>{!! $v->currency !!}{!! number_format($v->total) !!}</td>
                        <td><span class="badge {!! $v->statusName !!}">{!! ucfirst($v->statusName) !!}</span></td>
                        <td>
                           {!! date('F j, Y',strtotime($v->lpo_date)) !!}
                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                              <ul class="dropdown-menu">
                                 <li><a href="{{ route('finance.lpo.show', $v->lpo_code) }}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                 <li><a href="{!! route('finance.lpo.edit', $v->lpo_code) !!}"><i class="fas fa-edit"></i> Edit</a></li>
                                 <li><a href="{!! route('finance.lpo.delete', $v->lpo_code) !!}" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
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
@endsection
