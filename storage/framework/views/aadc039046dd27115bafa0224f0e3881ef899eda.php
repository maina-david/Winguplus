<div>
   <div class="card">
      <div class="card-body">
         <div class="row mb-3">
            <div class="col-md-5">
               <input type="text" class="form-control" wire:model="search" placeholder="Search by customer name">
            </div>
            <div class="col-md-7">
               <?php if($event->type == 'Free'): ?>
                  <a href="#" class="btn btn-warning float-right" data-toggle="modal" data-target="#checkInCustomer">CheckIn</a>
               <?php endif; ?>
            </div>
         </div>
         <table class="table table-striped table-bordered">
            <thead>
               <th width="1%">#</th>
               <th>Customer</th>
               <th>Ticket</th>
               <th>Qty</th>
               <th>Amount</th>
               <th>Payment Status</th>
               <th width="10%">Action</th>
            </thead>
            <tbody>
               <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($customer->business_code ==  Auth::user()->business_code): ?>
                     <tr>
                        <td><?php echo $count+1; ?></td>
                        <td><?php echo $customer->customer_name; ?></td>
                        <td><?php echo $customer->product_name; ?></td>
                        <td><?php echo $customer->quantity; ?> / <?php echo e($customer->checked_in); ?></td>
                        <td><?php echo e($currency); ?><?php echo number_format($customer->total_amount); ?></td>
                        <td>
                           <?php if($event->type == 'Paid'): ?>
                              <span class="badge <?php echo $customer->name; ?>"><?php echo $customer->name; ?></span>
                           <?php else: ?>
                              <span class="badge badge-warning">Fee Event</span>
                           <?php endif; ?>
                        </td>
                        <td>
                           <?php
                              $productCode = json_encode($customer->productCode);
                              $customerCode = json_encode($customer->customerCode);
                              $invoice = json_encode($customer->invoiceCode);
                           ?>
                           <?php if($event->type == 'Paid'): ?>
                              <?php if($customer->statusID == 1): ?>
                                 <?php if($customer->checked_in != $customer->quantity): ?>
                                    <a wire:click="ticket_details(<?php echo e($customerCode); ?>,<?php echo e($productCode); ?>,<?php echo e($invoice); ?>)" href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#checkInCustomer">Check in</a>
                                 <?php endif; ?>
                              <?php endif; ?>
                              <?php if($customer->checked_in > 0): ?>
                                 <a wire:click="check_in_details(<?php echo e($productCode); ?>)" href="" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#checkInDetails"><i class="far fa-eye"></i></a>
                              <?php endif; ?>
                           <?php endif; ?>
                        </td>
                     </tr>
                  <?php endif; ?>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
      </div>
   </div>

   <!-- check-in -->
   <div wire:ignore.self class="modal fade" id="checkInCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Check-in Customer</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="">Customer Name</label>
                  <input type="text" wire:model.defer="names" class="form-control" required>
                  <?php $__errorArgs = ['names'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
               <div class="form-group">
                  <label for="">Customer Email</label>
                  <input type="email" wire:model.defer="email" class="form-control">
                  <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
               <div class="form-group">
                  <label for="">Phone number</label>
                  <input type="number" wire:model.defer="phone_number" class="form-control" required>
                  <?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
            </div>
            <div class="modal-footer">
               <div wire:click="paid_check_in" wire:loading.class="none">
                  <a href="" class="btn btn-secondary" wire:click="close()">Close</a>
                  <?php if($event->type == 'Paid'): ?>
                     <a href="" class="btn btn-success" wire:click.prevent="paid_check_in()">Submit Information</a>
                  <?php endif; ?>
               </div>
               <div wire:loading wire:target="paid_check_in">
                  <center> <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" alt="loader" width="25%"></center>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div wire:ignore.self class="modal right fade" id="checkInDetails" tabindex="-1" role="dialog" aria-labelledby="right_modal_xl" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-xl" role="document">
         <div class="modal-content">
            <?php if($checkInDetails): ?>
               <div class="modal-header">
                  <h5 class="modal-title">Check-in details</h5>
                  <button type="button" class="close" wire:click="close()" data-dismiss="modal">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <?php $__currentLoopData = $checkInDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checks): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-3">
                           <div class="panel">
                              <div class="panel-body">
                                 <div>
                                    <p>
                                       <b>Name:</b> <?php echo $checks->names; ?><br>
                                       <b>Email:</b> <a href=""><?php echo $checks->email; ?></a><br>
                                       <b>Phone Number:</b> <a href=""><?php echo $checks->phone_number; ?></a><br>
                                       <b>Check in time:</b> <?php echo date('F jS, Y', strtotime($checks->created_at)); ?> @ <?php echo e(date('g:i A', strtotime($checks->created_at))); ?><br>
                                       <?php if($checks->created_by): ?>
                                          <?php
                                             $user = Wingu::user($checks->created_by)->getData();
                                          ?>
                                          <?php if($user->check == 1): ?>
                                             <b>Checked in by:</b> <span class="text-warning"><?php echo $user->user->name; ?></span><br>
                                          <?php endif; ?>
                                       <?php endif; ?>
                                    </p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
               </div>
               <div class="modal-footer modal-footer-fixed">
                  <button type="button" class="btn btn-secondary" wire:click="close" wire:loading.class="none" wire:click="close()" data-dismiss="modal">Close</button>
                  <div wire:loading wire:target="close">
                     <center> <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" alt="loader" width="25%"></center>
                  </div>
               </div>
            <?php else: ?>
               <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load float-right" alt="" style="width: 70%; justify-content: center;align-items: center;padding-left: 30%; padding-top: 30%">
            <?php endif; ?>
         </div>
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
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close()">Cancel</button>
               <button type="button" class="btn btn-danger" wire:click="delete()">Delete</button>
            </div>
         </div>
      </div>
   </div>

</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/events/events/attendance.blade.php ENDPATH**/ ?>