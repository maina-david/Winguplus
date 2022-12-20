@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Credit note')
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
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-credit-card"></i> Update Credit note</h1>
      @include('partials._messages')

         {!! Form::model($creditnote, ['route' => ['finance.creditnote.update',$creditnote->creditnote_code], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data','autocomplete' => 'off']) !!}
            @csrf
            <div class='row'>
               <div class="col-md-6 col-lg-6">
                  <div class="form-group form-group-default">
                     <label for="customer" class="text-danger">Customer</label>
                     {!! Form::select('customer',$customers,null,['class'=>'form-control select2','required'=>'']) !!}
                     <?php echo $errors->first('client', '<p class="error">:messages</p>');?>
                  </div>
               </div>
               <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                     <label for="number">Credit Note Number</label>
                     <div class="input-group">
                        <span class="input-group-addon solso-pre">{{ Finance::creditnote()->prefix }}</span>
                        {!! Form::text('number', null, array('class' => 'form-control equired no-line', 'autocomplete' => 'off', 'placeholder' => '','readonly' => '')) !!}
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
                     {!! Form::date('creditnote_date', null ,['class' => 'form-control required','required' => '']) !!}
                  </div>
               </div>
            </div>

            <div class="panel panel-default mt-3">
               <div class="panel-heading">
                  <h4 class="panel-title">Credit note Items </h4>
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
                                 <th width="25%">Total</th>
                                 <th></th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($creditProducts as $product)
                                 <tr class="clone-item">
                                    <td>
                                       @livewire('finance.invoice.product-list',['editProduct'=>'True','productCode'=>$product->product_code])
                                    </td>
                                    <td>
                                       <input type="number" name="qty[]" id="quantity_1" value="{{ $product->quantity }}" class="form-control changesNo quanyityChange" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                    </td>
                                    <td>
                                       <input type="number" name="price[]" id="price_1" value="{{ $product->price }}" class="form-control onchange changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                                    </td>
                                    <td style="display: none">
                                       <input type="number" name="discount[]" id="discount_1" class="form-control discount changesNo" value="{{ $product->discount }}" autocomplete="off" step="0.01">
                                    </td>
                                    <td style="display: none">
                                       <select name="tax[]" class="form-control changesNo onchange" id="tax_1" autocomplete="off">

                                          <option value="" class="text-danger">Remove Tax</option>
                                       </select>
                                       <input type="hidden" id="taxvalue_1" name="taxValue[]" class="form-control totalLineTax addNewRow" value="{!! $product->tax_value !!}" autocomplete="off" step="0.01" readonly>
                                    </td>
                                    <td>
                                       <input type="hidden" id="mainAmount_1" class="form-control mainAmount addNewRow" autocomplete="off" value="{!! $product->quantity * $product->price !!}" placeholder="Main Amount" step="0.01" readonly>
                                       <input type="hidden" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" value="{!! $product->sub_total !!}" placeholder="Total Amount" step="0.01" readonly>
                                       <input type="text" id="sum_1" class="form-control totalSum addNewRow" autocomplete="off" value="{!! $product->total !!}"  placeholder="Total Sum" step="0.01" readonly>
                                    </td>
                                    <td><a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media"><i class="fas fa-trash"></i></a></td>
                                 </tr>
                              @endforeach
                           </tbody>
                           <tfoot>
                              <tr>
                                 <td colspan="2" class="col-md-12 col-lg-8"></td>
                                 <td colspan="2" style="width:20%">
                                    <h4 class="pull-right top10">Amount</h4>
                                 </td>
                                 <td colspan="3">
                                    <h4 class="text-center">
                                       <input readonly value="{!! $creditnote->sub_total !!}" type="number" class="form-control" id="mainAmountF" step="0.01">
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
                                       <input readonly type="number" value="{!! $creditnote->sub_total !!}" class="form-control" id="subTotal" step="0.01">
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
                                       <input readonly type="number" class="form-control" id="InvoicetotalAmount" value="{!! $creditnote->total !!}" placeholder="Total" step="0.01">
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
                  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
               </div>
            </div>

            <div class='row'>
               <div class="col-md-6 mt-3">
                  <label for="">Customer Notes</label>
                  <textarea name="customer_note" class="form-control tinymcy" rows="8" cols="80">{!! $creditnote->customer_note !!}</textarea>
               </div>
               <div class="col-md-6 mt-3">
                  <label for="">Customer Notes</label>
                  <textarea name="terms" class="form-control tinymcy" rows="8" cols="80">{!! $creditnote->terms !!}</textarea>
               </div>
               <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
                  <div class='form-group text-center'>
                     <center>
                        <button type="submit"class="btn btn-pink btn-lg submit"><i class="fas fa-save"></i> Update Credit note </button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </div>
            </div>
         {{ Form::close() }}
   </div>
@endsection
@include('app.finance.partials._lpo')
