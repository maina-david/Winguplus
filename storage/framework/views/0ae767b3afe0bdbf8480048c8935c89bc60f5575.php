<?php $__env->startSection('title','Edit | Subscription'); ?>



<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.subscriptions.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('subscriptions.dashboard'); ?>">Subscriptions</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('subscriptions.index'); ?>">Subscription</a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-sync-alt"></i> Edit Subscription</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo Form::model($invoice, ['route' => ['subscriptions.update',$invoice->invoiceID], 'method'=>'post']); ?>

         <?php echo csrf_field(); ?>
         <div class="panel">
            <div class="panel-body">  
               <div class='row'>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="client" class="text-danger">Choose Customer *</label>
                        <select name="customer" class="form-control multiselect" required>
                           <option selected value="<?php echo e($invoice->customerID); ?>"><?php echo $invoice->customer_name; ?></option>
                           <option value=""><b>Choose Customer</b></option>
                           <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($cli->id); ?>"><?php echo $cli->customer_name; ?></option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group">
                        <label for="number">Subscription</label>
                        <div class="input-group">
                           <span class="input-group-addon solso-pre"><?php echo e(Finance::subscription_settings()->prefix); ?></span>
                           <input type="text" value="<?php echo $subscription->subscription_number; ?>" class="form-control" readonly>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="number" class="">Reference #</label>
                        <div class="input-group">
                           <input type="text" name="reference" class="form-control" value="<?php echo e($invoice->reference); ?>" placeholder="Enter reference">
                        </div>
                     </div>
                  </div>
               </div>
               <div class='row'>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="date" class="text-danger">Starts on *</label>
                        <input type="date" name="starts_on" class="form-control" autocomplete="off" placeholder="Choose date" value="<?php echo e($invoice->invoice_date); ?>" required>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="date">Due date *</label>
                        <input type="date" name="due_date" class="form-control" autocomplete="off" placeholder="Choose date" value="<?php echo e($invoice->invoice_due); ?>" required>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="end">Sales person</label>
                        <?php echo Form::select('salesperson',$salespersons,null,['class' => 'form-control multiselect']); ?>

                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="end" class="text-danger">Expiration cycle</label>
                        <select name="expiration_cycle" id="expiration_cycle" class="multiselect">
                           <option value="never">Never</option>
                           <option value="Enter cycle">Enter cycle</option>
                        </select>
                     </div>
                  </div>
                  <?php if($invoice->expiration_cycle != ""): ?>
                     <div class="col-md-4 col-lg-4">
                        <div class="form-group form-group-default">
                           <label for="date" class="text-danger">Cycle *</label>
                           <input type="number" name="cycles" class="form-control" autocomplete="off" value="<?php echo $invoice->expiration_cycle; ?>" placeholder="Enter cycle">
                        </div>
                     </div>
                  <?php endif; ?>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="number" class="">Subscription title</label>
                        <div class="input-group">
                           <input type="text" name="invoice_title" class="form-control" value="<?php echo e($invoice->invoice_title); ?>" placeholder="Enter title">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                     <div class="form-group form-group-default">
                        <label for="end" class="text-danger">Income account * <a href="" class="pull-right" data-toggle="modal" data-target="#addExpressIncome">Add Income</a></label>
                        <select name="income_category" id="getIncomeCategory" class="form-control multiselect" required>                     
                           <?php if($invoice->income_category == ""): ?>
                              <option value=""><b>Choose Income category</b></option>
                           <?php else: ?>
                              <option selected value="<?php echo e($invoice->income_category); ?>"><?php echo Finance::income_category($invoice->income_category)->name; ?></option>
                           <?php endif; ?>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel panel-default mt-3">
            <div class="panel-body">
               <div class='row mt-3'>
                  <div class="col-md-4 mb-3">
                     <label for="">Products</label>
                     <select name="product" id="products" class="form-control multiselect" required>                        
                        <?php if(Finance::check_product($subscription->product) == 1): ?>
                           <?php echo Finance::product($subscription->product)->product_name; ?>

                        <?php else: ?>
                           <option value="">Choose products</option>
                        <?php endif; ?>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo $product->id; ?>"><?php echo $product->product_name; ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </select>
                  </div>
                  
               </div>
               <div class='row mt-3'>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                     <table class="table table-bordered table-striped" id="table">
                        <thead>
                           <tr>
                              <th width="2%"><input id="check_all" class="formcontrol" type="checkbox"/></th>
                              <th width="35%">Item Name</th>
                              <th width="13%">Quantity</th>
                              <th width="13%">Price</th>
                              <th width="13%">Discount(<?php echo $invoice->symbol; ?>)</th>
                              <th width="13%">Tax</th>
                              <th width="25%">Total</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $__currentLoopData = $invoiceProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                 <td><input class="case" type="checkbox"/></td>
                                 <td>
                                    <select name="productID" class="form-control solsoCloneSelect2 multiselect" id="subscriptions" data-init-plugin='select2' required>
                                       <option value="<?php echo e($product->productID); ?>">
                                          <?php if(Finance::check_product($subscription->plan) == 1): ?>
                                             <?php echo Finance::product($subscription->plan)->product_name; ?>

                                          <?php endif; ?>
                                       </option>
                                    </select> 
                                    <?php echo $errors->first('currency', '<p class="error">:messages</p>');?>
                                 </td>
                                 <td>
                                    <input type="number" name="qty" id="quantity_1" value="<?php echo e($product->quantity); ?>" class="form-control changesNo quanyityChange" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                 </td>
                                 <td>
                                    <input type="number" name="price" id="price_1" value="<?php echo e($product->selling_price); ?>" class="form-control changesNo subscription_price" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                 </td>
                                 <td>
                                    <input type="number" name="discount" id="discount_1" class="form-control discount changesNo" value="<?php echo e($product->discount); ?>" autocomplete="off" step="0.01">
                                 </td>
                                 <td>
                                    <select name="tax" class="form-control changesNo onchange" id="tax_1" autocomplete="off">
                                       <?php if($product->taxrate == 0 || $product->taxrate == ""): ?>
                                          <option value="0">Choose tax rate</option>
                                       <?php else: ?> 
                                          <option value="<?php echo $product->taxrate; ?>"><?php echo $product->taxrate; ?>%</option>
                                       <?php endif; ?>
                                       <?php $__currentLoopData = $taxs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($tx->rate); ?>"> <?php echo e($tx->name); ?>-<?php echo e($tx->rate); ?>%</option>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <input type="hidden" id="taxvalue_1" name="taxValue" class="form-control totalLineTax addNewRow" value="<?php echo $product->taxvalue; ?>" autocomplete="off" step="0.01" readonly>
                                 </td>
                                 <td>
                                    <input type="hidden" id="mainAmount_1" class="form-control mainAmount addNewRow" autocomplete="off" value="<?php echo $product->quantity * $product->selling_price; ?>" placeholder="Main Amount" step="0.01" readonly>
                                    <input type="hidden" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" value="<?php echo $product->sub_total; ?>" placeholder="Total Amount" step="0.01" readonly>
                                    <input type="text" id="sum_1" class="form-control totalSum addNewRow" autocomplete="off" value="<?php echo $product->total_amount; ?>"  placeholder="Total Sum" step="0.01" readonly>
                                 </td>
                              </tr>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Amount</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly value="<?php echo $invoice->main_amount; ?>" type="number" class="form-control" id="mainAmountF" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Discount</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">                                    
                                    <input readonly type="number" value="<?php echo $invoice->discount; ?>" class="form-control" id="discountTotal" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Sub Total</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly type="number" value="<?php echo $invoice->sub_total; ?>" class="form-control" id="subTotal" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                           <tr id="taxfield">
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Tax</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly type="number" class="form-control" value="<?php echo $invoice->taxvalue; ?>" id="taxvalue" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                           <tr class="table-default">
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Total Amount</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly type="number" class="form-control" id="InvoicetotalAmount" value="<?php echo $invoice->total; ?>" placeholder="Total" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
               <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
            </div>
         </div>
         
         <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
            <div class='form-group text-center'>
               <center>
                  <button type="submit"class="btn btn-pink btn-lg submit"><i class="fas fa-save"></i> Update Subscription </button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </div>
      <?php echo e(Form::close()); ?>

   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app.finance.partials._invoice', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/subscriptions/edit.blade.php ENDPATH**/ ?>