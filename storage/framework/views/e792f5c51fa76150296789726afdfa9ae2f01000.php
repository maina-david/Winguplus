<div>
   <div class="card">
      <div class="card-body">
         <table class="table table-striped table-bordered">
            <thead>
               <th width="1%">#</th>
               <th>Title</th>
               <th>Start Date</th>
               <th>End Date</th>
               
               <th width="13%">Action</th>
            </thead>
            <tbody>
               <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                     <td><?php echo $count+1; ?></td>
                     <td><?php echo $event->title; ?></td>
                     <td><?php echo $event->start_date; ?></td>
                     <td><?php echo $event->end_date; ?></td>
                     
                     <td>
                        <a href="<?php echo route('hrm.events.edit',$event->event_code); ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="<?php echo route('hrm.events.delete',$event->event_code); ?>" class="btn btn-sm btn-danger delete">Delete</a>
                     </td>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/hr/events/index.blade.php ENDPATH**/ ?>