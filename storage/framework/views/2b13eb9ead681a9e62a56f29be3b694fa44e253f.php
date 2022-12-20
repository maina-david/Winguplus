<div>
   <div class="row">
      <div class="col-md-12">
         <a href="" data-toggle="modal" data-target=".repair" class="btn btn-sm btn-primary"><i class="fal fa-tools"></i> Add Repair Log</a>
      </div>
      <div class="col-md-12 mt-3">
         <table class="table table-bordered table-striped">
            <thead>
               
               <th>Repair date</th>
               <th>Date Completed</th>
               <th>Assigned to </th>
               <th>Supplier </th>
               <th>Repair Cost </th>
               <th width="12%">Action </th>
            </thead>
            <tbody>
               <?php $__currentLoopData = $repairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                     
                     <th>
                        <?php echo date('F jS, Y', strtotime($repair->action_date)); ?>

                     </th>
                     <th>
                        <?php if($repair->due_action_date): ?>
                           <?php echo date('F jS, Y', strtotime($repair->due_action_date)); ?>

                        <?php endif; ?>
                     </th>
                     <th>
                        <?php if($repair->employee): ?>
                           <?php echo Hr::employee($repair->employee)->names; ?>

                        <?php endif; ?>
                     </th>
                     <th>
                        <?php if(Finance::check_supplier($repair->supplier) == 1): ?>
                           <b><?php echo Finance::supplier($repair->supplier)->supplier_name; ?></b>
                        <?php endif; ?>
                     </th>
                     <th>
                        <?php if($repair->cost): ?>
                           <?php echo number_format($repair->cost); ?><?php echo Wingu::business()->currency; ?>

                        <?php endif; ?>
                     </th>
                     <th>
                        <?php
                           $getCode = json_encode($repair->code);
                        ?>
                        <a wire:click="edit(<?php echo e($getCode); ?>)" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editRepair" href="#">Edit</a>
                        <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete" wire:click="remove(<?php echo e($getCode); ?>)" href="#" >Delete</a>
                     </th>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
      </div>
      <div wire:ignore.self class="modal fade" id="editRepair" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <?php if($editMode == 'on'): ?>
               <div class="modal-content">
                  <div class="modal-header">
                     <h3 class="modal-title" id="exampleModalLabel"><i class="fal fa-tools"></i> Edit Repair Asset</h3>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <label for="" class="text-danger">Repair date </label>
                              <input type="date" class="form-control" wire:model="action_date" required>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Date Completed </label>
                              <input type="date" class="form-control" wire:model="due_action_date">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Employee </label>
                              <select wire:model="employee" class="form-control select2">
                                 <?php if($this->employee): ?>
                                    <?php if(Hr::check_employee($this->employee) == 1): ?>
                                       <option value="<?php echo $this->employee; ?>"><?php echo Hr::employee($this->employee)->names; ?></option>
                                    <?php else: ?>
                                       <option value="">Choose Employee</option>
                                    <?php endif; ?>
                                 <?php else: ?>
                                    <option value="">Choose Employee</option>
                                 <?php endif; ?>
                                 <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $emp->employee_code; ?>"><?php echo $emp->names; ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Suppliers </label>
                              <select class="form-control select2" wire:model="supplier">
                                 <?php if($this->supplier): ?>
                                    <?php if(Finance::check_supplier($this->supplier) == 1): ?>
                                       <option value="<?php echo $this->supplier; ?>"><?php echo Finance::supplier($this->supplier)->supplier_name; ?></option>
                                    <?php else: ?>
                                       <option value="">Choose Supplier</option>
                                    <?php endif; ?>
                                 <?php else: ?>
                                    <option value="">Choose Supplier</option>
                                 <?php endif; ?>
                                 <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $sup->supplier_code; ?>"><?php echo $sup->supplier_name; ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Repair Cost</label>
                              <input type="number" class="form-control" wire:model="cost">
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Note </label>
                              <textarea name="note" class="form-control tinymcy" wire:model="note" rows="6"></textarea>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <center>
                        <button type="submit" class="btn btn-pink submitRepairForm" wire:click.prevent="update()">Update Information</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                     </center>
                  </div>
               </div>
            <?php endif; ?>
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
</div>

<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/assets/assets/repairs.blade.php ENDPATH**/ ?>