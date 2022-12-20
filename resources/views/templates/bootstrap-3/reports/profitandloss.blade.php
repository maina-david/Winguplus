<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Profit and Loss</title>

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
            <h4 class="text-center">Profit and Loss</h4>
            <h5 class="text-center">From {!! date('F jS, Y', strtotime($from)) !!} To {!! date('F jS, Y', strtotime($to)) !!}</h5>
         </div>
      </div>
      <table class="table zi-table financial-comparison table-no-border">
         <thead>
            <tr class="rep-fin-th">
            <th class="text-left"><h3>Account</h3></th>
            <th class="text-right"><h3>Total</h3></th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td class="table-bg" colspan="2"><h4><b>Income</b></h4></td>
            </tr>
            @foreach($incomeCategories as $category)
               @if(Finance::check_invoice_in_category_by_period($category->category_code,$from,$to) != 0)
                  @foreach(Finance::invoices_per_income_category($category->category_code,$from,$to) as $xx)
                     <tr class=" balance-tr">
                        <td>{!! $category->name !!}</td>
                        <td class="text-right font-italics">{!! $business->currency !!}{!! number_format(Finance::invoices_per_income_category_sum($category->category_code,$from,$to),2) !!}</td>
                     </tr>
                  @endforeach
               @endif
            @endforeach
            @foreach($defaultCategories as $default)
               @if(Finance::check_invoice_in_category_by_period($default->category_code,$from,$to) != 0)
                  @foreach(Finance::invoices_per_income_category($default->category_code,$from,$to) as $xx)
                     <tr class=" balance-tr">
                        <td>{!! $default->name !!}</td>
                        <td class="text-right font-italics">{!! $business->currency !!}{!! number_format(Finance::invoices_per_income_category_sum($default->category_code,$from,$to),2) !!}</td>
                     </tr>
                  @endforeach
               @endif
            @endforeach
            @if($unCategorisedInvoicesCount != 0)
               <tr class=" balance-tr">
                  <td>Others</td>
                  <td class="text-right font-italics">{!! $business->currency !!}{!! number_format($unCategorisedInvoicesSum + $unCategorisedInvoicesSum2,2) !!}</td>
               </tr>
            @endif
            <tr>
               <td><b>Total Income</b></td>
               <td class="text-right font-italics"><b>{!! $business->currency !!}{!! number_format($income,2) !!}</b></td>
            </tr>
            <tr>
               <td class="table-bg" colspan="2"><h4><b>Operating Expenses</b></h4></td>
            </tr>
            @foreach($expenseCategory as $expCat)
               @if(Finance::check_expense_per_category_by_period($expCat->category_code,$from,$to) != 0)
                  @foreach(Finance::expense_per_category($expCat->category_code,$from,$to) as $x)
                     <tr class=" balance-tr">
                        <td>{!! $expCat->name !!}</td>
                        <td class="text-right font-italics">{!! $business->currency !!}{!! number_format(Finance::expense_per_category_sum($expCat->category_code,$from,$to),2) !!}</td>
                     </tr>
                  @endforeach
               @endif
            @endforeach
            <tr>
               <td><b>Total Expenses</b></td>
               <td class="text-right font-italics"><b>{!! $business->currency !!}{!! number_format($expense,2) !!}</b></td>
            </tr>
            <tr>
               <td class="table-bg"><h4><b>Net Profit</b></h4></td>
               <td class="table-bg text-right"><h4 class="text-pink font-italics"><b>{!! $business->currency !!}{!! number_format($income - $expense,2) !!}</b></h4></td>
            </tr>
         </tbody>
      </table>
   </div>
</body>
</html>
