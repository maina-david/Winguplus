<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Property Details <?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.propertywingu.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div class="row">
      <?php echo $__env->make('app.propertywingu.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.rental.billing.edit'): ?>
         <?php echo $__env->make('app.propertywingu.accounting.invoices.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>

      
      <?php if(request()->route()->getName() == 'propertywingu.property.invoice.index'): ?>
         <?php echo $__env->make('app.propertywingu.accounting.invoices.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.invoice.create'): ?>
         <?php echo $__env->make('app.propertywingu.accounting.invoices.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.invoice.edit'): ?>
         <?php echo $__env->make('app.propertywingu.accounting.invoices.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.invoice.settings'): ?>
         <?php echo $__env->make('app.propertywingu.accounting.invoices.settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.invoice.create.bulk'): ?>
         <?php echo $__env->make('app.propertywingu.accounting.invoices.bulk', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>

      <?php if(request()->route()->getName() == 'propertywingu.property.mpesaapi.integration'): ?>
         <?php echo $__env->make('app.propertywingu.property.integration.payments.mpesaapi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.mpesatill.integration'): ?>
         <?php echo $__env->make('app.propertywingu.property.integration.payments.mpesatill', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.mpesapaybill.integration'): ?>
         <?php echo $__env->make('app.propertywingu.property.integration.payments.paybill', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.bank1.integration'): ?>
         <?php echo $__env->make('app.propertywingu.property.integration.payments.bank1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.bank2.integration'): ?>
         <?php echo $__env->make('app.propertywingu.property.integration.payments.bank2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.bank3.integration'): ?>
         <?php echo $__env->make('app.propertywingu.property.integration.payments.bank3', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.bank4.integration'): ?>
         <?php echo $__env->make('app.propertywingu.property.integration.payments.bank4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.bank5.integration'): ?>
         <?php echo $__env->make('app.propertywingu.property.integration.payments.bank5', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.images'): ?>
         <?php echo $__env->make('app.propertywingu.property.images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.tenants.create'): ?>
         <?php echo $__env->make('app.propertywingu.tenants.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      
      <?php if(request()->route()->getName() == 'propertywingu.property.leases'): ?>
         <?php echo $__env->make('app.propertywingu.property.lease.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(request()->route()->getName() == 'propertywingu.property.leases.create'): ?>
         <?php echo $__env->make('app.propertywingu.property.lease.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/propertywingu/property/show.blade.php ENDPATH**/ ?>