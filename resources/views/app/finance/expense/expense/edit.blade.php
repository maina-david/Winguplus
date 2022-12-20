@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Expense | Finance')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection
{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
			<li class="breadcrumb-item"><a href="{!! route('finance.expense.index') !!}">Expenses</a></li>
			<li class="breadcrumb-item active">Edit</li>
		</ol>
      <h1 class="page-header"><i class="fal fa-money-check-alt"></i> Update Expenses </h1>
      @include('partials._messages')
      {!! Form::model($expense, ['route' => ['finance.expense.update',$expense->expense_code], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
         <div class="row">
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Expense Details</h4>
                  </div>
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group form-group-default">
                              {!! Form::label('Account', 'Account', array('class'=>'control-label')) !!}
                              {{ Form::select('account', $bankAccounts, null, ['class' => 'form-control select2', 'autocomplete' => 'off']) }}
                           </div>
                        </div>
                     </div>
                     <div class="form-group form-group-default required">
                        {!! Form::label('Date', 'Date', array('class'=>'control-label text-danger')) !!}
                        {!! Form::date('expense_date', null, array('class' => 'form-control','required' =>'', 'autocomplete' => 'off' )) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        {!! Form::label('Expense Title', 'Expense Title', array('class'=>'control-label text-danger')) !!}
                        {!! Form::text('expense_name', null, array('class' => 'form-control', 'placeholder' => 'Expense Title', 'required' =>'', 'autocomplete' => 'off' )) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        {!! Form::label('Expense Category', 'Expense Category', array('class'=>'control-label text-danger')) !!}
                        {{ Form::select('category', $category, null, ['class' => 'form-control select2','placeholder' => 'Expense Category','required' =>'']) }}
                     </div>
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group form-group-default required" aria-required="true">
                              {!! Form::label('Amount', 'Amount', array('class'=>'control-label text-danger')) !!}
                              {!! Form::text('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount','step'=>'0.01','required' =>'' )) !!}
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('Choose Tax Rate', 'Chosse Tax Rate', array('class'=>'control-label')) !!}
                              {{ Form::select('tax_rate',$tax, null, ['class' => 'form-control select2']) }}
                           </div>
                        </div>
                     </div>
                     <div class="form-group form-group-default">
                        {!! Form::label('Supplier', 'Supplier', array('class'=>'control-label')) !!}
                        {!! Form::select('supplier',$suppliers,null,['class' => 'form-control select2']) !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Expense Details</h4>
                  </div>
                  <div class="panel-body">
                        <div class="form-group form-group-default">
                        {!! Form::label('Reference', 'Reference (i.e Payment Code)', array('class'=>'control-label')) !!}
                        {!! Form::text('reference_number', null, array('class' => 'form-control', 'placeholder' => 'Reference')) !!}
                     </div>
                     <div class="form-group form-group-default required">
                        {!! Form::label('Choose expense status', 'Choose expense status', array('class'=>'control-label')) !!}
                        {{ Form::select('status', [''=>'Choose expense status','1'=>'Paid','2'=>'Unpaid','18'=>'Dept'], null, ['class' => 'form-control select2','required' =>'', 'autocomplete' => 'off'  ]) }}
                     </div>
                     <div class="form-group form-group-default">
                        <label for="">Method Of Payment <a href="" class="pull-right" data-toggle="modal" data-target="#addpayment">Add Payment Method</a></label>
                        <select name="payment_method" class="form-control select2">
                           @if($expense->payment_method != "")
                              <option value="{!! $expense->payment_method !!}">
                                 @if(Finance::check_default_payment_method($expense->payment_method) == 1)
                                    {!! Finance::default_payment_method($expense->payment_method)->name !!}
                                 @else
                                    @if(Finance::check_payment_method($expense->payment_method) == 1)
                                       {!! Finance::payment_method($expense->payment_method)->name !!}
                                    @endif
                                 @endif
                              </option>
                           @else
                              <option value="">Choose payment method</option>
                           @endif
									@foreach($accountPayment as $accayment)
										<option value="{!! $accayment->method_code !!}">{!! $accayment->name !!}</option>
									@endforeach
                        </select>
                     </div>
                     <h4 class="mt-4">Files</h4>
                     <div class="form-group form-group-default">
                        {!! Form::label('Expense Files', 'Expense Files', array('class'=>'control-label')) !!}
                        <input type="file" name="files[]"  id="files" multiple>
                     </div>
                     <div class="row mt-4">
                        @foreach ($files as $file)
                           <div class="col-md-2">
                              @if(stripos($file->file_mime, 'image') !== FALSE)
                              <img src="{!! asset('businesses/'.Wingu::business()->business_code.'/finance/expense/'.$file->file_name) !!}" alt="" style="width:100%;height:80px">
                              @elseif(stripos($file->file_mime, 'pdf') !== FALSE)
                                 <center><i class="fas fa-file-pdf fa-4x" style="width:100%;height:80px"></i></center>
                              @elseif(stripos($file->file_mime, 'octet-stream') !== FALSE)
                                 <center><i class="fas fa-file-alt fa-4x" style="width:100%;height:80px"></i></center>
                              @elseif(stripos($file->file_mime, 'officedocument') !== FALSE)
                                 <center><i class="fas fa-file-word fa-4x" style="width:100%;height:80px"></i></center>
                              @else
                                 <center><i class="fas fa-file fa-4x" style="width:100%;height:80px"></i></center>
                              @endif
                              <center>
                                 <a href="{!! route('finance.expense.file.delete', $file->id) !!}" title="delete" class="label label-danger delete"><i class="fas fa-trash"></i></a>
                                 <a href="{!! route('finance.expense.file.download', $file->id) !!}" title="download" class="label label-primary mt-1"><i class="fas fa-download"></i></a>
                                 <a href="{!! asset('businesses/'.Wingu::business()->business_code.'/finance/expense/'.$file->file_name) !!}" title="view" class="label label-warning mt-1" target="_blank"><i class="fas fa-eye"></i></a>
                              </center>
                           </div>
                        @endforeach
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Description</h4>
                  </div>
                  <div class="panel-body">
                     <div class="form-group">
                        {!! Form::textarea('description',null,['class'=>'form-control tinymcy', 'rows' => 9, 'placeholder'=>'content']) !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <center>
                  <button class="btn btn-pink submit" type="submit"><i class="fas fa-save"></i> Update Expense</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
               </center>
            </div>
         </div>
      {{ Form::close() }}
   </div>
   @include('app.finance.payments.express')
@endsection
{{-- page scripts --}}
@section('scripts')
@include('app.partials._express_scripts')
@endsection
