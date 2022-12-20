<div class="row">
   <div class="col-md-12">
      <a href="" class="btn btn-primary btn-small float-right" data-toggle="modal" data-target="#addTicket"><i class="fas fa-plus-circle"></i> Add Tickets</a>
   </div>
   <div class="col-md-10">
      <div class="card">
         <div class="card-body">
            <table class="table table-striped table-bordered">
               <thead>
                  <th width="1%">#</th>
                  <th>Ticket Name</th>
                  <th>Price</th>
                  <th>Available Tickets</th>
                  <th>Dates</th>
                  <th>Is Ticket Active</th>
                  <th width="15%">Action</th>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count+1; ?></td>
                        <td><?php echo $ticket->product_name; ?></td>
                        <td><?php echo e($currency); ?> <?php echo number_format($ticket->selling_price); ?></td>
                        <td><?php echo $ticket->current_stock; ?></td>
                        <td>
                           <?php if($ticket->event_start_date): ?>
                              <?php echo date('F jS, Y', strtotime($ticket->event_start_date)); ?>

                           <?php endif; ?>
                           <?php if($ticket->event_due_date): ?>
                              <b>to</b>
                              <?php echo date('F jS, Y', strtotime($ticket->event_due_date)); ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if($ticket->active == 'Yes'): ?>
                              <span class="badge badge-success"><?php echo $ticket->active; ?></span>
                           <?php endif; ?>
                           <?php if($ticket->active == 'No'): ?>
                              <span class="badge badge-danger"><?php echo $ticket->active; ?></span>
                           <?php endif; ?>
                        </td>
                        <td>
                           <?php
                              $getCode = json_encode($ticket->product_code);
                           ?>
                           <a href="" class="btn btn-sm btn-primary" wire:click="edit(<?php echo e($getCode); ?>)" data-toggle="modal" data-target="#addTicket">Edit</a>
                           <a href="" class="btn btn-sm btn-danger" wire:click="confirm_delete(<?php echo e($getCode); ?>)" data-toggle="modal" data-target="#delete">Delete</a>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>

   <!-- Ticket modal-->
   <div wire:ignore.self class="modal" id="addTicket">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
               <?php if($this->editCode): ?>
                  <h4 class="modal-title">Edit Ticket Details</h4>
               <?php else: ?>
                  <h4 class="modal-title">Ticket Details</h4>
               <?php endif; ?>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data">
               <!-- Modal body -->
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6 mb-2">
                        <label for="">Ticket Name</label>
                        <input type="text" class="form-control" wire:model.defer="ticket_name" required>
                        <?php $__errorArgs = ['ticket_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Price</label>
                        <input type="number" class="form-control" wire:model.defer="price" required>
                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                     <div class="col-md-4 mb-2">
                        <label for="">Quantity</label>
                        <input type="number" class="form-control" wire:model="qty" required>
                        <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                     <div class="col-md-4 mb-2">
                        <label for="">Is Item Active</label>
                        <select wire:model="status" class="form-control" required>
                           <option value="">Choose</option>
                           <option value="Yes">Yes</option>
                           <option value="No">No</option>
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
                     <div class="col-md-4 mb-2">
                        <label for="">Track Quantity</label>
                        <select wire:model="track_ticket_quantity" class="form-control" required>
                           <option value="">Choose</option>
                           <option value="Yes">Yes</option>
                           <option value="No">No</option>
                        </select>
                        <?php $__errorArgs = ['track_ticket_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Start Date</label>
                        <input type="date" class="form-control" wire:model="start_date">
                        <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Due Date</label>
                        <input type="date" class="form-control" wire:model="due_date">
                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">Details</label>
                        <textarea type="text" class="form-control" wire:model="description" rows="10"></textarea>
                     </div>
                  </div>
               </div>
               <!-- Modal footer -->
               <div class="modal-footer">
                  <?php if($this->editCode): ?>
                     <button type="submit" class="btn btn-primary" wire:click.prevent="update()"><i class="fas fa-save"></i> Update Information</button>
                  <?php else: ?>
                     <button type="submit" class="btn btn-success" wire:click.prevent="add_ticket()"><i class="fas fa-save"></i> Save Information</button>
                  <?php endif; ?>
               </div>
            </form>
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/events/events/tickets.blade.php ENDPATH**/ ?>