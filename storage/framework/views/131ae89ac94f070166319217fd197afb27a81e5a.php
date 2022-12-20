<div class="row">
   <div class="col-md-4">
      <?php if($show->logo != ""): ?>
         <img src="<?php echo asset('businesses/'.$show->business_code.'/documents/images/'.$show->logo); ?>" class="logo" alt="<?php echo $show->businessName; ?>" style="width:70%">
      <?php endif; ?>
   </div>
   <div class="col-md-4">
   </div>
   <div class="col-md-4">
      <p>
         <strong><?php echo $show->businessName; ?></strong>
         <?php if($show->street != ""): ?>
         <br><?php echo $show->street; ?><br>
         <?php endif; ?>
         <?php if($show->city != ""): ?>
         <?php echo $show->city; ?>,
         <?php endif; ?>
         <?php if($show->postal_address != "" ): ?>
         <?php echo $show->postal_address; ?>

         <?php endif; ?>
         <?php if($show->postal_address != "" && $show->zip_code != "" ): ?>
            - <?php echo $show->zip_code; ?>

         <?php endif; ?>
         <br>
         <b>Phone:</b> <?php echo $show->phone_number; ?><br>
         <b>Email:</b> <?php echo $show->business_email; ?>

      </p>
   </div>
</div>
<div class="row">
   <div class="col-md-12 mt-3 mb-3" style="border: 1px solid #ccc!important">
      <h3 style="text-align: center">Credit Note</h3>
   </div>
</div>
<div class="row">
   <div class="col-md-4">
      <address>
         <strong><?php echo $show->customer_name; ?></strong>
         <span><br><?php if($show->bill_state != ""): ?><?php echo $show->bill_state; ?>,<?php endif; ?></span>
         <span><?php if($show->bill_city != ""): ?><?php echo $show->bill_city; ?>,<?php endif; ?></span>
         <span><?php if($show->bill_street != ""): ?><?php echo $show->bill_street; ?><br><?php endif; ?></span>
         <span>
            <?php if($show->bill_street != ""): ?>
               <?php echo $show->bill_zip_code; ?><br>
            <?php endif; ?>
            <?php echo $show->bill_country; ?>

         </span>
         <span><b>Email: </b><?php if($show->customer_email != ""): ?><?php echo $show->customer_email; ?><?php endif; ?></span>
      </address>
   </div>
   <div class="col-md-4"></div>
   <div class="col-md-4">
      <table style="float:left">
         <tbody>
            <tr>
               <th><b>Credit Note Number</b></th>
               <td>: <?php echo $show->prefix; ?><?php echo $show->number; ?></td>
            </tr>
            <?php if($show->reference_number != ""): ?>
               <tr>
                  <th><b>Reference #</b></th>
                  <td class="text-right text-uppercase">: <?php echo $show->reference_number; ?></td>
               </tr>
            <?php endif; ?>
            <tr>
               <th><b>Status</b></th>
               <td>
                  <?php if($show->statusID == 1): ?>
                     <span style="color:green;font-style: normal;font-weight: bolder;">: <?php echo ucfirst($show->name); ?></span>
                  <?php else: ?>
                     <span style="color:blue;font-style: normal;font-weight: bolder;">: <?php echo ucfirst($show->name); ?></span>
                  <?php endif; ?>
               </td>
            </tr>
            <tr>
               <th><b>Issue Date</b></th>
               <td>: <?php echo date('F j, Y',strtotime($show->creditnote_date)); ?></td>
            </tr>
            <tr>
               <th><b>Balance :</b></th>
               <td>: <?php echo $show->currency; ?><?php echo $show->balance; ?></td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<table class="table table-striped table-bordered mt-3">
   <thead>
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
               <?php if(!$product->product_code): ?>
                  <?php echo e($product->product_name); ?>

               <?php else: ?>
                  <?php if(Finance::check_product($product->product_code) == 1 ): ?>
                     <?php echo Finance::product($product->product_code)->product_name; ?>

                  <?php else: ?>
                     <i>Unknown Product</i>
                  <?php endif; ?>
               <?php endif; ?>
            </td>
            <td><?php echo e($product->quantity); ?></td>
            <td>
               <?php echo $show->currency; ?><?php echo e(number_format($product->price)); ?>

            </td>
            <td>
               <?php echo $show->currency; ?><?php echo e(number_format($product->price * $product->quantity)); ?>

            </td>
         </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </tbody>
</table>
<div class="row">
   <div class="col-md-6"></div>
   <div class="col-md-6">
      <table class="table table-striped">
         <tbody>
            <tr>
               <th>Sub Total</th>
               <td><strong>: <?php echo $show->currency; ?><?php echo number_format($show->sub_total); ?> <strong></td>
            </tr>
            <tr>
               <th><strong>Total Amount</strong></th>
               <td>
                  <strong>
                     :  <?php echo $show->currency; ?><?php echo number_format($show->total); ?>

                  </strong>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<div class="row">
   <div class="col-md-12 invbody-terms">
      Thank you for your business.
      <br><br>
      <?php if($show->customer_note != ""): ?>
      <div class="notice">
         <h4><b>Customer Note</b></h4>
         <?php echo $show->customer_note; ?>

      </div>
      <?php endif; ?>
      <?php if($show->terms != ""): ?>
         <div class="notice">
            <h4><b>Terms & Conditions</b></h4>
            <?php echo $show->terms; ?>

         </div>
      <?php endif; ?>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/templates/bootstrap-3/creditnote/preview.blade.php ENDPATH**/ ?>