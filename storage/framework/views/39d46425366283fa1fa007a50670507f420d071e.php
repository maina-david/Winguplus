<div class="row">
   <div class="col-md-8">
      <?php echo Form::model($edit, ['route' => ['licenses.maintenances.update',[$details->asset_code,$edit->maintenance_code]], 'method'=>'post','enctype' => 'multipart/form-data','autocomplete' => 'off']); ?>

         <?php echo csrf_field(); ?>
         <div class="row">
            <div class="col-md-6">
               <div class="form-group form-group-default required">
                  <label for="">Supplier</label>
                  <?php echo Form::select('supplier',$suppliers,null,['class'=>'form-control select2', 'required' => '']); ?>

               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default">
                  <label for="">Asset Maintenance Type</label>
                  <?php echo Form::select('maintenance_type',['' => 'Select an asset maintenance type','Maintenance' => 'Maintenance','Repair' => 'Repair','Upgrade' => 'Upgrade','PAT test' => 'PAT test','Calibration' => 'Calibration','Software Support' => 'Software Support','Hardware Support' => 'Hardware Support'],null,['class'=>'form-control select2']); ?>

               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default required">
                  <label for="">Title</label>
                  <?php echo Form::text('title',null,['class'=>'form-control','placeholder' => 'Enter title', 'required' => '']); ?>

               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default required">
                  <label for="">Start Date</label>
                  <?php echo Form::date('start_date',null,['class'=>'form-control' ,'placeholder' => 'Enter date', 'required' => '']); ?>

               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default">
                  <label for="">Completion Date</label>
                  <?php echo Form::date('completion_date',null,['class'=>'form-control','placeholder' => 'Enter date']); ?>

               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default">
                  <label for="">Warranty Improvement</label>
                  <?php echo Form::select('warranty_improvement',['' => 'Choose', 'No' => 'No', 'Yes' => 'Yes'],null,['class'=>'form-control select2']); ?>

               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group form-group-default">
                  <label for="">Cost</label>
                  <?php echo Form::number('cost',null,['class'=>'form-control','placeholder' => 'Enter cost']); ?>

               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                  <label for="">Maintenance Notes</label>
                  <?php echo Form::textarea('note',null,['class'=>'form-control tinymcy']); ?>

               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                  <center>
                     <button class="btn btn-pink submit" type="submit"><i class="fas fa-save"></i> Update information</button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                  </center>
               </div>
            </div>
         </div>
      <?php echo Form::close(); ?>

   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/assets/licenses/maintenance/edit.blade.php ENDPATH**/ ?>