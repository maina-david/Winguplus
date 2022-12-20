<?php $__env->startSection('title','Survey'); ?>

<?php $__env->startSection('content'); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Survey </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Survey</a></li>
                     <li class="breadcrumb-item active">List</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="row">
      <div class="col-md-12">
         <a href="<?php echo route('survey.create'); ?>" class="btn btn-primary btn-sm mb-2">Add Survey</a>
         <div class="card">
            <div class="card-body">
               <table class="table table-striped table-bordered zero-configuration">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        
                        <th>Title</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date Create</th>
                        <th width="16%">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $__currentLoopData = $surveries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$survery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="odd gradeX">
                           <td width="1%" class="f-s-600 text-inverse"><?php echo $count+1; ?></td>
                           
                           <td><?php echo $survery->title; ?></td>
                           <td>
                              <?php echo e(date('j M Y',strtotime($survery->start_date))); ?>

                           </td>
                           <td><?php echo e(date('j M Y',strtotime($survery->end_date))); ?></td>
                           <td><?php echo $survery->type; ?></td>
                           <td><span class="badge <?php echo $survery->name; ?>"><?php echo $survery->name; ?></span></td>
                           <td><?php echo e(date('j M Y',strtotime($survery->updated_at))); ?></td>
                           <td>
                              <a href="<?php echo route('survey.show',$survery->code); ?>" class="btn btn-sm btn-warning"><i class="fas fa-eye" aria-hidden="true"></i></a>
                              <a href="<?php echo route('survey.edit',$survery->code); ?>" class="btn btn-sm btn-info"><i class="far fa-edit" aria-hidden="true"></i></a>
                              <a href="<?php echo route('survey.delete',$survery->code); ?>" class="btn btn-sm btn-danger delete"><i class="far fa-trash-alt" aria-hidden="true"></i></a>
                           </td>
                        </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/survey/survey/index.blade.php ENDPATH**/ ?>