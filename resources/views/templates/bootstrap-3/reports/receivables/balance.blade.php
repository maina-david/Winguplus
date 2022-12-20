<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Customer Balances</title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="{!! asset('assets/templates/bootstrap-3/style.css') !!}" media="all" />

   <style>
      .text-right {
         text-align: right;
      }
   </style>
</head>
<body class="login-page" style="background: white">
   <div>
      <div class="row">
         <div class="col-xs-12">
            <h3 class="text-center">Customer Balances</h3>
            <h5 class="text-center">From {!! date('F jS, Y', strtotime($from)) !!} To {!! date('F jS, Y', strtotime($to)) !!}</h5>
         </div>
      </div>
      <table class="table table-bordered">
         <thead>
            <tr>
               <th>Customer Name</th>
               <th><center>Balance</center></th>
            </tr>
         </thead>
         <tbody>
            <tbody>
               @foreach($balances as $balance)
                  @if($balance->total > 0)
                     <tr>
                        <td><a href="#">{!! $balance->customerName !!}</a></td>
                        <td><center><i><b>{!! $balance->currency !!} {!! number_format($balance->total) !!} </b></i></center></td>
                     </tr>
                  @endif
               @endforeach
               <tr>
                  <td><b>Total</b></td>
                  <td><center><i><b>{!! Wingu::business()->currency !!}{!!  number_format($balances->sum('total')) !!}</b></i></center></td>
               </tr>
            </tbody>
         </tbody>
      </table>
   </div>
</body>
</html>
