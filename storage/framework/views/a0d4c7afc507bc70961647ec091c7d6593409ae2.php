<div>
   <div class="row mb-2">
      <div class="col-md-12">
         <a href="" class="btn btn-pink float-right" data-toggle="modal" data-target="#sellTicket"><i class="fa fa-plus-circle"></i> Sale Ticket</a>
      </div>
   </div>
   <div class="card">
      <div class="card-body">
         <table class="table table-striped table-bordered">
            <thead>
               <th width="1%">#</th>
               <th>Ticket</th>
               <th>Price</th>
               <th>Sold</th>
               <th>Amount</th>
            </thead>
            <tbody>
               <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                     <td><?php echo $count+1; ?></td>
                     <td><?php echo $ticket->product_name; ?></td>
                     <td><?php echo e($currency); ?><?php echo number_format($ticket->selling_price); ?></td>
                     <td><?php echo Events::tickets_sold($ticket->productCode); ?></td>
                     <td><?php echo e($currency); ?><?php echo number_format($ticket->total_sales); ?></td>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
      </div>
   </div>

   <!-- Modal -->
   <div wire:ignore.self class="modal fade" id="sellTicket" tabindex="-1" role="dialog" aria-labelledby="sellTicketTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">Sale Ticket</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 mb-2">
                     <div class="row">
                        <div class="col-md-6">
                           <input type="radio" wire:model="member_type" value="new">
                           New Member
                        </div>
                        <div class="col-md-6">
                           <input type="radio" wire:model="member_type" value="member">
                           Member
                        </div>
                     </div>
                  </div>
                  <?php if($this->member_type == 'new'): ?>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Customer Name</label>
                           <input type="text" wire:model.defer="customer_name" class="form-control" required>
                           <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Email</label>
                           <input type="text" wire:model.defer="email" class="form-control" required>
                           <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Phone Number</label>
                           <input type="number" wire:model.defer="phone_number" class="form-control">
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
                  <?php else: ?>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Choose Customer</label>
                           <select class="form-control" wire:model.defer="customer">
                              <option value="">Choose Customer</option>
                              <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $customer->customer_code; ?>"><?php echo $customer->customer_name; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                           <?php $__errorArgs = ['customer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                     </div>
                  <?php endif; ?>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Choose ticket</label>
                        <select class="form-control" wire:model.defer="ticket" required>
                           <option value="">Choose ticket</option>
                           <?php $__currentLoopData = $ticketItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($item->product_code); ?>">
                                 <?php echo $item->product_name; ?> (<?php echo e($currency); ?><?php echo e(number_format($item->selling_price)); ?>) - qty <?php echo e($item->current_stock); ?>

                              </option>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['ticket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Quantity</label>
                        <input type="number" wire:model.defer="quantity" class="form-control" min="1" required>
                        <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Choose payment status</label>
                        <select class="form-control" wire:model="status" required>
                           <option value="">Choose status</option>
                           <option value="1">Paid</option>
                           <option value="2">Unpaid</option>
                           <option value="3">Partially paid</option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                  </div>
                  <?php if($this->status == 1 || $this->status == 3): ?>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Choose payment method</label>
                           <select class="form-control" wire:model="payment_method" required>
                              <option value="">Choose method</option>
                              <option value="cash">Cash</option>
                              <option value="banktransfer">Bank transfer</option>
                              <option value="cheque">Cheque</option>
                              <option value="mpesa">Mpesa</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Transaction Number</label>
                           <input type="text" wire:model.defer="transaction_number" class="form-control">
                        </div>
                     </div>
                  <?php endif; ?>
                  <?php if($this->status == 3): ?>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Partial Amount paid</label>
                           <input type="text" wire:model.defer="amount_paid" class="form-control">
                           <?php $__errorArgs = ['amount_paid'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                     </div>
                  <?php endif; ?>
                  
               </div>
            </div>
            <div class="modal-footer">
               <div wire:loading.class="none">
                  <button type="button" class="btn btn-secondary" wire:model="close()">Close</button>
                  <button type="button" class="btn btn-success" wire:click.prevent="sell_ticket()">Save changes</button>
               </div>
               <div wire:loading wire:target="sell_ticket">
                 <center> <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" alt="loding" width="25%"></center>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/events/events/sold.blade.php ENDPATH**/ ?>