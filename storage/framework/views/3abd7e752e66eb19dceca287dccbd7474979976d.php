<div class="row">
   <div class="col-md-6">
      <div class="panel panel-inverse">
         <div class="panel-body">
            <div class="panel-body">
               <div class="row">
                  <div class="col-md-12">
                     <input type="text" placeholder="Search by name" wire:model="search" class="form-control">
                  </div>
               </div>
               <table class="table table-striped table-bordered mt-3">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th width="20%">Name</th>
                        <th width="20%">Parent</th>
                        <th width="13%">Items</th>
                        <th class="text-center" width="15.5%">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$all): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(Auth::user()->business_code == $all->business_code): ?>
                           <tr>
                              <td><?php echo $count+1; ?></td>
                              <td><?php echo $all->name; ?></td>
                              <td class="font-weight-bold">
                                 <?php if(Finance::check_product_category($all->parent) == 1): ?>
                                    <?php echo Finance::product_category($all->parent)->name; ?>

                                 <?php endif; ?>
                              </td>
                              <td><?php echo Finance::products_by_category_count($all->category_code); ?></td>
                              <td>
                                 <?php
                                    $getCode = json_encode($all->category_code);
                                 ?>
                                 <a href="#" wire:click="edit(<?php echo e($getCode); ?>)" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                 <a href="#" wire:click="confirmDelete(<?php echo e($getCode); ?>)" data-toggle="modal" data-target="#delete" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                              </td>
                           </tr>
                        <?php endif; ?>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
               </table>
               <?php echo $categories->links(); ?>

            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <div class="panel panel-default">
         <div class="panel-heading">
            <?php if($editMode): ?>
               <h4 class="panel-title">Edit Category</h4>
            <?php else: ?>
               <h4 class="panel-title">Add Category</h4>
            <?php endif; ?>
         </div>
         <div class="panel-body">
            <div class="panel-body">
               <div class="form-group form-group-default required">
                  <?php echo Form::label('name', 'Name', array('class'=>'control-label')); ?>

                  <input type="text" wire:model="name" class="form-control" placeholder="Enter Category Name" required>
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
                  <?php echo Form::label('title', 'Parent Category', array('class'=>'control-label')); ?>

                  <select wire:model="parent" class="form-control">
                     <option value="">Choose parent category</option>
                     <?php $__currentLoopData = $allCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(Auth::user()->business_code == $cat->business_code): ?>
                           <option value="<?php echo e($cat->category_code); ?>"><?php echo $cat->name; ?></option>
                        <?php endif; ?>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <?php $__errorArgs = ['parent'];
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
                     <?php if($editMode): ?>
                        <button class="btn btn-primary" wire:click.prevent="update" wire:loading.class="none"><i class="fas fa-save"></i> Update Category</button>
                     <?php else: ?>
                        <button class="btn btn-pink" wire:click.prevent="store" wire:loading.class="none"><i class="fas fa-save"></i> Add Category</button>
                     <?php endif; ?>

                     <div wire:loading wire:target="update,store">
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load" alt="loader" width="25%">
                     </div>
                  </center>
               </div>
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
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="cancel_delete()">Cancel</button>
               <button type="button" class="btn btn-danger" wire:click="delete()">Delete</button>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/ecommerce/products/category.blade.php ENDPATH**/ ?>