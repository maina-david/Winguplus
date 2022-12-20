<?php $__env->startSection('title','Import Customer'); ?>



<?php $__env->startSection('content'); ?>
<div class="row">
   <div class="col-md-8">
      <div class="card card-default">
         <div class="card-body">
            <div class="row">
               <h4>Upload Customer</h4>
               <div class="col-md-4 mtop15">
                  <form action="<?php echo route('customer.import.store'); ?>" id="import_form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                     <?php echo csrf_field(); ?>
                     <input type="hidden" name="clients_import" value="true">
                     <div class="form-group mb-2 form-group-default">
                        <label for="file_csv" class="control-label  text-danger">
                           <small class="req text-danger">* </small>Choose CSV File
                        </label>
                        <input type="file" name="upload_import" required/>
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-success submit">Import</button>

                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/customers/import.blade.php ENDPATH**/ ?>