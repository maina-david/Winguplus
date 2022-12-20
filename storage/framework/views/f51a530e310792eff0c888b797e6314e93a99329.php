<?php $__env->startSection('title','Payment Gateways | Settings'); ?>

<?php $__env->startSection('stylesheet'); ?>
   <style>
      .select2-container {
         z-index: 9999 !important;
      }
   </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <a href="#" class="btn btn-pink" data-toggle="modal" data-target=".gateway"><i class="fas fa-plus-circle"></i> Add Payment Integration</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> Payment Gateways </h1>
      <!-- begin row -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php $__currentLoopData = $businessIntegrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $connection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 col-sm-6 col-xs-12">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <a href="#">
                        <center>
                           <img alt="<?php echo $connection->gateway_name; ?>" src="<?php echo asset('assets/img/gateways/'.$connection->logo); ?>" class="img-responsive payment-logo">
                        </center>
                     </a>
                  </div>
                  <div class="panel-body">
                     <h3 class="text-center"><?php echo $connection->integration_name; ?>.</h3>
                     <?php if($connection->integration_code == 'pesapal'): ?>
                        <a href="<?php echo route('settings.integrations.payments.pesapal.edit',$connection->integration_code); ?>" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit details</a>
                     <?php endif; ?>
                     <?php if($connection->integration_code == 'paypal'): ?>
                        <a href="<?php echo route('settings.integrations.payments.paypal.edit',$connection->integration_code); ?>" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit details</a>
                     <?php endif; ?>
                     <?php if($connection->integration_code == 'mpesadaraja'): ?>
                        <a href="<?php echo route('settings.integrations.payments.mpesa.edit',$connection->integration_code); ?>" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit details</a>
                     <?php endif; ?>
                     
                     <?php if($connection->integration_code == 'mpesaphonenumber'): ?>
                        <a href="<?php echo route('settings.payments.integrations.mpesa.phonenumber',$connection->integration_code); ?>" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit </a>
                     <?php endif; ?>

                     
                     <?php if($connection->integration_code == 'mpesatillnumber'): ?>
                        <a href="<?php echo route('settings.payments.integrations.mpesa.tillnumber',$connection->integration_code); ?>" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit </a>
                     <?php endif; ?>

                     
                     <?php if($connection->integration_code == 'mpesapaybill'): ?>
                        <a href="<?php echo route('settings.payments.integrations.mpesa.paybillnumber',$connection->integration_code); ?>" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit </a>
                     <?php endif; ?>

                     
                     <?php if($connection->integration_code == 'kepler9'): ?>
                        <a href="<?php echo route('settings.payments.integrations.kepler9',$connection->integration_code); ?>" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit </a>
                     <?php endif; ?>

                     
                     <?php if($connection->integration_code == 'ipay'): ?>
                        <a href="<?php echo route('settings.payments.integrations.ipay',$connection->integration_code); ?>" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit </a>
                     <?php endif; ?>
                     <div class="btn-group float-right mt-3" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                           <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <?php echo $connection->statusName; ?>

                           </button>
                           <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                              <?php if($connection->paymentStatus != 15): ?>
                                <a class="dropdown-item" href="<?php echo route('settings.integrations.payments.status',[$connection->integration_code,15]); ?>">Active</a>
                              <?php endif; ?>
                              <?php if($connection->paymentStatus != 22): ?>
                                 <a class="dropdown-item" href="<?php echo route('settings.integrations.payments.status',[$connection->integration_code,22]); ?>">Close</a>
                              <?php endif; ?>
                              <a class="dropdown-item delete" href="<?php echo route('settings.integrations.payments.delete',$connection->integration_code); ?>">Delete</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
   </div>

   <!-- Modal -->
   <form action="<?php echo route('settings.integrations.payments.store'); ?>" method="post">
      <div class="modal fade gateway" tabindex="-1" role="dialog" aria-labelledby="gatewayTitle" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Payment Gateways</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="form-group form-group-default">
                     <label for="">Choose Payment Integration</label>
                     <?php echo Form::select('integration',$integrations, null,['class' => 'form-control select2'] ); ?>

                  </div>
                  <div class="form-group form-group-default">
                     <label for="">Choose status</label>
                     <?php echo Form::select('status',['' => 'Choose status','15' => 'Active', '23' => 'Closed'], null,['class' => 'form-control select2'] ); ?>

                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Integration</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </div>
            </div>
         </div>
      </div>
   </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/settings/integrations/payment/index.blade.php ENDPATH**/ ?>