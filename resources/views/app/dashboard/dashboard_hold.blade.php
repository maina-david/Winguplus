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

         <!--- finance -->
         @if(Wingu::check_business_modules('finance') == 1)
            @php
               $module = Wingu::modules('finance');
            @endphp
            <div class="col-md-3 mb-3">
               <div class="green-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class="">{!! $module->name !!}</h2>
                        <p class="font-bold text-success">{!! $module->caption !!}</p>
                        <div class="mb-2">{!! $module->icon !!}</div>
                        <p class="small">{!! $module->introduction !!}</p>
                        <a href="{!! route('finance.index') !!}" class="btn btn-success btn-sm">
                           <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         @endif

         <!--- human resource -->
         @if(Wingu::check_business_modules('human-resource') == 1)
            @php
               $module = Wingu::modules('human-resource');
            @endphp
            <div class="col-md-3 mb-3">
               <div class="blue-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class="">{!! $module->name !!}</h2>
                        <p class="font-bold text-info">{!! $module->caption !!}</p>
                        <div class="mb-2">{!! $module->icon !!}</div>
                        <p class="small">{!! $module->introduction !!}</p>
                        <a href="{!! route('hrm.dashboard') !!}" class="btn btn btn-info btn-sm text-white">
                           <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         @endif

         <!-- crm -->
         @if(Wingu::check_business_modules('crm') == 1)
            @php
               $module = Wingu::modules('crm');
            @endphp
            <div class="col-md-3 mb-3">
               <div class="black-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class="m-b-xs">{!! $module->name !!}</h2>
                        <p class="font-bold">{!! $module->caption !!}</p>
                        <div class="mb-2">
                           {!! $module->icon !!}
                        </div>
                        <p class="small">{!! $module->introduction !!}</p>
                        <a href="{!! route('crm.dashboard') !!}" class="btn btn btn-black btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                     </div>
                  </div>
               </div>
            </div>
         @endif

         <!-- project management -->
         @if(Wingu::check_business_modules('jobs-management') == 1)
            @php
               $module = Wingu::modules('jobs-management');
            @endphp
            <div class="col-md-3 mb-3">
               <div class="greenish-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class="m-b-xs">{!! $module->name !!}</h2>
                        <p class="font-bold text-greenish">{!! $module->caption !!}</p>
                        <div class="mb-2">{!! $module->icon !!}</div>
                        <p class="small">{!! $module->introduction !!}</p>
                        <a href="{!! route('jobs.dashboard') !!}" class="btn btn-greenish btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                     </div>
                  </div>
               </div>
            </div>
         @endif

         <!--- Asset Management -->
         @if(Wingu::check_business_modules('asset-management') == 1)
            @php
               $module = Wingu::modules('asset-management');
            @endphp
            @if($module->status == 15)
               <div class="col-md-3 mb-3">
                  <div class="pink-border">
                     <div class="panel-body">
                        <div class="text-center">
                           <h2 class="m-b-xs">{!! $module->name !!}</h2>
                           <p class="font-bold text-pink">{!! $module->caption !!}</p>
                           <div class="mb-2"><div class="mb-2">{!! $module->icon !!}</div></div>
                           <p class="small">{!! $module->introduction !!}</p>
                           <a href="{!! route('assets.dashboard') !!}" class="btn btn-pink btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                        </div>
                     </div>
                  </div>
               </div>
            @endif
         @endif

         <!--- e-commerce -->
         @if(Wingu::check_business_modules('wingustore') == 1)
            @php
               $module = Wingu::modules('wingustore');
            @endphp
            @if($module->status == 15)
               <div class="col-md-3 mb-3">
                  <div class="border-color-1">
                     <div class="panel-body">
                        <div class="text-center">
                           <h2 class="m-b-xs">{!! $module->name !!}</h2>
                           <p class="font-bold text-color-1">{!! $module->caption !!}</p>
                           <div class="mb-2"><div class="mb-2">{!! $module->icon !!}</div></div>
                           <p class="small">{!! $module->introduction !!}</p>
                           <a href="{!! route('ecommerce.dashboard') !!}" class="btn btn-color-1 btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                        </div>
                     </div>
                  </div>
               </div>
            @endif
         @endif

         <!--- POS -->
         @if(Wingu::check_business_modules('point-of-sale') == 1)
            @php
               $module = Wingu::modules('point-of-sale');
            @endphp
            @if($module->status == 15)
               <div class="col-md-3 mb-3">
                  <div class="border-color-b2">
                     <div class="panel-body">
                        <div class="text-center">
                           <h2 class="m-b-xs">{!! $module->name !!}</h2>
                           <p class="font-bold text-color-2">{!! $module->caption !!}</p>
                           <div class="mb-2"><div class="mb-2">{!! $module->icon !!}</div></div>
                           <p class="small">{!! $module->introduction !!}</p>
                           <a href="{!! route('pos.dashboard') !!}" class="btn btn-color-2 btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                        </div>
                     </div>
                  </div>
               </div>
            @endif
         @endif

         @if(Wingu::business()->id == 1)
            <!--- Subscription -->
            @if(Wingu::check_business_modules('subscription') == 1)
               @php
                  $module = Wingu::modules('subscription');
               @endphp
               @if($module->status == 15)
                  <div class="col-md-3 mb-3">
                     <div class="border-color-4">
                        <div class="panel-body">
                           <div class="text-center">
                              <h2 class="m-b-xs">{!! $module->name !!}</h2>
                              <p class="font-bold text-color-4">{!! $module->caption !!}</p>
                              <div class="mb-2"><div class="mb-2">{!! $module->icon !!}</div></div>
                              <p class="small">{!! $module->introduction !!}</p>
                              <a href="{!! route('subscriptions.dashboard') !!}" class="btn btn-color-4 btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                           </div>
                        </div>
                     </div>
                  </div>
               @endif
            @endif

            <!--- Sales Flow -->
            @if(Wingu::check_business_modules('salesflow') == 1)
               @if(Wingu::check_modules('salesflow') == 1)
                  @php
                     $module = Wingu::modules('salesflow');
                  @endphp
                  @if($module->status == 15)
                     <div class="col-md-3 mb-3">
                        <div class="orangeish-border">
                           <div class="panel-body">
                              <div class="text-center">
                                 <h2 class="m-b-xs">{!! $module->name !!}</h2>
                                 <p class="font-bold text-orangeish">{!! $module->caption !!}</p>
                                 <div class="mb-2"><div class="mb-2">{!! $module->icon !!}</div></div>
                                 <p class="small">{!! $module->introduction !!}</p>
                                 <a href="{!! route('salesflow.dashboard') !!}" class="btn btn-orangeish btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  @endif
               @endif
            @endif

            <!--- Sacco operations -->
            @if(Wingu::check_modules('sacco-operations') == 1)
               @php
                  $module = Wingu::modules('sacco-operations');
               @endphp
               @if($module->status == 15)
                  <div class="col-md-3 mb-3">
                     <div class="border-color-1">
                        <div class="panel-body">
                           <div class="text-center">
                              <h2 class="m-b-xs">{!! $module->name !!}</h2>
                              <p class="font-bold text-color-4">{!! $module->caption !!}</p>
                              <div class="mb-2"><div class="mb-2">{!! $module->icon !!}</div></div>
                              <p class="small">{!! $module->introduction !!}</p>
                              <a href="#" class="btn btn-color-1 btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                           </div>
                        </div>
                     </div>
                  </div>
               @endif
            @endif

            <!--- Property Wingu -->
            @if(Wingu::check_modules('property-wingu') == 1)
               @php
                  $module = Wingu::modules('property-wingu');
               @endphp
               @if($module->status == 15)
                  <div class="col-md-3 mb-3">
                     <div class="border-color-1">
                        <div class="panel-body">
                           <div class="text-center">
                              <h2 class="m-b-xs">{!! $module->name !!}</h2>
                              <p class="font-bold text-color-4">{!! $module->caption !!}</p>
                              <div class="mb-2"><div class="mb-2">{!! $module->icon !!}</div></div>
                              <p class="small">{!! $module->introduction !!}</p>
                              <a href="{!! route('propertywingu.dashboard') !!}" class="btn btn-color-1 btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                           </div>
                        </div>
                     </div>
                  </div>
               @endif
            @endif

            <!--- wingu crowd -->
            @if(Wingu::check_modules('event-management') == 1)
               @php
                  $module = Wingu::modules('event-management');
               @endphp
               @if($module->status == 15)
                  <div class="col-md-3 mb-3">
                     <div class="border-color-1">
                        <div class="panel-body">
                           <div class="text-center">
                              <h2 class="m-b-xs">{!! $module->name !!}</h2>
                              <p class="font-bold text-color-4">{!! $module->caption !!}</p>
                              <div class="mb-2"><div class="mb-2">{!! $module->icon !!}</div></div>
                              <p class="small">{!! $module->introduction !!}</p>
                              <a href="{!! route('events.manager.dashboard') !!}" class="btn btn-color-1 btn-sm text-white"><i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter</a>
                           </div>
                        </div>
                     </div>
                  </div>
               @endif
            @endif
         @endif

         <!--- settings -->
         @if(Wingu::check_if_user_has_role(Auth::user()->user_code,'admin'))
            <div class="col-md-3">
               <div class="yellow-border">
                  <div class="panel-body">
                     <div class="text-center">
                        <h2 class="m-b-xs">Settings</h2>
                        <p class="font-bold text-yellow">All Configurations</p>
                        <div class="mb-2">
                           <i class="fal fa-tools fa-5x"></i>
                        </div>
                        <p class="small">
                           User roles,user management,payment integration,Telephony integration,business profile
                        </p>
                        <a href="{!! route('settings.index') !!}" class="btn btn-yellow btn-sm">
                           <i aria-hidden="true" class="fas fa-sign-in-alt"></i> Enter
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         @endif
      </div>
   </div>
@endsection
