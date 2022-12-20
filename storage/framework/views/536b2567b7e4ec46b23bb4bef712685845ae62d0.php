<div class="row mt-3">
   <div class="col-md-12 mb-2">
      <a href="<?php echo route('finance.customers.statement.convert',[$customerCode,'pdf']); ?>" target="_blank" class="btn btn-primary" title="pdf"><i class="fal fa-file-pdf"></i> pdf</a>
      <a href="<?php echo route('finance.customers.statement.convert',[$customerCode,'print']); ?>" target="_blank" class="btn btn-warning" title="print"><i class="fal fa-print"></i> print</a>
      <a href="<?php echo route('finance.customers.statement.mail',$customerCode); ?>" class="btn btn-pink" title="send email"><i class="fal fa-paper-plane"></i> Send mail</a>
   </div>
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <div class="invoice-content">
               <?php echo $__env->make('templates.bootstrap-3.statement.preview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/contacts/statement.blade.php ENDPATH**/ ?>