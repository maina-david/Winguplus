@extends('layouts.app')
@section('title','Edit Plan')
@section('sidebar')
@include('app.subscriptions.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('subscriptions.dashboard') !!}">Subscriptions</a></li>
         <li class="breadcrumb-item"><a href="{!! route('subscriptions.products.index') !!}">Products</a></li>
         <li class="breadcrumb-item"><a href="{!! route('subscriptions.plan.index',$productID) !!}">Plan</a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-file-alt"></i> Edit Plan</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">
            <!-- shop menu -->
         <div class="col-md-9">
            {!! Form::model($edit, ['route' => ['subscriptions.plan.update',$edit->proID], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
               {!! csrf_field() !!}
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Plan Information</h4>
                  </div>
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('title', 'Plan Name', array('class'=>'control-label')) !!}
                              {!! Form::text('product_name', null, array('class' => 'form-control', 'placeholder' => 'Enter plan name','required' => '')) !!}
                              <input type="hidden" value="{!! $productID !!}" name="parentID">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('title', 'Plan code', array('class'=>'control-label')) !!}
                              {!! Form::text('sku_code', null, array('class' => 'form-control', 'placeholder' => 'Plan code', 'required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('title', 'Plan price', array('class'=>'control-label')) !!}
                              {!! Form::number('selling_price', null, array('class' => 'form-control', 'placeholder' => 'Enter plan price','required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('title', 'Bill Every', array('class'=>'control-label')) !!}
                              {!! Form::number('bill_count', null, array('class' => 'form-control', 'placeholder' => 'Enter billing count','required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('title', 'Bill period', array('class'=>'control-label')) !!}
                              {!! Form::select('billing_period', ['Month' => 'Month(s)','Week' => 'Week(s)','Year' => 'Year(s)'], null, array('class' => 'form-control multiselect','required' => '')) !!}
                           </div>
                        </div>                        
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('title', 'Billing type', array('class'=>'control-label')) !!}
                              {!! Form::select('billing_type', ['auto renew' => 'Auto renews until canceled','specified' => 'Expires after a specified no. of billing cycles'], null, array('class' => 'form-control multiselect','required' => '')) !!}
                           </div>
                        </div>                     
                        @if($edit->specified_bill_cycle != "")
                           <div class="col-md-6">
                              <div class="form-group form-group-default">
                                 {!! Form::label('title', 'Specified billing cycle', array('class'=>'control-label')) !!}
                                 {!! Form::number('specified_bill_cycle', null, array('class' => 'form-control', 'placeholder' => 'Enter billing count')) !!}
                              </div>
                           </div>
                        @endif
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('title', 'Free Trial (in days)', array('class'=>'control-label')) !!}
                              {!! Form::number('trial_days', null, array('class' => 'form-control', 'placeholder' => 'Enter days')) !!}
                           </div>
                        </div>
                        {{-- <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('title', 'Setup Fee', array('class'=>'control-label')) !!}
                              {!! Form::number('setup_fee', null, array('class' => 'form-control', 'placeholder' => 'Enter fee')) !!}
                           </div>
                        </div> --}}
                        {{-- <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('title', 'Tax', array('class'=>'control-label')) !!}
                              <select name="tax" id="" class="form-control multiselect">
                                 @if($edit->taxID != 0)
                                    <option value="{!! $edit->taxID !!}">
                                       {!! Finance::tax($edit->taxID)->name !!}-{!! Finance::tax($edit->taxID)->rate !!}%
                                    </option>
                                 @else
                                    <option value=""> Choose tax</option>
                                 @endif
                                 @foreach($taxes as $tax)
                                    <option value="{!! $tax->id !!}">{!! $tax->name !!}-{!! $tax->rate !!}%</option>
                                 @endforeach
                              </select>
                           </div>
                        </div> --}}
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              {!! Form::label('title', 'Description', array('class'=>'control-label')) !!}
                              {!! Form::textarea('description',null,['class'=>'ckeditor form-control','rows' => 5, 'placeholder'=>'content']) !!}
                           </div>
                        </div>
                        <div class="col-md-12 mt-4">
                           <center>
                              <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Plan</button>
                              <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                           </center>
                        </div>
                     </div>
                  </div>
               </div>
            {!! Form::close() !!}
         </div>
      </div>
   </div>
@endsection
@section('scripts')
	<script>
      $(document).ready(function() {
         $('#sku').on('change', function() {
            if (this.value == 'Custom') {
               $('#custom-sku').show();
            }
            if (this.value == 'Auto') {
               $('#custom-sku').hide();
            }
         });
      });
   </script>
   <script src="{!! asset('assets/plugins/ckeditor/4/basic/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection