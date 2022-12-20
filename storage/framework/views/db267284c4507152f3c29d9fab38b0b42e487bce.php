<?php $__env->startSection('title','Subscription Customer'); ?>

<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.subscriptions.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
         <?php if(Finance::count_customers() != Wingu::plan()->customers && Finance::count_customers() < Wingu::plan()->customers): ?>
            <?php if (app('laratrust')->isAbleTo('create-contact')) : ?>
               <a href="<?php echo route('subscription.customer.create'); ?>" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add a Customer</a>
               <a href="<?php echo route('finance.contact.import'); ?>" target="_blank" class="btn btn-primary"><i class="fal fa-file-upload"></i> Import Customer</a>
            <?php endif; // app('laratrust')->permission ?>
         <?php endif; ?>
         <a href="<?php echo route('finance.contact.export','csv'); ?>" class="btn btn-warning"><i class="fal fa-file-download"></i> Export Customer</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> Customers</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Customers List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th width="1%"><input type="checkbox" name="" id=""></th>
                     <th width="5">Image</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phonenumber</th>
                     <th>Receivables</th>
                     <th width="12%">Added at</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th><input type="checkbox" name="" id=""></th>
                     <th>Image</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phonenumber</th>
                     <th>Category</th>
                     <th width="12%">Added at</th>
                     <th>Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr >
                        <td><input type="checkbox" name="" id=""></td>
                        <td>                          
                           <?php if($contact->image != ""): ?>
                              <img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$contact->customer_code); ?>/images/<?php echo $contact->image; ?>" alt="" style="width:40px;height:40px" class="rounded-circle">
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
                        <td><?php echo $contact->email; ?></td>
                        <td><?php echo $contact->primary_phone_number; ?></td>
                        <td>
									00
                        </td>
                        <td><?php echo date('d F, Y', strtotime($contact->created_at)); ?></td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                              <ul class="dropdown-menu">
                                 <li><a href="<?php echo e(route('crm.customers.show',$contact->customerID)); ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                                 <li><a href="<?php echo e(route('subscription.customer.edit', $contact->customerID)); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                                 <?php if (app('laratrust')->isAbleTo('delete-contact')) : ?>
                                    <li><a href="<?php echo route('subscription.customer.delete', $contact->customerID); ?>" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                                 <?php endif; // app('laratrust')->permission ?>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/customer/index.blade.php ENDPATH**/ ?>