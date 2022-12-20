<?php $__env->startSection('title','Leave Settings'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.dashboard'); ?>">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-tools"></i> Settings</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.hr.partials._settings_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     
                     <li class="nav-item">
                        <a class="<?php echo e(Nav::isRoute('hrm.leave.type')); ?>" href="<?php echo route('hrm.leave.type'); ?>"><i class="fal fa-user-clock"></i> Leave Types</a>
                     </li>
                     
                  </ul>
               </div>
               <div class="card-block">
                  <?php if(Request::is('hrm/leave/holiday')): ?>
                     <?php echo $__env->make('app.hr.leave.settings.holiday', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <?php endif; ?>
                  <?php if(Wingu::check_if_user_has_role(Auth::user()->user_code,'admin') == 1 || Wingu::check_user_permission('read-leavetype') == 1 ): ?>
                     <?php if(Request::is('hrm/leave/type')): ?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('hr.leave.types')->html();
} elseif ($_instance->childHasBeenRendered('DhIadYT')) {
    $componentId = $_instance->getRenderedChildComponentId('DhIadYT');
    $componentTag = $_instance->getRenderedChildComponentTagName('DhIadYT');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('DhIadYT');
} else {
    $response = \Livewire\Livewire::mount('hr.leave.types');
    $html = $response->html();
    $_instance->logRenderedChild('DhIadYT', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                     <?php endif; ?>
                  <?php endif; ?>
                  <?php if(Request::is('hrm/leave/workdays')): ?>
                     <?php echo $__env->make('app.hr.leave.settings.workdays', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <?php endif; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#typeModal').modal('hide');
         $('#delete').modal('hide');
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/hrm/settings.blade.php ENDPATH**/ ?>