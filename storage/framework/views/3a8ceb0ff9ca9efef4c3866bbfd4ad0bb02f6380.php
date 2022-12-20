<div class="col-md-12 mt-3">
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-md-4">
               <?php if(Finance::check_product_image($details->productCode) == 1): ?>
                  <img src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/finance/products/'.Finance::product_image($details->productCode)->file_name); ?>" class="img-responsive">
               <?php else: ?>
                  <img src="<?php echo asset('assets/img/product_placeholder.jpg'); ?>" class="img-responsive">
               <?php endif; ?>
            </div>
            <div class="col-md-4">
               <h4>
                  Product Name : <span class="text-primary"><b><?php echo $details->product_name; ?></b></span><br>
                  Item Type : <span class="text-primary"><b><?php echo $details->type; ?></b></span><br>
                  Serial : <span class="text-primary"><b><?php echo $details->sku_code; ?></b></span><br>
                  Created by :
                     <?php if($details->creator != ""): ?>
                        <span class="text-primary"><b><?php echo Wingu::user($details->creator)->name; ?></b></span><br>
                     <?php endif; ?>
                  Supplier :
                     <?php if(Finance::check_supplier($details->supplier) == 1): ?>
                        <span class="text-primary"><b><?php echo Finance::supplier($details->supplier)->supplier_name; ?></b></span>
                     <?php endif; ?><br>
                  Brand :
                     <?php if($details->brand): ?>
                        <span class="text-primary"><b><?php echo $details->brand; ?></b></span>
                     <?php endif; ?><br>
               </h4>
               <hr>
               <h4>
                  Buying Price : <span class="text-primary"><b><?php echo $details->code; ?> <?php echo number_format($details->buying_price); ?></b></span><br>
                  Selling Price : <span class="text-primary"><b><?php echo $details->code; ?> <?php echo number_format($details->selling_price); ?></b></span><br>
               </h4>
               <hr>
               <h4>
                  Category<br>
                  <?php $__currentLoopData = Finance::get_products_categories($details->productCode); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <span class="badge badge-primary"><?php echo $category->name; ?></span>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </h4>
            </div>
            <?php if( $details->type != 'service'): ?>
               <div class="col-md-4">
                  <h4>
                     Current Stock  : <span class="text-primary"><b><?php echo $details->current_stock; ?></b></span><br>
                     Available for Sale : <span class="text-primary"><b><?php echo $details->current_stock; ?></b></span><br>
                     Reorder Point : <span class="text-primary"><b><?php echo $details->reorder_level; ?></b></span><br>
                     Replenish level : <span class="text-primary"><b><?php echo $details->replenish_level; ?></b></span><br>
                     Expiration date : <?php if($details->expiration_date != ""): ?><span class="text-primary"><b><?php echo date('F jS, Y', strtotime($details->expiration_date)); ?></b></span><?php endif; ?><br>
                  </h4>
               </div>
            <?php endif; ?>
         </div>

      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/products/details/overview.blade.php ENDPATH**/ ?>