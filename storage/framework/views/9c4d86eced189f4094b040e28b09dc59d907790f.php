<?php $__env->startSection('title','Finance | Edit Invoice'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.invoice.index'); ?>">Invoice</a></li>
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> Update Invoice</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo Form::model($invoice, ['route' => ['finance.invoice.product.update',$invoice->invoiceCode], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

         <?php echo csrf_field(); ?>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.customer-list',['editCustomer'=>'True','customerCode' => $invoice->customer])->html();
} elseif ($_instance->childHasBeenRendered('ZhjNXMz')) {
    $componentId = $_instance->getRenderedChildComponentId('ZhjNXMz');
    $componentTag = $_instance->getRenderedChildComponentTagName('ZhjNXMz');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ZhjNXMz');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.customer-list',['editCustomer'=>'True','customerCode' => $invoice->customer]);
    $html = $response->html();
    $_instance->logRenderedChild('ZhjNXMz', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group">
                  <label for="number">Invoice Number</label>
                  <div class="input-group">
                     <span class="input-group-addon solso-pre"><?php echo e($invoice->prefix); ?></span>
                     <?php echo Form::number('invoice_number', null, array('class' => 'form-control','placeholder' => '','required' => '')); ?>

                  </div>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="number" class="">Order Number # </label>
                  <div class="input-group">
                     <input type="text" name="lpo_number" class="form-control" value="<?php echo e($invoice->lpo_number); ?>" placeholder="Enter order number">
                  </div>
               </div>
            </div>
         </div>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
                <div class="form-group form-group-default">
                    <label for="end">Subject</label>
                    <?php echo Form::text('invoice_title', null, array('class' => 'form-control', 'placeholder' => 'Enter invoice title')); ?>

                </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="date" class="text-danger">Issue Date *</label>
                  <?php echo Form::date('invoice_date', null, array('class' => 'form-control','required' => '')); ?>

               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end" class="text-danger">Due Date * </label>
                  <?php echo Form::date('invoice_due', null, array('class' => 'form-control','required' => '')); ?>

               </div>
            </div>
         </div>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end"> Amounts are
                     <span class="pull-right" data-toggle="tooltip" data-placement="top" title="If the amount is tax exlusive the tax field will be hidden on the invoice view">
                        <i class="fas fa-info-circle"></i>
                     </span>
                  </label>
                  <?php echo Form::select('tax_config',['Inclusive' => 'Tax Inclusive','Exclusive' => 'Tax Exclusive'],null,['class' => 'form-control select2', 'id' => 'tax_config' ]); ?>

               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end" class="text-danger">Sales person</label>
                  <?php echo Form::select('sales_person',$salespersons,null,['class' => 'form-control select2']); ?>

               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <?php if(Finance::check_income_category($invoice->income_category) == 1): ?>
                  <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.income-list',['editIncome'=>'True','incomeCode' => $invoice->income_category])->html();
} elseif ($_instance->childHasBeenRendered('TUOj3ua')) {
    $componentId = $_instance->getRenderedChildComponentId('TUOj3ua');
    $componentTag = $_instance->getRenderedChildComponentTagName('TUOj3ua');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('TUOj3ua');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.income-list',['editIncome'=>'True','incomeCode' => $invoice->income_category]);
    $html = $response->html();
    $_instance->logRenderedChild('TUOj3ua', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
               <?php else: ?>
                  <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.income-list')->html();
} elseif ($_instance->childHasBeenRendered('kFwCsfQ')) {
    $componentId = $_instance->getRenderedChildComponentId('kFwCsfQ');
    $componentTag = $_instance->getRenderedChildComponentTagName('kFwCsfQ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('kFwCsfQ');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.income-list');
    $html = $response->html();
    $_instance->logRenderedChild('kFwCsfQ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
               <?php endif; ?>
            </div>
         </div>
         <div class="panel panel-default mt-3">
            <div class="panel-heading">
               <h4 class="panel-title">Invoice Items <a href=""  data-toggle="modal" data-target="#addProducts" class="float-right badge badge-primary text-white">Add Product</a></h4>
            </div>
            <div class="panel-body">
               <div class='row mt-3'>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                     <table class="table table-bordered table-striped" id="invoiceItems">
                        <thead>
                           <tr>
                              <th width="35%">Item Name</th>
                              <th width="13%">Quantity</th>
                              <th width="13%">Price</th>
                              <th width="13%">Discount(<?php echo $invoice->symbol; ?>)</th>
                              <th width="13%">Tax</th>
                              <th width="25%">Total</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $__currentLoopData = $invoiceProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr class="clone-item">
                                 <td>
                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.product-list',['editProduct'=>'True','productCode'=>$product->product_code])->html();
} elseif ($_instance->childHasBeenRendered('rPIMNvf')) {
    $componentId = $_instance->getRenderedChildComponentId('rPIMNvf');
    $componentTag = $_instance->getRenderedChildComponentTagName('rPIMNvf');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('rPIMNvf');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.product-list',['editProduct'=>'True','productCode'=>$product->product_code]);
    $html = $response->html();
    $_instance->logRenderedChild('rPIMNvf', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                 </td>
                                 <td>
                                    <input type="number" name="qty[]" id="quantity_1" value="<?php echo e($product->quantity); ?>" class="form-control changesNo quanyityChange" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                 </td>
                                 <td>
                                    <input type="number" name="price[]" id="price_1" value="<?php echo e($product->selling_price); ?>" class="form-control onchange changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                                 </td>
                                 <td>
                                    <input type="number" name="discount[]" id="discount_1" class="form-control discount changesNo" value="<?php echo e($product->discount); ?>" autocomplete="off" step="0.01">
                                 </td>
                                 <td>
                                    <select name="tax[]" class="form-control changesNo onchange" id="tax_1" autocomplete="off">
                                       <?php if($product->tax_rate == 0 || $product->tax_rate == ""): ?>
                                          <option value="0">Choose tax rate</option>
                                       <?php else: ?>
                                          <option value="<?php echo $product->tax_rate; ?>"><?php echo $product->tax_rate; ?>%</option>
                                       <?php endif; ?>
                                       <?php $__currentLoopData = $taxs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($tx->rate); ?>"> <?php echo e($tx->name); ?>-<?php echo e($tx->rate); ?>%</option>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <option value="" class="text-danger">Remove Tax</option>
                                    </select>
                                    <input type="hidden" id="taxvalue_1" name="taxValue[]" class="form-control totalLineTax addNewRow" value="<?php echo $product->tax_value; ?>" autocomplete="off" step="0.01" readonly>
                                 </td>
                                 <td>
                                    <input type="hidden" id="mainAmount_1" class="form-control mainAmount addNewRow" autocomplete="off" value="<?php echo $product->quantity * $product->selling_price; ?>" placeholder="Main Amount" step="0.01" readonly>
                                    <input type="hidden" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" value="<?php echo $product->sub_total; ?>" placeholder="Total Amount" step="0.01" readonly>
                                    <input type="text" id="sum_1" class="form-control totalSum addNewRow" autocomplete="off" value="<?php echo $product->total_amount; ?>"  placeholder="Total Sum" step="0.01" readonly>
                                 </td>
                                 <td><a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media"><i class="fas fa-trash"></i></a></td>
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
                                    <input readonly type="number" class="form-control" value="<?php echo $invoice->tax_value; ?>" id="taxvalue" step="0.01">
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
               <div class='row mb-3'>
                  <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                     <a class="btn btn-primary" id="addRows" href="javascript:;"><i class="fal fa-plus-circle"></i> Add More</a>
                  </div>
               </div>
               <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
            </div>
         </div>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Invoice Note | Terms & conditions</h4>
            </div>
            <div class="panel-body">
               <div class='row mt-3'>
                  <div class="col-md-6">
                     <label for="">Customer Notes</label>
                     <textarea name="customer_note" class="form-control tinymcy" rows="8" cols="80"><?php echo $invoice->customer_note; ?></textarea>
                  </div>
                  <div class="col-md-6">
                     <label for="">Terms & Conditions</label>
                     <textarea name="terms" class="form-control tinymcy" rows="8" cols="80"><?php echo $invoice->terms; ?></textarea>
                  </div>
               </div>
            </div>
         </div>
         <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
            <div class='form-group text-center'>
               <center>
                  <button type="submit" class="btn btn-pink btn-lg submit"><i class="fas fa-save"></i> Update Invoice </button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="invoice-load none" alt="" width="15%">
               </center>
            </div>
         </div>
      <?php echo e(Form::close()); ?>

   </div>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.customer-create')->html();
} elseif ($_instance->childHasBeenRendered('6JQry0G')) {
    $componentId = $_instance->getRenderedChildComponentId('6JQry0G');
    $componentTag = $_instance->getRenderedChildComponentTagName('6JQry0G');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('6JQry0G');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.customer-create');
    $html = $response->html();
    $_instance->logRenderedChild('6JQry0G', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.income-create')->html();
} elseif ($_instance->childHasBeenRendered('zrVYjXN')) {
    $componentId = $_instance->getRenderedChildComponentId('zrVYjXN');
    $componentTag = $_instance->getRenderedChildComponentTagName('zrVYjXN');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('zrVYjXN');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.income-create');
    $html = $response->html();
    $_instance->logRenderedChild('zrVYjXN', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.product-create')->html();
} elseif ($_instance->childHasBeenRendered('0ENDwAq')) {
    $componentId = $_instance->getRenderedChildComponentId('0ENDwAq');
    $componentTag = $_instance->getRenderedChildComponentTagName('0ENDwAq');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('0ENDwAq');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.product-create');
    $html = $response->html();
    $_instance->logRenderedChild('0ENDwAq', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app.finance.partials._invoice', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startSection('script2'); ?>
   <script type="text/javascript">
      $(document).ready(function(){
         $("form").on("submit", function(){
            $(".save-invoice").hide();
            $(".invoice-load").show();
         });//submit
      });//document ready
   </script>
   <script type="text/javascript">
      window.livewire.on('ModalStore', () => {
         $('#addCustomer').modal('hide');
         $('#addIncomeCategory').modal('hide');
         $('#addProducts').modal('hide');
      });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/invoices/product/edit.blade.php ENDPATH**/ ?>