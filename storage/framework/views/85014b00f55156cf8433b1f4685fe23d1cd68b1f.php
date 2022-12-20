<div>
   <div class="row mb-2">
      <div class="col-md-6">
         <input type="text" wire:model="search" class="form-control" placeholder="Search by lead name, phone number or email">
      </div>
   </div>
   <div class="panel panel-default">
      <div class="panel-body">
         <table id="data-table-default" class="table table-striped table-bordered">
            <thead>
               <tr role="row">
                  <th width="1%">#</th>
                  <th>Lead Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Assigned</th>
                  <th>Status</th>
                  <th>Date Added</th>
                  <th width="10%">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if(Auth::user()->business_code == $lead->business_code): ?>
                  <tr>
                     <td><?php echo $count+1; ?></td>
                     <td><?php echo $lead->customer_name; ?></td>
                     <td><?php echo $lead->email; ?></td>
                     <td><?php echo $lead->primary_phone_number; ?></td>
                     <td>
                        <?php if(Wingu::check_user($lead->assigned) == 1): ?>
                           <?php echo Wingu::user($lead->assigned)->name; ?>

                        <?php endif; ?>
                     </td>
                     <td>
                        <?php if(Crm::check_lead_status($lead->status)): ?>
                           <span class="badge badge-pink"><?php echo Crm::lead_status($lead->status)->name; ?></span>
                        <?php endif; ?>
                     </td>
                     <td>
                        <?php echo date("F d, Y", strtotime($lead->created_at)); ?>

                     </td>
                     <td>
                        <div class="btn-group">
                           <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                           <ul class="dropdown-menu">
                              <li><a href="<?php echo e(route('crm.leads.show', $lead->customer_code)); ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                              <li><a href="<?php echo route('crm.leads.edit',$lead->customer_code); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                              <li><a href="<?php echo route('crm.leads.delete', $lead->customer_code); ?>" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                           </ul>
                        </div>
                     </td>
                  </tr>
                  <?php endif; ?>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
         <?php echo $leads->links('pagination.custom'); ?>

      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/crm/leads/index.blade.php ENDPATH**/ ?>