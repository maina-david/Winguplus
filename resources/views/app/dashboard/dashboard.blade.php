@extends('layouts.app')
@section('title','Dashboard')
@section('stylesheet')
   <link rel="stylesheet" href="{!! asset('assets/css/dashboard.css') !!}" />
@endsection
@section('content')
   <div class="main">
      <div class="row mt-5">
         <div class="col-md-12 mb-5">
            <h1 class="text-center"><b>What would you like to manage ?</b></h1>
         </div>

         @foreach ($modules as $module)
            <div class="col-md-3 mb-3">
               <div class="black-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class="">{!! $module->name !!}</h2>
                        <p class="font-bold text-black">{!! $module->caption !!}</p>
                        <div class="mb-2">{!! $module->icon !!}</div>
                        <p class="small">{!! $module->introduction !!}</p>
                        <a href="{!! route($module->link) !!}" class="btn btn-black btn-sm">
                           <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         @endforeach
      </div>
   </div>
@endsection
