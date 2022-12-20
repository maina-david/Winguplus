<div>
   <div class="row">
      <div class="col-md-12">
         <a href="#typeModal" data-toggle="modal" class="btn btn-pink mb-2 float-right"><i class="fas fa-plus-circle"></i> Add Leave Type</a>
      </div>
   </div>
   <table id="data-table-default" class="table table-striped table-bordered">
      <thead>
         <tr>
            <th width="5%"></th>
            <th class="text-nowrap">Type</th>
            <th class="text-nowrap" width="16%">Action</th>
         </tr>
      </thead>
      <tbody>
         <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <td><?php echo $count+1; ?></td>
               <td><?php echo $type->name; ?></td>
               <td>
                  <?php
                     $code = json_encode($type->type_code);
                  ?>
                  <a href="#typeModal" data-toggle="modal"  class="btn btn-primary btn-sm" wire:click="edit(<?php echo e($code); ?>)">Edit</a>
                  <a href="#" wire:click="remove(<?php echo e($code); ?>)" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-sm">Delete</a>
               </td>
            </tr>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
   </table>

   <div wire:ignore.self class="modal fade" id="typeModal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <form>
            <div class="modal-content">
               <div class="modal-header">
                  <?php if($typeCode): ?>
                     <h4 class="modal-title">Edit Type</h4>
                  <?php else: ?>
                     <h4 class="modal-title">Add Type</h4>
                  <?php endif; ?>
                  <button wire:click="close()" type="button"  class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <?php echo csrf_field(); ?>
                  <div class="form-group form-group-default required">
                     <?php echo Form::label('names', 'Leave Type', array('class'=>'control-label')); ?>

                     <input type="text" class="form-control" wire:model="name" placeholder="Enter Type" required>
                  </div>
               </div>
               <div class="modal-footer">
                  <?php if($typeCode): ?>
                     <button type="submit" class="btn btn-primary submit" wire:click.prevent="update()"><i class="fas fa-save"></i> Edit Type</button>
                  <?php else: ?>
                     <button type="submit" class="btn btn-success submit" wire:click.prevent="store()"><i class="fas fa-save"></i> Add Type</button>
                  <?php endif; ?>
               </div>
            </div>
         </form>
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/hr/leave/types.blade.php ENDPATH**/ ?>