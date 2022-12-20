<?php $__env->startSection('title','Subscriptions'); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.subscriptions.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <?php if(Subscription::count_subscriptions() != Wingu::plan()->subscriptions && Subscription::count_subscriptions() < Wingu::plan()->subscriptions): ?>
            <?php if (app('laratrust')->isAbleTo('create-subscription')) : ?>
               <a href="<?php echo route('subscriptions.create'); ?>" class="btn btn-pink float-right mr-2"><i class="fas fa-plus"></i> Add Subscriptions</a>
            <?php endif; // app('laratrust')->permission ?>
         <?php endif; ?>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-sync-alt"></i> Subscriptions</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">All Plans</h4>
               </div>
               <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th> Created</th>
                           <th> Activated</th>
                           <th> Subscription#</th>
                           <th> Customer Name</th>
                           <th> Plan Name</th>
                           <th> Status</th>
                           <th> Amount</th>
                           <th> Last Billed</th>
                           <th> Next Billing</th>
                           <th width="9%">Action</th>
                        </tr>
                     </thead> 
                     <tbody>
                        <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td><?php echo date('d M, Y', strtotime($subscription->created_at)); ?></td>
                              <td>
                                 <?php if($subscription->starts_on != ""): ?><?php echo date('d M, Y', strtotime($subscription->starts_on)); ?><?php endif; ?>
                              </td>
                              <td>
                                 <b><?php echo $subscription->prefix; ?><?php echo $subscription->subscription_number; ?></b>
                              </td>
                              <td><?php echo $subscription->customer_name; ?></td>
                              <td><?php echo $subscription->product_name; ?></td>
                              <td>
                                 <?php if($subscription->statusID != ""): ?>
                                    <span class="badge <?php echo $subscription->statusName; ?>"><?php echo $subscription->statusName; ?></span>
                                 <?php endif; ?>
                              </td>
                              <td>
                                 <b><?php echo $subscription->code; ?> <?php echo number_format($subscription->amount); ?></b>
                              </td>
                              <td>
                                 <?php if($subscription->last_billing): ?>
                                    <?php echo date('d M, Y', strtotime($subscription->last_billing)); ?>

                                 <?php endif; ?>
                              </td>
                              <td>
                                 <?php if($subscription->next_billing != ""): ?>
                                    <?php echo date('d M, Y', strtotime($subscription->next_billing)); ?>

                                 <?php endif; ?>
                              </td>
                              <td>
                                 <?php if (app('laratrust')->isAbleTo('read-subscription')) : ?>
                                    <a href="<?php echo route('subscriptions.show',$subscription->subscriptionID); ?>" class="btn btn-sm btn-pink"><i class="fas fa-eye"></i></a>
                                 <?php endif; // app('laratrust')->permission ?>
                                 <?php if (app('laratrust')->isAbleTo('delete-subscription')) : ?>
                                    <a href="<?php echo route('subscriptions.edit',$subscription->subscriptionID); ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                 <?php endif; // app('laratrust')->permission ?>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/subscriptions/index.blade.php ENDPATH**/ ?>