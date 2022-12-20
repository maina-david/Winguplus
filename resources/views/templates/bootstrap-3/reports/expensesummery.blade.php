<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Expense Summary</title>

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
            <h3 class="text-center">{!! $business->name !!}</h3>
            <h4 class="text-center">Expense Summary</h4>
            <h5 class="text-center">From {!! date('F jS, Y', strtotime($from)) !!} To {!! date('F jS, Y', strtotime($to)) !!}</h5>
         </div>
      </div>
      <table class="table zi-table financial-comparison table-no-border">
         <thead>
            <tr class="rep-fin-th">
            <th class="text-left"><h4>Expense</h4></th>
            <th class="text-right"><h4>Total</h4></th>
            </tr>
         </thead>
         <tbody>
            @foreach($expenseCategory as $expCat)
               @if(Finance::check_expense_per_category_by_period($expCat->category_code,$from,$to) != 0)
                  @foreach(Finance::expense_per_category($expCat->category_code,$from,$to) as $x)
                     <tr class=" balance-tr">
                        <td>{!! $expCat->name !!}</td>
                        <td class="text-right font-italics">
                           {!! $business->currency !!} {!! number_format(Finance::expense_per_category_sum($expCat->category_code,$from,$to)) !!}
                        </td>
                     </tr>
                  @endforeach
               @endif
            @endforeach
            <tr>
               <td><b>Total Expenses</b></td>
               <td class="text-right"><b>{!! $business->currency !!}{!! number_format($expense) !!}</b></td>
            </tr>
         </tbody>
      </table>
   </div>
</body>
</html>
