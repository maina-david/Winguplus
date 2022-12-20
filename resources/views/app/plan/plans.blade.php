@extends('layouts.app')
@section('title') Plans @endsection
@section('url'){!! route('home.page') !!}@endsection
@section('stylesheet')
   <style>
      .section-container{
         min-height: 350px
      }
      .section-container-plain{
         background-image: none;
      }

      .icon-shape {
         display: -webkit-inline-box;
         display: inline-flex;
         -webkit-box-align: center;
         align-items: center;
         -webkit-box-pack: center;
         justify-content: center;
         text-align: center;
         vertical-align: middle;
      }

      .icon-xs {
         height: 20px;
         width: 20px;
         line-height: 20px;
      }
      .mr-2, .mx-2 {
         margin-right: .5rem!important;
      }

      .rounded-circle {
         border-radius: 50%!important;
      }
      .bg-lightpalegreen {
         background-color: #e4ffcf!important;
      }

      .bg-lightpeach {
         background-color: #ffd7de!important;
      }
   </style>
@endsection
@section('content')
   {{-- <div class="section-container head-section mb-5 bg-white">
      <div class="pageheader bg-shape mt-5">
         <div class="container">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="page-caption mt-5">
                     <div class="page-caption-para-text text-center mt-5">
                        <h2 class="mb-2"><i class="fal fa-credit-card-front fa-3x"></i></h2>
                        <h1>Upgrade today and get more!</h1>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div> --}}
   <div class="section-container-plain head-section mb-5 mt-5">
      <div class="container">
         @include('partials._messages')
         <div class="row justify-content-center">
            <div class="col-md-12 mb-5">
               <h2 class="text-center"><b>Pick a plan that’s as unique as your business.</b></h2>
            </div>
            @foreach(Wingu::get_all_plan() as $plan)
               <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                  <!--  pricing block start -->
                  <div class="card card-body" style="min-height: 350px">
                     <div class="mb-3 text-center">
                        <h3 class="font-14 textspace-lg font-weight-bold text-info mb-3">{!! $plan->title !!}</h3>
                        <h4 class="font-weight-bold text-dark">${!! number_format($plan->usd) !!}/month.</h4>
                     </div>
                     <div class="d-flex mb-2">
                        {!! $plan->features !!}
                     </div>
                  </div>
                  <div class="card-footer">
                     <form method="POST" action="{{ route('wingu.application.flutterwave.pay') }}" id="paymentForm">
                        {{ csrf_field() }}
                        <input type="hidden" name="planCode" value="{!! $plan->plan_code !!}" class="form-control">
                        <center><button type="submit" class="btn btn-success btn-block"><i class="fas fa-credit-card"></i> Checkout</button></center>
                     </form>
                  </div>
               </div>
            @endforeach
         </div>
      </div>
   </div>
@endsection
