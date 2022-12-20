<?php $__env->startSection('title','Expense Settings'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item">Expense</li>
         <li class="breadcrumb-item active">General</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-cogs"></i>  Expense Settings</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.finance.partials._settings_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isRoute('finance.expense.category.index')); ?>" href="#"><i class="fal fa-sitemap"></i> Expense Category </a>
                     </li>
                     
                  </ul>
               </div>

               <div class="card-block">
                  <div class="p-0 m-0">
                     <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('finance.expenses.category')->html();
} elseif ($_instance->childHasBeenRendered('6etuUhA')) {
    $componentId = $_instance->getRenderedChildComponentId('6etuUhA');
    $componentTag = $_instance->getRenderedChildComponentTagName('6etuUhA');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('6etuUhA');
} else {
    $response = \Livewire\Livewire::mount('finance.expenses.category');
    $html = $response->html();
    $_instance->logRenderedChild('6etuUhA', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#CategoryModel').modal('hide');
         $('#delete').modal('hide');
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/expense/category/index.blade.php ENDPATH**/ ?>