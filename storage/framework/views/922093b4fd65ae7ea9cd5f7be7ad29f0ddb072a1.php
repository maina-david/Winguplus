<?php $__env->startSection('title','Event Schedules | Events Manager'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.events.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">Events Manager</a></li>
         <li class="breadcrumb-item"><a href="#">Events</a></li>
         <li class="breadcrumb-item">Events Details</li>
         <li class="breadcrumb-item active">Schedules</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-clipboard-list-check"></i>  Schedules</h1>
      <!-- end page-header -->
      <?php echo $__env->make('app.events.events._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('events.events.schedules', ['eventCode'=>$code])->html();
} elseif ($_instance->childHasBeenRendered('kFdyxVr')) {
    $componentId = $_instance->getRenderedChildComponentId('kFdyxVr');
    $componentTag = $_instance->getRenderedChildComponentTagName('kFdyxVr');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('kFdyxVr');
} else {
    $response = \Livewire\Livewire::mount('events.events.schedules', ['eventCode'=>$code]);
    $html = $response->html();
    $_instance->logRenderedChild('kFdyxVr', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
   window.livewire.on('popModal', () => {
      $('#addSchedule').modal('hide');
      $('#delete').modal('hide');
   });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/events/events/schedules/index.blade.php ENDPATH**/ ?>