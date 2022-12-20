<div>
   <div class="panel mb-3">
      <div class="panel-body">
         <!--begin::Details-->
         <div class="row">
            <!--begin::Image-->
            <div class="col-md-6 mb-4">
               <div class="row">
                  <div class="col-md-3">
                     <?php if($job->image): ?>
                        <img src="<?php echo asset('businesses/'.Auth::user()->business_code.'/jobs/'.$job->job_code.'/images/'.$job->image); ?>" alt="<?php echo $job->job_title; ?>" class="img-responsive">
                     <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo $job->job_title; ?>&rounded=false&size=120" alt="<?php echo $job->job_title; ?>" class="img-responsive">
                     <?php endif; ?>
                  </div>
                  <div class="col-md-9">
                     <h4 class=""><?php echo $job->job_title; ?></h4>

                     <?php if($job->job_type != 'Internal'): ?>
                        <?php if($client): ?>
                           <h5>
                              <b><i class="fal fa-user"></i> Client:</b> <?php echo $client->email; ?><br>
                              <b><i class="fal fa-phone-alt"></i> Phone Number:</b> <a href="tel:<?php echo $client->primary_phone_number; ?>"><?php echo $client->primary_phone_number; ?></a><br>
                              <b><i class="fal fa-at"></i> Email:</b> <a href="mailto:<?php echo $client->email; ?>"><?php echo $client->email; ?></a><br>
                              <b><i class="fal fa-globe"></i> Website:</b> <a href="<?php echo $client->website; ?>" target="_blank"><?php echo $client->website; ?></a><br>
                           </h5>
                        <?php endif; ?>
                     <?php endif; ?>
                     <?php if($job->job_type == 'Internal'): ?>
                        <h5><?php echo Wingu::business()->name; ?></h5>
                     <?php endif; ?>
                     <h5> Job Status :
                        <span class="badge <?php echo $job->name; ?>"><?php echo $job->name; ?></span>
                     </h5>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="row">
                  <div class="col-md-12 mb-4">
                     <a class="btn btn-grey float-right text-white ml-2" data-toggle="modal" data-target="#add-section"><i class="fas fa-sticky-note"></i> Add Task Section</a>
                     <a class="btn btn-info float-right text-white ml-2" href="<?php echo route('job.edit',$job->job_code); ?>"><i class="fas fa-edit"></i> Edit Job</a>
                     <a class="btn btn-success float-right btn-pink text-white" data-toggle="modal" data-target="#kt_modal_users_search"><i class="fas fa-user-plus"></i> Add Team Member</a>
                  </div>
                  <div class="col-md-3">
                     <b> Start Date</b><br>
                     <a href="" class="btn btn-primary btn-block mt-0"><?php echo date('F jS, Y', strtotime($job->start_date)); ?></a>
                  </div>
                  <div class="col-md-3">
                     <b> Due Date</b><br>
                     <a href="" class="btn btn-warning btn-block mt-0"><?php echo date('F jS, Y', strtotime($job->end_date)); ?></a>
                  </div>
                  <div class="col-md-6">
                     <span><b>Progress</b></span><br>
                     <?php if(Job::count_task_per_status($job->job_code,16) && Job::count_task_per_job($job->job_code) != 0): ?>
                        <?php
                           $tasks = Job::count_task_per_job($job->job_code);
                           $complete = Job::count_task_per_status($job->job_code,16);
                           $progress = ($complete/$tasks)*100;
                        ?>
                        <div class="progress mb-1" style="height: 7px;">
                           <div class="progress-bar"
                              role="progressbar" aria-valuenow="<?php echo $progress ?>" aria-valuemin="0" aria-valuemax="100"
                              style="width: <?php echo number_format($progress) ?>%;">
                           </div>
                        </div>
                        <span><b><?php echo number_format($progress) ?>%</b></span>
                     <?php else: ?>
                        <div class="progress mb-1" style="height: 7px;">
                           <div class="progress-bar"
                              role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                              style="width: 0%;">
                           </div>
                        </div>
                        <span class="mt-1"><b>0%</b></span>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
            <!--end::Wrapper-->
         </div>
         <!--end::Details-->
         <div class="separator"></div>
         <!--begin::Nav wrapper-->
         <!--begin::Nav links-->
         <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x mt-2">
            <li class="nav-item">
               <a class="nav-link active" href="<?php echo route('job.dashboard',$code); ?>"><i class="fal fa-chart-network"></i> Dashboard</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="<?php echo route('job.task',$code); ?>"><i class="fal fa-check-square"></i> Tasks</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="<?php echo route('job.discussions',$code); ?>"><i class="fal fa-comments-alt"></i> Discussions</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="<?php echo route('job.users',$code); ?>"><i class="fal fa-users"></i> Users</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="<?php echo route('job.files',$code); ?>"><i class="fal fa-paperclip"></i> Files</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="<?php echo route('job.notes',$code); ?>"><i class="fal fa-sticky-note"></i> Notes</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="<?php echo route('job.goals',$code); ?>"><i class="far fa-bullseye-arrow"></i> Goals</a>
            </li>
            
            <li class="nav-item">
               <a class="nav-link" href="<?php echo route('job.events',$code); ?>"><i class="fal fa-calendar-alt"></i> Events</a>
            </li>
            
            
            <li class="nav-item">
               <a class="nav-link" href="<?php echo route('job.edit',$job->job_code); ?>"><i class="fal fa-cogs"></i> Settings</a>
            </li>
         </ul>
      </div>
   </div>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.add-member-modal', ['jobCode' => $jobCode])->html();
} elseif ($_instance->childHasBeenRendered('K7cnfrz')) {
    $componentId = $_instance->getRenderedChildComponentId('K7cnfrz');
    $componentTag = $_instance->getRenderedChildComponentTagName('K7cnfrz');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('K7cnfrz');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.add-member-modal', ['jobCode' => $jobCode]);
    $html = $response->html();
    $_instance->logRenderedChild('K7cnfrz', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.sections', ['jobCode' => $jobCode])->html();
} elseif ($_instance->childHasBeenRendered('8SSOxFn')) {
    $componentId = $_instance->getRenderedChildComponentId('8SSOxFn');
    $componentTag = $_instance->getRenderedChildComponentTagName('8SSOxFn');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('8SSOxFn');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.sections', ['jobCode' => $jobCode]);
    $html = $response->html();
    $_instance->logRenderedChild('8SSOxFn', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>

<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/jobs/job/head.blade.php ENDPATH**/ ?>