@extends('layouts.app')
{{-- page header --}}
@section('title','Finance | Edit Invoice')
{{-- page styles --}}

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
         <li class="breadcrumb-item"><a href="{!! route('finance.invoice.index') !!}">Invoice</a></li>
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> Update Invoice</h1>
      @include('partials._messages')
      {!! Form::model($invoice, ['route' => ['finance.invoice.product.update',$invoice->invoiceCode], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
         @csrf
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               @livewire('finance.invoice.customer-list',['editCustomer'=>'True','customerCode' => $invoice->customer])
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group">
                  <label for="number">Invoice Number</label>
                  <div class="input-group">
                     <span class="input-group-addon solso-pre">{{ $invoice->prefix }}</span>
                     {!! Form::number('invoice_number', null, array('class' => 'form-control','placeholder' => '','required' => '')) !!}
                  </div>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="number" class="">Order Number # </label>
                  <div class="input-group">
                     <input type="text" name="lpo_number" class="form-control" value="{{ $invoice->lpo_number }}" placeholder="Enter order number">
                  </div>
               </div>
            </div>
         </div>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
                <div class="form-group form-group-default">
                    <label for="end">Subject</label>
                    {!! Form::text('invoice_title', null, array('class' => 'form-control', 'placeholder' => 'Enter invoice title'))!!}
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="date" class="text-danger">Issue Date *</label>
                  {!! Form::date('invoice_date', null, array('class' => 'form-control','required' => '')) !!}
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end" class="text-danger">Due Date * </label>
                  {!! Form::date('invoice_due', null, array('class' => 'form-control','required' => '')) !!}
               </div>
            </div>
         </div>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end"> Amounts are
                     <span class="pull-right" data-toggle="tooltip" data-placement="top" title="If the amount is tax exlusive the tax field will be hidden on the invoice view">
                        <i class="fas fa-info-circle"></i>
                     </span>
                  </label>
                  {!! Form::select('tax_config',['Inclusive' => 'Tax Inclusive','Exclusive' => 'Tax Exclusive'],null,['class' => 'form-control select2', 'id' => 'tax_config' ]) !!}
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end" class="text-danger">Sales person</label>
                  {!! Form::select('sales_person',$salespersons,null,['class' => 'form-control select2']) !!}
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               @if(Finance::check_income_category($invoice->income_category) == 1)
                  @livewire('finance.invoice.income-list',['editIncome'=>'True','incomeCode' => $invoice->income_category])
               @else
                  @livewire('finance.invoice.income-list')
               @endif
            </div>
         </div>
         <div class="panel panel-default mt-3">
            <div class="panel-heading">
               <h4 class="panel-title">Invoice Items <a href=""  data-toggle="modal" data-target="#addProducts" class="float-right badge badge-primary text-white">Add Product</a></h4>
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
                              <th width="13%">Discount({!! $invoice->symbol !!})</th>
                              <th width="13%">Tax</th>
                              <th width="25%">Total</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($invoiceProducts as $product)
                              <tr class="clone-item">
                                 <td>
                                    @livewire('finance.invoice.product-list',['editProduct'=>'True','productCode'=>$product->product_code])
                                 </td>
                                 <td>
                                    <input type="number" name="qty[]" id="quantity_1" value="{{ $product->quantity }}" class="form-control changesNo quanyityChange" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                 </td>
                                 <td>
                                    <input type="number" name="price[]" id="price_1" value="{{ $product->selling_price }}" class="form-control onchange changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                                 </td>
                                 <td>
                                    <input type="number" name="discount[]" id="discount_1" class="form-control discount changesNo" value="{{ $product->discount }}" autocomplete="off" step="0.01">
                                 </td>
                                 <td>
                                    <select name="tax[]" class="form-control changesNo onchange" id="tax_1" autocomplete="off">
                                       @if($product->tax_rate == 0 || $product->tax_rate == "")
                                          <option value="0">Choose tax rate</option>
                                       @else
                                          <option value="{!! $product->tax_rate !!}">{!! $product->tax_rate !!}%</option>
                                       @endif
                                       @foreach ($taxs as $tx)
                                          <option value="{{ $tx->rate }}"> {{ $tx->name }}-{{ $tx->rate }}%</option>
                                       @endforeach
                                       <option value="" class="text-danger">Remove Tax</option>
                                    </select>
                                    <input type="hidden" id="taxvalue_1" name="taxValue[]" class="form-control totalLineTax addNewRow" value="{!! $product->tax_value !!}" autocomplete="off" step="0.01" readonly>
                                 </td>
                                 <td>
                                    <input type="hidden" id="mainAmount_1" class="form-control mainAmount addNewRow" autocomplete="off" value="{!! $product->quantity * $product->selling_price !!}" placeholder="Main Amount" step="0.01" readonly>
                                    <input type="hidden" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" value="{!! $product->sub_total !!}" placeholder="Total Amount" step="0.01" readonly>
                                    <input type="text" id="sum_1" class="form-control totalSum addNewRow" autocomplete="off" value="{!! $product->total_amount !!}"  placeholder="Total Sum" step="0.01" readonly>
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
                                    <input readonly value="{!! $invoice->main_amount !!}" type="number" class="form-control" id="mainAmountF" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Discount</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly type="number" value="{!! $invoice->discount !!}" class="form-control" id="discountTotal" step="0.01">
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
                                    <input readonly type="number" value="{!! $invoice->sub_total !!}" class="form-control" id="subTotal" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                           <tr id="taxfield">
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Tax</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly type="number" class="form-control" value="{!! $invoice->tax_value !!}" id="taxvalue" step="0.01">
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
                                    <input readonly type="number" class="form-control" id="InvoicetotalAmount" value="{!! $invoice->total !!}" placeholder="Total" step="0.01">
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
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Invoice Note | Terms & conditions</h4>
            </div>
            <div class="panel-body">
               <div class='row mt-3'>
                  <div class="col-md-6">
                     <label for="">Customer Notes</label>
                     <textarea name="customer_note" class="form-control tinymcy" rows="8" cols="80">{!! $invoice->customer_note !!}</textarea>
                  </div>
                  <div class="col-md-6">
                     <label for="">Terms & Conditions</label>
                     <textarea name="terms" class="form-control tinymcy" rows="8" cols="80">{!! $invoice->terms !!}</textarea>
                  </div>
               </div>
            </div>
         </div>
         <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
            <div class='form-group text-center'>
               <center>
                  <button type="submit" class="btn btn-pink btn-lg submit"><i class="fas fa-save"></i> Update Invoice </button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="invoice-load none" alt="" width="15%">
               </center>
            </div>
         </div>
      {{ Form::close() }}
   </div>
   @livewire('finance.invoice.customer-create')
   @livewire('finance.invoice.income-create')
   @livewire('finance.invoice.product-create')
@endsection
@include('app.finance.partials._invoice')
@section('script2')
   <script type="text/javascript">
      $(document).ready(function(){
         $("form").on("submit", function(){
            $(".save-invoice").hide();
            $(".invoice-load").show();
         });//submit
      });//document ready
   </script>
   <script type="text/javascript">
      window.livewire.on('ModalStore', () => {
         $('#addCustomer').modal('hide');
         $('#addIncomeCategory').modal('hide');
         $('#addProducts').modal('hide');
      });
  </script>
@endsection
