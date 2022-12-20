<div class="container">
   <div class="py-5 text-center">
     <h2 class="text-center">Select the perfect applications for your business.</h2>
   </div>
   <div class="row">
      <div class="col-md-4 order-md-2 mb-4">
         <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Selected Applications</span>
            <span class="badge badge-pink badge-pill"><?php echo number_format($cart->sum('qty')); ?></span>
         </h4>
         <form action="<?php echo route('winguplus.apps.install'); ?>" method="post">
            <?php echo csrf_field(); ?>
            <ul class="list-group mb-3">
               <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                     <div>
                        <h6 class="my-0"><?php echo $item->module_name; ?></h6>
                        <small class="text-muted"><i><?php echo $item->description; ?></i></small><br>
                        <a href="#" wire:click="confirm_remove(<?php echo e($item->id); ?>)" data-toggle="modal" data-target="#delete"><span class="badge badge-danger">Remove</span></a>
                     </div>
                     <span class="text-muted">$<?php echo $item->price; ?>/Mo</span>
                  </li>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
               <li class="list-group-item d-flex justify-content-between">
                  <span>Amount (USD)</span>
                  <strong>$<?php echo number_format($cart->sum('total_amount')); ?>/Mo</strong>
               </li>
               <li class="list-group-item d-flex justify-content-between">
                  <span class="text-pink">Trial Discount (USD)</span>
                  <strong class="text-pink">$<?php echo number_format($cart->sum('total_amount')); ?>/Mo</strong>
               </li>
               <li class="list-group-item d-flex justify-content-between">
                  <span>Total (USD)</span>
                  <strong>$0/Mo</strong>
               </li>
            </ul>
            
            <div class="card">
               <div class="card-body">
                  <button class="btn btn-primary btn-lg btn-block mt-2 submit" type="submit">Install Applications</button>
                  <center><img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="45%"></center>
               </div>
            </div>
         </form>
      </div>
      <div class="col-md-8 order-md-1">
         <h4 class="mb-3">Applications</h4>
         <div class="row">
            <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php if($app->module_code != 'settings'): ?>
                  <?php if(Wingu::check_business_modules($app->module_code) != 1): ?>
                     <div class="col-md-4">
                        <div class="card">
                           <div class="card-body text-center">
                              <?php echo $app->icon; ?>

                              <p class="mt-1"><?php echo $app->name; ?></p>
                           </div>
                           <div class="card-footer">
                              <div class="row">
                                 <div class="col-md-6">
                                    <h4 class="font-weight-bold text-pink">$<?php echo number_format($app->price); ?>/Mo</h4>
                                 </div>
                                 <div class="col-md-6">
                                    <?php
                                       $appCode = json_encode($app->module_code);
                                    ?>
                                    <?php if($app->status == 15): ?>
                                       <a wire:click="add_to_cart(<?php echo e($appCode); ?>)" class="btn btn-sm btn-success float-right" href="#"><i class="fal fa-plus-circle"></i></a>
                                    <?php endif; ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  <?php endif; ?>
               <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
               <button type="button" class="btn btn-secondary" wire:click="close()">Cancel</button>
               <button type="button" class="btn btn-danger" wire:click="remove_cart()">Delete</button>
            </div>
         </div>
      </div>
   </div>

</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/wingu/apps.blade.php ENDPATH**/ ?>