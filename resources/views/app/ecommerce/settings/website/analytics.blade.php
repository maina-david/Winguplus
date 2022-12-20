@extends('layouts.app')
{{-- page header --}}
@section('title','Website Settings')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboard menu --}}
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
         <li class="breadcrumb-item active">Analytics</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-analytics"></i> Website Settings - Analytics</h1>
      @include('partials._messages')
      <div class="row">
         @include('app.ecommerce.settings._menu')
         <div class="col-md-9">
            <div class="card">
               @include('app.ecommerce.settings.website._menu')
               <div class="card-block">
                  <div class="p-0 m-0">
                     <form class="row" action="{!! route('ecommerce.settings.website.analytics.save') !!}" method="POST">
                        @csrf
                        <div class="col-md-12">
                           <div class="form-group ">
                              <label for="">Google Analytics code</label>
                              <textarea type="text" class="form-control" name="google_analytics"  cols="10" rows="10" value="">{!! $site->google_analytics !!}</textarea>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group ">
                              <label for="">Facebook pixel Analytics code</label>
                              <textarea type="text" class="form-control" name="facebook_pixel"  cols="10" rows="10" value="">{!! $site->facebook_pixel !!}</textarea>
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
