<div class="row">
   <div class="col-md-4">
      <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
         <tbody>
            <tr>
               <td>Supplier</td>
               <td>
                  <b>
                     <?php if($details->supplier): ?>
                        <?php if(Finance::check_supplier($details->supplier) == 1): ?>
                           <b><?php echo Finance::supplier($details->supplier)->supplier_name; ?></b>
                        <?php endif; ?>
                     <?php endif; ?>
                  </b>
               </td>
            </tr>
            <tr>
               <td>Depreciable assets</td>
               <td>
                  <b><?php echo $details->depreciable_assets; ?></b>
               </td>
            </tr>
            <tr>
               <td>Purchase date</td>
               <td>
                  <b><?php echo date('F jS, Y', strtotime($details->purchase_date)); ?></b>
               </td>
            </tr>
            <tr>
               <td>Order Number</td>
               <td>
                  <b><?php echo $details->order_number; ?></b>
               </td>
            </tr>
            <tr>
               <td>Purchase Cost</td>
               <td>
                  <b><?php echo $details->purches_cost; ?></b>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/assets/assets/finance.blade.php ENDPATH**/ ?>