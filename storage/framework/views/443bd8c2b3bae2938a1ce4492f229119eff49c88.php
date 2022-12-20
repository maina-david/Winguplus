<?php $__env->startSection('title','Add New |  New Purchase Order'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.lpo.index'); ?>">Purchase Order</a></li>
         <li class="breadcrumb-item active">New Purchase Order</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-contract"></i> New Purchase Order</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo Form::open(array('route' => 'finance.lpo.store', 'enctype'=>'multipart/form-data','method' => 'post','autocomplete' => 'off')); ?>

         <?php echo csrf_field(); ?>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default required">
                  <label for="client" class="text-danger">Supplier </label>
                  <?php echo Form::select('supplier',$suppliers,null,['class'=>'form-control select2','required'=>'']); ?>

               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group">
                  <label for="number">Purchase Order</label>
                  <div class="input-group">
                     <span class="input-group-addon solso-pre"><?php echo e(Finance::lpo()->prefix); ?></span>
                     <input type="text" name="lpo_number" class="form-control required no-line" autocomplete="off" value="<?php echo e(Finance::lpo()->number + 1); ?>" readonly>
                  </div>
                  <?php echo $errors->first('number', '<p class="error">:messages</p>');?>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="number" class="">Reference # </label>
                  <div class="input-group">
                     <?php echo e(Form::text('reference_number',null, ['class' => 'form-control','placeholder' => 'Enter reference number'])); ?>

                  </div>
               </div>
            </div>
         </div>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                   <label for="title">Title</label>
                   <?php echo Form::text('title',null,['class' => 'form-control', 'placeholder' => 'Enter title']); ?>

               </div>
           </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default required">
                  <label for="date" class="text-danger">Issue Date </label>
                  <?php echo Form::date('lpo_date', null, array('class' => 'form-control required', 'placeholder' => 'Enter date','required' => '')); ?>

               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default required">
                  <label for="end" class="text-danger">Expected Delivery Date </label>
                  <?php echo Form::date('lpo_due', null, array('class' => 'form-control required', 'placeholder' => 'Enter date','required' => '')); ?>

               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="" class="text-danger">Expense Category <a href="" class="pull-right" data-toggle="modal" data-target="#expenceCategory">Add Expense category</a></label>
                  <select name="expense_category" id="selectCategory" class="form-control select2" required></select>
               </div>
            </div> 
         </div>
         <div class="panel panel-default mt-2">
            <div class="panel-heading">
               <h4 class="panel-title">Purchase Order Items</h4>
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
} elseif ($_instance->childHasBeenRendered('zBegNFd')) {
    $componentId = $_instance->getRenderedChildComponentId('zBegNFd');
    $componentTag = $_instance->getRenderedChildComponentTagName('zBegNFd');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('zBegNFd');
} else {
    $response = \Livewire\Livewire::mount('finance.invoice.product-list');
    $html = $response->html();
    $_instance->logRenderedChild('zBegNFd', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
                              <td style="display: none">
                                 <input type="number" name="discount[]" id="discount_1" class="form-control discount changesNo" autocomplete="off" step="0.01" >
                              </td>
                              <td>
                                 <select name="tax[]" class="form-control changesNo onchange" id="tax_1" autocomplete="off">
                                    <option value="0">Choose tax rate</option>
                                    <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
               <div class='row mb-3'>
                  <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                     <a class="btn btn-primary" id="addRows" href="javascript:;"><i class="fal fa-plus-circle"></i> Add More</a>
                  </div>
               </div>
            </div>
         </div>
         <div class='row mt-3'>
            <div class="col-md-6 mt-3">
               <label for="">Supplier Notes</label>
               <textarea name="customer_note" class="form-control tinymcy" rows="8" cols="80"><?php echo Finance::lpo()->default_customer_notes; ?></textarea>
            </div>
            <div class="col-md-6 mt-3">
               <label for="">Terms & Conditions</label>
               <textarea name="terms" class="form-control tinymcy" rows="8" cols="80"><?php echo Finance::lpo()->default_terms_conditions; ?></textarea>
            </div>
            <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
               <div class='form-group text-center'>
                  <center>
                     <button type="submit"class="btn btn-pink btn-lg"><i class="fas fa-save"></i> Save Purchase Order </button>
                     
                  </center>
               </div>
            </div>
         </div>
      <?php echo e(Form::close()); ?>

   </div>
   <?php echo $__env->make('app.finance.expense.category.express', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app.finance.partials._lpo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/purchaseorders/create.blade.php ENDPATH**/ ?>