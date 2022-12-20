@extends('layouts.app')
{{-- page header --}}
@section('title','Website Settings | E-commerce')
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
         <li class="breadcrumb-item active">Details</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-globe"></i> Website Settings - Details</h1>
      @include('partials._messages')
      <div class="row">
         @include('app.ecommerce.settings._menu')
         <div class="col-md-9">
            <div class="card">
               @include('app.ecommerce.settings.website._menu')
               <div class="card-block">
                  <div class="p-0 m-0">
                     <form class="row" action="{!! route('ecommerce.settings.website.details.save') !!}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                           <div class="row">
                              <div class="col-md-3">
                                 <img src="{!! asset('businesses/'.$site->business_code .'/documents/images/'.$site->logo) !!}" width="142" alt="">
                              </div>
                              <div class="col-md-9">
                                 <div class="form-group">
                                    <label for="">Website Logo</label>
                                    <input type="file" class="form-control" name="logo">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Website Title</label>
                              <input type="text" class="form-control" name="site_title" value="{!! $site->store_title !!}" required>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Website domain</label>
                              <input type="text" class="form-control" name="domain" value="{!! $site->domain !!}" required>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Meta Description</label>
                              <textarea name="store_meta_description" class="form-control" cols="5" rows="5" maxlength="180">{!! $site->store_meta_description !!}</textarea>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">About Website</label>
                              <textarea name="store_description" class="form-control tinymcy" cols="5" rows="30">{!! $site->store_description !!}</textarea>
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
