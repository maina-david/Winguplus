<?php $__env->startSection('title','Edit Event | Events Manager'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.events.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Event Manager</a></li>
         <li class="breadcrumb-item"><a href="#">Events</a></li>
         <li class="breadcrumb-item active"> Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-edit"></i> Edit Event</h1>
      <!-- end page-header -->
      <?php echo $__env->make('app.events.events._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo Form::model($event, ['route' => ['events.update',$event->event_code],'class' => 'row', 'method'=>'post','enctype'=>'multipart/form-data']); ?>

         <?php echo csrf_field(); ?>
         <div class="col-md-8">
            <div class="card">
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-12 mb-2">
                        <label for="">Event Title</label>
                        <?php echo Form::text('title',null,['class'=>'form-control']); ?>

                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">Tag Line</label>
                        <?php echo Form::text('tagline',null,['class'=>'form-control']); ?>

                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Number of available tickets</label>
                        <?php echo Form::text('available_tickets',null,['class'=>'form-control']); ?>

                     </div>
                     <div class="col-md-6 mb-2">
                        <label for="">Event Type</label>
                        <?php echo Form::select('type',['Paid'=>'Paid','Free' => 'Free'],null,['class'=>'form-control']); ?>

                     </div>
                     <div class="col-md-6 mb-2">
                        <div class="row">
                           <div class="col-md-6">
                              <label for="">Event Start Date</label>
                              <?php echo Form::date('start_date',null,['class'=>'form-control','required'=>'']); ?>

                           </div>
                           <div class="col-md-6">
                              <label for="">Event Start Time</label>
                              <?php echo Form::time('start_time',null,['class'=>'form-control']); ?>

                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 mb-2">
                        <div class="row">
                           <div class="col-md-6">
                              <label for="">Event End Date</label>
                              <?php echo Form::date('end_date',null,['class'=>'form-control']); ?>

                           </div>
                           <div class="col-md-6">
                              <label for="">Event End Time</label>
                              <?php echo Form::time('end_time',null,['class'=>'form-control']); ?>

                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">Location</label>
                        <?php echo Form::text('location',null,['class'=>'form-control','']); ?>

                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">Embed Map</label>
                        <?php echo Form::textarea('map',null,['class'=>'form-control','size' => '5 x 5']); ?>

                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">Details</label>
                        <?php echo Form::textarea('details',null,['class'=>'form-control tinymcy']); ?>

                     </div>

                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label for="">Upload Cover Image</label>
               <input type="file" name="cover_image" id="coverImage" class="form-control">
            </div>
            <?php if($event->cover_image): ?>
               <img class="card-img-top" src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/events/'.$event->event_code.'/events/images/'.$event->cover_image); ?>" alt="<?php echo $event->title; ?>">
            <?php else: ?>
               <img class="card-img-top" src="<?php echo asset('assets/img/image_placeholder.png'); ?>" alt="<?php echo $event->title; ?>">
            <?php endif; ?>
         </div>
         <div class="col-md-8">
            <center>
               <button type="submit" class="btn btn-primary submit"><i class="fa fa-save"></i> Update Information</button>
               <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="20%">
            </center>
         </div>
      <?php echo Form::close(); ?>

   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/events/events/event/edit.blade.php ENDPATH**/ ?>