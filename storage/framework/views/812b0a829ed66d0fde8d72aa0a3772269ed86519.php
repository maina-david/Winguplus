<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Document</title>
   <style>
      @import  url("https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700");
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

      @keyframes  print {
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
                  <?php if($event->cover_image): ?>
                     <img src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/wingucrowd/'.$event->event_code.'/events/images/'.$event->cover_image); ?>" alt="" class="airliner-logo">
                  <?php else: ?>
                     <img src="<?php echo asset('assets/img/tickeplaceholder.webp'); ?>" alt="" class="airliner-logo">
                  <?php endif; ?>
               </center>
               <div class="route">
                  <h2><?php echo $event->title; ?></h2>
               </div>
               <div class="details">
                  <div class="item">
                     <span>Sites</span>
                     <h3><?php echo $ticket->quantity; ?></h3>
                  </div>
                  <div class="item">
                     <span>Amount.</span>
                     <h3><?php echo $ticket->total_amount; ?></h3>
                  </div>
                  <div class="item">
                     <span>Date</span>
                     <h3><?php echo date('F jS Y', strtotime($ticket->event_start_date)); ?></h3>
                  </div>
                  
                  
               </div>
            </div>
            <div class="receipt qr-code">
               
               <?php echo DNS2D::getBarcodeHTML($link, 'QRCODE',2,2); ?>

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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/email/tickets/template2.blade.php ENDPATH**/ ?>