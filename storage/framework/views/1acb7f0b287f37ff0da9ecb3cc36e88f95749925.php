<?php $__env->startSection('title','Product Category'); ?>

<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.ecommerce.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('ecommerce.dashboard'); ?>">E-commerce</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('ecommerce.product.index'); ?>">Products</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('ecommerce.product.category'); ?>">Category</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-sitemap"></i> All Categories</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('ecommerce.products.category')->html();
} elseif ($_instance->childHasBeenRendered('MZtEzPf')) {
    $componentId = $_instance->getRenderedChildComponentId('MZtEzPf');
    $componentTag = $_instance->getRenderedChildComponentTagName('MZtEzPf');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('MZtEzPf');
} else {
    $response = \Livewire\Livewire::mount('ecommerce.products.category');
    $html = $response->html();
    $_instance->logRenderedChild('MZtEzPf', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#delete').modal('hide');
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/ecommerce/products/category/index.blade.php ENDPATH**/ ?>