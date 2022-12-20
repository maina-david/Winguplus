<?php $__env->startSection('title','View Order'); ?>


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
      <h1 class="page-header">Order #<?php echo $order->invoice_code; ?></h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-8">
            <table class="table table-bordered bg-white">
               <tr>
                  <td>
                     <p>Order Date<br><?php echo date('F jS, Y', strtotime($order->invoice_date)); ?></p>
                  </td>
                  <td>
                     <p>Payment Status<br>
                        <?php if((int)$order->total - (int)$order->paid < 0): ?>
                           <span class="badge <?php echo $order->status_name; ?>"><?php echo ucfirst($order->status_name); ?></span>
                        <?php else: ?>
                           <span class="badge <?php echo Helper::seoUrl($order->status_name); ?>"><?php echo ucfirst($order->status_name); ?></span>
                        <?php endif; ?>
                     </p>
                  </td>
                  <td>
                     <p>Delivery Date<br>
                        <?php if($order->delivery_date != ""): ?>
                           <?php echo date('F jS, Y', strtotime($order->delivery_date)); ?>

                        <?php endif; ?>
                     </p>
                  </td>
                  <td>
                     <p>
                        Delivery Status<br>

                     </p>
                  </td>
               </tr>
            </table>
            <div class="panel panel-default">
               <div class="panel-heading">Order details <a href="#" class="badge badge-primary float-right">Change status</a></div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th>Product</th>
                              <th>Price</th>
                              <th>Qty</th>
                              <th>Total</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                 <td>
                                    <?php if(Finance::check_product_image($item->proID) == 1): ?>
                                       <img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID .'/finance/products/'.Finance::product_image($item->proID)->file_name); ?>" width="80px" height="60px">
                                    <?php else: ?>
                                       <img src="<?php echo asset('assets/img/product_placeholder.jpg'); ?>" width="80px" height="60px">
                                    <?php endif; ?><br>
                                    <?php echo $item->product_name; ?>

                                 </td>
                                 <td><?php echo $order->currency; ?><?php echo number_format($item->selling_price,2); ?></td>
                                 <td><?php echo $item->quantity; ?></td>
                                 <td><?php echo $order->currency; ?><?php echo number_format($item->total_amount,2); ?></td>
                              </tr>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td colspan="1">&nbsp;</td>
                              <td colspan="4"><b>TOTAL AMOUNT</b></td>
                           </tr>

                           <tr>
                              <td colspan="1">&nbsp;</td>
                              <td colspan="1"><b>Subtotal</b></td>
                              <td class="" colspan="2">:<?php echo $order->currency; ?><?php echo number_format($order->main_amount,2); ?></td>
                           </tr>
                           <tr>
                              <td colspan="1">&nbsp;</td>
                              <td colspan="1"><b>Discount</b></td>
                              <td class="" colspan="2">:<?php echo $order->currency; ?><?php echo number_format($order->discount,2); ?></td>
                           </tr>
                           <tr>
                              <td colspan="1">&nbsp;</td>
                              <td colspan="1"><b>Tax</b></td>
                              <td class="" colspan="2">:<?php echo $order->currency; ?><?php echo number_format($order->tax_value,2); ?></td>
                           </tr>
                           
                           <tr class="mw-ui-table-footer last">
                              <td colspan="1">&nbsp;</td>
                              <td colspan="1" class=""><strong><b>Total</b></strong></td>
                              <td class="" colspan="2"><strong>:<?php echo $order->currency; ?> <?php echo number_format($order->total,2); ?></strong></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">Order Note</div>
               <div class="panel-body">
                  <?php echo $order->note_1; ?>

               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="panel panel-default">
               <div class="panel-heading">Billing Details </div>
               <div class="panel-body">
                  <ul class="order-table-info-list">
                     <li><strong>Name:</strong> <?php echo $client->customer_name; ?></li>
                     <li><strong>Email:</strong> <?php echo $client->email; ?></li>
                     <li><strong>Phone Number:</strong> <?php echo $client->primary_phone_number; ?></li>
                  </ul>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">Shipping Address </div>
               <div class="panel-body">
                  <ul class="order-table-info-list">
                     <li><strong>Country:</strong> <?php if($order->shipping_country != ""): ?><?php echo Wingu::country($order->shipping_country)->name; ?><?php endif; ?></li>
                     <li><strong>Shipping Address:</strong> <?php echo $order->note_2; ?></li>
                  </ul>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">Client Information</div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tbody>
                           <tr>
                              <td width="40%"><b>Customer Name</b></td>
                              <td>: <a href="#"><?php echo $client->customer_name; ?></a></td>
                           </tr>
                           <tr>
                              <td width="40%"><b>Email</b></td>
                              <td>: <a href="<?php echo $client->email; ?>"><?php echo $client->email; ?></a></td>
                           </tr>
                           <tr>
                              <td width="40%"><b>Phone Number</b></td>
                              <td>: <b><?php echo $client->phone_number; ?></b></td>
                           </tr>
                           <tr>
                              <td width="40%"><b>Gender</b></td>
                              <td>: <b><?php echo $client->gender; ?></b></td>
                           </tr>
                           <tr>
                              <td width="40%"><b>User IP</b></td>
                              <td>: <?php echo $client->ip; ?></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/ecommerce/orders/show.blade.php ENDPATH**/ ?>