<?php $__env->startSection('title','All Category | Wingu CMS'); ?>
<?php $__env->startSection('breadcrumb'); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1 breadcrumb-new">
         <h3 class="content-header-title mb-0 d-inline-block"><i class="fal fa-folder-tree"></i> Category</h3>
         <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo url('/'); ?>">Home</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo url('/'); ?>">Trivia</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo route('trivia.category.index'); ?>">Category</a></li>
                  <li class="breadcrumb-item active">All</li>
               </ol>
            </div>
         </div>
      </div>
      <div class="content-header-right col-md-6 col-12"><a href="<?php echo route('trivia.category.create'); ?>" class="btn btn-sm btn-warning float-right"><i class="fal fa-plus-circle"></i> Add Category</a></div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="card">
      <div class="card-body">
         <table class="table table-striped table-bordered zero-configuration">
            <thead>
               <tr>
                  <th width="1%">#</th> 
                  <th width="6%"></th>
                  <th>Title</th>
                  <th>Status</th>
                  <th width="10%">Date Create</th>
                  <th width="8%">Actions</th>
               </tr>
            </thead>
            <tbody>
               <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr class="odd gradeX">
                     <td width="1%" class="f-s-600 text-inverse"><?php echo $count++; ?></td>
                     <td ><img src="<?php echo asset('trivia/category/'.$slider->image); ?>" class="img-responsive"/></td>
                     <td><?php echo $slider->title; ?></td>
                     <td>
                        <?php if($slider->status == 'In-Active'): ?>
                           <span class="label label-default">In-Active</span>
                        <?php else: ?>
                           <span class="label label-success">Active</span>
                        <?php endif; ?>
                     </td>
                     <td><?php echo e(date('j M Y',strtotime($slider->updated_at))); ?></td>
                     <td>
                        <a href="<?php echo route('trivia.category.edit',$slider->id); ?>" class="btn btn-sm btn-info"><i class="far fa-edit" aria-hidden="true"></i></a>
                        <a href="<?php echo route('trivia.category.delete',$slider->id); ?>" class="btn btn-sm btn-danger delete"><i class="far fa-trash-alt" aria-hidden="true"></i></a>
                     </td>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/survey/category/index.blade.php ENDPATH**/ ?>