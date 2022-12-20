<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Utility Billing <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

 
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
         <li class="breadcrumb-item"><a href="#">Accounting</a></li>
         <li class="breadcrumb-item active"><a href="#">Utility Billing</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  <?php echo $property->title; ?> | Utility Billing </h1>
         <div class="row">
            <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="col-md-12"> 
               <div class="row mb-3">
                  <span class="col-md-12">
                     <?php if (app('laratrust')->isAbleTo('read-invoice')) : ?>
                        <a href="<?php echo route('property.invoice.print',[$propertyID,$invoice->invoiceID]); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                           <i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
                        </a>
                     <?php endif; // app('laratrust')->permission ?>
                     <?php if (app('laratrust')->isAbleTo('read-invoice')) : ?>
                        <a href="<?php echo route('property.invoice.print',[$propertyID,$invoice->invoiceID]); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                           <i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print
                        </a>
                     <?php endif; // app('laratrust')->permission ?>
                     <a href="<?php echo route('property.utility.compose.mail',[$propertyID,$invoice->invoiceID]); ?>" class="btn btn-sm btn-warning m-b-10 p-l-5">
                        <i class="fal fa-paper-plane"></i> Mail Invoice
                     </a>
                     
                     <?php if($invoice->statusID != 1): ?>
                        <?php if (app('laratrust')->isAbleTo('create-invoice')) : ?>
                           <a href="#" class="btn btn-success btn-sm m-b-10 p-l-5" data-toggle="modal" data-target="#payment"><i class="fa fa-plus"></i> Add Payments</a>
                        <?php endif; // app('laratrust')->permission ?>
                     <?php endif; ?>
                     <a href="<?php echo route('property.invoice.delete',[$propertyID,$invoiceID]); ?>" class="btn btn-sm btn-danger delete m-b-10 p-l-5">
                        <i class="fas fa-trash"></i> Delete
                     </a>
                  </span>
               </div>
               <div class="panel"> 
                  <div class="panel-body">         
                     <?php echo $__env->make('templates.'.$business->template_name.'.utility.preview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  </div>
               </div>
            </div>
            
            <form action="<?php echo route('property.utility.payment',[$propertyID,$invoiceID]); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
               <?php echo csrf_field(); ?>
               <div class="modal fade" id="payment">
                  <div class="modal-dialog modal-lg">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h4 class="modal-title">Record Payment for <?php echo $invoice->invoice_prefix; ?><?php echo $invoice->invoice_number; ?></h4>
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              
                              
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="amount" class="control-label text-danger"> Amount Received </label>
                                    <input type="text" value="<?php echo $invoice->invoice_balance; ?>" name="amount" class="form-control" placeholder="Enter amount" required>
                                    <input type="hidden" name="tenantID" value="<?php echo $tenant->tenantID; ?>" required>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="transactionID" class="control-label"> Transaction ID </label>
                                    <?php echo Form::text('transactionID', null, array('class' => 'form-control','placeholder' => 'Enter Transaction NO')); ?>

                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group required">
                                    <label class="control-label"> Payment Date </label>
                                    <div class="input-group">
                                       <input type="date" name="payment_date" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="amount" class="control-label"> Payment method </label>
                                    <select name="payment_method" class="form-control multiselect">
                                       <option value="">Choose payment method</option>
                                       <?php $__currentLoopData = $mainMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo $main->id; ?>"><?php echo $main->name; ?></option>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <?php $__currentLoopData = $paymentmethod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo $method->id; ?>"><?php echo $method->name; ?></option>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-gruoup">
                                    <label for="note" class="control-label">Leave a note</label>
                                    <?php echo Form::textarea('note', null, array('class' => 'form-control', 'placeholder' => 'Add Note', 'spellcheck' => 'true', 'size' => '5x5')); ?>

                                 </div>
                              </div>
                              
                           </div>
                           <div class="row">
            
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Save</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div> 
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/propertywingu/accounting/utility/show.blade.php ENDPATH**/ ?>