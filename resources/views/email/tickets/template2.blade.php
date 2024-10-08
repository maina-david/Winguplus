<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Document</title>
   <style>
      @import url("https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700");
      * { box-sizing: border-box;}
      html, body {
         height: 100%;
         margin: 0;
      }

      body {
         font-family: "Ubuntu", sans-serif;
         background-color: #3f32e5;
         height: 100%;
         -webkit-font-smoothing: antialiased;
         -moz-osx-font-smoothing: grayscale;
         text-align: center;
         color: #1c1c1c;
         display: flex;
         justify-content: center;
      }

      .ticket-system {
         max-width: 385px;
      }

      .top {
         display: flex;
         align-items: center;
         flex-direction: column;
      }

      .title {
         font-weight: normal;
         font-size: 1.6em;
         text-align: left;
         margin-left: 20px;
         margin-bottom: 50px;
         color: #fff;
      }

      .printer {
         width: 90%;
         height: 20px;
         border: 5px solid #fff;
         border-radius: 10px;
         box-shadow: 1px 3px 3px 0px rgba(0, 0, 0, 0.2);
      }

      .receipts-wrapper {
         overflow: hidden;
         margin-top: -10px;
         padding-bottom: 10px;
      }

      .receipts {
         width: 100%;
         display: flex;
         align-items: center;
         flex-direction: column;
         transform: translateY(-510px);
         animation-duration: 2.5s;
         animation-delay: 500ms;
         animation-name: print;
         animation-fill-mode: forwards;
      }
      .receipt {
         padding: 25px 30px;
         text-align: left;
         min-height: 200px;
         width: 88%;
         background-color: #fff;
         border-radius: 10px 10px 20px 20px;
         box-shadow: 1px 3px 8px 3px rgba(0, 0, 0, 0.2);
      }
      .airliner-logo {
        max-width: 80px;
      }

      .route {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 30px 0;


      }

      .plane-icon {
         width: 30px;
         height: 30px;
         transform: rotate(90deg);
      }
      h2 {
         font-weight: 300;
         font-size: 2.2em;
         margin: 0;
      }

      .details {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        }

      .item {
          display: flex;
          flex-direction: column;
          min-width: 70px;
      }

      span {
      font-size: 0.8em;
      color: rgba(28, 28, 28, 0.7);
      font-weight: 500;
      }
      h3 {
      margin-top: 10px;
      margin-bottom: 25px;
      }

      .qr-code {
        height: 110px;
        min-height: unset;
        position: relative;
        border-radius: 20px 20px 10px 10px;
        display: flex;
        align-items: center;
      }

      .qr-code::before {
         content: "";
         background: linear-gradient(to right, #fff 50%, #3f32e5 50%);
         background-size: 22px 4px, 100% 4px;
         height: 4px;
         width: 90%;
         display: block;
         left: 0;
         right: 0;
         top: -1px;
         position: absolute;
         margin: auto;
      }

      .qr {
         width: 70px;
         height: 70px;
      }

      .description {
         margin-left: 20px;
      }

      h2 {
         margin: 0 0 5px 0;
         font-weight: 500;
      }

      p {
         margin: 0;
         font-weight: 400;
      }

      @keyframes print {
      0% {
         transform: translateY(-510px);
      }
      35% {
         transform: translateY(-395px);
      }
      70% {
         transform: translateY(-140px);
      }
      100% {
         transform: translateY(0);
      }
      }

   </style>
</head>
<body>
   <main class="ticket-system">
      <div class="top">
      <h1 class="title">Wait a second, your ticket is being printed</h1>
      <div class="printer" />
      </div>
      <div class="receipts-wrapper">
         <div class="receipts">
            <div class="receipt">
               <center>
                  @if($event->cover_image)
                     <img src="{!! asset('businesses/'.Wingu::business()->business_code.'/wingucrowd/'.$event->event_code.'/events/images/'.$event->cover_image) !!}" alt="" class="airliner-logo">
                  @else
                     <img src="{!! asset('assets/img/tickeplaceholder.webp') !!}" alt="" class="airliner-logo">
                  @endif
               </center>
               <div class="route">
                  <h2>{!! $event->title !!}</h2>
               </div>
               <div class="details">
                  <div class="item">
                     <span>Sites</span>
                     <h3>{!! $ticket->quantity !!}</h3>
                  </div>
                  <div class="item">
                     <span>Amount.</span>
                     <h3>{!! $ticket->total_amount !!}</h3>
                  </div>
                  <div class="item">
                     <span>Date</span>
                     <h3>{!! date('F jS Y', strtotime($ticket->event_start_date)) !!}</h3>
                  </div>
                  {{-- <div class="item">
                     <span>Gate Closes</span>
                     <h3>15:03</h3>
                  </div> --}}
                  {{-- <div class="item">
                     <span>Luggage</span>
                     <h3>Hand Luggage</h3>
                  </div>
                  <div class="item">
                     <span>Seat</span>
                     <h3>69P</h3>
                  </div> --}}
               </div>
            </div>
            <div class="receipt qr-code">
               {{-- <svg class="qr" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29.938 29.938">
                  <path d="M7.129 15.683h1.427v1.427h1.426v1.426H2.853V17.11h1.426v-2.853h2.853v1.426h-.003zm18.535 12.83h1.424v-1.426h-1.424v1.426zM8.555 15.683h1.426v-1.426H8.555v1.426zm19.957 12.83h1.427v-1.426h-1.427v1.426zm-17.104 1.425h2.85v-1.426h-2.85v1.426zm12.829 0v-1.426H22.81v1.426h1.427zm-5.702 0h1.426v-2.852h-1.426v2.852zM7.129 11.406v1.426h4.277v-1.426H7.129zm-1.424 1.425v-1.426H2.852v2.852h1.426v-1.426h1.427zm4.276-2.852H.002V.001h9.979v9.978zM8.555 1.427H1.426v7.127h7.129V1.427zm-5.703 25.66h4.276V22.81H2.852v4.277zm14.256-1.427v1.427h1.428V25.66h-1.428zM7.129 2.853H2.853v4.275h4.276V2.853zM29.938.001V9.98h-9.979V.001h9.979zm-1.426 1.426h-7.127v7.127h7.127V1.427zM0 19.957h9.98v9.979H0v-9.979zm1.427 8.556h7.129v-7.129H1.427v7.129zm0-17.107H0v7.129h1.427v-7.129zm18.532 7.127v1.424h1.426v-1.424h-1.426zm-4.277 5.703V22.81h-1.425v1.427h-2.85v2.853h2.85v1.426h1.425v-2.853h1.427v-1.426h-1.427v-.001zM11.408 5.704h2.85V4.276h-2.85v1.428zm11.403 11.405h2.854v1.426h1.425v-4.276h-1.425v-2.853h-1.428v4.277h-4.274v1.427h1.426v1.426h1.426V17.11h-.004zm1.426 4.275H22.81v-1.427h-1.426v2.853h-4.276v1.427h2.854v2.853h1.426v1.426h1.426v-2.853h5.701v-1.426h-4.276v-2.853h-.002zm0 0h1.428v-2.851h-1.428v2.851zm-11.405 0v-1.427h1.424v-1.424h1.425v-1.426h1.427v-2.853h4.276v-2.853h-1.426v1.426h-1.426V7.125h-1.426V4.272h1.426V0h-1.426v2.852H15.68V0h-4.276v2.852h1.426V1.426h1.424v2.85h1.426v4.277h1.426v1.426H15.68v2.852h-1.426V9.979H12.83V8.554h-1.426v2.852h1.426v1.426h-1.426v4.278h1.426v-2.853h1.424v2.853H12.83v1.426h-1.426v4.274h2.85v-1.426h-1.422zm15.68 1.426v-1.426h-2.85v1.426h2.85zM27.086 2.853h-4.275v4.275h4.275V2.853zM15.682 21.384h2.854v-1.427h-1.428v-1.424h-1.427v2.851zm2.853-2.851v-1.426h-1.428v1.426h1.428zm8.551-5.702h2.853v-1.426h-2.853v1.426zm1.426 11.405h1.427V22.81h-1.427v1.426zm0-8.553h1.427v-1.426h-1.427v1.426zm-12.83-7.129h-1.425V9.98h1.425V8.554z"/>
               </svg> --}}
               {!! DNS2D::getBarcodeHTML($link, 'QRCODE',2,2) !!}
               <div class="description">
                  <h2>Ticket</h2>
                  <p>Show QR-code when requested</p>
               </div>
            </div>
         </div>
      </div>
   </main>
</body>
</html>
