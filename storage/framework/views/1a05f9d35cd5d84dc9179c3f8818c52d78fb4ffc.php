<?php $__env->startSection('title','Invoices'); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.subscriptions.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('subscriptions.dashboard'); ?>">Subscriptions</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('subscription.invoice.index'); ?>">Invoice</a></li>
         <li class="breadcrumb-item active">List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> Invoices</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Invoice List</h4>
            </div>
            <div class="panel-body">
               <table id="data-table-default" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th width="10%">Invoice #</th>
                        <th>Title </th>
                        <th width="21%">Customer</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th width="10%">Action</th>
                     </tr>
                  </thead>
                  <tfoot>
                     <tr>
                        <th width="1%">#</th>
                        <th width="8%">Invoice #</th>
                        <th>Title </th>
                        <th width="18%">Customer</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th width="10%">Issue Date</th>
                        <th width="10%">Due Date</th>
                        <th>Status</th>
                        <th width="10%">Action</th>
                     </tr>
                  </tfoot>
                  <tbody>
                     <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr role="row" class="odd">
                           <td><?php echo e($crt+1); ?></td>
                           <td>
                              <b><?php echo e($v->prefix); ?><?php echo e($v->invoice_number); ?></b>
                           </td>
                           <td><?php echo $v->invoice_title; ?> </td>
                           <td>
                              <?php echo $v->customer_name; ?>

                           </td>
                           <td><b class="text-info"><?php echo number_format((float)$v->paid); ?> <?php echo $v->symbol; ?></b></td>
                           <td class="v-align-middle">
                              <p>
                                 <?php if( $v->statusID == 1 ): ?>
                                    <span class="badge <?php echo $v->statusName; ?>"><?php echo ucfirst($v->statusName); ?></span>
                                 <?php else: ?>
                                    <b class="text-primary"><?php echo e(number_format(round($v->balance))); ?> <?php echo $v->symbol; ?></b>
                                 <?php endif; ?>
                              </p>
                           </td>
                           <td><p><?php echo date('M j, Y',strtotime($v->invoice_date)); ?></p></td>
                           <td>
                              <?php if($v->invoice_due != ""): ?>
                                 <p><?php echo date('M j, Y',strtotime($v->invoice_due)); ?></p>
                              <?php endif; ?>
                           </td>
                           <?php if((int)$v->total - (int)$v->paid < 0): ?>
                              <td><span class="badge <?php echo $v->statusName; ?>"><?php echo ucfirst($v->statusName); ?></span></td>
                           <?php else: ?>
                               <td>
                                   <span class="badge <?php echo Helper::seoUrl($v->statusName); ?>"><?php echo ucfirst($v->statusName); ?></span>
                               </td>
                           <?php endif; ?>
                           <td>
                              <div class="btn-group">
                                 <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                                 <ul class="dropdown-menu">
                                    <?php if (app('laratrust')->isAbleTo('read-invoice')) : ?>
                                       <li><a href="<?php echo e(route('subscription.invoice.show', $v->invoiceID)); ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                    <?php endif; // app('laratrust')->permission ?>
                                    <?php if (app('laratrust')->isAbleTo('delete-invoice')) : ?>
                                       <li><a href="<?php echo route('finance.invoice.delete', $v->invoiceID); ?>" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
                                    <?php endif; // app('laratrust')->permission ?>
                                 </ul>
                              </div>
                           </td>
                        </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/invoice/index.blade.php ENDPATH**/ ?>