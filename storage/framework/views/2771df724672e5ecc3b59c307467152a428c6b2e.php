<div>
   <div class="row">
      <div class="col-md-9">
         <h1 class="page-header">
            <i class="fal fa-code-branch"></i> Pipeline | <?php echo $pipeline->title; ?>

         </h1>
      </div>
      <div class="col-md-3">
         <select class="form-control" wire:model="pipelineCode">
            <option value="">Change Pipeline</option>
            <?php $__currentLoopData = $lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <option value="<?php echo $line->pipeline_code; ?>"><?php echo $line->title; ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </select>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <a wire:click="add_stage()" data-toggle="modal" data-target="#stageModal" href="#" class="btn btn-sm btn-warning float-right"><i class="fas fa-plus-circle"></i> Add Stage</a>
      </div>
      <div class="col-md-12">
         <div class="task-board">
            <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php
                  $getStageCode = json_encode($stages->stage_code);
               ?>
               <div class="status-card">
                  <div class="card-header" <?php if($stages->color): ?>style="color:#fff;background-color:<?php echo $stages->color; ?>;"<?php endif; ?>>
                     <span class="card-header-text mb-2">
                        <?php echo $stages->title; ?>

                        (<?php echo Crm::stage_deals($stages->stage_code)->count(); ?>)
                        <i class="far fa-horizontal-rule"></i>
                        <b>[ <?php echo $business->currency; ?> <?php echo number_format(Crm::stage_deals($stages->stage_code)->sum('value')); ?> ]</b>

                        <a wire:click="delete_alert(<?php echo e($getStageCode); ?>,'stage')" data-toggle="modal" data-target="#delete" href="#">
                           <i class="fas fa-trash-alt <?php if($stages->color): ?> text-white <?php else: ?> text-danger <?php endif; ?> float-right mr-2"></i>
                        </a>

                        <a wire:click="edit_stage(<?php echo e($getStageCode); ?>)" data-toggle="modal" data-target="#stageModal" href="#">
                           <i class="fas fa-edit <?php if($stages->color): ?> text-white <?php else: ?> text-info <?php endif; ?> float-right mr-2"></i>
                        </a>

                        <a wire:click="add_deal(<?php echo e($getStageCode); ?>)" data-toggle="modal" data-target="#dealModal" href="#">
                           <i class="fas fa-plus-circle <?php if($stages->color): ?> text-white <?php endif; ?> float-right mr-2"></i>
                        </a>
                     </span>
                  </div>
                  <ul class="sortable ui-sortable" id="sort<?php echo $stages->id; ?>" data-stage-code="<?php echo $stages->stage_code; ?>">
                     <?php $__currentLoopData = Crm::stage_deals($stages->stage_code); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stageDeals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                           $getDealCode = json_encode($stageDeals->deal_code);
                        ?>
                        <li class="text-row ui-sortable-handle" data-deal-code="<?php echo $stageDeals->deal_code; ?>" style="border-top: 5px solid <?php echo $stages->color; ?>;">
                           <h5>
                              <a href="<?php echo route('crm.deals.show',$stageDeals->deal_code); ?>" class="text-dark"><?php echo $stageDeals->title; ?></a>
                           </h5>
                           <p class="font-small">
                              <?php if($stageDeals->status): ?>
                                 <i class="fal fa-heartbeat"></i> Status :
                                 <span class="badge <?php echo Wingu::status($stageDeals->status)->name; ?>"><?php echo Wingu::status($stageDeals->status)->name; ?></span><br>
                              <?php endif; ?>
                              <?php if($stageDeals->close_date): ?>
                                 <b><i class="fal fa-calendar-day"></i> Close Date :</b>  <span class="text-success"><b><?php echo date('d F Y', strtotime($stageDeals->close_date)); ?></b></span>
                              <?php endif; ?>
                              <?php if($stageDeals->value): ?>
                                 <br><b><i class="far fa-funnel-dollar"></i> Value :</b>  <?php echo $business->currency; ?> <?php echo number_format($stageDeals->value); ?>

                              <?php endif; ?>
                              <?php if($stageDeals->owner): ?>
                                 <br><b><i class="far fa-user-headset"></i> Owner :</b>   <?php echo Wingu::user($stageDeals->owner)->name; ?>

                              <?php endif; ?>
                              <?php if($stageDeals->contact): ?>
                                 <?php if(Finance::check_client($stageDeals->contact) == 1): ?>
                                    <br><b><i class="far fa-user-crown"></i> Customer :</b> <?php echo Finance::client($stageDeals->contact)->customer_name; ?>

                                 <?php endif; ?>
                              <?php endif; ?>
                           </p>
                           <a href="<?php echo route('crm.deals.show',$stageDeals->deal_code); ?>" class="btn btn-xs btn-warning text-white"><i class="fal fa-eye"></i> View</a>
                           <a data-toggle="modal" data-target="#dealModal" wire:click="edit_deal(<?php echo e($getDealCode); ?>)" class="btn btn-xs btn-primary text-white"><i class="fal fa-edit"></i> Edit</a>
                           <a wire:click="delete_alert(<?php echo e($getDealCode); ?>,'deal')" data-toggle="modal" data-target="#delete" class="btn btn-xs btn-danger text-white"><i class="fal fa-trash"></i> Delete</a>
                        </li>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                  <a wire:click="add_deal(<?php echo e($getStageCode); ?>)" data-toggle="modal" data-target="#dealModal" href="#" class="badge badge-info ml-2 mt-2 mb-2"><i class="fas fa-plus-circle"></i> Add Deal</a>
               </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </div>
      </div>
   </div>

   <!-- Deal -->
   <div wire:ignore.self class="modal fade" id="dealModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">
                  <?php if($this->dealEdit == 'on'): ?>
                     Edit Deal
                  <?php else: ?>
                     Add Deal
                  <?php endif; ?>
               </h5>
               <button type="button" class="close" wire:click="close()" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <?php if($this->dealEdit == 'on'): ?>
               <form wire:submit.prevent="update_deal()">
            <?php else: ?>
               <form wire:submit.prevent="store_deal()">
            <?php endif; ?>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Deal Title</label>
                           <input type="text" class="form-control" wire:model="title" required>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Deal Value</label>
                           <input type="number" class="form-control" wire:model="value">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Expected close date</label>
                           <input type="date" class="form-control" wire:model="close_date">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Sales Owner</label>
                           <select wire:model="owner" class="form-control select2">
                              <option value="">Choose owner</option>
                              <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $user->user_code; ?>"><?php echo $user->name; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Related Customer</label>
                           <select wire:model="contact" class="form-control select2">
                              <option value="">Choose customer</option>
                              <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $customer->customer_code; ?>"><?php echo $customer->customer_name; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Status</label>
                           <select wire:model="status" class="form-control select2">
                              <option value="">Choose status</option>
                              <option value="45">Won</option>
                              <option value="46">Lost</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Details</label>
                           <textarea type="text" class="form-control" wire:model="description" rows="5"></textarea>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button class="btn btn-secondary" wire:click="close()">Close</button>
                  <?php if($this->dealEdit == 'on'): ?>
                     <button class="btn btn-primary"><i class="fas fa-save"></i> Update Deal</button>
                  <?php else: ?>
                     <button class="btn btn-primary"><i class="fas fa-save"></i> Save Deal</button>
                  <?php endif; ?>
               </div>
            </form>
         </div>
      </div>
   </div>

   <!-- stage -->
   <div wire:ignore.self class="modal fade" id="stageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">
                  <?php if($this->stageModal == 'add'): ?>
                     Add Stage
                  <?php else: ?>
                     Edit Stage
                  <?php endif; ?>
               </h5>
               <button type="button" class="close" wire:click="close()" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <?php if($this->stageModal == 'add'): ?>
               <form wire:submit.prevent="store_stage()">
            <?php else: ?>
               <form wire:submit.prevent="update_stage()">
            <?php endif; ?>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Stage Title</label>
                           <input type="text" class="form-control" wire:model="stage_title" required>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Label</label>
                           <select wire:model="color" class="form-control">
                              <option value="">Choose Label</option>
                              <option value="#468847">Green</option>
                              <option value="#348fe2">Blue</option>
                              <option value="#ebeb35">Yellow</option>
                              <option value="#000000">Black</option>
                              <option value="#8753de">Purple</option>
                              <option value="#FF0000">Red</option>
                              <option value="#00FFFF">Cyan / Aqua</option>
                              <option value="#FF00FF">Magenta / Fuchsia	</option>
                              <option value="#C0C0C0">Silver</option>
                              <option value="#808080">Gray</option>
                              <option value="#800000">Maroon</option>
                              <option value="#808000">Olive</option>
                              <option value="#008080">Teal</option>
                              <option value="#f59c1a">Orange</option>
                              <option value="#000080">Navy</option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button class="btn btn-secondary" wire:click="close()">Close</button>
                  <button class="btn btn-primary"><i class="fas fa-save"></i> Save Information</button>
               </div>
            </form>
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

               <?php if($this->deleteType == 'deal'): ?>
                  <button type="button" class="btn btn-danger" wire:click="delete_deal(<?php echo e(json_encode($this->deleteCode)); ?>)">Delete</button>
               <?php endif; ?>
               <?php if($this->deleteType == 'stage'): ?>
                  <button type="button" class="btn btn-danger" wire:click="delete_stage(<?php echo e(json_encode($this->deleteCode)); ?>)">Delete</button>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/crm/deals/grid.blade.php ENDPATH**/ ?>