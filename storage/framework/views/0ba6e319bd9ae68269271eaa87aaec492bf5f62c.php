<div class="col-md-6">
   <div class="panel">
      <div class="panel-heading mb-0">
         <h4>Team Members</h4>
      </div>
      <div class="panel-body">
         <div class="widget-list rounded">
            <div class="row">
               <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-md-6 mb-3">
                     <div class="widget-list-item">
                        <div class="widget-list-media">
                           <img src="../assets/img/user/user-12.jpg" width="50" alt=""  />
                           <?php if($member->avatar): ?>
                              <img alt="<?php echo $member->name; ?>" src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/users/'.$member->user_code.'/'.$member->avatar); ?>" class="rounded">
                           <?php else: ?>
                              <img alt="<?php echo $member->name; ?>" src="https://ui-avatars.com/api/?name=<?php echo $member->name; ?>&rounded=true&size=50" class="rounded">
                           <?php endif; ?>
                        </div>
                        <div class="widget-list-content">
                           <h4 class="widget-list-title"><?php echo $member->name; ?></h4>
                           <p class="widget-list-desc">Total Tasks : </p>
                        </div>
                        <?php
                           $userCode = json_encode($member->user_code);
                           $code = json_encode($this->jobCode);
                        ?>
                        <div class="widget-list-action">
                           <a href="#" data-toggle="dropdown" class="text-gray-500"><i class="fa fa-ellipsis-h fs-14px"></i></a>
                           <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item">View Tasks</a>
                              <a class="dropdown-item delete" wire:click="remove_member(<?php echo e($code); ?>,<?php echo e($userCode); ?>)">Remove</a>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/jobs/job/dashboard/team-members.blade.php ENDPATH**/ ?>