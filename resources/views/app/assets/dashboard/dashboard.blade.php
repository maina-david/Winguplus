@extends('layouts.app')
{{-- page header --}}
@section('title','Assets')
{{-- page styles --}}
@section('stylesheet')
@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.assets.partials._menu')
@endsection

@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <div class="row">
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-teal">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-boxes-alt"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Total Assets</div>
                  <div class="stats-number">{!! number_format($assets->count()) !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-blue">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-door-open"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Checked-out</div>
                  <div class="stats-number">{!! number_format($checkedOut->count()) !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-yellow">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-tools"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Under repair</div>
                  <div class="stats-number">{!! number_format($underRepair->count()) !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-gradient-purple">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-search"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Lost/Missing</div>
                  <div class="stats-number">{!! number_format($missing->count()) !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">.</div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
      </div>
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Total Assets By Type</div>
               <div class="card-body">
                  {!! $assetByType->container() !!}
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Total Assets By Status</div>
               <div class="card-body">
                  {!! $assetByStatus->container() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end #content -->
@endsection
@section('scripts')
   {!! $assetByType->script() !!}
   {!! $assetByStatus->script() !!}
@endsection
