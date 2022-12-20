<?php $__env->startSection('title','Customer List | Customer Relationship Management'); ?>


<?php $__env->startSection('sidebar'); ?>
  <?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="<?php echo route('crm.customers.create'); ?>" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add a Customers</a>
         <a href="<?php echo route('finance.contact.import'); ?>" target="_blank" class="btn btn-primary"><i class="fal fa-file-upload"></i> Import Customer</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> All Customers</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Customer List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="5">Image</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phone Number</th>
                     <th>Category</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr >
                        <td><?php echo $count+1; ?></td>
                        <td>
                           <?php if($contact->image): ?>
                              <img src="<?php echo asset('businesses/'.$contact->business_code.'/customer/'.$contact->customer_code.'/'.$contact->image); ?>" alt="" style="width:40px;height:40px" class="rounded-circle">
                           <?php else: ?>
                              <img src="https://ui-avatars.com/api/?name=<?php echo $contact->customer_name; ?>&rounded=true&size=40" alt="">
                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if($contact->contact_type == 'Individual'): ?>
                              <?php echo $contact->salutation; ?> <?php echo $contact->customer_name; ?>

                           <?php else: ?>
                              <?php echo $contact->customer_name; ?>

                           <?php endif; ?>
                        </td>
                        <td><?php echo $contact->customer_email; ?></td>
                        <td><?php echo $contact->primary_phone_number; ?></td>
                        <td>
                           <?php if($contact->group && $contact->group != 'null'): ?>
                              <?php
                                 $groups = json_decode($contact->group,true);
                              ?>
                              <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <span class="badge badge-primary"><?php echo $group; ?></span>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php endif; ?>
                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                              <ul class="dropdown-menu">
                                 <li><a href="<?php echo e(route('crm.customers.show',$contact->customer_code)); ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                 <li><a href="<?php echo e(route('crm.customers.edit', $contact->customer_code)); ?>"><i class="fas fa-edit"></i> Edit</a></li>
                                 <li><a href="<?php echo route('crm.customers.delete', $contact->customer_code); ?>" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
                              </ul>
                           </div>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/customers/index.blade.php ENDPATH**/ ?>