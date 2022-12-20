<div wire:ignore class="col-md-6">
   <!--begin::Summary-->
   <div class="panel">
      <!--begin::Card header-->
      <div class="panel-heading">
         <div class="row">
            <div class="col-md-8">
               <h4>Task summary</h4>
            </div>
            <div class="col-md-4">
               
            </div>
         </div>
      </div>
      <!--end::Card header-->
      <!--begin::Card body-->
      <div class="panel-body">
         <?php echo $taskStatusSummary->container(); ?>

      </div>
      <!--end::Card body-->
   </div>
   <!--end::Summary-->
   <?php echo $taskStatusSummary->script(); ?>

</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/jobs/job/dashboard/task-summary.blade.php ENDPATH**/ ?>