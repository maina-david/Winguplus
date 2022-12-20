<?php $__env->startSection('title','Winguplus Apps'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <link rel="stylesheet" href="<?php echo asset('assets/css/dashboard.css'); ?>" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('wingu.apps')->html();
} elseif ($_instance->childHasBeenRendered('bFvjUFo')) {
    $componentId = $_instance->getRenderedChildComponentId('bFvjUFo');
    $componentTag = $_instance->getRenderedChildComponentTagName('bFvjUFo');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('bFvjUFo');
} else {
    $response = \Livewire\Livewire::mount('wingu.apps');
    $html = $response->html();
    $_instance->logRenderedChild('bFvjUFo', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#delete').modal('hide');
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/wingu/apps.blade.php ENDPATH**/ ?>