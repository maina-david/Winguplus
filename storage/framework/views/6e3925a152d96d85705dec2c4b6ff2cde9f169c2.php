<?php $__env->startSection('title'); ?> <?php echo $job->title; ?> | Recruitment | Human Resource <?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-12">
            <div class="row">
               <div class="col-md-8">
                  <h3><i class="fal fa-briefcase"></i> <?php echo $job->title; ?></h3>
                  <p><i class="fal fa-map-marker-alt"></i> Nairobi, Nairobi County, Kenya<br><i class="fal fa-usd-circle"></i> <?php echo number_format($job->min_salary); ?> - <?php echo number_format($job->max_salary); ?></p>

               </div>
               <div class="col-md-4">
                  <a href="<?php echo route('hrm.recruitment.jobs.edit',$job->code); ?>" class="btn btn-primary float-right"><i class="fas fa-edit"></i> Edit</a>
               </div>
               <div class="col-md-12">
                  <div class="row">
                     <ul class="nav nav-tabs">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#"><i class="fal fa-users"></i> Candidate</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fal fa-info-circle"></i> Summary</a>
                        </li>
                        
                     </ul>
                     <div class="col-md-12 bg-white">
                        <!-- begin widget-table -->
                        <table class="table table-bordered table-striped mt-3">
                           <thead>
                              <tr>
                                 <th width="1%">#</th>
                                 <th width="10%">Image</th>
                                 <th>Name</th>
                                 <th>Location</th>
                                 <th>Expectation</th>
                                 <th>Experience</th>
                                 <th>Qualification</th>
                                 <th>Phone number</th>
                                 <th>Email</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                    <td><?php echo $count+1; ?></td>
                                    <td>
                                       <img src="../assets/img/product/product-6.png" width="100" />
                                    </td>
                                    <td>
                                       <h5><?php echo $application->name; ?></h5>
                                    </td>
                                    <td><?php echo $application->location; ?></td>
                                    <td><?php echo $application->salary_currency; ?><?php echo number_format($application->salary_expectation); ?></td>
                                    <td><?php echo $application->experience; ?> years</td>
                                    <td><?php echo $application->qualification; ?></td>
                                    <td><?php echo $application->phone_number; ?></td>
                                    <td><?php echo $application->email; ?></td>
                                    <td><a href="" class="btn btn-sm btn-success"> <i class="fas fa-eye"></i> view </a></td>
                                 </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </tbody>
                        </table>
                        <!-- end widget-table -->
                        <br>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/recruitment/jobs/show.blade.php ENDPATH**/ ?>