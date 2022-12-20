<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Purchase Order | <?php echo $details->lpo_prefix; ?><?php echo $details->lpo_number; ?></title>

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
         <div class="col-xs-4">
            <?php if($details->logo != ""): ?>
               <img src="<?php echo asset('businesses/'.$details->business_code.'/documents/images/'.$details->logo); ?>" class="logo" alt="<?php echo $details->businessName; ?>">
            <?php endif; ?>
         </div>
         <div class="col-xs-2"></div>
         <div class="col-xs-6">
            <strong><?php echo $details->business_name; ?></strong>
            <?php if($details->street != ""): ?>
            <br><?php echo $details->street; ?>

            <?php endif; ?>
            <?php if($details->city != ""): ?>
            <br><?php echo $details->city; ?>,
            <?php endif; ?>
            <?php if($details->postal_address != "" ): ?>
            <br><?php echo $details->postal_address; ?>

            <?php endif; ?>
            <?php if($details->postal_address != "" && $details->zip_code != "" ): ?>
                 <?php echo $details->zip_code; ?>

            <?php endif; ?>
            <?php if($details->phone_number != "" ): ?>
            <br><b>Phone:</b> <?php echo $details->phone_number; ?>

            <?php endif; ?>
            <?php if($details->email != "" ): ?>
            <br><b>Email:</b> <?php echo $details->email; ?>

            <?php endif; ?>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
            <h4 style="text-align: center">Purchase Order</h4>
         </div>
      </div>
      <br>
      <div class="row">
         <div class="col-xs-6">
            <address>
               <strong><?php echo $supplier->supplier_name; ?></strong>
               <span><?php if($supplier->bill_state != ""): ?><br><?php echo $supplier->bill_state; ?>,<?php endif; ?></span>
               <span><?php if($supplier->bill_city != ""): ?><br><?php echo $supplier->bill_city; ?>,<?php endif; ?></span>
               <span><?php if($supplier->bill_street != ""): ?><br><?php echo $supplier->bill_street; ?><br><?php endif; ?></span>
               <span>
                  <?php if($supplier->bill_street != ""): ?>
                     <?php echo $supplier->bill_zip_code; ?><br>
                  <?php endif; ?>
                  <?php if($supplier->bill_country != ""): ?>
                     <?php echo Wingu::country($supplier->bill_country)->name; ?><br>
                  <?php endif; ?>
               </span>
               <span><b>Email: </b><?php if($supplier->email != ""): ?><?php echo $supplier->email; ?><?php endif; ?></span>
            </address>
         </div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr>
                     <th><b>Purchase Order #</b></th>
                     <td>: <?php echo $details->lpo_prefix; ?><?php echo $details->lpo_number; ?></td>
                  </tr>
                  <?php if($details->reference_number != ""): ?>
                     <tr>
                        <th><b>Reference #</b></th>
                        <td class="text-uppercase">: <?php echo $details->reference_number; ?></td>
                     </tr>
                  <?php endif; ?>
                  <tr>
                     <th><b>Status</b></th>
                     <td>
                        : <span class="badge <?php echo $details->status_name; ?>"><?php echo $details->status_name; ?></span>
                     </td>
                  </tr>
                  <tr>
                     <th><b>Issue Date</b></th>
                     <td>: <?php echo date('F j, Y',strtotime($details->lpo_date)); ?></td>
                  </tr>
                  <tr>
                     <th>Expected Delivery Date</th>
                     <td>: <?php echo date('F j, Y',strtotime($details->lpo_due)); ?></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <table class="table table-striped table-bordered">
         <thead style="background: #F5F5F5 !important;">
            <tr>
               <th width="1%">#</th>
               <th width="30%">Item</th>
               <th>Quantity</th>
               <th>Price</th>
               <th>Total</th>
            </tr>
         </thead>
         <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr class="item-row">
                  <td align="center"><?php echo e($count+1); ?></td>
                  <td class="description">
                     <?php echo e($product->product_name); ?>

                  </td>
                  <td><?php echo e($product->quantity); ?></td>
                  <td>
                     <?php echo $details->currency; ?><?php echo e(number_format($product->price)); ?>

                  </td>
                  <td>
                     <?php echo $details->currency; ?><?php echo e(number_format($product->total)); ?>

                  </td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
      <div class="row">
         <div class="col-xs-6"></div>
         <div class="col-xs-5">
            <table style="width: 100%">
               <tbody>
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><div>Sub Total </div></th>
                     <td style="padding: 5px" class="text-right"><strong><?php echo $details->code; ?> <?php echo number_format($details->sub_total); ?><strong></td>
                  </tr>
                  <tr class="well" style="padding: 5px">
                     <th style="padding: 5px"><strong>TOTAL </strong></th>
                     <td style="padding: 5px" class="text-right">
                        <strong>
                           <?php echo $details->code; ?> <?php echo number_format($details->total); ?>

                        </strong>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div style="margin-bottom: 0px !important">&nbsp;</div>
      <div class="row">
         <div class="col-md-12 invbody-terms">
            <?php if($details->customer_note != ""): ?>
               <div class="notice">
                  <h4><b>Supplier Note</b></h4>
                  <?php echo $details->customer_note; ?>

               </div>
            <?php endif; ?>
            <?php if($details->terms != ""): ?>
               <div class="notice">
                  <h4><b>Terms & Conditions</b></h4>
                  <?php echo $details->terms; ?>

               </div>
            <?php endif; ?>
            <br><br>
            Thank you for your business.
         </div>
      </div>
   </div>
</body>
</html>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/templates/bootstrap-3/lpo/lpo.blade.php ENDPATH**/ ?>