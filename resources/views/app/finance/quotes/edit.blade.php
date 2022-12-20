@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Quote | Finance')

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
         <li class="breadcrumb-item"><a href="{!! route('finance.quotes.index') !!}">Quotes</a></li>
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-file-alt"></i> Update Quotes</h1>
      @include('partials._messages')
         {!! Form::model($quote, ['route' => ['finance.quotes.update',$quote->quote_code], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']) !!}
            @csrf
            <div class="load-animate">
               <div class='row'>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="customer" class="text-danger">Customer</label>
                        {!! Form::select('customer',$customers,null,['class'=>'form-control select2','required'=>'']) !!}
                        <?php echo $errors->first('client', '<p class="error">:messages</p>');?>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group">
                        <label for="number">Quote Number</label>
                        <div class="input-group">
                           <span class="input-group-addon solso-pre">{{ Finance::quote()->prefix }}</span>
                           {!! Form::text('quote_number', null, array('class' => 'form-control equired no-line', 'autocomplete' => 'off', 'placeholder' => '','readonly' => '')) !!}
                        </div>
                        <?php echo $errors->first('number', '<p class="error">:messages</p>');?>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="number" class="">Reference # </label>
                        <div class="input-group">
                           <input type="text" name="reference_number" class="form-control" value="{{ $quote->reference_number }}" >
                        </div>
                        <?php echo $errors->first('reference_number', '<p class="error">:messages</p>');?>
                     </div>
                  </div>
               </div>
               <div class='row'>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="date" class="text-danger">Date Create</label>
                        {!! Form::date('quote_date', null, array('class' => 'form-control', 'placeholder' => 'Date Create','required' => '')) !!}
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="end" class="text-danger">Expiry Date * </label>
                        {!! Form::date('quote_due', null, array('class' => 'form-control', 'placeholder' => 'Expiry Date','required' => '')) !!}
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="end">Amounts are</label>
                        {!! Form::select('tax_config',['Inclusive' => 'Tax Inclusive','Exclusive' => 'Tax Exclusive'],null,['class' => 'form-control', 'id' => 'taxconfig' ]) !!}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group-default">
                        <label for="">Subject</label>
                        {!! Form::text('subject',null, ['class' => 'form-control', 'placeholder' => 'Enter quote subject']) !!}
                     </div>
                  </div>
               </div>
               <div class="row mt-3 mb-3">
                  <div class="col-md-12">
                     {!! Form::textarea('description',null,['class' => 'form-control tinymcy']) !!}
                  </div>
               </div>
               <div class="panel panel-default mt-4">
                  <div class="panel-heading">
                     <h4 class="panel-title">Quote Items</h4>
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
                                    <th width="13%">Discount({!! $quote->symbol !!})</th>
                                    <th width="13%">Tax</th>
                                    <th width="25%">Total</th>
                                    <th></th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach ($quoteProducts as $product)
                                    <tr class="clone-item">
                                       <td>
                                          <select name="productID[]" class="form-control dublicateSelect2 onchange solsoCloneSelect2" id="itemName_1" data-init-plugin='select2' required>
                                             <option value="{{ $product->product_code }}">
                                                @if(Finance::check_product($product->product_code) == 1)
                                                   {!! Finance::product($product->product_code)->product_name !!}
                                                @else
                                                   <i>Unknown Product</i>
                                                @endif
                                             </option>
                                             @foreach ($products as $prod)
                                                <option value="{{ $prod->product_code }}"> {!! $prod->product_name !!} </option>
                                             @endforeach
                                          </select>
                                          <?php echo $errors->first('currency', '<p class="error">:messages</p>');?>
                                       </td>
                                       <td>
                                          <input type="number" name="qty[]" id="quantity_1" value="{{ $product->quantity }}" class="form-control changesNo quanyityChange" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                       </td>
                                       <td>
                                          <input type="number" name="price[]" id="price_1" value="{{ $product->price }}" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                       </td>
                                       <td>
                                          <input type="number" name="discount[]" id="discount_1" class="form-control discount changesNo" value="{{ $product->discount }}" autocomplete="off" step="0.01">
                                       </td>
                                       <td>
                                          <select name="tax[]" class="form-control changesNo onchange" id="tax_1" autocomplete="off">
                                             <option value="">Choose</option>
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
                                          <input readonly value="{!! $quote->main_amount !!}" type="number" class="form-control" id="mainAmountF" step="0.01">
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
                                          <input readonly type="number" value="{!! $quote->discount !!}" class="form-control" id="discountTotal" step="0.01">
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
                                          <input readonly type="number" value="{!! $quote->sub_total !!}" class="form-control" id="subTotal" step="0.01">
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
                                          <input readonly type="number" class="form-control" value="{!! $quote->tax_value !!}" id="taxvalue" step="0.01">
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
                                          <input readonly type="number" class="form-control" id="InvoicetotalAmount" value="{!! $quote->total !!}" placeholder="Total" step="0.01">
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
               <div class='row'>
                <div class="col-md-6 mt-3">
                    <label for="">Customer Notes</label>
                    <textarea name="customer_note" class="form-control tinymcy" rows="8" cols="80">{!! $quote->customer_note !!}</textarea>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="">Terms & Conditions</label>
                    <textarea name="terms" class="form-control tinymcy" rows="8" cols="80">{!! $quote->terms !!}</textarea>
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                </div>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
                     <div class='form-group text-center'>
                        <center>
                           <button type="submit" class="btn btn-pink btn-lg submitQuote"><i class="fas fa-save"></i> Update Quote </button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submitQuoteLoad none" alt="" width="15%">
                        </center>
                     </div>
                  </div>
               </div>
            </div>
         {{ Form::close() }}
         </div>
      </div>
   </div>
@endsection
@include('app.finance.partials._invoice')
@section('script2')
   <script type="text/javascript">
      $(document).ready(function(){
         $('.submitQuote').on('submit', function(){
            $(".submitQuote").hide();
            $(".submitQuoteLoad").show();
         });//submit
      });
   </script>
@endsection
