<div>
   <div class="row">
      <div class="col-md-12 mb-3">
         <div class="row">
            <div class="col-md-10">
               <h4 class="font-weight-bold">
                  <i class="far fa-bullseye-arrow"></i>
                  <a href="<?php echo route('job.dashboard',$this->jobCode); ?>"><?php echo $job->job_title; ?></a> | Goals
               </h4>
            </div>
            <div class="col-md-2">
               <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#goalModal">
                  <i class="fas fa-plus-circle"></i> Add Goal
               </button>
            </div>
         </div>
      </div>
      <div class="col-md-12 mt-3">
         <div class="card">
            <div class="card-body">
               <div class="row mb-3">
                  <div class="col-md-6">
                     <label for="">Search</label>
                     <input type="text" wire:model="search" class="form-control" placeholder="Enter goal name">
                  </div>
               </div>
               <table class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th>Goal</th>
                        <th>Progress</th>
                        
                        <th>Achievement</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Goal Type</th>
                        <th>Status</th>
                        <th width="12%">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($goal->business_code == Auth::user()->business_code): ?>
                           <tr>
                              <td><?php echo $count+1; ?></td>
                              <td><?php echo $goal->title; ?></td>
                              <td>
                                 <?php if($goal->goal_type == 'Custom'): ?>
                                    <?php
                                       $progress = Job::calculate_goal_progress($goal->goal_code,$goal->achievement)->getData();
                                    ?>
                                    <b>Achievement : </b> <?php echo $progress->total_achievement; ?></br>
                                    <?php if($progress->total_achievement >= $goal->achievement): ?>
                                       <div class="progress h-10px rounded-pill mb-5px">
                                          <div class="progress-bar progress-bar-striped progress-bar-animated bg-green fs-10px fw-bold" style="width: 100%;">100%</div>
                                       </div>
                                    <?php else: ?>
                                       <div class="progress h-10px rounded-pill mb-5px">
                                          <div class="progress-bar progress-bar-striped progress-bar-animated bg-orange fs-10px fw-bold" style="width: <?php echo $progress->percentage; ?>%;"><?php echo $progress->percentage; ?>%</div>
                                       </div>
                                    <?php endif; ?>
                                 <?php endif; ?>
                              </td>
                              <td><?php echo number_format($goal->achievement); ?></td>
                              <td><?php echo date('F jS, Y', strtotime($goal->start_date)); ?></td>
                              <td><?php echo date('F jS, Y', strtotime($goal->end_date)); ?></td>
                              <td><?php echo $goal->goal_type; ?></td>
                              <td>
                                 <?php if($goal->goal_type == 'Custom'): ?>
                                    <?php if($progress->total_achievement >= $goal->achievement): ?>
                                       <a href="" class="badge badge-success">Complete</a>
                                    <?php else: ?>
                                       <a href="" class="badge badge-warning">In-progress</a>
                                    <?php endif; ?>
                                 <?php endif; ?>
                              </td>
                              <td>
                                 <?php
                                    $getCode = json_encode($goal->goal_code);
                                 ?>
                                 <a href="#" wire:click="goal_details(<?php echo e($getCode); ?>)" data-toggle="modal" data-target="#goalDetails" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                                 <a href="#" wire:click="edit_goal(<?php echo e($getCode); ?>)" data-toggle="modal" data-target="#goalModal" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                 <a href="#" wire:click="delete(<?php echo e($getCode); ?>,'goal')" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                              </td>
                           </tr>
                        <?php endif; ?>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>

   <!-- Goal -->
   <div  wire:ignore.self class="modal fade" id="goalModal" tabindex="-1" role="dialog" aria-labelledby="addGoalTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <?php if($editMode == 'on'): ?>
                  <h5 class="modal-title" id="exampleModalLongTitle">Edit Goal</h5>
               <?php else: ?>
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Goal</h5>
               <?php endif; ?>
               <button type="button" class="close" wire:click="close()">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 mb-1">
                     <label for="">Goal Title</label>
                     <input type="text" wire:model="title" class="form-control">
                     <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                  <div class="col-md-6 mb-1">
                     <label for="">Goal Type</label>
                     <select type="text" wire:model="type" class="form-control">
                        <option value="">Choose type</option>
                        <option value="Custom">Custom Goal</option>
                     </select>
                     <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                  <div class="col-md-6 mb-1">
                     <label for="">Achievement</label>
                     <input type="number" wire:model="achievement" class="form-control">
                     <?php $__errorArgs = ['achievement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                  <div class="col-md-6 mb-1">
                     <label for="">Start date</label>
                     <input type="date" wire:model="start_date" class="form-control">
                     <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                  <div class="col-md-6 mb-1">
                     <label for="">End date</label>
                     <input type="date" wire:model="end_date" class="form-control">
                     <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                  <div class="col-md-12 mb-1">
                     <label for="">Description</label>
                     <textarea type="text" wire:model="description" class="form-control" rows="10"></textarea>
                     <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" wire:click="close()">Close</button>
               <?php if($editMode == 'on'): ?>
                  <button type="button" class="btn btn-primary" wire:click.prevent="update_goal()"><i class="fas fa-save"></i> Edit Information</button>
               <?php else: ?>
                  <button type="button" class="btn btn-success" wire:click.prevent="store_goal()"><i class="fas fa-save"></i> Submit Information</button>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>

   <!-- Goal details -->
   <div  wire:ignore.self class="modal right fade" id="goalDetails" tabindex="-1" role="dialog" aria-labelledby="right_modal_xl">
      <div class="modal-dialog modal-xl" role="document">
         <div class="modal-content">
            <?php if($goalDetails): ?>
               <div class="modal-header">
                  <h3 class="modal-title font-weight-bold"><?php echo $goalDetails->title; ?></h3>
                  <button type="button" class="close" wire:click="close()" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6">
                        <h4>Progress Records <a href="" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#progressModal"><i class="fas fa-plus-circle"></i> Add Progress</a></h4>
                        <hr>
                        <table class="table table-bordered table-striped">
                           <thead>
                              <th width="1%">#</th>
                              <th>Details</th>
                              <th width="1%"></th>
                           </thead>
                           <tbody>
                              <?php $__currentLoopData = $progresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$progress): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                    <td><?php echo $count + 1; ?></td>
                                    <td>
                                       <h4><b>Achievement</b> <?php echo $progress->achievement; ?></h4>
                                       <p><?php echo date('F jS, Y', strtotime($progress->from_date)); ?> - <?php echo date('F jS, Y', strtotime($progress->to_date)); ?></p>
                                       <hr>
                                       <p><?php echo $progress->note; ?></p>
                                    </td>
                                    <?php
                                       $getProgressCode = json_encode($progress->progress_code);
                                    ?>
                                    <td><a href="" wire:click="delete(<?php echo e($getProgressCode); ?>,'progress')" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                                 </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </tbody>
                        </table>
                     </div>
                     <div class="col-md-6">
                        <?php
                           $detailProgress = Job::calculate_goal_progress($goalDetails->goal_code,$goalDetails->achievement)->getData();
                        ?>
                        <h5>Details</h5>
                        <p>
                           <b>Start Date  :</b> <?php echo date('F jS, Y', strtotime($goalDetails->start_date)); ?></br>
                           <b>End Date    :</b> <?php echo date('F jS, Y', strtotime($goalDetails->end_date)); ?><br>
                           <b>Achievement Goal:</b> <?php echo $goalDetails->achievement; ?><br>
                           <b>Progress :</b> <?php echo $detailProgress->total_achievement; ?>

                        </p>
                        <hr>
                        <p><?php echo $goalDetails->description; ?></p>
                        <hr>
                        <h5>Progress</h5>
                        <?php if($detailProgress->total_achievement >= $goalDetails->achievement): ?>
                           <div class="progress h-10px rounded-pill mb-5px">
                              <div class="progress-bar progress-bar-striped progress-bar-animated bg-green fs-10px fw-bold" style="width: 100%;">100%</div>
                           </div>
                        <?php else: ?>
                           <div class="progress h-10px rounded-pill mb-5px">
                              <div class="progress-bar progress-bar-striped progress-bar-animated bg-orange fs-10px fw-bold" style="width: <?php echo $detailProgress->percentage; ?>%;"><?php echo $detailProgress->percentage; ?>%</div>
                           </div>
                        <?php endif; ?>
                     </div>
                  </div>
               </div>
               <div class="modal-footer modal-footer-fixed">
                  <button type="button" class="btn btn-danger" wire:click="close()" data-dismiss="modal">Close</button>
               </div>
            <?php endif; ?>
         </div>
      </div>
   </div>

   <!-- progress -->
   <div  wire:ignore.self class="modal fade" id="progressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Add Progress</h5>
               <button type="button" class="close" wire:click="close_progress()">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 mb-2">
                     <label for="">Achievement</label>
                     <input type="number" class="form-control" wire:model="progress_achievement">
                  </div>
                  <div class="col-md-12 mb-2">
                     <label for="">From</label>
                     <input type="date" class="form-control" wire:model="progress_from">
                  </div>
                  <div class="col-md-12 mb-2">
                     <label for="">To</label>
                     <input type="date" class="form-control" wire:model="progress_to">
                  </div>
                  <div class="col-md-12 mb-2">
                     <label for="">Achievement</label>
                     <textarea type="number" class="form-control" wire:model="progress_note" rows="10"></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger btn-sm" wire:click="close_progress()">Close</button>
               <button type="button" class="btn btn-success btn-sm" wire:click.prevent="add_progress()"><i class="fas fa-save"></i> Save Information</button>
            </div>
         </div>
      </div>
   </div>

   <!-- Delete -->
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
               <?php if($deleteType == 'goal'): ?>
                  <button type="button" class="btn btn-danger" wire:click="delete_goal()">Delete</button>
               <?php endif; ?>
               <?php if($deleteType == 'progress'): ?>
                  <button type="button" class="btn btn-danger" wire:click="delete_progress()">Delete</button>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/jobs/goals/goals.blade.php ENDPATH**/ ?>