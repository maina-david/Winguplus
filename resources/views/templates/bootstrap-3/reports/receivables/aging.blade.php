<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Aging Report</title>

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
            <h3 class="text-center">Aging Report</h3>
            <h5 class="text-center">As of {!! $date !!}</h5>
         </div>
      </div>
      <table class="table table-striped">
         <thead>
            <tr>
               <th>Customer Name</th>
               <th>Current</th>
               <th>31 - 60 Days</th>
               <th>61 - 90 Days</th>
               <th>91 - 120 Days</th>
               <th>121 - 150 Days</th>
               <th>151 - 180 Days</th>
            </tr>
         </thead>
         <tbody>
            @foreach($ages as $age)
               <tr>
                  <td><a href="#">{!! $age->customer_name !!}</a></td>
                  <td>{!! $currency !!}{!! number_format($age->age130,2) !!}</td>
                  <td>{!! $currency !!}{!! number_format($age->age3160,2) !!}</td>
                  <td>{!! $currency !!}{!! number_format($age->age6190,2) !!}</td>
                  <td>{!! $currency !!}{!! number_format($age->age91120,2) !!}</td>
                  <td>{!! $currency !!}{!! number_format($age->age121150,2) !!}</td>
                  <td>{!! $currency !!}{!! number_format($age->age151180,2) !!}</td>
               </tr>
            @endforeach
            <tr>
               <th>Total</th>
               <th>{!! $currency !!}{!! number_format($ages->sum('age130'),2) !!}</th>
               <th>{!! $currency !!}{!! number_format($ages->sum('age3160'),2) !!}</th>
               <th>{!! $currency !!}{!! number_format($ages->sum('age6190'),2) !!}</th>
               <th>{!! $currency !!}{!! number_format($ages->sum('age91120'),2) !!}</th>
               <th>{!! $currency !!}{!! number_format($ages->sum('age121150'),2) !!}</th>
               <th>{!! $currency !!}{!! number_format($ages->sum('age151180'),2) !!}</th>
            </tr>
         </tbody>
      </table>
   </div>
</body>
</html>
