<?php $__env->startSection('title','Job Management | Dashboard'); ?>


<?php $__env->startSection('stylesheet'); ?>
	<link rel="stylesheet" href="<?php echo asset('assets/css/project.css'); ?>" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.jobs.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div class="content">
      <!--begin::Container-->
      <div class="container-fluid">
         <!--begin::Navbar-->
         <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.head', ['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('tT2Bbs9')) {
    $componentId = $_instance->getRenderedChildComponentId('tT2Bbs9');
    $componentTag = $_instance->getRenderedChildComponentTagName('tT2Bbs9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('tT2Bbs9');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.head', ['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('tT2Bbs9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
         <div class="row">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.dashboard.task-summary',['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('R4rHhER')) {
    $componentId = $_instance->getRenderedChildComponentId('R4rHhER');
    $componentTag = $_instance->getRenderedChildComponentTagName('R4rHhER');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('R4rHhER');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.dashboard.task-summary',['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('R4rHhER', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.dashboard.tasksperuser',['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('swGnHjf')) {
    $componentId = $_instance->getRenderedChildComponentId('swGnHjf');
    $componentTag = $_instance->getRenderedChildComponentTagName('swGnHjf');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('swGnHjf');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.dashboard.tasksperuser',['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('swGnHjf', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.dashboard.task-overtime',['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('O4ozKyA')) {
    $componentId = $_instance->getRenderedChildComponentId('O4ozKyA');
    $componentTag = $_instance->getRenderedChildComponentTagName('O4ozKyA');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('O4ozKyA');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.dashboard.task-overtime',['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('O4ozKyA', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.dashboard.files',['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('ChaUVbD')) {
    $componentId = $_instance->getRenderedChildComponentId('ChaUVbD');
    $componentTag = $_instance->getRenderedChildComponentTagName('ChaUVbD');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ChaUVbD');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.dashboard.files',['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('ChaUVbD', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.dashboard.team-members',['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('U1X97I2')) {
    $componentId = $_instance->getRenderedChildComponentId('U1X97I2');
    $componentTag = $_instance->getRenderedChildComponentTagName('U1X97I2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('U1X97I2');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.dashboard.team-members',['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('U1X97I2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#kt_modal_users_search').modal('hide');
      });
   </script>
   <script>
      window.livewire.on('chartUpdate', () => {
         let chart = window[chartId].chart;

         chart.data.datasets.forEach((dataset, key) => {
            dataset.data = datasets[key];
         });

         chart.data.labels = labels;

         chart.update();
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/job/dashboard.blade.php ENDPATH**/ ?>