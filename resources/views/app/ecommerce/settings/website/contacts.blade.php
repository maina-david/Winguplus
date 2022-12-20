@extends('layouts.app')
{{-- page header --}}
@section('title','Website Settings')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
   @include('app.ecommerce.partials._menu')
@endsection
{{-- content section --}}
@section('content')
   <div id="content" class="content"> 
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('ecommerce.dashboard') !!}">E-commerce</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item">Website</li>
         <li class="breadcrumb-item active">Contacts</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-phone-rotary"></i> Website Settings - Contacts</h1>
      @include('partials._messages')
      <div class="row">
         @include('app.ecommerce.settings._menu')
         <div class="col-md-9">
            <div class="card">
               @include('app.ecommerce.settings.website._menu')
               <div class="card-block">
                  <div class="p-0 m-0">
                     <form class="row" action="{!! route('ecommerce.settings.website.contacts.save') !!}" method="POST">
                        @csrf
                        <div class="col-md-6">
                           <div class="form-group ">  
                              <label for="">Notification Email</label>
                              <input type="text" class="form-control" name="notification_email" value="{!! $site->notification_email !!}" required>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group ">  
                              <label for="">Phone Number</label>
                              <input type="text" class="form-control" name="phone_number" value="{!! $site->phone_number !!}" required>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group ">  
                              <label for="">Location Address</label>
                              <input type="text" class="form-control" name="location_address" value="{!! $site->location_address !!}">
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group ">  
                              <label for="">Map</label>
                              <textarea type="text" class="form-control" name="map"  cols="5" rows="5" value="">{!! $site->map !!}</textarea>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <button type="submit" class="float-left btn btn-pink btn-sm submit"><i class="fa fa-save"></i> Save Information</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="float-left submit-load none" alt="" width="25%">
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
@endsection
