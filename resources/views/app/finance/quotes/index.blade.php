@extends('layouts.app')
{{-- page header --}}
@section('title','Quotes | Finance')

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('finance.quotes.create') !!}" class="btn btn-pink"><i class="fas fa-plus-circle"></i> New Quote</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-alt"></i> Quotes</h1>
      @include('partials._messages')
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Number</th>
                     <th>Title</th>
                     <th>Customer</th>
                     <th>Reference #</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Date</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($quotes as $crt => $v)
                     <tr role="row" class="odd">
                        <td>{{ $crt+1 }}</td>
                        <td>
                            <b>{!! $v->prefix !!}{!! $v->quote_number !!}</b>
                        </td>
                        <td>
                            {!! $v->subject !!}
                        </td>
                        <td>
                           {!! $v->customer_name !!}
                        </td>
                        <td class="text-uppercase font-weight-bold">
                           {!! $v->reff !!}
                        </td>
                        <td>
                           @if($v->total != "")
                              <b>{!! $v->currency !!}{!! number_format($v->total,2) !!}</b>
                           @endif
                        </td>
                        <td><span class="badge {!! $v->name !!}">{!! ucfirst($v->name) !!}</span></td>
                        <td>
                            {!! date('M j, Y',strtotime($v->quote_date)) !!}
                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                              <ul class="dropdown-menu">
                                 <li><a href="{{ route('finance.quotes.show', $v->quote_code ) }}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                 @if($v->status != 13)
                                 <li><a href="{!! route('finance.quotes.edit', $v->quote_code ) !!}"><i class="fas fa-edit"></i> Edit</a></li>
                                 @endif
                                 <li><a href="{!! route('finance.quotes.delete', $v->quote_code ) !!}" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
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
