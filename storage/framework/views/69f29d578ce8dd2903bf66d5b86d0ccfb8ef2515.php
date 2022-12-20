<div class="panel panel-default">
   <div class="panel-body">
      <div class="row mb-3">
         <div class="col-md-10">
            <label for="">Search</label>
            <input type="text" class="form-control" wire:model="search" placeholder="Search by supplier name">
         </div>
         <div class="col-md-2">
            <label for="">Per Page</label>
            <select wire:model="perPage" class="form-control">
               <option value="25" selected>25</option>
               <option value="50">50</option>
               <option value="75">75</option>
               <option value="100">100</option>
            </select>
         </div>
      </div>
      <table class="table table-striped table-bordered">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th width="5">Image</th>
               <th>Name</th>
               <th>Email</th>
               <th>Phone number</th>
               <th>Date Added</th>
               <th width="8%">Action</th>
            </tr>
         </thead>
         <tbody>
            <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php if($supplier->business_code == Auth::user()->business_code): ?>
                  <tr >
                     <td><?php echo $count+1; ?></td>
                     <td>
                        <?php if($supplier->image == ""): ?>
                           <img src="https://ui-avatars.com/api/?name=<?php echo $supplier->supplier_name; ?>&rounded=true&size=32"  class="img-circle"  alt="<?php echo $supplier->supplier_name; ?>" width="40" height="40">
                        <?php else: ?>
                           <img width="40" height="40" alt="" class="img-circle" src="<?php echo asset('businesses/'.$supplier->business_code.'/suppliers/'.$supplier->supplierCode.'/images/'.$supplier->image); ?>">
                        <?php endif; ?>
                     </td>
                     <td><?php echo $supplier->supplier_name; ?></td>
                     <td><?php echo $supplier->email; ?></td>
                     <td><?php echo $supplier->primary_phone_number; ?></td>
                     <td><?php echo date('d F, Y', strtotime($supplier->created_at)); ?></td>
                     <td>
                        <div class="btn-group">
                           <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                           <ul class="dropdown-menu">
                              
                              <li><a href="<?php echo e(route('finance.supplier.edit', $supplier->supplierCode)); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                              <li><a href="<?php echo route('finance.supplier.delete', $supplier->supplierCode); ?>" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                           </ul>
                        </div>
                     </td>
                  </tr>
               <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
      <?php echo $suppliers->links(); ?>

   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/finance/suppliers/suppliers.blade.php ENDPATH**/ ?>