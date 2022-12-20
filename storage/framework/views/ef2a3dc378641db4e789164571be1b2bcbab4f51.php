<div>
   <div class="row mb-2">
      <div class="col-md-6">
         <input type="text" wire:model="search" class="form-control" placeholder="Search by lead name, phone number or email">
      </div>
   </div>
   <div class="panel panel-default">
      <div class="panel-body">
         <table class="table table-striped">
            <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php if(Auth::user()->business_code == $lead->business_code): ?>
                  <tr>
                     <td width="0.5%"><?php echo $count+1; ?></td>
                     <td width="3%">
                        <?php if($lead->image == ""): ?>
                           <img src="https://ui-avatars.com/api/?name=<?php echo $lead->customer_name; ?>&size=84" alt="<?php echo $lead->customer_name; ?>">
                        <?php else: ?>
                           <img width="84" height="81" alt="<?php echo $lead->customer_name; ?>" src="<?php echo asset('businesses/'.$lead->business_code.'/customer/'. $lead->customerCode.'/'.$lead->image); ?>">
                        <?php endif; ?>
                     </td>
                     <td class="text-left" width="60%">
                        <a href="<?php echo e(route('crm.leads.show', $lead->customer_code)); ?>" class="text-black"><h4 class="font-weight-bolder"><?php echo $lead->customer_name; ?></h4></a>
                        <p class="font-small">
                           <b>Phone :</b> <a href="tel:<?php echo $lead->primary_phone_number; ?>"><?php echo $lead->primary_phone_number; ?></a>
                           | <b>Email :</b> <a href="mailto:<?php echo $lead->email; ?>"><?php echo $lead->email; ?></a>
                           | <b>Mobile :</b> <a href="tel:<?php echo $lead->other_phone_number; ?>"><?php echo $lead->other_phone_number; ?></a>
                           
                           | <b>Title :</b> <?php echo $lead->designation; ?>

                           | <b>Lead Status :</b> <?php if(Crm::check_lead_status($lead->status) == 1): ?><span class="badge badge-pink"><?php echo Crm::lead_status($lead->status)->name; ?></span> <?php endif; ?>
                        </p>
                     </td>
                     <td>
                        <?php if(Wingu::check_user($lead->assigned) == 1): ?>
                           <?php
                              $user = Wingu::user($lead->assigned);
                           ?>
                           <div class="row mb-3">
                              <div class="col-md-2">
                                 <?php if($user->avatar): ?>
                                    <img width="40" height="40" alt="<?php echo $user->name; ?>" src="<?php echo asset('businesses/'.$lead->business_code.'/documents/images/'. $lead->avatar); ?>">
                                 <?php else: ?>
                                    <img src="https://ui-avatars.com/api/?rounded=true&name=<?php echo $user->name; ?>&size=40" alt="<?php echo $user->name; ?>">
                                 <?php endif; ?>
                              </div>
                              <div class="col-md-8 text-left">
                                 <b><?php echo $user->name; ?></b><br>
                                 <i><?php echo date('F jS, Y', strtotime($lead->created_at)); ?></i>
                              </div>
                           </div>
                        <?php endif; ?>
                        <a href="<?php echo e(route('crm.leads.show', $lead->customer_code)); ?>" class="btn btn-sm btn-outline-black"><i class="fas fa-eye"></i> View</a>
                        <a href="<?php echo route('crm.leads.edit',$lead->customer_code); ?>" class="btn btn-sm btn-outline-black"><i class="fas fa-edit"></i> Edit</a>
                        <a href="<?php echo route('crm.leads.delete', $lead->customer_code); ?>" class="btn btn-sm btn-outline-black delete"><i class="fas fa-trash-alt"></i> Delete</a>
                     </td>
                  </tr>
               <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </table>
         <?php echo $leads->links('pagination.custom'); ?>

      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/crm/leads/canvas.blade.php ENDPATH**/ ?>