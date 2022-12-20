<div class="row">
   <div class="col-md-6">
      <div class="panel panel-inverse">
         <div class="panel-body">
            <div class="panel-body">
               <div class="row">
                  <div class="col-md-12 mb-3">
                     <input type="text" wire:model="search" placeholder="Search by category name" class="form-control">
                  </div>
               </div>
               <table class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th width="20%">Name</th>
                        <th width="20%">Parent</th>
                        <th class="text-center" width="20%">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$all): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($all->business_code == Auth::user()->business_code): ?>
                           <tr>
                              <td><?php echo $count+1; ?></td>
                              <td><?php echo $all->name; ?></td>
                              <td class="font-weight-bold">
                                 <?php if(Finance::check_product_category($all->parent) == 1): ?>
                                    <?php echo Finance::product_category($all->parent)->name; ?>

                                 <?php endif; ?>
                              </td>
                              <td>
                                 <?php
                                    $code = json_encode($all->category_code);
                                 ?>
                                 <a href="#" wire:click="edit(<?php echo e($code); ?>)" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                 <a href="#" wire:click="remove(<?php echo e($code); ?>)" data-toggle="modal" data-target="#delete"  class="btn btn-danger"><i class="fas fa-trash"></i></a>
                              </td>
                           </tr>
                        <?php endif; ?>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
               </table>
               <?php echo $category->links(); ?>

            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title"><?php if($editMode): ?> Edit <?php else: ?> Add <?php endif; ?> Category</h4>
         </div>
         <div class="panel-body">
            <div class="panel-body">
               <div class="form-group form-group-default required">
                  <?php echo Form::label('name', 'Name', array('class'=>'control-label')); ?>

                  <input type="text" class="form-control" wire:model="name" placeholder="Enter Category Name" required>
               </div>
               <div class="form-group">
                  <?php echo Form::label('title', 'Parent Category', array('class'=>'control-label')); ?>

                  <select wire:model="parent" class="form-control select2">
                     <option value="">Choose parent category</option>
                     <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo $cat->category_code; ?>"><?php echo $cat->name; ?></option>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
               </div>
               <div class="form-group mt-4">
                  <center>
                     <?php if($editMode): ?>
                        <button type="submit" class="btn btn-primary submit" wire:click.prevent="update()"><i class="fas fa-save"></i> Update Category</button>
                     <?php else: ?>
                        <button type="submit" class="btn btn-pink submit" wire:click.prevent="store()"><i class="fas fa-save"></i> Add Category</button>
                     <?php endif; ?>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="25%">
                  </center>
               </div>
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/finance/products/category.blade.php ENDPATH**/ ?>