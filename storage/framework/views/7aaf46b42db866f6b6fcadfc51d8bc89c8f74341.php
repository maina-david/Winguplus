<?php $__env->startSection('title'); ?> View Event <?php $__env->stopSection(); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.jobs.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.head',['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('rpobd7F')) {
    $componentId = $_instance->getRenderedChildComponentId('rpobd7F');
    $componentTag = $_instance->getRenderedChildComponentTagName('rpobd7F');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('rpobd7F');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.head',['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('rpobd7F', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row mb-3">
         <div class="col-md-12">
            <h4><i class="fal fa-calendar-alt"></i> <?php echo $event->title; ?> |  Details</h4>
         </div>
      </div>
      <div class="row mt-3">
         <div class="col-md-8">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Event information</h4>
               </div>
               <div class="panel-body">
                  <div class="task-details">
                     <h3><?php echo $event->title; ?></h3>
                     <p>
                        <b>Event date :</b> <?php echo date('jS F, Y', strtotime($event->start_date)); ?><br>
                        <b>Event end date :</b> <?php echo date('jS F, Y', strtotime($event->end_date)); ?><br>
                        <b>Venu :</b> <?php echo $event->venue; ?><br>
                        <b>Status :</b> <?php echo $event->status; ?><br>
                        <b>Priority : </b> <?php echo $event->priority; ?>

                     </p>
                  </div>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Event Details</h4>
               </div>
               <div class="panel-body">
                  <div class="task-details">
                     <?php echo $event->description; ?>

                  </div>
               </div>
            </div>
            <a href="#" class="btn btn-pink mb-3" id="record-results"><i class="fas fa-file"></i> Record event results</a>
            <div class="card" style="display:none" id="record-results-section">
               <div class="card-body">
                  <?php echo Form::model($event, ['route' => ['job.events.results', $event->event_code], 'method' => 'post', 'class' => 'row']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Event Result details</label>
                           <?php echo Form::textarea('results',null,['class' => 'form-control tinymcy', 'required' => '']); ?>

                        </div>
                     </div>
                     <div class="form-group">
                        <center>
                           <button type="submit" class="btn btn-pink submit ml-2">Update Results</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                        </center>
                     </div>
                  </form>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Event Results</h4>
               </div>
               <div class="panel-body">
                  <div class="task-details">
                     <?php echo $event->results; ?>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
   $(document).ready(function(){
      $('#record-results').click(function(){
         $('#record-results-section').toggle('show');
      });
   });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/events/show.blade.php ENDPATH**/ ?>