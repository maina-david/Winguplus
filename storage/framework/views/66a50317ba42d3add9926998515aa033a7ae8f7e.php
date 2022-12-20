<div>
   <div class="row mb-3">
      <div class="col-md-9">
         <label for="">Search</label>
         <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Enter Product name or SKU code">
      </div>
      <div class="col-md-3">
         <label for="">Items Per</label>
         <select wire:model="perPage" class="form-control">`
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
         </select>
      </div>
   </div>
   <div class="panel panel-default">
      <div class="panel-body">
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th width="1%">#</th>
                  <th width="5%">Image</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Current Stock</th>
                  <th>Created at</th>
                  <th width="12%">Actions</th>
               </tr>
            </thead>
            <tbody>
               <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                     <td><?php echo $key + 1; ?></td>
                     <td>
                        <center>
                        <?php if(Finance::check_product_image($product->productCode) == 1): ?>
                           <img src="<?php echo asset('businesses/'.Wingu::business()->business_code .'/finance/products/'.Finance::product_image($product->productCode)->file_name); ?>" width="80px" height="60px">
                        <?php else: ?>
                           <img src="<?php echo asset('assets/img/product_placeholder.jpg'); ?>" width="80px" height="60px">
                        <?php endif; ?>
                        </center>
                     </td>
                     <td><?php echo $product->product_name; ?></td>
                     <td>
                        <?php echo $product->symbol; ?><?php echo number_format($product->price); ?>

                     </td>
                     <td>
                        <?php echo $product->stock; ?>

                     </td>
                     <td><?php echo date('F d, Y', strtotime($product->date)); ?></td>
                     <td>
                        
                        <a href="<?php echo e(route('pos.products.edit', $product->productCode)); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="<?php echo route('pos.products.destroy', $product->productCode); ?>" class="btn btn-danger delete btn-sm"><i class="fas fa-trash"></i></a>
                     </td>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
         <?php echo $products->links('pagination.custom'); ?>

      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/pos/products.blade.php ENDPATH**/ ?>