<?php $__env->startSection('title','Settings | Add Role'); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.settings.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Settings</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('settings.users.index'); ?>">Roles</a></li>
         <li class="breadcrumb-item active">List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shield-alt"></i>  Add Role</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <form action="<?php echo route('settings.roles.store'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
         <?php echo csrf_field(); ?>
         <div class="panel panel-default" data-sortable-id="ui-widget-1">
            <div class="panel-heading">
               <h4 class="panel-title">Add Role</h4>
            </div>
            <div class="panel-body">
               <div class="col-md-12">
                  <div class="form-group">
                     <label for="name" class="">Role Name</label>
                     <?php echo Form::text('display_name', null, array('class' => 'form-control')); ?>

                  </div>
                  <div class="form-group">
                     <label for="description">Description</label>
                     <?php echo Form::textarea('description', null, array('class' => 'form-control tinymcy')); ?>

                  </div>
               </div>
            </div>
         </div>
         <div id="accordion" class="accordion">
            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <div class="card">
                  <div class="card-header pointer-cursor d-flex align-items-center collapsed" data-toggle="collapse" data-target="#collapse<?php echo $module->moduleCode; ?>">
                     <?php echo $module->name; ?>

                  </div>
                  <div id="collapse<?php echo $module->moduleCode; ?>" class="collapse show" data-parent="#accordion">
                     <div class="card-body">
                        <div class="row">
                           <?php $__currentLoopData = Wingu::get_module_funations($module->moduleCode); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <div class="col-md-6">
                                 <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                       <th colspan="5"><?php echo $group->title; ?></th>
                                    </thead>
                                    <tr>
                                       <?php $__currentLoopData = Wingu::permissions_by_group($group->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <td>
                                             <div class="">
                                                <input type="checkbox" value="<?php echo $permission->id; ?>" name="permissions[]">
                                                <?php
                                                   echo substr($permission->display_name, 0, strrpos($permission->display_name, ' '));
                                                ?>
                                             </div>
                                          </td>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                 </table>
                              </div>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                     </div>
                  </div>
               </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </div>
         <button type="submit" class="btn btn-pink submit float-right mb-5"><i class="fas fa-save"></i> Create Role</button>
         <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none loat-right" alt="" width="10%">
      </form>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/settings/roles/create.blade.php ENDPATH**/ ?>