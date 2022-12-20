<div>
   <div wire:ignore.self class="modal fade" id="kt_modal_users_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!--begin::Modal dialog-->
      <div class="modal-dialog modal-lg">
         <!--begin::Modal content-->
         <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header no-border">
               <h3 class="modal-title text-center" id="exampleModalLabel"></h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body">
               <!--begin::Content-->
               <div class="text-center mb-3">
                  <h2 class="mb-3">Search Users</h2>
                  <div class="text-muted mb-0">Add Members To This Job</div>
               </div>
               <!--begin::Input-->
               <div class="row mb-5">
                  <div class="col-md-12">
                     <input type="text" class="form-control px-15" placeholder="Search by Name or email..." wire:model="search" />
                  </div>
                  <div class="col-md-12 mt-5">
                     <div class="row">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if(Job::check_if_job_member($this->jobCode,$user->user_code) == 0): ?>
                              <div class="col-md-6 mb-3">
                                 <div class="rounded d-flex bg-silver-transparent-9 flex-stack bg-active-lighten p-4">
                                    <div class="d-flex align-items-center">
                                       <div class="symbol symbol-35px symbol-circle">
                                          <?php if($user->avatar): ?>
                                             <img alt="<?php echo $user->name; ?>" src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/users/'.$user->user_code.'/'.$user->avatar); ?>">
                                          <?php else: ?>
                                             <img alt="Pic" src="https://ui-avatars.com/api/?name=<?php echo $user->name; ?>&rounded=true&size=70">
                                          <?php endif; ?>
                                       </div>
                                       <div class="ms-5">
                                          <a href="#" class="fw-bolder text-gray-900 text-hover-primary mb-2"><?php echo $user->name; ?></a>
                                          <div class="fw-bold text-muted"><?php echo $user->email; ?></div>
                                       </div>
                                    </div>
                                    <?php
                                       $userCode = json_encode($user->user_code);
                                       $code = json_encode($this->jobCode);
                                    ?>
                                    <div class="ms-2 w-80px">
                                       <a wire:click="add_member(<?php echo e($code); ?>,<?php echo e($userCode); ?>)" class="btn btn-sm btn-success btn-block text-white"><i class="fal fa-user-plus"></i> Add</a>
                                    </div>
                                 </div>
                              </div>
                           <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/jobs/job/add-member-modal.blade.php ENDPATH**/ ?>