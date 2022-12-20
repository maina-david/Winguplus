<?php $__env->startSection('title','Events | Event Manager'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.events.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Event Manager</a></li>
         <li class="breadcrumb-item"><a href="#">Events</a></li>
         <li class="breadcrumb-item active">Event List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-calendar-alt"></i> Events</h1>
      <!-- end page-header -->
      <div class="row">
         <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3">
               <div class="card border-0">
                  <?php if($event->cover_image): ?>
                     <img class="card-img-top" src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/events/'.$event->event_code.'/events/images/'.$event->cover_image); ?>" alt="<?php echo $event->title; ?>">
                  <?php else: ?>
                     <img class="card-img-top" src="<?php echo asset('assets/img/image_placeholder.png'); ?>" alt="<?php echo $event->title; ?>">
                  <?php endif; ?>
                  <div class="card-body">
                     <h5><b><?php echo $event->title; ?></b></h5>
                     <a href="<?php echo route('events.show',$event->event_code); ?>" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i> View</a>
                     <a href="<?php echo route('events.show',$event->event_code); ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
                     <a href="<?php echo route('events.show',$event->event_code); ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i> Delete</a>
                  </div>
               </div>
            </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/events/events/event/index.blade.php ENDPATH**/ ?>