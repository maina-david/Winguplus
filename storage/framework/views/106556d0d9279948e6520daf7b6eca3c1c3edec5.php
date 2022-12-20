<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Aging Report</title>

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
            <h3 class="text-center">Aging Report</h3>
            <h5 class="text-center">As of <?php echo $date; ?></h5>
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
            <?php $__currentLoopData = $ages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                  <td><a href="#"><?php echo $age->customer_name; ?></a></td>
                  <td><?php echo $currency; ?><?php echo number_format($age->age130,2); ?></td>
                  <td><?php echo $currency; ?><?php echo number_format($age->age3160,2); ?></td>
                  <td><?php echo $currency; ?><?php echo number_format($age->age6190,2); ?></td>
                  <td><?php echo $currency; ?><?php echo number_format($age->age91120,2); ?></td>
                  <td><?php echo $currency; ?><?php echo number_format($age->age121150,2); ?></td>
                  <td><?php echo $currency; ?><?php echo number_format($age->age151180,2); ?></td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <th>Total</th>
               <th><?php echo $currency; ?><?php echo number_format($ages->sum('age130'),2); ?></th>
               <th><?php echo $currency; ?><?php echo number_format($ages->sum('age3160'),2); ?></th>
               <th><?php echo $currency; ?><?php echo number_format($ages->sum('age6190'),2); ?></th>
               <th><?php echo $currency; ?><?php echo number_format($ages->sum('age91120'),2); ?></th>
               <th><?php echo $currency; ?><?php echo number_format($ages->sum('age121150'),2); ?></th>
               <th><?php echo $currency; ?><?php echo number_format($ages->sum('age151180'),2); ?></th>
            </tr>
         </tbody>
      </table>
   </div>
</body>
</html>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/templates/bootstrap-3/reports/receivables/aging.blade.php ENDPATH**/ ?>