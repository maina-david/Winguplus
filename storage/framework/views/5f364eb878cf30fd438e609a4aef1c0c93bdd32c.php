<div>
   <div class="row">
      <div class="col-md-12">
         <a href="#" class="btn btn-pink btn-sm m-b-10 p-l-5 offset-md-10 float-right" title="Add Category" data-toggle="modal" data-target="#CategoryModel">
            <i class="fal fa-plus-circle"></i> Add Category
         </a>
      </div>
   </div>
   <table class="table table-striped table-bordered">
      <thead>
         <tr>
            <th width="1%">#</th>
            <th>Name</th>
            <th>Description</th>
            <th width="20%"><center>Action</center></th>
         </tr>
      </thead>
      <tbody>
         <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($cat->business_code == Auth::user()->business_code): ?>
               <tr>
                  <td><?php echo $count+1; ?></td>
                  <td><?php echo $cat->name; ?></td>
                  <td><?php echo $cat->description; ?></td>
                  <td>
                     <?php
                        $getEditCode = json_encode($cat->category_code);
                     ?>
                     <a wire:click="edit(<?php echo e($getEditCode); ?>)" data-toggle="modal" data-target="#CategoryModel" class="btn btn-pink btn-sm" href="#"><i class="far fa-edit"></i> Edit</a>
                     <a wire:click="remove(<?php echo e($getEditCode); ?>)" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-sm" href="#"><i class="fas fa-trash"></i> Delete</a>
                  </td>
               </tr>
            <?php endif; ?>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
   </table>
   <?php echo $category->links(); ?>

   <div wire:ignore.self class="modal fade" id="CategoryModel" tabindex="-1" role="dialog" aria-labelledby="CategoryModel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <?php if($editMode == 'true'): ?>
                  <h4 class="modal-title">Edit Expense Category</h4>
               <?php else: ?>
                  <h4 class="modal-title">Add Expense Category</h4>
               <?php endif; ?>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <div class="form-group form-group-default required ">
                  <?php echo Form::label('Category Name', 'Category Name', array('class'=>'control-label')); ?>

                  <input type="text" wire:model="name" class="form-control" placeholder="Enter category name" required>
                  <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
               </div>
               <div class="form-group">
                  <?php echo Form::label('Description', 'Description', array('class'=>'control-label')); ?>

                  <textarea wire:model="description" class="form-control" rows="9"></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <?php if($editMode == 'true'): ?>
                  <button type="submit" wire:click.prevent="update_category()" class="btn btn-primary">Edit Information</button>
               <?php else: ?>
                  <button type="submit" wire:click.prevent="save_category()" class="btn btn-success">Submit Information</button>
               <?php endif; ?>
            </div>
         </div>
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/finance/expenses/category.blade.php ENDPATH**/ ?>