<div class="row">
   <div class="col-md-8">
      <?php echo Form::model($edit, ['route' => ['assets.maintenances.update',[$code,$edit->maintenance_code]], 'method'=>'post','enctype' => 'multipart/form-data']); ?>

         <?php echo csrf_field(); ?>
         <div class="row">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('assets.assets.suppliers')->html();
} elseif ($_instance->childHasBeenRendered('dTjaMx2')) {
    $componentId = $_instance->getRenderedChildComponentId('dTjaMx2');
    $componentTag = $_instance->getRenderedChildComponentTagName('dTjaMx2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('dTjaMx2');
} else {
    $response = \Livewire\Livewire::mount('assets.assets.suppliers');
    $html = $response->html();
    $_instance->logRenderedChild('dTjaMx2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
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
                  <?php echo Form::date('completion_date',null,['class'=>'form-control','placeholder' => 'Enter date', 'required' => '']); ?>

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
            <div class="col-md-6">
               <div class="form-group form-group-default required">
                  <label for="">Next inspection date</label>
                  <input type="date" name="next_inspection_date" value="<?php echo $details->next_inspection_date; ?>" class="form-control">
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
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/assets/assets/maintenance/edit.blade.php ENDPATH**/ ?>