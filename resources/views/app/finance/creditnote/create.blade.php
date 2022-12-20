@extends('layouts.app')
{{-- page header --}}
@section('title','Add New Credit note')
{{-- page styles --}}
@section('stylesheet')

@endsection

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
         <li class="breadcrumb-item"><a href="{!! route('finance.creditnote.index') !!}">Credit note</a></li>
         <li class="breadcrumb-item active">Create</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-credit-card"></i> Create Credit note</h1>
      @include('partials._messages')
      {{ Form::open(array('route' => 'finance.creditnote.store','enctype'=>'multipart/form-data')) }}
         @csrf
         <div class='row'>
            <div class="col-md-6 col-lg-6">
               <div class="form-group form-group-default">
                  <label for="Customer" class="text-danger">Customer *</label>
                  {!! Form::select('customer',$customers,null,['class'=>'form-control select2','required'=>'']) !!}
               </div>
            </div>
            <div class="col-md-6 col-lg-6">
               <div class="form-group">
                  <label for="number">Credit Note Number</label>
                  <div class="input-group">
                     <span class="input-group-addon solso-pre">{{ Finance::creditnote()->prefix }}</span>
                     <input type="text" name="number" class="form-control required no-line" autocomplete="off" value="{{ Finance::creditnote()->number + 1 }}" readonly>
                  </div>
                  <?php echo $errors->first('number', '<p class="error">:messages</p>');?>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="number" class="">Title</label>
                  {!! Form::text('title', null ,['class' => 'form-control','placeholder' => 'Enter title']) !!}
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="number" class="">Reference number #</label>
                  {!! Form::text('reference_number', null ,['class' => 'form-control','placeholder' => 'Enter Reference Number']) !!}
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="date" class="text-danger">Credit Note Date *</label>
                  <input type="date" name="creditnote_date" class="form-control required" autocomplete="off" required>
               </div>
            </div>
         </div>
         <div class="panel panel-default mt-2">
            <div class="panel-heading">
               <h4 class="panel-title">Credit Note Items</h4>
            </div>
            <div class="panel-body">
               <div class='row mt-3'>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                     <table class="table table-bordered table-striped" id="invoiceItems">
                        <thead>
                           <tr>
                              <th width="35%">Item Name</th>
                              <th width="13%">Quantity</th>
                              <th width="13%">Price</th>
                              {{-- <th width="13%">Tax</th> --}}
                              <th width="25%">Total</th>
                              <th width=""></th>
                           </tr>
                        </thead>
                        <?php
                           $count = 1;
                        ?>
                        <tbody>
                           <tr class="clone-item">
                              <td>
                                 @livewire('finance.invoice.product-list')
                              </td>
                              <td>
                                 <input type="number" name="qty[]" id="quantity_1" class="form-control changesNo quanyityChange">
                              </td>
                              <td>
                                 <input type="number" name="price[]" id="price_1" class="form-control changesNo" autocomplete="off" step="0.01">
                              </td>
                              <td style="display: none">
                                 <input type="number" name="discount[]" id="discount_1" class="form-control discount changesNo" autocomplete="off" step="0.01" >
                              </td>
                              <td style="display: none">
                                 <select name="tax[]" class="form-control changesNo onchange" id="tax_1" autocomplete="off">
                                    <option value="0">Choose tax rate</option>
                                    @foreach ($taxes as $tx)
                                       <option value="{{ $tx->rate }}"> {{ $tx->name }}-{{ $tx->rate }}%</option>
                                    @endforeach
                                    <option value="" class="text-danger">Remove Tax</option>
                                 </select>
                                 <input type="hidden" id="taxvalue_1" name="taxValue[]" class="form-control totalLineTax addNewRow" autocomplete="off" step="0.01" readonly>
                              </td>
                              <td>
                                 <input type="hidden" id="mainAmount_1" class="form-control mainAmount addNewRow" autocomplete="off" placeholder="Main Amount" step="0.01" readonly>
                                 <input type="hidden" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" placeholder="Total Amount" step="0.01" readonly>
                                 <input type="text" id="sum_1" class="form-control totalSum addNewRow" autocomplete="off" placeholder="Total Sum" step="0.01" readonly>
                              </td>
                              <td><a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media"><i class="fas fa-trash"></i></a></td>
                           </tr>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Amount</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly value="0" type="number" class="form-control" id="mainAmountF" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Sub Total</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly value="0" type="number" class="form-control" id="subTotal" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                           <tr class="table-default">
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Total Amount</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly value="0" type="number" class="form-control" id="InvoicetotalAmount" placeholder="Total" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
               <div class='row mb-3'>
                  <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                     <a class="btn btn-primary" id="addRows" href="javascript:;"><i class="fal fa-plus-circle"></i> Add More</a>
                  </div>
               </div>
            </div>
         </div>
         <div class='row mt-3'>
            <div class="col-md-6 mt-3">
               <label for="">Customer Notes</label>
               <textarea name="customer_note" class="form-control tinymcy" rows="8" cols="80">{!! Finance::creditnote()->default_customer_notes !!}</textarea>
            </div>
            <div class="col-md-6 mt-3">
               <label for="">Terms & Conditions</label>
               <textarea name="terms" class="form-control tinymcy" rows="8" cols="80">{!! Finance::creditnote()->default_terms_conditions !!}</textarea>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
               <div class='form-group text-center'>
                  <center>
                     <button type="submit"class="btn btn-pink btn-lg submit"><i class="fas fa-save"></i> Create Credit note </button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                  </center>
               </div>
            </div>
         </div>
      {{ Form::close() }}
   </div>
   @include('app.finance.partials._lpo')
@endsection

