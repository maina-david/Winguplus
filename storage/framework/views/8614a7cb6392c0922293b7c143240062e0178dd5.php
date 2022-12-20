<div>
   <div class="row">
      <div class="col-md-12">
         <a href="" class="btn btn-primary float-right mb-3" data-toggle="modal" data-target=".lease"><i class="fa fa-plus-circle"></i> Add Lease</a>
      </div>
      <div class="col-md-12">
         <table class="table table-striped table-bordered">
            <thead>
               <th width="1%">#</th>
               <th>Lease Date</th>
               <th>Lease Expires</th>
               <th>Leasing Customer</th>
               <th>Created By</th>
               <th width="12%">Action</th>
            </thead>
            <tbody>
               <?php $__currentLoopData = $leases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$lease): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                     <td><?php echo $count+1; ?></td>
                     <td><?php echo date('F jS, Y', strtotime($lease->action_date)); ?></td>
                     <td><?php echo date('F jS, Y', strtotime($lease->due_action_date)); ?></td>
                     <td>
                        <?php if($lease->customer): ?>
                           <?php echo Finance::client($lease->customer)->customer_name; ?>

                        <?php endif; ?>
                     </td>
                     <td>
                        <?php if($lease->updated_by): ?>
                           <?php echo Wingu::user($lease->updated_by)->name; ?>

                        <?php endif; ?>
                     </td>
                     <td>
                        <?php
                           $getCode = json_encode($lease->code);
                        ?>
                        <a wire:click="edit(<?php echo e($getCode); ?>)" class="btn btn-primary" data-toggle="modal" data-target="#editLease" href="#">Edit</a>
                        <a wire:click="remove(<?php echo e($getCode); ?>)" class="btn btn-danger" data-toggle="modal" data-target="#delete" href="#">Delete</a>
                     </td>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
      </div>
   </div>

   <div wire:ignore.self class="modal fade" id="editLease" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <form action="<?php echo route('assets.lease.store',$code); ?>" method="POST" autocomplete="off" id="leaseForm">
               <?php echo csrf_field(); ?>
               <div class="modal-header">
                  <h3 class="modal-title" id="exampleModalLabel"><i class="fal fa-file-contract"></i> Lease</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="" class="text-danger">Lease Begins</label>
                           <input type="date" wire:model="action_date" class="form-control" required>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="" class="text-danger">Lease Expires</label>
                           <input type="date" wire:model="due_action_date" class="form-control" required>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           <label for="" class="text-danger">Leasing Customer </label>
                           <select wire:model="customer" class="form-control" required>
                              <?php if($this->customer): ?>
                                 <option value="<?php echo $this->customer; ?>"><?php echo Wingu::user($lease->updated_by)->name; ?></option>
                              <?php else: ?>
                                 <option value="">Choose Customer</option>
                              <?php endif; ?>
                              <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cust): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $cust->customer_code; ?>"><?php echo $cust->customer_name; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                        <?php $__errorArgs = ['customer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                     
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Note </label>
                           <textarea wire:model="note" class="form-control tinymcy" rows="10"></textarea>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <center>
                     <button type="submit" class="btn btn-pink submit" wire:click.prevent="update()">Submit Lease</button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                  </center>
               </div>
            </form>
         </div>
      </div>
   </div>

   <!-- Modal HTML -->
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/assets/assets/leases.blade.php ENDPATH**/ ?>