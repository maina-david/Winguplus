<?php echo Form::open(array('route' => 'hrm.payroll.settings.approval.update','method' =>'post','autocomplete'=>'off')); ?>

   <div class="row">
      <div class="col-md-6">
         <div class="custom-control custom-checkbox mb-3">
            <input type="checkbox" class="custom-control-input" name="payroll_approval" id="customCheck1" value="Yes" <?php if($settings->payroll_approval == 'Yes'): ?> checked <?php endif; ?>>
            <label class="custom-control-label" for="customCheck1"> Set a payroll approver </label>
         </div>
      </div>
      <?php if($settings->payroll_approval == 'Yes'): ?>
         <div class="col-md-12">
            <div class="form-group">
               <?php echo Form::label('Choose Employee', 'Choose Employee', array('class'=>'control-label')); ?>

               <?php echo Form::select('employee[]', $joinemployee, null, array('class' => 'form-control multiple-select2', 'multiple' => 'multiple')); ?>

               <p>Approver list only shows the users who have a permission to access Pay Run menu</p>
            </div>
         </div>
      <?php endif; ?>
   </div>
   <div class="row mt-3">
      <div class="col-md-12">
         <center>
            <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update details</button>
            <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
         </center>
      </div>
   </div>
<?php echo Form::close(); ?>

<?php $__env->startSection('scripts'); ?>
   <script>
      $(".multiple-select2").select2();
		$(".multiple-select2").select2().val(<?php echo json_encode($jointApprovers); ?>).trigger('change');
   </script>
<?php $__env->stopSection(); ?>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/payroll/settings/approval.blade.php ENDPATH**/ ?>