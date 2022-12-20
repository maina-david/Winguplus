@extends('layouts.app')
{{-- page header --}}
@section('title','Customer Balances report')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">Finance</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.report') !!}">Report</a></li>
         <li class="breadcrumb-item active">Customer Balance</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Customer Balances</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="col-md-12 mb-3">
         <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
               <a href="{!! route('finance.report.receivables.balance.print',[$to,$from]) !!}" target="_blank" class="btn btn-pink pull-right"><i class="fas fa-file-pdf"></i> Export in pdf</a>
               <a href="{!! route('finance.report.receivables.balance.print',[$to,$from]) !!}" target="_blank" class="btn btn-pink pull-right mr-2"><i class="fas fa-print"></i> Print</a>
               <a href="#" data-toggle="modal" data-target="#filter" class="btn btn-pink pull-right mr-2"><i class="fas fa-calendar-day"></i> Filter</a>
            </div>
         </div>
      </div>
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <h3 class="text-center">Customer Balances</h3>
               <h5 class="text-center">From {!! date('F jS, Y', strtotime($from)) !!} To {!! date('F jS, Y', strtotime($to)) !!}</h5>
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th>Customer Name</th>
                        <th><center>Balance</center></th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($balances as $balance)
                        @if($balance->total > 0)
                           <tr>
                              <td><a href="#">{!! $balance->customerName !!}</a></td>
                              <td><center><i><b>{!! $balance->currency !!} {!! number_format($balance->total) !!} </b></i></center></td>
                           </tr>
                        @endif
                     @endforeach
                     <tr>
                        <td><b>Total</b></td>
                        <td><center><i><b>{!! Wingu::business()->currency !!}{!!  number_format($balances->sum('total')) !!}</b></i></center></td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal -->
   <form action="{!! route('finance.report.receivables.balance') !!}" method="GET" autocomplete="off">
      <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="filter" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Filter Date</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="form-group form-group-default">
                     <label for="">From</label>
                     {!! Form::date('from',null,['class'=>'form-control','placeholder' => 'choose date']) !!}
                  </div>
                  <div class="form-group form-group-default">
                     <label for="">To</label>
                     {!! Form::date('to',null,['class'=>'form-control','placeholder' => 'choose date']) !!}
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button class="btn btn-success" type="submit">Filter date</button>
               </div>
            </div>
         </div>
      </div>
   </form>
@endsection
