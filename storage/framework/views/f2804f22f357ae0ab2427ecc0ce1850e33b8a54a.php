<?php $__env->startSection('title','Job Openings | Recruitment | Human Resource'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         
         <a href="<?php echo route('hrm.recruitment.jobs.create'); ?>" class="btn btn-pink"><i class="fal fa-plus-circle"></i> Add Job Openings</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-briefcase"></i> Job Openings </h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-responsive">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Candidates</th>
                     <th>Job Opening</th>
                     <th>Hiring Lead</th>
                     <th>Status</th>
                     <th>Created On</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count++; ?></td>
                        <td>0</td>
                        <td><?php echo $job->title; ?></td>
                        <td>
                           <?php if($job->hiring_lead != ""): ?>
                              <?php if(Wingu::check_user($job->hiring_lead) == 1): ?>
                                 <?php echo Wingu::user($job->hiring_lead)->name; ?>

                              <?php endif; ?>
                           <?php endif; ?>
                        </td>
                        <td><span class="badge <?php echo $job->name; ?>"><?php echo $job->name; ?></td>
                        <td><?php echo date('F jS, Y', strtotime($job->job_date)); ?></td>
                        <td>
                           <a href="<?php echo route('hrm.recruitment.jobs.show',$job->code); ?>" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                           <a href="<?php echo route('hrm.recruitment.jobs.edit',$job->code); ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
      <!-- end panel -->
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/recruitment/jobs/index.blade.php ENDPATH**/ ?>