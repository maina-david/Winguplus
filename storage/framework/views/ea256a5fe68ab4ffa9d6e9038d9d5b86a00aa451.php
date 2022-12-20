<?php $__env->startSection('title'); ?> <?php echo $lead->customer_name; ?> | Lead Details <?php $__env->stopSection(); ?>


<?php $__env->startSection('stylesheet'); ?>
   <link rel="stylesheet" href="<?php echo asset('assets/css/project.css'); ?>" />
   <style>
      .select2-container {
         z-index: 9999 !important;
      }
      table{
         background-color: #ffffff !important;
      }
      thead th{
         border-bottom: 1px solid #f2f3f4 !important;
         border-top: 1px solid #f2f3f4 !important;
      }
      th {
         border-left: 1px solid #f2f3f4;
         border-right: 1px solid #f2f3f4;
      }
   </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <div class="row">
         
         <div class="col-md-12">
            <div class="row mb-3">
               <div class="col-md-6"><h3><?php echo $lead->customer_name; ?></h3></div>
               <div class="col-md-6">
                  <div class="float-right">
                     <a href="<?php echo route('crm.leads.edit',$code); ?>" class="btn btn-primary"><i class="fas fa-phone-volume"></i> Edit</a>
                     <a href="<?php echo route('crm.leads.send',$code); ?>" class="btn btn-white"><i class="fas fa-paper-plane"></i> Send Email</a>
                     <?php if($lead->category != ""): ?>
                        <a href="<?php echo route('crm.leads.convert',$code); ?>" class="btn btn-success delete"> Convert to customer</a>
                     <?php endif; ?>
                     <a href="<?php echo route('crm.leads.delete', $code); ?>" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                  </div>
               </div>
            </div>
            <?php echo $__env->make('app.crm.leads._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if(Request::is('crm/leads/'.$code.'/show')): ?>
               <?php echo $__env->make('app.crm.leads.view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/leads/'.$code.'/calllog')): ?>
               <?php echo $__env->make('app.crm.leads.calllog.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/leads/'.$code.'/notes')): ?>
               <?php echo $__env->make('app.crm.leads.notes.notes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/leads/'.$code.'/tasks')): ?>
               <?php echo $__env->make('app.crm.leads.tasks.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(Request::is('crm/leads/'.$code.'/events')): ?>
               <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crm.leads.events.grid-view', ['leadCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('X8uc9Np')) {
    $componentId = $_instance->getRenderedChildComponentId('X8uc9Np');
    $componentTag = $_instance->getRenderedChildComponentTagName('X8uc9Np');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('X8uc9Np');
} else {
    $response = \Livewire\Livewire::mount('crm.leads.events.grid-view', ['leadCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('X8uc9Np', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php endif; ?>

            <?php if(Request::is('crm/leads/'.$code.'/events/list')): ?>
               <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crm.leads.events.list-view', ['leadCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('4drc44M')) {
    $componentId = $_instance->getRenderedChildComponentId('4drc44M');
    $componentTag = $_instance->getRenderedChildComponentTagName('4drc44M');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('4drc44M');
} else {
    $response = \Livewire\Livewire::mount('crm.leads.events.list-view', ['leadCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('4drc44M', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php endif; ?>

            <?php if(Request::is('crm/leads/'.$code.'/mail')): ?>
               <?php echo $__env->make('app.crm.leads.mail.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(Request::is('crm/leads/'.$code.'/send')): ?>
               <?php echo $__env->make('app.crm.leads.mail.send', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::route()->getName() == 'crm.leads.details'): ?>
               <?php echo $__env->make('app.crm.leads.mail.details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/leads/'.$code.'/sms')): ?>
               <?php echo $__env->make('app.crm.leads.sms.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/leads/'.$code.'/documents')): ?>
               <?php echo $__env->make('app.crm.leads.documents.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#eventCreate').modal('hide');
      });
   </script>
   <script type="text/javascript">
      window.livewire.on('editModal', () => {
         $('#eventEdit').modal('hide');
      });
   </script>
   <script type="text/javascript">
      window.livewire.on('detailsModal', () => {
         $('#detail').modal('hide');
      });
   </script>
   <script type="text/javascript">
      window.livewire.on('deleteModal', () => {
         $('#delete').modal('hide');
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/leads/show.blade.php ENDPATH**/ ?>