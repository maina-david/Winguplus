<?php $__env->startSection('stylesheets'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title','Order Assign'); ?>


<?php $__env->startSection('content'); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Order Details | Assign Order</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Orders</a></li>
                     <li class="breadcrumb-item active"><?php echo $order->order_code; ?></li>
                     <li class="breadcrumb-item active">Assign Order</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <form class="row" action="<?php echo route('order.create.delivery'); ?>" method="POST" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="order_code" value="<?php echo $order->order_code; ?>">
      <input type="hidden" name="customer" value="<?php echo $order->customerID; ?>">
      <div class="col-md-8">
         <div class="card">
            <div class="card-body">
               <h4>Assign Order To User</h4>
               <hr>
               <div class="row">
                  <div class="form-group col-md-6">
                     <label for="">Choose User</label>
                     <select name="user" class="form-control" required>
                        <option value="">Choose User</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo $user->user_code; ?>"><?php echo $user->name; ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </select>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="">Assign Stock From</label>
                     <select name="warehouse" class="form-control" required>
                        <option value="">Choose warehouse</option>
                        <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo $warehouse->warehouse_code; ?>"><?php echo $warehouse->name; ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </select>
                  </div>
               </div>
            </div>
         </div>
         <div class="card mt-2">
            <div class="card-body">
               <h4>Assign Items</h4>
               <hr>
               <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <input type="hidden" name="item_code[]" value="<?php echo $item->productID; ?>">
                  <div class="row mb-1">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="">Product</label>
                           <input type="text" value="<?php echo $item->product_name; ?>" class="form-control" readonly>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="">Quantity</label>
                           <input type="text" value="<?php echo $item->quantity; ?>" class="form-control" readonly>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="">Allocate</label>
                           <input type="text" name="allocate[]" class="form-control" placeholder="max <?php echo $item->quantity; ?>" max="<?php echo $item->quantity; ?>">
                        </div>
                     </div>
                  </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         </div>
         <button class="btn btn-success mt-1" type="submit">Save and Allocate order</button>
      </div>
   </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/orders/allocation.blade.php ENDPATH**/ ?>