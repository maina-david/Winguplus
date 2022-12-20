<?php $__env->startSection('title','Event Speakers | Events Manager'); ?>
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
         <li class="breadcrumb-item active">Speakers</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-podium-star"></i> Speakers</h1>
      <!-- end page-header -->
      <?php echo $__env->make('app.events.events._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('events.events.speakers', ['eventCode'=>$code])->html();
} elseif ($_instance->childHasBeenRendered('YCgjhfV')) {
    $componentId = $_instance->getRenderedChildComponentId('YCgjhfV');
    $componentTag = $_instance->getRenderedChildComponentTagName('YCgjhfV');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('YCgjhfV');
} else {
    $response = \Livewire\Livewire::mount('events.events.speakers', ['eventCode'=>$code]);
    $html = $response->html();
    $_instance->logRenderedChild('YCgjhfV', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
   window.livewire.on('popModal', () => {
      $('#speakerModal').modal('hide');
      $('#delete').modal('hide');
   });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/events/events/speakers.blade.php ENDPATH**/ ?>