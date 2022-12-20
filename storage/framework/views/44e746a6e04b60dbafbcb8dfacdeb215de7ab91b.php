<div>
   <!-- begin panel -->
   <div class="row">
      <div class="col-md-6">
         <div class="panel panel-inverse">
            <div class="panel-body">
               <div class="panel-body">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th>Name</th>
                           <th width="30%">Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count+1; ?></td>
                              <td><?php echo $group->name; ?></td>
                              <td>
                                 <a href="#" wire:click="edit(<?php echo e($group->id); ?>)"  class="btn btn-pink btn-sm"><i class="far fa-edit"></i> Edit</a>
                                 <a href="#" data-toggle="modal" data-target="#deleteModal" wire:click="confirmDelete(<?php echo e($group->id); ?>)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
                  <?php echo $groups->links(); ?>

               </div>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">
                  <?php if($updateMode==true): ?>
                     Edit Category
                  <?php else: ?>
                     Add Category
                  <?php endif; ?>
               </h4>
            </div>
            <div class="panel-body">
               <div class="panel-body">
                  <form>
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('name', 'Name', array('class'=>'control-label')); ?>

                        <input type="text" wire:model.defer="name" class="form-control" placeholder="Enter category name" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                     </div>
                     <div class="form-group mt-4">
                        <center>
                           <?php if($updateMode==true): ?>
                              <button type="button" class="btn btn-warning" wire:click.prevent="update()" wire:loading.class="none"><i class="fas fa-save"></i> Update Category</button>
                           <?php else: ?>
                              <button type="button" class="btn btn-success" wire:click.prevent="store()" wire:loading.class="none"><i class="fas fa-save"></i> Add Category</button>
                           <?php endif; ?>
                           <div class="">

                           </div>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" wire:loading.class.remove="none" alt="" width="15%">
                        </center>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- delete subject -->
      <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Delete Confirm</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                  </button>
               </div>
               <div class="modal-body">
                  <p>Are you sure, you want to delete this category?</p>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                  <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal" data-dismiss="modal">Yes, Delete</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/salesflow/customers/groups.blade.php ENDPATH**/ ?>