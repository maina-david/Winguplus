<?php $__env->startSection('title','Settings | Users '); ?>

<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <?php if($users->count() == $businessPlan->users): ?>
            <a class="btn btn-pink" href="#"><i class="fal fa-user-plus"></i> Upgrade your plan</a>
         <?php else: ?>
            <a class="btn btn-pink" href="<?php echo route('settings.users.create'); ?>"><i class="fal fa-user-plus"></i> Add New User</a>
         <?php endif; ?>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> Users </h1>
      <div class="panel panel-default" data-sortable-id="ui-widget-1">
         <div class="panel-heading">
            <h4 class="panel-title">All User</h4>
         </div>
         <div class="panel-body">
            <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr role="row">
                     <th width="1%">#</th>
                     <th></th>
                     <th>Name</th>
                     <th>email</th>
                     <th>Last Login</th>
                     <th>Roles</th>
                     <th width="4%">Status</th>
                     <th width="10%"><center>Action</center></th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count+1; ?></td>
                        <td>
                           <?php if($user->avatar != ""): ?>
                              <img class="rounded-circle" width="40" height="40" alt="<?php echo $user->user_name; ?>" class="img-circle FL" src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/users/'.$user->user_code.'/'.$user->avatar); ?>">
                           <?php else: ?>
                              <img src="https://ui-avatars.com/api/?name=<?php echo $user->user_name; ?>&rounded=true&size=32" alt="<?php echo $user->user_name; ?>">
                           <?php endif; ?>
                        </td>
                        <td>
                           <p>
                              <?php echo $user->user_name; ?>

                              <?php if($user->branch_code): ?>
                                 <br>
                                 <?php if(Hr::check_branch($user->branch_code) == 1): ?>
                                    <span class="badge badge-pink"><?php echo Hr::branch($user->branch_code)->name; ?></span>
                                 <?php endif; ?>
                              <?php endif; ?>
                           </p>
                        </td>
                        <td><?php echo $user->email; ?></td>
                        <td>
                           <?php if($user->last_login != "" && $user->last_login_ip != ""): ?>
                              <p>
                                 <b>Date :</b> <?php echo date("F jS, Y", strtotime($user->last_login)); ?>@ <?php echo date("h:i:sa", strtotime($user->last_login)); ?><br>
                                 <b>IP :</b> <?php echo $user->last_login_ip; ?>

                              </p>
                           <?php endif; ?>
                        </td>
                        <td>
                           <?php $__currentLoopData = Wingu::user_roles($user->user_code); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <a href="#" class="badge badge-primary"><?php echo e($role->name); ?></a>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td>
                           <?php if($user->status): ?>
                              <span class="badge <?php echo $user->status_name; ?>"><?php echo $user->status_name; ?></span>
                           <?php endif; ?>
                        </td>
                        <td>
                           <a href="<?php echo route('settings.users.edit',$user->user_code); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/settings/users/index.blade.php ENDPATH**/ ?>