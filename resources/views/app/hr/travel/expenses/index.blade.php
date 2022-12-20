@extends('layouts.app')
{{-- page header --}}
@section('title','Travel Expenses | Human Resource ')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         {{-- <a href="#" class="btn btn-white mr-1 active"><i class="fa fa-bars"></i></a>
         <a href="#" class="btn btn-white mr-1"><i class="fa fa-th"></i></a> --}}
         <a href="{!! route('hrm.travel.expenses.create') !!}" class="btn btn-pink"><i class="fal fa-plus-circle"></i> Add Expenses</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-usd-circle"></i> Travel Expenses </h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-responsive">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Title</th>
                     <th>Travel Date</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Approved By</th>
                     <th>Approved</th>
                     <th width="12%">Action</th>
                  </tr>
               </thead>
               <tbody>
                 @foreach($expenses as $count=>$expense)
                     <tr>
                        <td>{!! $count+1 !!}</td>
                        <td>{!! $expense->title !!}</td>
                        <td>{!! date('M jS, Y', strtotime($expense->date)) !!}</td>
                        <td>{!! $expense->currency !!} {!!  number_format($expense->amount) !!}</td>
                        <td><span class="badge {!! $expense->statusName !!}">{!! $expense->statusName !!}</td>
                        <td>
                           @if($expense->approved_by)
                              @if(Wingu::check_user($expense->approved_by))
                                 {!! Wingu::user($expense->approved_by)->name !!}
                              @endif
                           @endif
                        </td>
                        <td>
                           @if($expense->approval_date)
                              {!! date('M jS, Y', strtotime($expense->approval_date)) !!}
                           @endif
                        </td>
                        <td>
                           {{-- <a href="{!! route('hrm.travel.expenses.show',$expense->expenseCode) !!}" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a> --}}
                           <a href="{!! route('hrm.travel.expenses.edit',$expense->expenseCode) !!}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                           <a href="{!! route('hrm.travel.expenses.delete',$expense->expenseCode) !!}" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></a>
                        </td>
                     </tr>
                 @endforeach
               </tbody>
            </table>
         </div>
      </div>
      <!-- end panel -->
   </div>
@endsection
