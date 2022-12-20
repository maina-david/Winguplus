@extends('layouts.app')
@section('title','All | Subscriptions')
@section('stylesheet')@endsection
@section('sidebar')
@include('app.subscriptions.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Subscription</a></li>
         <li class="breadcrumb-item active">Add</li>
      </ol> 
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-sync-alt"></i> New Subscription</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      {{ Form::open(array('route' => 'subscriptions.store', 'role' => 'form', 'class' => 'solsoForm')) }}
         @csrf 
         <div class="panel">
            <div class="panel-body">                 
               <div class='row'>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default text-danger">
                        <label for="customer" class="text-danger">Choose Customer * <a href="" class="pull-right" data-toggle="modal" data-target="#addExpressCustomer">Add Customer</a></label>
                        <select name="customer" id="getCustomers" class="form-control select2" required></select>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group">
                        <label for="number">Subscription#</label>
                        <div class="input-group">
                           <span class="input-group-addon solso-pre">{{ Finance::subscription_settings()->prefix }}</span>
                           <input type="text" name="subscription_number" class="form-control required no-line" autocomplete="off" value="{{ Finance::subscription_settings()->number + 1 }}" readonly>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="number">Reference #</label>
                        <div class="input-group">
                           <input type="text" name="reference" class="form-control required" placeholder="Enter order number" autocomplete="off" >
                        </div>
                     </div>
                  </div>
               </div>
               <div class='row'>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="date" class="text-danger">Starts on *</label>
                        <input type="text" name="starts_on" class="form-control datepicker" autocomplete="off" value="@php echo date('Y-m-d') @endphp" required>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="customer">Sales Person</label>
                        <select name="sales_person" class="form-control multiselect">
                           <option value="" selected>Sales Person</option>
                           @foreach ($employees as $employee)
                              <option value="{{ $employee->id }}"> {!! $employee->names !!}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="end" class="text-danger">Expiration cycle</label>
                        <select name="expiration_cycle" id="expiration_cycle" class="multiselect">
                           <option value="never">Never</option>
                           <option value="Enter cycle">Enter cycle</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4" style="display: none" id="cycles">
                     <div class="form-group form-group-default">
                        <label for="date" class="text-danger">Cycle *</label>
                        <input type="number" name="cycles" class="form-control" autocomplete="off" placeholder="Enter cycle">
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="number" class="">Subscription title</label>
                        <div class="input-group">
                           <input type="text" name="invoice_title" class="form-control" placeholder="Enter title">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="end" class="text-danger">Income account * <a href="" class="pull-right" data-toggle="modal" data-target="#addExpressIncome">Add Income</a></label>
                        <select name="income_category" id="getIncomeCategory" class="form-control select2" required></select>
                     </div>
                  </div>
                  {{-- <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="end">Have you received payment for the first billing cycle?</label>
                        <select name="payment_status" id="payment_status" class="multiselect">
                           <option value="">Choose</option>
                           <option value="No">No</option>
                           <option value="Yes">Yes</option>
                        </select>
                     </div>
                  </div> --}}
                  {{-- <div class="col-md-4 col-lg-4" style="display: none" id="amount_paid">
                     <div class="form-group form-group-default">
                        <label for="date" class="text-danger">Amount paid</label>
                        <input type="number" name="amount_paid" class="form-control" autocomplete="off" placeholder="Enter amount">
                     </div>
                  </div> --}}
               </div>
            </div>
         </div>  
         <div class="panel panel-default mt-3">
            <div class="panel-body">
               <div class='row'>
                  <div class="col-md-4 mb-3">
                     <label for="">Products</label>
                     <select name="product" id="products" class="form-control multiselect" required>
                        <option value="">Choose products</option>
                        @foreach($products as $product)
                           <option value="{!! $product->id !!}">{!! $product->product_name !!}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-md-4 mb-3">
                     <label for="">Trial Days</label>
                     <input type="number" class="form-control" id="trial_days" name="trial_days">
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                     <table class="table table-bordered table-striped" id="table">
                        <thead>
                           <tr>
                              <th width="2%"><input id="check_all" class="formcontrol" type="checkbox"/></th>
                              <th width="30%">Plan Name <span class="text-danger pull-right">*</span></th>
                              <th width="13%">Quantity <span class="text-danger pull-right">*</span></th>
                              <th width="13%">Price <span class="text-danger pull-right">*</span></th>
                              {{-- <th width="13%">Discount()</th> --}}
                              <th width="13%">Tax</th>
                              <th width="25%">Total</th>
                           </tr>
                        </thead>
                        <?php
                           $count = 1;
                        ?>
                        <tbody>
                           <tr> 
                              <td><input class="case" type="checkbox"/></td>
                              <td>
                                 <select name="productID" class="form-control solsoCloneSelect2 multiselect" id="subscriptions" data-init-plugin='select2' required>
                                       
                                 </select> 
                              </td>
                              <td> 
                                 <input type="number" name="qty" id="quantity_1" class="form-control onchange quanyityChange quantity" required>
                              </td>
                              <td>
                                 <input type="number" name="price" id="price_1" class="form-control onchange subscription_price" autocomplete="off" step="0.01" required>
                              </td>
                              <td style="display: none">
                                 <input type="number" name="discount" id="discount_1" class="form-control discount changesNo" autocomplete="off" step="0.01" >
                              </td>
                              <td>
                                 <select name="tax" class="form-control changesNo onchange multiselect" id="tax_1" autocomplete="off">                                    
                                    <option value="0">Choose tax rate</option>
                                    @foreach ($taxs as $tx)
                                       <option value="{{ $tx->rate }}"> {{ $tx->name }}-{{ $tx->rate }}%</option>
                                    @endforeach
                                 </select>
                                 <input type="hidden" id="taxvalue_1" name="taxValue" class="form-control totalLineTax addNewRow" autocomplete="off" step="0.01" readonly>
                              </td>
                              <td>
                                 <input type="text" id="sum_1" class="form-control totalSum addNewRow" autocomplete="off" placeholder="Total Sum" step="0.01" readonly>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
         <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
            <div class='form-group text-center'>
               <center>
                  <button type="submit"class="btn btn-pink btn-lg"><i class="fas fa-save"></i> Add Subscription </button>
                  {{-- <img src="{!! url('/') !!}/public/backend/img/btn-loader.gif" class="submit-load none" alt="" width="15%"> --}}
               </center>
            </div>
         </div> 
      {{ Form::close() }}      
   </div>
@endsection
@include('app.finance.partials._invoice')
@include('app.finance.contacts.express')
@include('app.finance.income.express')
@section('tips')
<div class="theme-panel theme-panel-lg">
   <a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i class="fas fa-info-circle"></i></i></a>
   <div class="theme-panel-content">
      <h5 class="m-t-0">Tips</h5>
      <div class="row m-t-10">
         <div class="col-md-12">
            <p><i class="fad fa-lightbulb-on"></i> If the trial days field has a value, LimitlessERP will create a discounted invoice.</p>
            <p><i class="fad fa-lightbulb-on"></i> LimitlessERP will also create a discounted invoice if the trial field has a value and at the same time a payment was made, In this case the billing invoice will be dated after the trial end date.</p>
         </div>
      </div>
   </div>
</div>
@endsection
