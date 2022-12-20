<div>
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo route('jobs.dashboard'); ?>">Jobs Management</a></li>
      <li class="breadcrumb-item"><a href="<?php echo route('job.index'); ?>">Clients</a></li>
      <li class="breadcrumb-item active">All</li>
   </ol>
   <h1 class="page-header"><i class="fal fa-users"></i> Clients <a href="" class="btn btn-sm btn-success" data-toggle="modal" data-target="#customerModal"><i class="fa fa-plus-circle"></i> Add client</a></h1>
   <div class="row mb-3">
      <div class="col-md-10">
         <label for="">Search</label>
         <input type="text" wire:model="search" class="form-control" placeholder="Enter client name">
      </div>
      <div class="col-md-2">
         <label for="">Per Page</label>
         <select wire:model="perPage" class="form-control">`
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
         </select>
      </div>
   </div>
   <div class="row">
      <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <?php if($client->business_code = Auth::user()->business_code): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 img_div_modal">
               <div class="staffinfo-box">
                  <div class="staffleft-box">
                     <?php if($client->image): ?>
                        <img width="40" height="40" alt="<?php echo $client->customer_name; ?>" class="img-circle" src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/customer/'. $client->customer_code.'/images/'.$client->image); ?>">
                     <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo $client->customer_name; ?>&rounded=false&size=120" alt="<?php echo $client->customer_name; ?>" class="img-responsive">
                     <?php endif; ?>
                  </div>
                  <div class="staffleft-content">
                     <h5><span><?php echo $client->customer_name; ?></span></h5>
                     <p><?php echo $client->primary_phone_number; ?></p>
                     <p><?php echo $client->email; ?></p>
                     <p><?php echo $client->website; ?></p>
                  </div>
                  <?php
                     $geteditCode = json_encode($client->customer_code);
                  ?>
                  <div class="overlay3">
                     <div class="stafficons">
                        <a title="Show" data-toggle="modal" data-target="#delete" wire:click="delete_notification(<?php echo e($geteditCode); ?>)" href="#"><i class="fal fa-trash-alt"></i></a>
                        <a title="Edit" data-toggle="modal" data-target="#customerModal" href="#" wire:click="edit_mode(<?php echo e($geteditCode); ?>)"><i class=" fal fa-pencil"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php echo e($clients->links()); ?>

   </div>

   
   <div wire:ignore.self class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"><?php if($editCode): ?> Edit Client <?php else: ?> Add Client <?php endif; ?></h5>
               <button type="button" class="close" wire:click="close()" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label class="col-form-label">Client Name:</label>
                  <input type="text" class="form-control" wire:model="client_name" required>
                  <?php $__errorArgs = ['client_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
               <div class="form-group">
                  <label class="col-form-label">Email</label>
                  <input type="email" class="form-control" wire:model="email">
                  <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
               <div class="form-group">
                  <label class="col-form-label">Phone Number</label>
                  <input type="number" class="form-control" wire:model="phone_number">
                  <?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
               <div class="form-group">
                  <label class="col-form-label">Website</label>
                  <input type="text" class="form-control" wire:model="website">
                  <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" wire:click="close()">Close</button>
               <?php if($editCode): ?>
                  <?php
                     $editCode2 = json_encode($editCode);
                  ?>
                  <button type="button" class="btn btn-primary" wire:click="update_client(<?php echo e($editCode2); ?>)"><i class="fa fa-save"></i> Update Client</button>
               <?php else: ?>
                  <button type="button" class="btn btn-success" wire:click="add_client()"><i class="fa fa-save"></i> Add Client</button>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>

   <!-- Delete -->
   <div wire:ignore.self id="delete" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-confirm">
         <?php if($editCode): ?>
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
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="delete_close()">Cancel</button>
                  <?php
                     $editCode2 = json_encode($editCode);
                  ?>
                  <button type="button" class="btn btn-danger" wire:click="delete(<?php echo e($editCode2); ?>)">Delete</button>
               </div>
            </div>
         <?php endif; ?>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/jobs/clients.blade.php ENDPATH**/ ?>