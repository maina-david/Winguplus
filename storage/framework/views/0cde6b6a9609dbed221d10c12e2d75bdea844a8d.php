<div class="card">
   <div class="card-body">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <tr>
            <th>#</th>
            <th>Names</th>
            <th>Email Address</th>
            <th>Work Phone</th>
            <th>Mobile</th>
            <th>Skype Name/Number</th>
            <th>Designation</th>
            <th>Department</th>
            <th>Action</th>
         </tr>
         <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v => $cp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <td><?php echo e($v+1); ?></td>
               <td><?php echo $cp->names; ?></td>
               <td><?php echo $cp->contact_email; ?></td>
               <td><?php echo $cp->work_phone; ?></td>
               <td><?php echo $cp->mobile_phone; ?></td>
               <td><?php echo $cp->skype_id; ?></td>
               <td><?php echo $cp->designation; ?></td>
               <td><?php echo $cp->department; ?></td>
               <td colspan="" rowspan="" headers="">
                  <div class="btn-group sm-m-t-10">
                     <a class="btn btn-danger" href="<?php echo e(route('finance.contactperson.delete',$cp->id)); ?>"><i class="fas fa-trash-alt"></i></a>
                  </div>
               </td>
            </tr>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </table>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/customer/contacts.blade.php ENDPATH**/ ?>