<div>
   <div class="row">
      <div class="col-xl-3 col-md-6 col-12">
         <div class="panel">
            <div class="panel-content">
               <div class="panel-body">
                  <div class="row mb-2">
                     <div class="col-md-8">
                        <h3> <?php echo e($currency); ?><?php echo e(number_format($paid->sum('paid'))); ?></h3>
                        <h5 class="font-bold">Paid  <span class="float-right text-primary"><?php echo e($paid->count()); ?> / <?php echo $totalInvoices; ?></span></h5>
                     </div>
                     <div class="col-md-4">
                        <i class="fal fa-check-circle fa-5x float-right"></i>
                     </div>
                  </div>
                  <div class="progress progress-striped">
                     <?php
                        if($totalInvoices > 0 && $paid->count()){
                           $percentage = number_format(($paid->count() / $totalInvoices) * 100);
                        }else{
                           $percentage = 0;
                        }
                     ?>
                     <div class="progress-bar bg-green" style="width: <?php echo e($percentage); ?>%">
                        <?php echo e($percentage); ?>%
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-md-6 col-12">
         <div class="panel">
            <div class="panel-content">
               <div class="panel-body">
                  <div class="row mb-2">
                     <div class="col-md-8">
                        <h3> <?php echo e($currency); ?><?php echo e(number_format($partially->sum('paid'))); ?></h3>
                        <h5 class="font-bold">Partially Paid  <span class="float-right text-primary"><?php echo e($partially->count()); ?> / <?php echo $totalInvoices; ?></span></h5>
                     </div>
                     <div class="col-md-4">
                        <i class="fal fa-money-check-edit-alt fa-5x float-right"></i>
                     </div>
                  </div>
                  <div class="progress progress-striped">
                     <?php
                        if($totalInvoices > 0 && $partially->count()){
                           $percentage = number_format(($partially->count() / $totalInvoices) * 100);
                        }else{
                           $percentage = 0;
                        }
                     ?>
                     <div class="progress-bar bg-success" style="width: <?php echo e($percentage); ?>%">
                        <?php echo e($percentage); ?>%
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-md-6 col-12">
         <div class="panel">
            <div class="panel-content">
               <div class="panel-body">
                  <div class="row mb-2">
                     <div class="col-md-8">
                        <h3> <?php echo e($currency); ?><?php echo e(number_format($overdue->sum('balance'))); ?></h3>
                        <h5 class="font-bold">Overdue  <span class="float-right text-primary"><?php echo e($overdue->count()); ?> / <?php echo $totalInvoices; ?></span></h5>
                     </div>
                     <div class="col-md-4">
                        <i class="fal fa-alarm-exclamation fa-5x float-right"></i>
                     </div>
                  </div>
                  <div class="progress progress-striped">
                     <?php
                        if($totalInvoices > 0 && $overdue->count()){
                           $percentage = number_format(($overdue->count() / $totalInvoices) * 100);
                        }else{
                           $percentage = 0;
                        }
                     ?>
                     <div class="progress-bar bg-warning" style="width: <?php echo e($percentage); ?>%">
                        <?php echo e($percentage); ?>%
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-md-6 col-12">
         <div class="panel">
            <div class="panel-content">
               <div class="panel-body">
                  <div class="row mb-2">
                     <div class="col-md-8">
                        <h3> <?php echo e($currency); ?><?php echo e(number_format($unpaid->sum('balance'))); ?></h3>
                        <h5 class="font-bold">Unpaid  <span class="float-right text-primary"><?php echo e($unpaid->count()); ?> / <?php echo $totalInvoices; ?></span></h5>
                     </div>
                     <div class="col-md-4">
                        <i class="fal fa-exclamation-circle fa-5x float-right"></i>
                     </div>
                  </div>
                  <div class="progress progress-striped">
                     <?php
                        if($totalInvoices > 0 && $unpaid->count()){
                           $percentage = number_format(($unpaid->count() / $totalInvoices) * 100);
                        }else{
                           $percentage = 0;
                        }
                     ?>
                     <div class="progress-bar bg-danger" style="width: <?php echo e($percentage); ?>%">
                        <?php echo e($percentage); ?>%
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="panel panel-default">
      <div class="panel-body">
         <div class="row mb-2">
            <div class="col-6">
               <label for="">Search</label>
               <input type="text" class="form-control" wire:model="search" placeholder="Search by Customer name or Invoice title">
            </div>
            <div class="col-md-2">
               <label for="">Status</label>
               <select wire:model="status" class="form-control">
                  <option value="">All Status</option>
                  <option value="1">Paid</option>
                  <option value="2">Unpaid</option>
                  <option value="3">Partially paid</option>
               </select>
            </div>
            <div class="col-md-2">
               <label for="">Month</label>
               <select wire:model="month" class="form-control">
                  <option value="">All Months</option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
               </select>
            </div>
            <div class="col-md-1">
               <?php
                  $thisYear = date("Y");
               ?>
               <label for="">Year</label>
               <select wire:model="year" class="form-control">
                  <option value="">All Years</option>
                  <option value="<?php echo $thisYear; ?>"><?php echo $thisYear; ?></option>
                  <option value="<?php echo $thisYear-1; ?>"><?php echo $thisYear-1; ?></option>
                  <option value="<?php echo $thisYear-2; ?>"><?php echo $thisYear-2; ?></option>
                  <option value="<?php echo $thisYear-3; ?>"><?php echo $thisYear-3; ?></option>
                  <option value="<?php echo $thisYear-4; ?>"><?php echo $thisYear-4; ?></option>
                  <option value="<?php echo $thisYear-5; ?>"><?php echo $thisYear-5; ?></option>
               </select>
            </div>
            <div class="col-md-1">
               <label for="">Per Page</label>
               <select wire:model="perPage" class="form-control">
                  <option value="20">20</option>
                  <option value="40">40</option>
                  <option value="80">80</option>
                  <option value="100">100</option>
                  <option value="120">120</option>
                  <option value="140">140</option>
                  <option value="200">200</option>
                  <option value="250">250</option>
               </select>
            </div>
         </div>
         <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                  <th width="1%">#</th>
                  <th width="10%">Invoice #</th>
                  <th width="21%">Customer</th>
                  <th>Paid</th>
                  <th>Balance</th>
                  <th>Issue Date</th>
                  <th>Due Date</th>
                  <th>Status</th>
                  <th width="10%">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($invoice->business_code == Auth::user()->business_code): ?>
                     <tr>
                        <td><?php echo e($count+1); ?></td>
                        <td>
                           <a href="<?php echo e(route('finance.invoice.show', $invoice->invoiceCode)); ?>">
                              <?php if($invoice->invoice_prefix == ""): ?>
                                 <?php echo e($invoice->prefix); ?>

                              <?php else: ?>
                                 <?php echo e($invoice->invoice_prefix); ?>

                              <?php endif; ?>
                              <?php echo e($invoice->invoice_number); ?>

                           </a><br>
                           <i><b><?php echo $invoice->invoice_title; ?></b></i>
                        </td>
                        <td>
                           <?php echo $invoice->customer_name; ?>

                        </td>
                        <td>
                           <?php if( $invoice->paid < 0 ): ?>
                              <b class="text-info"><?php echo $invoice->currency; ?><?php echo number_format((float)$invoice->main_amount); ?> </b>
                           <?php else: ?>
                              <b class="text-info"><?php echo $invoice->currency; ?><?php echo number_format((float)$invoice->paid); ?> </b>
                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if( $invoice->status == 1 ): ?>
                              <span class="badge <?php echo $invoice->statusName; ?>"><?php echo $invoice->statusName; ?></span>
                           <?php else: ?>
                              <?php if($invoice->balance < 0): ?>
                                 <b class="text-primary">0 <?php echo $invoice->currency; ?></b>
                              <?php else: ?>
                                 <b class="text-primary"><?php echo $invoice->currency; ?><?php echo e(number_format(round($invoice->balance))); ?></b>
                              <?php endif; ?>
                           <?php endif; ?>
                        </td>
                        <td><?php if($invoice->invoice_date != ""): ?><?php echo date('M j, Y',strtotime($invoice->invoice_date)); ?><?php endif; ?></td>
                        <td><?php if($invoice->invoice_due != ""): ?><?php echo date('M j, Y',strtotime($invoice->invoice_due)); ?><?php endif; ?></td>
                        <?php if((int)$invoice->total - (int)$invoice->paid < 0): ?>
                           <td><span class="badge <?php echo $invoice->statusName; ?>"><?php echo $invoice->statusName; ?></span></td>
                        <?php else: ?>
                           <td>
                              <span class="badge <?php echo Helper::seoUrl($invoice->statusName); ?>"><?php echo $invoice->statusName; ?></span>
                           </td>
                        <?php endif; ?>
                        <?php
                           $getCode = json_encode($invoice->invoiceCode);
                        ?>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                              <ul class="dropdown-menu">
                                 <li><a href="<?php echo e(route('finance.invoice.show', $invoice->invoiceCode)); ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                 <li><a href="<?php echo route('finance.invoice.product.edit', $invoice->invoiceCode); ?>"><i class="fas fa-edit"></i> Edit</a></li>
                                 
                                 <li><a wire:click="confirm_delete(<?php echo e($getCode); ?>)" data-toggle="modal" data-target="#delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
                              </ul>
                           </div>
                        </td>
                     </tr>
                  <?php endif; ?>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
         <?php echo $invoices->links('pagination.custom'); ?>

      </div>
   </div>

   <!-- delete modal -->
   <div wire:ignore.self id="delete" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-confirm">
         <div class="modal-content">
            <div class="modal-header flex-column">
               <div class="icon-box">
                  <i class="fal fa-times"></i>
               </div>
               <h4 class="modal-title w-100">Are you sure?</h4>
            </div>
            <div class="modal-body">
               <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
               <button type="button" class="btn btn-secondary" wire:click="close()">Cancel</button>
               <button type="button" class="btn btn-danger" wire:click="delete()">Delete</button>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/finance/invoice/invoices.blade.php ENDPATH**/ ?>