<?php $__env->startSection('title','Finance | Add New | Invoice'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.invoice.index'); ?>">Invoice</a></li>
         <li class="breadcrumb-item active">Create</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> New Invoice</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo e(Form::open(array('route' => 'finance.invoice.product.store', 'role' => 'form', 'class' => 'solsoForm','enctype'=>'multipart/form-data'))); ?>

         <?php echo csrf_field(); ?>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.customer-list')->html();
} elseif ($_instance->childHasBeenRendered('tRw4wvk')) {
    $componentId = $_instance->getRenderedChildComponentId('tRw4wvk');
    $componentTag = $_instance->getRenderedChildComponentTagName('tRw4wvk');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('tRw4wvk');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.customer-list');
    $html = $response->html();
    $_instance->logRenderedChild('tRw4wvk', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group">
                  <label for="number">Invoice Number</label>
                  <div class="input-group">
                     <span class="input-group-addon solso-pre"><?php echo e(Finance::invoice_settings()->prefix); ?></span>
                     <input type="text" name="invoice_number" class="form-control required no-line" autocomplete="off" value="<?php echo e(Finance::invoice_settings()->number + 1); ?>" readonly>
                  </div>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="number">Order Number #</label>
                  <div class="input-group">
                     <input type="text" name="lpo_number" class="form-control required" placeholder="Enter order number" autocomplete="off" >
                  </div>
               </div>
            </div>
         </div>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
                  <div class="form-group form-group-default">
                     <label for="end">Subject</label>
                     <input type="text" name="invoice_title" class="form-control" autocomplete="off" placeholder = "Enter invoice title">
                  </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="date" class="text-danger">Issue Date *</label>
                  <input type="date" name="invoice_date" class="form-control" autocomplete="off" required>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end" class="text-danger">Due Date * </label>
                  <input type="date" name="invoice_due" class="form-control required" autocomplete="off" required>
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
                  <label for="end">Sales person</label>
                  <?php echo Form::select('sales_person',$salespersons,null,['class' => 'form-control select2']); ?>

               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.income-list')->html();
} elseif ($_instance->childHasBeenRendered('ny0UiYK')) {
    $componentId = $_instance->getRenderedChildComponentId('ny0UiYK');
    $componentTag = $_instance->getRenderedChildComponentTagName('ny0UiYK');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ny0UiYK');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.income-list');
    $html = $response->html();
    $_instance->logRenderedChild('ny0UiYK', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
            
         </div>
         <div class="panel panel-default mt-3">
            <div class="panel-heading">
               <h4 class="panel-title">Invoice Items <a href=""  data-toggle="modal" data-target="#addProducts" class="float-right badge badge-primary text-white">Add Product</a></h4>
            </div>
            <div class="panel-body">
               <div class='row mt-3'>
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                     <table class="table table-bordered table-striped" id="invoiceItems">
                        <thead>
                           <tr>
                              <th width="35%">Item Name</th>
                              <th width="13%">Quantity</th>
                              <th width="13%">Price</th>
                              <th width="13%">Discount()</th>
                              <th width="13%">Tax</th>
                              <th width="25%">Total</th>
                              <th width=""></th>
                           </tr>
                        </thead>
                        <?php
                           $count = 1;
                        ?>
                        <tbody>
                           <tr class="clone-item">
                              <td>
                                 <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.product-list')->html();
} elseif ($_instance->childHasBeenRendered('n5le6en')) {
    $componentId = $_instance->getRenderedChildComponentId('n5le6en');
    $componentTag = $_instance->getRenderedChildComponentTagName('n5le6en');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('n5le6en');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.product-list');
    $html = $response->html();
    $_instance->logRenderedChild('n5le6en', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                              </td>
                              <td>
                                 <input type="number" name="qty[]" id="quantity_1" class="form-control changesNo quanyityChange">
                              </td>
                              <td>
                                 <input type="number" name="price[]" id="price_1" class="form-control changesNo" autocomplete="off" step="0.01">
                              </td>
                              <td>
                                 <input type="number" name="discount[]" id="discount_1" class="form-control discount changesNo" autocomplete="off" step="0.01" >
                              </td>
                              <td>
                                 <select name="tax[]" class="form-control changesNo onchange" id="tax_1" autocomplete="off">
                                    <option value="0">Choose tax rate</option>
                                    <?php $__currentLoopData = $taxs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <option value="<?php echo e($tx->rate); ?>"> <?php echo e($tx->name); ?>-<?php echo e($tx->rate); ?>%</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <option value="" class="text-danger">Remove Tax</option>
                                 </select>
                                 <input type="hidden" id="taxvalue_1" name="taxValue[]" class="form-control totalLineTax addNewRow" autocomplete="off" step="0.01" readonly>
                              </td>
                              <td>
                                 <input type="hidden" id="mainAmount_1" class="form-control mainAmount addNewRow" autocomplete="off" placeholder="Main Amount" step="0.01" readonly>
                                 <input type="hidden" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" placeholder="Total Amount" step="0.01" readonly>
                                 <input type="text" id="sum_1" class="form-control totalSum addNewRow" autocomplete="off" placeholder="Total Sum" step="0.01" readonly>
                              </td>
                              <td><a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media"><i class="fas fa-trash"></i></a></td>
                           </tr>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Amount</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly value="0" type="number" class="form-control" id="mainAmountF" step="0.01">
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
                                    <input readonly value="0" type="number" class="form-control" id="discountTotal" step="0.01">
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
                                    <input readonly value="0" type="number" class="form-control" id="subTotal" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Tax</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly value="0" type="number" class="form-control" id="taxvalue" step="0.01">
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
                                    <input readonly value="0" type="number" class="form-control" id="InvoicetotalAmount" placeholder="Total" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
                <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
               <div class='row mb-3'>
                  <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                     <a class="btn btn-primary" id="addRows" href="javascript:;"><i class="fal fa-plus-circle"></i> Add More</a>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Invoice Note | Terms & conditions</h4>
            </div>
            <div class="panel-body">
               <div class='row mt-3'>
                  <div class="col-md-6 mt-3">
                     <label for="">Customer Notes</label>
                     <textarea name="customer_note" class="form-control tinymcy" rows="8" cols="80"><?php echo Finance::invoice_settings()->default_customer_notes; ?></textarea>
                  </div>
                  <div class="col-md-6 mt-3">
                     <label for="">Terms & Conditions</label>
                     <textarea name="terms" class="form-control tinymcy" rows="8" cols="80"><?php echo Finance::invoice_settings()->default_terms_conditions; ?></textarea>
                  </div>
               </div>
            </div>
         </div>
         <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
            <div class='form-group text-center'>
               <center>
                  <button type="submit" class="btn btn-pink btn-lg submit"><i class="fas fa-save"></i> Create Invoice </button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="invoice-load none" alt="" width="15%">
               </center>
            </div>
         </div>
      <?php echo e(Form::close()); ?>

   </div>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.customer-create')->html();
} elseif ($_instance->childHasBeenRendered('m3zGzuL')) {
    $componentId = $_instance->getRenderedChildComponentId('m3zGzuL');
    $componentTag = $_instance->getRenderedChildComponentTagName('m3zGzuL');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('m3zGzuL');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.customer-create');
    $html = $response->html();
    $_instance->logRenderedChild('m3zGzuL', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.income-create')->html();
} elseif ($_instance->childHasBeenRendered('4KW7Wbl')) {
    $componentId = $_instance->getRenderedChildComponentId('4KW7Wbl');
    $componentTag = $_instance->getRenderedChildComponentTagName('4KW7Wbl');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('4KW7Wbl');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.income-create');
    $html = $response->html();
    $_instance->logRenderedChild('4KW7Wbl', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.invoice.product-create')->html();
} elseif ($_instance->childHasBeenRendered('eAspYp9')) {
    $componentId = $_instance->getRenderedChildComponentId('eAspYp9');
    $componentTag = $_instance->getRenderedChildComponentTagName('eAspYp9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('eAspYp9');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.product-create');
    $html = $response->html();
    $_instance->logRenderedChild('eAspYp9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/invoices/product/create.blade.php ENDPATH**/ ?>