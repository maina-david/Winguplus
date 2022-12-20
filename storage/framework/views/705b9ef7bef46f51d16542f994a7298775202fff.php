<?php $__env->startSection('title','Sale Checkout | Point Of Sale'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <link href="<?php echo asset('assets/css/pos.css'); ?>" rel="stylesheet" />
   <style>
      .accordion p{
         margin-bottom: 0px;
      }
   </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Point Of Sale</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('pos.sell'); ?>">Sales</a></li>
         <li class="breadcrumb-item active">Checkout</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shopping-basket"></i> Checkout</h1>
      <!-- begin row -->
      <div class="container">
         <div class="row justify-content-md-center mt-5">
            <div class="col col-md-6">
               <div class="card">
                  <div class="card-body" style="min-height:350px">
                     <h2 class="text-center">Sale Summary</h2>
                     <div class="row mt-3">
                        <div class="col-md-6">
                           <h4 class="float-left">Quantity:</h4>
                        </div>
                        <div class="col-md-6">
                           <h4 class="float-right"><?php echo number_format($cartItems->sum('qty')); ?></h4>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <h4 class="float-left">Subtotal:</h4>
                        </div>
                        <div class="col-md-6">
                           <h4 class="float-right"><?php echo $symbol; ?><?php echo number_format($cartItems->sum('amount'),2); ?></h4>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <h4 class="float-left">Discount:</h4>
                        </div>
                        <div class="col-md-6">
                           <h4 class="float-right"><?php echo $symbol; ?><?php echo number_format($cartItems->sum('discount'),2); ?></h4>
                        </div>
                     </div>
                     <?php if(Session::has('taxRate')): ?>
                        <div class="row">
                           <div class="col-md-6">
                              <h4 class="float-left">Tax:</h4>
                           </div>
                           <div class="col-md-6">
                              <h4 class="float-right"><?php echo Session::get('taxRate')['rate']; ?>%</h4>
                           </div>
                        </div>
                     <?php endif; ?>
                     <div class="row">
                        <div class="col-md-12">
                          <hr>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <h4 class="float-left font-weight-bold">Total:</h4>
                        </div>
                        <div class="col-md-6">
                           <?php if(Session::has('taxRate')): ?>
                              <?php
                                 $rate = session()->get('taxRate')['rate']/100;
                                 $amount = $cartItems->sum('total_amount') * $rate;
                                 $total = $amount + $cartItems->sum('total_amount');
                              ?>
                              <h4 class="float-right"><?php echo $symbol; ?><?php echo number_format($total,2); ?></h4>
                           <?php else: ?>
                              <h4 class="float-right"><?php echo $symbol; ?><?php echo number_format($cartItems->sum('total_amount'),2); ?></h4>
                           <?php endif; ?>
                        </div>
                     </div>
                     <div class="row mt-5">
                        <div class="col-md-12 mt-4">
                           <a href="<?php echo route('pos.sell'); ?>" class="btn btn-pink float-right"><i class="fal fa-long-arrow-left"></i> Back To Sale</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col col-md-6">
               <div class="card">
                  <div class="card-body">
                     <h2 class="text-center">Checkout</h2>
                     <form class="col-md-12" method="post" action="<?php echo route('pos.save.order'); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                           <label for="" class="text-danger">Amount Received</label>
                           <?php if(Session::has('taxRate')): ?>
                              <?php
                                 $rate = session()->get('taxRate')['rate']/100;
                                 $amount = $cartItems->sum('total_amount') * $rate;
                                 $total = $amount + $cartItems->sum('total_amount');
                              ?>
                              <input type="number" name="amountReceived" value="<?php echo $total; ?>" class="form-control" placeholder="Enter Amount Paid" step="0.01" required>
                           <?php else: ?>
                              <input type="number" name="amountReceived" value="<?php echo $cartItems->sum('total_amount'); ?>" class="form-control" placeholder="Enter Amount Paid" step="0.01" required>
                           <?php endif; ?>
                        </div>
                        <div class="form-group">
                           <label for="">Customer</label>
                           <select class="form-control select2" id="customer" name="customer" required>
                              <option value="">Choose Customer</option>
                              <option value="New" style="color: rgb(5, 129, 47)"><span class="text-success font-weight-bold">New Customer</span></option>
                              <?php $__currentLoopData = $customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo e($cli->customer_code); ?>"> <?php echo $cli->customer_name; ?> </option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                        <div id="new-customer" style="display: none">
                           <div class="form-group">
                              <label for="" class="text-danger">Customer Name</label>
                              <input type="text" name="customer_name" class="form-control">
                           </div>
                           <div class="form-group">
                              <label for="">Customer Phone Number</label>
                              <input type="text" name="customer_phone_number" class="form-control">
                           </div>
                           <div class="form-group">
                              <label for="">Customer Email</label>
                              <input type="text" name="customer_email" class="form-control">
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="">Select payment method</label>
                           <select name="payment_method" class="form-control select2" required>
										<option value="">Choose payment method</option>
										<?php $__currentLoopData = $defaultPaymentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo $dp->method_code; ?>"><?php echo $dp->name; ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php $__currentLoopData = $paymentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo $ap->method_code; ?>"><?php echo $ap->name; ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
                        </div>
                        <div class="form-group mt-3">
                           <center>
                              <button class="btn btn-success submit">Make Payment</button>
                              <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="25%">
                           </center>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
   $(document).ready(function() {
		$('#customer').on('change', function() {
			if (this.value == 'New') {
				$('#new-customer').show();
			} else {
				$('#new-customer').hide();
			}
		});
	});
</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/sales/checkout.blade.php ENDPATH**/ ?>