<div class="col-md-6">
   <div class="form-group form-group-default">
      <label for="">Department <a href="" class="float-right" data-toggle="modal" data-target="#addDepartment">Add Department</a></label>
      <select name="department" class="form-control select2">
         <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo $department->department_code; ?>"><?php echo $department->title; ?></option>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/assets/assets/departments.blade.php ENDPATH**/ ?>