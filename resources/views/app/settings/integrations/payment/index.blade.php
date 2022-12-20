@extends('layouts.app')
{{-- page header --}}
@section('title','Payment Gateways | Settings')
{{-- page styles --}}
@section('stylesheet')
   <style>
      .select2-container {
         z-index: 9999 !important;
      }
   </style>
@endsection

{{-- dashboard menu --}}
@section('sidebar')
   @include('app.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <a href="#" class="btn btn-pink" data-toggle="modal" data-target=".gateway"><i class="fas fa-plus-circle"></i> Add Payment Integration</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> Payment Gateways </h1>
      <!-- begin row -->
      @include('partials._messages')
      <div class="row">
         @foreach ($businessIntegrations as $connection)
            <div class="col-md-4 col-sm-6 col-xs-12">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <a href="#">
                        <center>
                           <img alt="{!! $connection->gateway_name !!}" src="{!! asset('assets/img/gateways/'.$connection->logo) !!}" class="img-responsive payment-logo">
                        </center>
                     </a>
                  </div>
                  <div class="panel-body">
                     <h3 class="text-center">{!! $connection->integration_name !!}.</h3>
                     @if($connection->integration_code == 'pesapal')
                        <a href="{!! route('settings.integrations.payments.pesapal.edit',$connection->integration_code) !!}" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit details</a>
                     @endif
                     @if($connection->integration_code == 'paypal')
                        <a href="{!! route('settings.integrations.payments.paypal.edit',$connection->integration_code) !!}" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit details</a>
                     @endif
                     @if($connection->integration_code == 'mpesadaraja')
                        <a href="{!! route('settings.integrations.payments.mpesa.edit',$connection->integration_code) !!}" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit details</a>
                     @endif
                     {{-- mpesa phone number --}}
                     @if($connection->integration_code == 'mpesaphonenumber')
                        <a href="{!! route('settings.payments.integrations.mpesa.phonenumber',$connection->integration_code) !!}" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit </a>
                     @endif

                     {{-- mpesa Till number --}}
                     @if($connection->integration_code == 'mpesatillnumber')
                        <a href="{!! route('settings.payments.integrations.mpesa.tillnumber',$connection->integration_code) !!}" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit </a>
                     @endif

                     {{-- mpesa Paybill number --}}
                     @if($connection->integration_code == 'mpesapaybill')
                        <a href="{!! route('settings.payments.integrations.mpesa.paybillnumber',$connection->integration_code) !!}" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit </a>
                     @endif

                     {{--kepler9 --}}
                     @if($connection->integration_code == 'kepler9')
                        <a href="{!! route('settings.payments.integrations.kepler9',$connection->integration_code) !!}" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit </a>
                     @endif

                     {{--ipay --}}
                     @if($connection->integration_code == 'ipay')
                        <a href="{!! route('settings.payments.integrations.ipay',$connection->integration_code) !!}" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit </a>
                     @endif
                     <div class="btn-group float-right mt-3" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                           <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             {!! $connection->statusName !!}
                           </button>
                           <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                              @if($connection->paymentStatus != 15)
                                <a class="dropdown-item" href="{!! route('settings.integrations.payments.status',[$connection->integration_code,15]) !!}">Active</a>
                              @endif
                              @if($connection->paymentStatus != 22)
                                 <a class="dropdown-item" href="{!! route('settings.integrations.payments.status',[$connection->integration_code,22]) !!}">Close</a>
                              @endif
                              <a class="dropdown-item delete" href="{!! route('settings.integrations.payments.delete',$connection->integration_code) !!}">Delete</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         @endforeach
      </div>
   </div>

   <!-- Modal -->
   <form action="{!! route('settings.integrations.payments.store') !!}" method="post">
      <div class="modal fade gateway" tabindex="-1" role="dialog" aria-labelledby="gatewayTitle" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            @csrf
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Payment Gateways</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="form-group form-group-default">
                     <label for="">Choose Payment Integration</label>
                     {!! Form::select('integration',$integrations, null,['class' => 'form-control select2'] ) !!}
                  </div>
                  <div class="form-group form-group-default">
                     <label for="">Choose status</label>
                     {!! Form::select('status',['' => 'Choose status','15' => 'Active', '23' => 'Closed'], null,['class' => 'form-control select2'] ) !!}
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Integration</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </div>
            </div>
         </div>
      </div>
   </form>
@endsection
