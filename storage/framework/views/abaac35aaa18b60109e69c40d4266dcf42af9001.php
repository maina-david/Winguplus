<div>
   <div class="row mb-3">
      <div class="col-md-10">
         <label for="">Search</label>
         <input type="text" wire:model.debounce.300ms="search" class="form-control" placeholder="Enter customer name, email address or phone number">
      </div>
      <div class="col-md-2">
         <label for="">Items Per</label>
         <select wire:model="perPage" class="form-control">`
            <option value="30" selected>30</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
         </select>
      </div>
   </div>
   <div class="panel panel-default">
      <div class="panel-heading">
         <h4 class="panel-title">Customers List</h4>
      </div>
      <div class="panel-body">
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th width="1%">#</th>
                  <th width="5"></th>
                  <th>Customer/Company</th>
                  <th>Email</th>
                  <th>Phone Number</th>
                  <th width="10%">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($contact->business_code == Auth::user()->business_code): ?>
                     <?php if($contact->customerCode): ?>
                        <tr>
                           <td><?php echo $count+1; ?></td>
                           <td>
                              <?php if($contact->image == ""): ?>
                                 <img src="https://ui-avatars.com/api/?name=<?php echo $contact->customer_name; ?>&rounded=true&size=32" alt="">
                              <?php else: ?>
                                 <img width="40" height="40" alt="" class="img-circle" src="<?php echo asset('businesses/'.$contact->business_code.'/customer/'. $contact->customerCode.'/'.$contact->image); ?>">
                              <?php endif; ?>
                           </td>
                           <td>
                              <?php if($contact->salutation): ?>
                                 <?php echo $contact->salutation; ?>

                              <?php endif; ?>
                              <?php echo $contact->customer_name; ?>

                           </td>
                           <td><?php echo $contact->customer_email; ?></td>
                           <td><?php echo $contact->primary_phone_number; ?></td>
                           <td>
                              <div class="btn-group">
                                 <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                                 <ul class="dropdown-menu">
                                    <li><a href="<?php echo e(route('finance.contact.show',$contact->customerCode)); ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                    <li><a href="<?php echo e(route('salesflow.customer.edit',$contact->customerCode)); ?>"><i class="fas fa-edit"></i> Edit</a></li>
                                    <li><a href="<?php echo route('salesflow.customer.delete',$contact->customerCode); ?>" class="delete"><i class="fal fa-trash-alt"></i> Delete</a></li>
                                 </ul>
                              </div>
                           </td>
                        </tr>
                     <?php endif; ?>
                  <?php endif; ?>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
         <?php echo $contacts->links(); ?>

      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/salesflow/customers/index.blade.php ENDPATH**/ ?>