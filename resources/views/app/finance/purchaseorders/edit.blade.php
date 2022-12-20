@extends('layouts.app')
{{-- page header --}}
@section('title','Edit | Purchase Order')

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
         <li class="breadcrumb-item"><a href="{!! route('finance.lpo.index') !!}">Purchase Order</a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-contract"></i> Edit Purchase Order</h1>
      @include('partials._messages')
      <div class="panel panel-inverse">
         <div class="panel-body">
            {!! Form::model($lpo, ['route' => ['finance.lpo.update',$lpo->po_code], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']) !!}
               @csrf
               <div class="load-animate">
                  <div class='row'>
                     <div class="col-md-4 col-lg-4">
                        <div class="form-group form-group-default required">
                           <label for="client" class="text-danger">Suppliers</label>
                           {!! Form::select('supplier',$suppliers,null,['class'=>'form-control select2','required'=>'']) !!}
                           <?php echo $errors->first('client', '<p class="error">:messages</p>');?>
                        </div>
                     </div>
                     <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                           <label for="number">Purchase Order #</label>
                           <div class="input-group">
                           <span class="input-group-addon solso-pre">{{ Finance::lpo()->prefix }}</span>
                           {!! Form::text('lpo_number', null, array('class' => 'form-control equired no-line', 'autocomplete' => 'off', 'placeholder' => '','readonly' => '')) !!}
                           </div>
                           <?php echo $errors->first('number', '<p class="error">:messages</p>');?>
                        </div>
                     </div>
                     <div class="col-md-4 col-lg-4">
                        <div class="form-group form-group-default">
                           <label for="number" class="">Reference #</label>
                           <div class="input-group">
                           <input type="text" name="reference_number" class="form-control required" value="{{ $lpo->reference_number }}" >
                           </div>
                           <?php echo $errors->first('reference_number', '<p class="error">:messages</p>');?>
                        </div>
                     </div>
                  </div>
                  <div class='row'>
                     <div class="col-md-4 col-lg-4">
                        <div class="form-group form-group-default">
                           <label for="title">Title</label>
                           {!! Form::text('title',null,['class' => 'form-control', 'placeholder' => 'Enter title']) !!}
                        </div>
                     </div>
                     <div class="col-md-4 col-lg-4">
                        <div class="form-group form-group-default required">
                           <label for="date" class="text-danger">Issue Create</label>
                           {!! Form::date('lpo_date', null, array('class' => 'form-control', 'placeholder' => 'Issue Create','required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-4 col-lg-4">
                        <div class="form-group form-group-default required">
                           <label for="end" class="text-danger">Expected Delivery Date</label>
                           {!! Form::date('lpo_due', null, array('class' => 'form-control', 'placeholder' => 'Expiry Date','required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-4 col-lg-4">
                        <div class="form-group form-group-default">
                           <label for="" class="text-danger">Expense Category
                           {!! Form::select('expense_category',$expenseCategories,null,['class'=>'form-control select2','required'=>'']) !!}
                        </div>
                     </div>
                  </div>
                  <div class='row mt-3'>
                     <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                        <table class="table table-bordered table-striped" id="invoiceItems">
                           <thead>
                              <tr>
                                 <th width="35%">Item Name</th>
                                 <th width="13%">Quantity</th>
                                 <th width="13%">Price</th>
                                 <th width="13%">Tax</th>
                                 <th width="25%">Total</th>
                                 <th></th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($poProducts as $product)
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
                                       <input type="number" name="discount[]" id="discount_1" class="form-control discount changesNo" autocomplete="off" step="0.01" >
                                    </td>
                                    <td>
                                       <select name="tax[]" class="form-control changesNo onchange" id="tax_1" autocomplete="off">
                                          @if($product->tax_rate == 0 || $product->tax_rate == "")
                                             <option value="0">Choose tax rate</option>
                                          @else
                                             <option value="{!! $product->tax_rate !!}">{!! $product->tax_rate !!}%</option>
                                          @endif
                                          @foreach ($taxes as $tx)
                                             <option value="{{ $tx->rate }}"> {{ $tx->name }}-{{ $tx->rate }}%</option>
                                          @endforeach
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
                                    <h4 class="pull-right top10">Sub Total</h4>
                                 </td>
                                 <td colspan="3">
                                    <h4 class="text-center">
                                       <input readonly type="number" value="{!! $lpo->sub_total !!}" class="form-control" id="subTotal" step="0.01">
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
                                       <input readonly type="number" class="form-control" value="{!! $lpo->tax_value !!}" id="taxvalue" step="0.01">
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
                                       <input readonly type="number" class="form-control" id="InvoicetotalAmount" value="{!! $lpo->total !!}" placeholder="Total" step="0.01">
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
                  <div class='row'>
                     <div class="col-md-6 mt-3">
                        <label for="">Supplier Notes</label>
                        <textarea name="customer_note" class="form-control tinymcy" rows="8" cols="80">{!! $lpo->customer_note !!}</textarea>
                     </div>
                     <div class="col-md-6 mt-3">
                        <label for="">Terms and Conditions</label>
                        <textarea name="terms" class="form-control tinymcy" rows="8" cols="80">{!! $lpo->terms !!}</textarea>
                     </div>
                     <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                     <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
                        <div class='form-group text-center'>
                           <center>
                              <button type="submit"class="btn btn-pink btn-lg"><i class="fas fa-save"></i> Update Purchase Order </button>
                              {{-- <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%"> --}}
                           </center>
                        </div>
                     </div>
                  </div>
               </div>
            {{ Form::close() }}
         </div>
      </div>
   </div>
   @include('app.finance.expense.category.express')
@endsection
@include('app.finance.partials._lpo')
