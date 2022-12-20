<?php $__env->startSection('title','Pipeline | Customer Relationship Management'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('crm.dashboard'); ?>">CRM</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('crm.pipeline.index'); ?>">Pipeline</a></li>
         <li class="breadcrumb-item active">List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-stream"></i> Pipeline</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Pipeline list</div>
               <div class="card-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <th width="1%">#</th>
                        <th>Title</th>
                        <th>Deals</th>
                        <th width="35%">Action</th>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $pipelines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$pipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count+1; ?></td>
                              <td><?php echo $pipe->title; ?></td>
                              <td>0</td>
                              <td>
                                 <a href="<?php echo route('crm.pipeline.edit',$pipe->pipeline_code); ?>" class="btn btn-sm btn-pink">Edit</a>
                                 <a href="<?php echo route('crm.pipeline.show',$pipe->pipeline_code); ?>" class="btn btn-sm btn-primary">Stages</a>
                                 <a href="<?php echo route('crm.pipeline.delete',$pipe->pipeline_code); ?>" class="btn btn-sm btn-danger">Delete</a>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Add Pipeline</div>
               <div class="card-body">
                  <form action="<?php echo route('crm.pipeline.store'); ?>" method="post" autocomplete="off">
                     <?php echo csrf_field(); ?>
                     <div class="form-group form-group-default">
                        <label for="">Title</label>
                        <?php echo Form::text('title',null,['class'=>'form-control','required'=>'','placeholder'=>'Enter pipeline title']); ?>

                     </div>
                     <div class="form-group">
                        <label for="">Description</label>
                        <?php echo Form::textarea('description',null,['class'=>'form-control','size'=>'8x8','placeholder'=>'Enter pipeline description']); ?>

                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Create Pipeline</button>
			               <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/deals/pipelines/pipeline/index.blade.php ENDPATH**/ ?>