<?php $__env->startSection('title','Subscription Product'); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.subscriptions.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('subscriptions.dashboard'); ?>">Subscriptions</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('subscriptions.products.index'); ?>">Products</a></li>
         <li class="breadcrumb-item active">List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shopping-basket"></i> Products</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
		<div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">Product list</h4>
         </div>
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="15%">Name</th>
                     <th width="15%">Code</th>
                     <th width="15%">Notification Address</th>
                     <th>Plans</th>
                     
                     <th width="12%">Created at</th>
                     <th width="20%">Actions</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $product->product_name; ?></td>
                        <td><?php echo $product->sku_code; ?></td>
                        <td><?php echo $product->notification_email; ?></td>
                        <td><?php echo Subscription::count_plans_per_product($product->id); ?></td>
                        
                        <td><?php echo date('jS M,Y', strtotime($product->created_at)); ?></td>
                        <td>
                           <?php if (app('laratrust')->isAbleTo('update-subscriptionproducts')) : ?>
                              <a href="<?php echo route('subscriptions.products.edit',$product->id); ?>" class="btn btn-pink btn-sm"><i class="fas fa-edit"></i> Edit</a>
                           <?php endif; // app('laratrust')->permission ?>
                           <?php if (app('laratrust')->isAbleTo('read-subscriptionplan')) : ?>
                              <a href="<?php echo route('subscriptions.plan.index',$product->id); ?>" class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Plans</a>
                           <?php endif; // app('laratrust')->permission ?>
                           <?php if (app('laratrust')->isAbleTo('delete-subscriptionproducts')) : ?>
                              <a href="<?php echo route('subscriptions.products.delete',$product->id); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i> Delete</a>
                           <?php endif; // app('laratrust')->permission ?>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
		</div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/products/index.blade.php ENDPATH**/ ?>