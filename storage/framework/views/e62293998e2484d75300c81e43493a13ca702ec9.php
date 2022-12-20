<?php $__env->startSection('title','Leads | Canvas | Customer Relationship Management'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="float-right">
         <div class="btn-group">
            <button type="button" class="btn btn-outline-black dropdown-toggle mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fal fa-grip-horizontal"></i> Canvas view
            </button>
            <ul class="dropdown-menu" role="menu">
               <li><a href="<?php echo route('crm.leads.index'); ?>"><i class="fal fa-list"></i> List view</a></li>
            </ul>
         </div>
         <a href="<?php echo route('crm.leads.create'); ?>" class="btn btn-pink"><i class="fas fa-user-plus"></i> New Leads</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-phone-volume"></i> All Leads</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crm.leads.canvas')->html();
} elseif ($_instance->childHasBeenRendered('A9r3cLO')) {
    $componentId = $_instance->getRenderedChildComponentId('A9r3cLO');
    $componentTag = $_instance->getRenderedChildComponentTagName('A9r3cLO');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('A9r3cLO');
} else {
    $response = \Livewire\Livewire::mount('crm.leads.canvas');
    $html = $response->html();
    $_instance->logRenderedChild('A9r3cLO', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/leads/canvas.blade.php ENDPATH**/ ?>