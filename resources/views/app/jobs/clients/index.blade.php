@extends('layouts.app')
{{-- page header --}}
@section('title','Jobs Management | Clients')
{{-- dashboad menu --}}
@section('sidebar')
	@include('app.jobs.partials._menu')
@endsection
@section('stylesheet')
   <style>
      .img_div_modal {
         padding-right: 5px;
         padding-left: 5px;
      }
      .staffinfo-box {
         box-sizing: border-box;
         position: relative;
         overflow: hidden;
         border: 1px solid #e4e4e4;
         width: 100%;
         box-shadow: 0 1px 1px rgb(0 0 0 / 10%);
         border-radius: 2px;
         margin-bottom: 15px;
         background: #fff;
      }
      .staffleft-box {
         float: left;
         padding-right: 10px;
      }
      .staffleft-box img {
         width: 100px;
         height: 100px;
         position: relative;
         z-index: 1;
         background: #fff;
      }
      .staffinfo-box img, .fadeoverlay img {
         display: block;
         width: 100%;
      }
      .staffleft-content {
         overflow: hidden;
      }
      .staffinfo-box h5 {
         display: block;
         margin-bottom: 5px;
         margin-top: 5px;
         font-size: 14px;
      }
      .staffinfo-box p {
         margin-bottom: 1px;
         display: block;
         font-size: 13px;
         line-height: normal;
      }
      .staffsub {
         padding-top: 4px;
         display: inline-block;
      }
      .staffinfo-box p span {
         background-color: #e2e2e2;
         border: 1px solid #c3c3c3;
         border-radius: 2px;
         padding: 2 px 3px;
         text-align: center;
         color: #424242;
         line-height: 18px;
      }
      .staffinfo-box:hover .overlay3, .fadeoverlay:hover .overlay3 {
         opacity: 1;
      }
      .overlay3 {
         position: absolute;
         top: 0;
         bottom: 0;
         left: 0;
         right: 0;
         height: 101%;
         width: 100%;
         opacity: 0;
         transition: .5s ease;
         background-color: rgba(0, 0, 0, 0.69);
         -webkit-transition: all 0.4s ease-in-out 0s;
         -moz-transition: all 0.4s ease-in-out 0s;
         transition: all 0.4s ease-in-out 0s;
         border-radius: 4px;
         border: 0px solid rgba(0, 0, 0, 0.69);
      }
      .stafficons {
         display: block;
         text-align: center;
         padding-left: 100px;
      }
      .stafficons a {
         display: inline-block;
         text-align: center;
         color: #fff;
         font-size: 30px;
         padding-right: 8px;
         padding-left: 8px;
         line-height: 100px;
      }
   </style>
@endsection
{{-- content section --}}
@section('content')
   <div id="content" class="content">
      @livewire('jobs.clients')
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#customerModal').modal('hide');
         $('#delete').modal('hide');
      });
   </script>
@endsection
