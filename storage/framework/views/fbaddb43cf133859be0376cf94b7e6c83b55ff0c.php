<?php $__env->startSection('title','All Orders | eCommerce'); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.ecommerce.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('ecommerce.dashboard'); ?>">E-commerce</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('ecommerce.orders.index'); ?>">Orders</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> All Orders</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="10%">Order #</th>
                     <th>Title </th>
                     <th>Customer</th>
                     <th>Balance</th>
                     <th>Order Date</th>
                     <th>Status</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
						<?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr role="row" class="odd">
                        <td><?php echo e($crt+1); ?></td>
                        <td>
                           <?php if($v->invoice_prefix == ""): ?><?php echo e($v->prefix); ?><?php else: ?><?php echo e($v->invoice_prefix); ?><?php endif; ?><?php echo e($v->invoice_number); ?>

                        </td>
                        <td><?php echo $v->invoice_title; ?> </td>
                        <td>
							      <?php echo $v->customer_name; ?>

                        </td>
                        <td>
                           <b class="text-primary"><?php echo $v->currency; ?><?php echo e(number_format(round($v->total))); ?></b>
                        </td>
                        <td><?php if($v->invoice_date != ""): ?><?php echo date('M j, Y',strtotime($v->invoice_date)); ?><?php endif; ?></td>
                        <?php if((int)$v->total - (int)$v->paid < 0): ?>
                           <td><span class="badge <?php echo $v->statusName; ?>"><?php echo ucfirst($v->statusName); ?></span></td>
                        <?php else: ?>
                           <td>
                              <span class="badge <?php echo Helper::seoUrl($v->statusName); ?>"><?php echo ucfirst($v->statusName); ?></span>
                           </td>
                        <?php endif; ?>
                        <td>
                           <a href="<?php echo e(route('ecommerce.orders.show', $v->invoice_code)); ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                           <a href="<?php echo route('ecommerce.orders.delete', $v->invoice_code); ?>" class="delete btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/ecommerce/orders/index.blade.php ENDPATH**/ ?>