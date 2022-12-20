<?php $__env->startSection('title'); ?><?php echo $invoice->invoice_prefix; ?><?php echo $invoice->invoice_number; ?> | POS <?php $__env->stopSection(); ?>
<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="row">
      <div class="col-md-4 mb-2">
         <div class="mt-4">
            <h4 class="text-center">Payment Summary</h4>
            <div class="widget-list widget-list-rounded m-b-30" data-id="widget">
               <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <!-- begin widget-list-item -->
                  <div class="widget-list-item mb-2">
                     <div class="widget-list-content">
                        
                        <p class="widget-list-desc">
                           <?php if($payment->amount != ""): ?>
                           Payement date: <b><?php echo date('F jS, Y',strtotime($payment->payment_date)); ?></b><br>
                           <?php endif; ?>
                           <?php if($payment->amount != ""): ?>
                           Amount: <b> <?php echo $invoice->symbol; ?><?php echo number_format($payment->amount); ?></b><br>
                           <?php endif; ?>
                           <?php if($payment->created_by != ""): ?>
                           Recorded by: <b><?php echo Wingu::user($payment->created_by)->name; ?></b>
                           <?php endif; ?>
                        </p>
                     </div>
                     
                  </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         </div>
      </div>
      <div class="col-md-8">
         <div class="row">
            <div class="col-md-12">
                  <button data-toggle="modal" data-target=".bd-example-modal-sm" class="btn btn-sm btn-success m-b-10 p-l-5"> <i class="fal fa-paper-plane t-plus-1 fa-fw fa-lg"></i> Email</button>
               <a href="<?php echo route('pos.sale.receipt.print', $invoice->invoice_code); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
                  <i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
               </a>
               
               
               <a href="#" class="btn btn-pink btn-sm m-b-10 p-l-5" data-toggle="modal" data-target="#payment"><i class="fa fa-plus"></i> Add Payments</a>

            </div>
            <div class="col-md-12">
               <div class="card">
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-6">
                           <h5><b>Customer Name :</b> <?php echo $client->customer_name; ?></h5>
                           
                        </div>
                        <div class="col-md-6">
                           <h5>Order Date : <?php echo date('F jS, Y', strtotime($invoice->invoice_date)); ?></h5>
                        </div>
                        <div class="col-md-12">
                           <hr>
                        </div>
                        <div class="col-md-12">
                           <table class="table  table-striped">
                              <thead>
                                 <th width="1%">#</th>
                                 <th>Product</th>
                                 <th>Qty</th>
                                 <th>Price per Item</th>
                                 <th>Amount</th>
                              </thead>
                              <tbody>
                                 <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                       <td><?php echo $count++; ?></td>
                                       <td><?php echo $product->product_name; ?></td>
                                       <td><?php echo $product->quantity; ?></td>
                                       <td><?php echo $invoice->symbol; ?><?php echo number_format($product->selling_price,2); ?></td>
                                       <td><?php echo $invoice->symbol; ?><?php echo number_format($product->total_amount,2); ?></td>
                                    </tr>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </tbody>
                           </table>
                           <div class="row">
                              <div class="col-md-6 offset-md-6">
                                 <table class="table table-striped">
                                    <tr>
                                       <th>Discount</th>
                                       <th><?php echo $invoice->symbol; ?><?php echo number_format($invoice->discount); ?></th>
                                    </tr>
                                    <tr>
                                       <th>Subtotal</th>
                                       <th><?php echo $invoice->symbol; ?><?php echo number_format($invoice->sub_total); ?></th>
                                    </tr>
                                    <tr>
                                       <th>Tax (<?php echo $invoice->taxRate; ?>%)</th>
                                       <th><?php echo $invoice->symbol; ?><?php echo number_format($invoice->taxvalue); ?></th>
                                    </tr>
                                    <tr>
                                       <th>Total</th>
                                       <th><?php echo $invoice->symbol; ?><?php echo number_format($invoice->total); ?></th>
                                    </tr>
                                    <tr>
                                       <th>Paid</th>
                                       <th><?php echo $invoice->symbol; ?><?php echo number_format($invoice->total); ?></th>
                                    </tr>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-body">
            <form class="" method="POST" action="<?php echo route('pos.sale.receipt.mail'); ?>">
               <?php echo csrf_field(); ?>
               <div class="form-group">
                  <label for="">Enter Email</label>
                  <input type="email" class="form-control" name="email" placeholder="email" required>
                  <input type="hidden" name="saleID" value="<?php echo $invoice->invoice_code; ?>" required>
               </div>
               <div class="form-group">
                  <center>
                     <button class="btn btn-success submit btn-sm" type="submit"><i class="fas fa-save"></i> Send Receipt</button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="35%">
                  </center>
               </div>
            </form>
         </div>
      </div>
   </div>
 </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/sales/sale-details.blade.php ENDPATH**/ ?>