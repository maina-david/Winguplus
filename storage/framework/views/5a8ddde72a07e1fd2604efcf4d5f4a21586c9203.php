<div>
   <!-- begin panel -->
   <div class="panel panel-inverse">
      <div class="panel-body">
         <div class="row mb-3">
            <div class="col-md-6">
               <label for="">Search</label>
               <input type="text" wire:model="search" class="form-control" placeholder="Search by employee name">
            </div>
            <div class="col-md-2">
               <label for="">Items Per</label>
               <select wire:model="perPage" class="form-control">`
                  <option value="10" selected>10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
               </select>
            </div>
         </div>
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th width="1%">#</th>
                  <th width="5%"></th>
                  <th >Name</th>
                  <th >Email</th>
                  <th >Leave Days</th>
                  <th width="7%">Contract</th>
                  <th width="12%">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                     $status = Wingu::status($employee->current_status);
                  ?>
                  <tr role="row" class="odd">
                     <td><?php echo $count+1; ?></td>
                     <td>
                        <?php if($employee->image != ""): ?>
                           <img class="rounded-circle" width="42" height="42" alt="<?php echo $employee->names; ?>" src="<?php echo asset('businesses/'.$employee->businessCode.'/hr/employee/images/'.$employee->image); ?>">
                        <?php else: ?>
                           <img src="https://ui-avatars.com/api/?name=<?php echo $employee->names; ?>&rounded=true&size=42" alt="">
                        <?php endif; ?>
                     </td>
                     <td>
                        <p class="mb-0"><?php echo $employee->names; ?></p>
                        <?php if($employee->current_status): ?>
                           <span class="badge <?php echo $status->name; ?>"><?php echo $status->name; ?></span>
                        <?php endif; ?>
                     </td>
                     <td><?php echo $employee->company_email; ?></td>
                     <td><?php echo $employee->leave_days; ?></td>
                     <td><b><?php echo $employee->contract_type; ?></b></td>
                     <td>
                        <?php
                           $getCode = json_encode($employee->employeeID);
                        ?>
                        <a href="<?php echo e(route('hrm.employee.edit',$getCode)); ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        
                        <a href="#" class="btn btn-sm btn-danger"  wire:click="confirm_delete(<?php echo e($getCode); ?>)" data-toggle="modal" data-target="#delete"><i class="fas fa-trash"></i></a>
                     </td>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
         <?php echo $employees->links('pagination.custom'); ?>

      </div>
   </div>
   <!-- end panel -->

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
               <button type="button" class="btn btn-danger" wire:click="delete()">Delete</button>
            </div>
         </div>
      </div>
   </div>

</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/hr/employees/index.blade.php ENDPATH**/ ?>