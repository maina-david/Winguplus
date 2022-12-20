<?php $__env->startSection('title','Events | Events Manager'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.events.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Wingu Crowd</a></li>
         <li class="breadcrumb-item"><a href="#">Events</a></li>
         <li class="breadcrumb-item active">Event List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-calendar-alt"></i> Event Details</h1>
      <!-- end page-header -->
      <?php echo $__env->make('app.events.events._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-3">
            <?php if($event->cover_image): ?>
               <img class="card-img-top" src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/events/'.$event->event_code.'/events/images/'.$event->cover_image); ?>" alt="<?php echo $event->title; ?>">
            <?php else: ?>
               <img class="card-img-top" src="<?php echo asset('assets/img/image_placeholder.png'); ?>" alt="<?php echo $event->title; ?>">
            <?php endif; ?>
         </div>
         <div class="col-md-8">
            <div class="card">
               <div class="card-body">
                  <?php echo $event->details; ?>

               </div>
            </div>
            <div class="card">
               <div class="card-body">
                  <?php echo $event->map; ?>

               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/events/events/event/details.blade.php ENDPATH**/ ?>