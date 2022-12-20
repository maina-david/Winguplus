<div class="col-md-6">
   <div class="form-group form-group-default">
      <label for="">Asset Type/Category <a href="" class="float-right" data-toggle="modal" data-target="#addType">Add Type</a></label>
      <select name="asset_type" id="type" class="form-control select2">
         <?php if($editType): ?>
            <?php if($editType == 'xxxxxxx'): ?>
               <option value="xxxxxxx">Vehicle</option>
            <?php else: ?>
               <option value="<?php echo $editType; ?>"><?php echo Asset::type($editType)->name; ?></option>
            <?php endif; ?>
         <?php else: ?>
            <option value="" selected>Choose</option>
         <?php endif; ?>
         <option value="xxxxxxx">Vehicle</option>
         <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo $type->type_code; ?>"><?php echo $type->name; ?></option>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/assets/assets/types.blade.php ENDPATH**/ ?>