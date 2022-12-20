<?php $__env->startSection('title','Sale Details'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <style>
      /*  receipt */
      #invoice-POS{
         box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
         padding:20px;
         margin: 0 auto;
         width: 100%;
         background: #FFF;
      }

      #top, #mid,#bot{ /* Targets all id with 'col-' */
        border-bottom: 1px solid #EEE;
      }

      #top{min-height: 100px;}
      #mid{min-height: 80px;}
      #bot{ min-height: 50px;}

      #top .logo{
         height: 60px;
         width: 60px;
         background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
         background-size: 60px 60px;
      }
      .clientlogo{
        float: left;
         height: 60px;
         width: 60px;
         background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
         background-size: 60px 60px;
        border-radius: 50px;
      }
      .info{
        display: block;
        margin-left: 0;
      }
      .title{
        float: right;
      }
      .title p{text-align: right;}
      table{
        width: 100%;
        border-collapse: collapse;
      }
      th.tabletitle{
        background: #EEE;
      }
      .service{border-bottom: 1px solid #EEE;}
      .item{width: 24mm;}
      .itemtext{font-size: .5em;}

      #legalcopy{
        margin-top: 5mm;
      }
   </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('backend.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">POS</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.product.index'); ?>">Sales History</a></li>
         <li class="breadcrumb-item active">Sale View</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Sale View</h1>

      <div class="d-flex justify-content-center">
         <div class="col-md-6"> 
            <div class="card">
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-4">
                        <a href="#" class="btn btn-pink btn-block"><i class="fas fa-undo"></i> Return Items</a>
                     </div>
                     <div class="col-md-4">
                        <a href="<?php echo route('pos.print.receipt',$transaction->id); ?>" class="btn btn-pink btn-block"><i class="fas fa-envelope"></i> Email Receipt</a>
                     </div>
                     <div class="col-md-4">
                        <a href="<?php echo route('pos.print.receipt',$transaction->id); ?>" class="btn btn-pink btn-block"><i class="fas fa-print"></i> Print Receipt</a>
                     </div>
                  </div>
               </div>
            </div>
            <div id="invoice-POS">
               
               <div id="mid" class="text-center mb-3">
                  <div class="info">
                     <h5>
                        <?php echo $business->name; ?></br>
                        <?php echo $business->street; ?>,<?php echo $business->city; ?></br>
                        <?php echo $business->postal_address; ?> - <?php echo $business->zip_code; ?></br>
                        Phone: <?php echo $business->primary_phonenumber; ?></br>
                        Email: <?php echo $business->primary_email; ?>

                     </h5>
                  </div>
               </div>
               <div class="receipt-info mt-3">
                  <p>
                     <b>TransactionID :</b> <span class="text-uppercase"><?php echo $transaction->transactionID; ?></span><br>
                     <b>You were served by :</b> <?php echo Limitless::user($transaction->userID)->name; ?> <br>
                     <b>Date Time : </b> <?php echo date("F j, Y, g:i a", strtotime($transaction->created_at)); ?> </br>
                     <b>Payment method :
                        <?php if(Finance::check_payment($transaction->id) > 0): ?>
                           <?php if(Finance::check_payment_method(Finance::invoice_payment($transaction->id)->payment_method) == 1): ?>
                              <?php echo Finance::payment_method(Finance::invoice_payment($transaction->id)->payment_method)->name; ?>

                           <?php else: ?>
                              <i>Unknown method</i>
                           <?php endif; ?>
                        <?php else: ?>
                           <i>Unknown method</i>
                        <?php endif; ?>
                     </b>
                  </p>
               </div>
               <!--End Invoice Mid-->
               <hr>
               <div id="bot">
                  <div id="table">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Item</th>
                              <th>Qty</th>
                              <th>Price</th>
                              <th>Amount</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                 <td class="no"><?php echo e($count++); ?></td>
                                 <td class="desc">
                                    <?php echo Finance::product($item->productID)->product_name; ?>

                                 </td>
                                 <td class="unit">
                                    <?php echo $item->quantity; ?>

                                 </td>
                                 <td class="qty"><?php echo e(number_format($item->selling_price)); ?></td>
                                 <td class="total"><?php echo number_format($item->quantity * $item->selling_price) ?>
                                    <?php if($business->base_currency != ""): ?>
         										<?php echo Finance::currency($business->base_currency)->code; ?>

         									<?php endif; ?>
                                 </td>
                              </tr>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td colspan="2"></td>
                              <td colspan="2"><strong>Sub Total :</strong></td>
                              <td>
                                 <?php echo number_format($transaction->total); ?>.00
                                 <?php if($business->base_currency != ""): ?>
                                    <?php echo Finance::currency($business->base_currency)->code; ?>

                                 <?php endif; ?>
                              </td>
                           </tr>
                           
                           <tr>
                              <td colspan="2"></td>
                              <td colspan="2"><strong>TOTAL :</strong></td>
                              <td>
                                 <?php echo number_format($transaction->total); ?>.00
                                 <?php if($business->base_currency != ""): ?>
                                    <?php echo Finance::currency($business->base_currency)->code; ?>

                                 <?php endif; ?>
                              </td>
                           </tr>
                        </tfoot>
                     </table>
                  </div><!--End Table-->
                  
               </div>
               <!--End InvoiceBot-->
            </div>
            <!--End Invoice-->
         </div>
      </div>
   </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/sales/history/show.blade.php ENDPATH**/ ?>