@extends('layouts.app')
{{-- page header --}}
@section('title',' Payrolls | Human Resource Management')
{{-- page styles --}}

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('hrm.dashboard') !!}">Human resource</a></li>
         <li class="breadcrumb-item active">Payrolls</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-history"></i> All Payrolls</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <th width="1%">#</th>
                        <th>Payroll duration</th>
                        <th>Branch</th>
                        <th>Net Pay</th>
                        <th>Gross pay</th>
                        {{-- <th>Additions</th> --}}
                        <th>Deductions</th>
                        <th width="14%">Action</th>
                     </thead>
                     <tbody>
                        @foreach($payrolls as $payroll)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td>{!! date('F jS Y', strtotime($payroll->payroll_date)) !!}</td>
                              <td>
                                 @if($payroll->branch_code == 'All')
                                    All
                                 @else
                                    @if(Hr::check_department($payroll->branch_code)==1)
                                       {!! Hr::department($payroll->branch_code)->title !!}
                                    @endif
                                 @endif
                              </td>
                              <td>{!! $payroll->currency !!}{!! number_format($payroll->total_net_pay,2) !!} </td>
                              <td>{!! $payroll->currency !!}{!! number_format($payroll->total_gross_pay,2) !!} </td>
                              {{-- <td>{!! number_format($payroll->total_additions) !!} {!! $payroll->currency !!}</td> --}}
                              <td>{!! $payroll->currency !!}{!! number_format($payroll->total_deductions,2) !!}</td>
                              <td>
                                 <a href="{!! route('hrm.payroll.details',$payroll->payroll_code) !!}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>
                                 <a href="{!! route('hrm.payroll.delete',$payroll->payroll_code) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
