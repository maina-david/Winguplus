<?php $__env->startSection('title','Attendance | Events Manager'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.events.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Event Manager</a></li>
         <li class="breadcrumb-item"><a href="#">Events</a></li>
         <li class="breadcrumb-item">Events Details</li>
         <li class="breadcrumb-item active">Attendance</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-ticket-alt"></i> Attendance</h1>
      <!-- end page-header -->
      <?php echo $__env->make('app.events.events._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php if($event->type == 'Paid'): ?>
         <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('events.events.attendance', ['eventCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('lLSYhns')) {
    $componentId = $_instance->getRenderedChildComponentId('lLSYhns');
    $componentTag = $_instance->getRenderedChildComponentTagName('lLSYhns');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('lLSYhns');
} else {
    $response = \Livewire\Livewire::mount('events.events.attendance', ['eventCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('lLSYhns', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
      <?php endif; ?>
      <?php if($event->type == 'Free'): ?>
         <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('events.events.attendance-free', ['eventCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('04FQDJj')) {
    $componentId = $_instance->getRenderedChildComponentId('04FQDJj');
    $componentTag = $_instance->getRenderedChildComponentTagName('04FQDJj');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('04FQDJj');
} else {
    $response = \Livewire\Livewire::mount('events.events.attendance-free', ['eventCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('04FQDJj', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
      <?php endif; ?>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#checkInCustomer').modal('hide');
         $('#delete').modal('hide');
         $('#checkInDetails').modal('hide');
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/events/events/tickets/attendance.blade.php ENDPATH**/ ?>