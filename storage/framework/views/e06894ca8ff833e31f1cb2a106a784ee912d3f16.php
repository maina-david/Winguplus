
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<?php echo App::setLocale('ksw'); ?>

<html lang="en">
<!--<![endif]-->
<?php echo $__env->make('partials._head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body>
	<div id="app" <?php echo $__env->yieldContent('app_class'); ?>>
		<!-- begin #page-loader -->
		<div id="page-loader" class="fade show"><span class="spinner"></span></div>
		<!-- end #page-loader -->

		<!-- begin #page-container -->
		<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">

			<!-- begin #header -->
			<?php echo $__env->make('partials._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<!-- end #header -->
			<!-- begin #sidebar -->
			<?php if(Request::is('dashboard')): ?>

			<?php else: ?>
				<?php echo $__env->yieldContent('sidebar'); ?>
			<?php endif; ?>
			<!-- end #sidebar -->

			<!-- begin #content -->
			<?php echo $__env->yieldContent('content'); ?>
			<!-- end #content -->

         <!-- notes -->
         <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('general.notes.note')->html();
} elseif ($_instance->childHasBeenRendered('AhODE59')) {
    $componentId = $_instance->getRenderedChildComponentId('AhODE59');
    $componentTag = $_instance->getRenderedChildComponentTagName('AhODE59');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('AhODE59');
} else {
    $response = \Livewire\Livewire::mount('general.notes.note');
    $html = $response->html();
    $_instance->logRenderedChild('AhODE59', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

			<!-- begin _howitworks -->
			<?php echo $__env->make('partials._howitworks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<!-- end _howitworks -->

			<div id="footer" class="footer mt-5">
				© WinguPlus<sup>TM</sup>  2020 - <?php  echo date('Y') ?>
			</div>

			<!-- begin scroll to top btn -->
			<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
			<!-- end scroll to top btn -->
		</div>
	</div>
	<!-- end page container -->
	<?php echo $__env->make('partials._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/layouts/app.blade.php ENDPATH**/ ?>