<?php $__env->startSection('title','Subscription | details'); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.subscriptions.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <?php if(date('Y-m-d') > $subscription->next_billing): ?>
            <a class="btn btn-warning mr-1" href="<?php echo route('subscriptions.renew',$subscription->subscriptionID); ?>"><i class="fal fa-sync-alt"></i> Renew</a>
         <?php endif; ?>
         <a class="btn btn-primary mr-1" href="<?php echo route('subscriptions.edit',$subscription->subscriptionID); ?>"><i class="fas fa-edit"></i> Edit</a>
         <?php if (app('laratrust')->isAbleTo('delete-subscription')) : ?>
            <a class="btn btn-danger delete" href="<?php echo route('subscriptions.delete',$subscription->subscriptionID); ?>"><i class="fas fa-trash"></i> Delete</a>
         <?php endif; // app('laratrust')->permission ?>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-sync-alt"></i> <?php echo $subscription->product_name; ?> (<?php echo $subscription->sku_code; ?>)  <span class="badge <?php echo $subscription->statusName; ?>" style="font-size:8px"><?php echo $subscription->statusName; ?></span></h1>
      <h4><b>#<?php echo $subscription->prefix; ?><?php echo $subscription->subscription_number; ?></b></h4>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-3">
            <div class="card">
               <div class="card-header">
                  Details
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-3">
                        <center>
                           <?php if($customer->image == ""): ?>
                              <img src="https://ui-avatars.com/api/?name=<?php echo $customer->customer_name; ?>&rounded=false&size=40" alt="">
                           <?php else: ?>
                              <img width="40" height="40" alt="" class="img-circle" src="<?php echo asset('businesses/'.$customer->primary_email .'/clients/'.$customer->customer_code.'/images/'.$customer->image); ?>">
                           <?php endif; ?>
                        </center>
                     </div>
                     <div class="col-md-9">
                        <p><a href=""><?php echo $customer->customer_name; ?></a><br><?php echo $customer->email; ?></p>
                     </div>
                  </div>
                  <?php if($checkContactPerson != 0): ?>
                     <div class="row mt-3">
                        <div class="col-md-12">
                           <h5>Contact Person</h5>
                           <hr>
                           <?php $__currentLoopData = $contactPersons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <p><a href=""><?php echo $person->names; ?></a><br><?php echo $person->contact_email; ?><br><?php echo $person->phone_number; ?></p><br><br>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                     </div>
                  <?php endif; ?>
                  <div class="row mt-3">
                     <div class="col-md-12">
                        <h5>Subscriptions</h5>
                        <hr>
                     </div>
                     <div class="col-md-12">
                        <p>
                           Reference # : <span class="text-primary"><?php echo $subscription->reference; ?></span><br>
                           Sales Person : <?php if($subscription->sales_person): ?>
                                             <span class="text-primary">
                                                <?php if(Hr::check_employee($subscription->sales_person != 0)): ?>
                                                   <?php echo Hr::employee($subscription->sales_person)->names; ?>

                                                <?php endif; ?>
                                             </span>
                                          <?php endif; ?><br>
                           Repeat Every : <span class="text-primary"><?php echo $subscription->bill_count; ?> <?php echo $subscription->billing_period; ?>(s)</span><br>
                           Start Date : <span class="text-primary"><?php echo date('jS F, Y', strtotime($subscription->starts_on)); ?></span><br>
                           <?php if($subscription->trial_days != ""): ?>
                              Trial Ends At : <span class="text-primary"><?php echo date('jS F, Y', strtotime($subscription->trial_end_date)); ?></span><br>
                              Trial Remaining day(s) : <span class="text-primary"><?php echo number_format(Helper::date_difference($subscription->trial_end_date,$subscription->starts_on)); ?> day(s)</span><br>
                              Activation Date : <span class="text-primary"><?php echo date('jS F, Y', strtotime($subscription->trial_end_date)); ?></span>
                           <?php endif; ?>
                        </p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-9">
            <ul class="nav nav-tabs">
               <li class="nav-item">
                  <a class="nav-link <?php echo Nav::isRoute('subscriptions.show'); ?>" href="<?php echo route('subscriptions.show',$subscription->subscriptionID); ?>"><i class="fal fa-info-circle"></i> Overview</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link <?php echo Nav::isRoute('subscriptions.invoices'); ?>" href="<?php echo route('subscriptions.invoices',$subscription->subscriptionID); ?>"><i class="fal fa-file-invoice-dollar"></i> Invoice History</a>
               </li>
            </ul>
            <?php if(Request::is('subscriptions/'.$subscription->subscriptionID.'/details')): ?>
               <?php echo $__env->make('app.subscriptions.subscriptions.overview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('subscriptions/'.$subscription->subscriptionID.'/invoices')): ?>
               <?php echo $__env->make('app.subscriptions.subscriptions.invoices', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/subscriptions/show.blade.php ENDPATH**/ ?>