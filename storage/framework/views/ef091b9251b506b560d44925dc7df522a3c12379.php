<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Sales by Customer</title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="<?php echo asset('assets/templates/bootstrap-3/style.css'); ?>" media="all" />

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
            <h3 class="text-center">Sales by Customer</h3>
            <h5 class="text-center">From <?php echo date('F jS, Y', strtotime($from)); ?> To <?php echo date('F jS, Y', strtotime($to)); ?></h5>
         </div>
      </div>
      <table class="table table-bordered">
         <thead>
            <tr>
               <th>Name</th>
               <th><center>Invoice Count</center></th>
               <th align="right"><center>Sales</center></th>
            </tr>
         </thead>
         <tbody>
            <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                  <td><a href="#"><?php echo $sale->customer_name; ?></a></td>
                  <td><center><?php echo Finance::client_total_invoices_report($sale->customer_code,$from,$to); ?></center></td>
                  <td><center><b><i><?php echo $sale->currency; ?><?php echo number_format($sale->total); ?></i></b></center></td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <td><b>Total</b></td>
               <td><center><?php echo $countInvoice; ?></center></td>
               <td><center><b><i><?php echo Wingu::business()->currency; ?><?php echo number_format($sales->sum('total')); ?></i></b></center></td>
            </tr>
         </tbody>
      </table>
   </div>
</body>
</html>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/templates/bootstrap-3/reports/sales/customer.blade.php ENDPATH**/ ?>