<?php $__env->startSection('title','Asset Management | Edit Asset'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <style>
      .map_canvas {
         width: 100%;
         height: 300px;
      }
   </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.assets.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo route('assets.dashboard'); ?>">Assets</a></li>
		<li class="breadcrumb-item"><a href="<?php echo route('assets.index'); ?>">Assets</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fas fa-barcode"></i> Edit Asset </h1>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <?php echo Form::model($edit, ['route' => ['assets.update',$edit->asset_code], 'method'=>'post','enctype' => 'multipart/form-data']); ?>

      <?php echo csrf_field(); ?>
      <div class="col-md-12">
         <ul class="nav nav-tabs">
            <li class="nav-item">
               <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                  <span class="d-sm-none"><i class="fal fa-info-circle"></i></span>
                  <span class="d-sm-block d-none"><i class="fal fa-info-circle"></i> Asset Info</span>
               </a>
            </li>
            <li class="nav-item">
               <a href="#additionalInfo" data-toggle="tab" class="nav-link">
                  <span class="d-sm-none"><i class="fal fa-question-circle"></i></span>
                  <span class="d-sm-block d-none"><i class="fal fa-question-circle"></i> Additional Information</span>
               </a>
            </li>

            <li class="nav-item">
               <a href="#financial" data-toggle="tab" class="nav-link">
                  <span class="d-sm-none"><i class="fal fa-file-invoice-dollar"></i></span>
                  <span class="d-sm-block d-none"><i class="fal fa-file-invoice-dollar"></i> Financial Information</span>
               </a>
            </li>
            
            <?php if($edit->asset_type == 'xxxxxxx'): ?>
               <li class="nav-item">
                  <a href="#vehicle" data-toggle="tab" class="nav-link">
                     <span class="d-sm-none"><i class="fal fa-cars"></i></span>
                     <span class="d-sm-block d-none"><i class="fal fa-cars"></i> Vehicle details</span>
                  </a>
               </li>
            <?php else: ?>
               <li class="nav-item" style="display: none" id="vehicle-details">
                  <a href="#vehicle" data-toggle="tab" class="nav-link">
                     <span class="d-sm-none"><i class="fal fa-cars"></i></span>
                     <span class="d-sm-block d-none"><i class="fal fa-cars"></i> Vehicle details</span>
                  </a>
               </li>
            <?php endif; ?>
            <li class="nav-item">
               <a href="#Images" data-toggle="tab" class="nav-link">
                  <span class="d-sm-none"><i class="fal fa-cars"></i></span>
                  <span class="d-sm-block d-none"><i class="fal fa-images"></i> More Asset Images</span>
               </a>
            </li>
         </ul>
         <div class="tab-content panel rounded-0">
            <div class="tab-pane fade active show" id="default-tab-1">
               <div class="row">
                  <div class="col-md-8">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('title', 'Asset Name', array('class'=>'control-label')); ?>

                              <?php echo Form::text('asset_name', null, array('class' => 'form-control', 'placeholder' => 'Enter name','required' => '')); ?>

                           </div>
                        </div>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('assets.assets.status')->html();
} elseif ($_instance->childHasBeenRendered('rXejS2n')) {
    $componentId = $_instance->getRenderedChildComponentId('rXejS2n');
    $componentTag = $_instance->getRenderedChildComponentTagName('rXejS2n');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('rXejS2n');
} else {
    $response = \Livewire\Livewire::mount('assets.assets.status');
    $html = $response->html();
    $_instance->logRenderedChild('rXejS2n', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('assets.assets.types',['editType'=>$edit->asset_type])->html();
} elseif ($_instance->childHasBeenRendered('1P4NSN8')) {
    $componentId = $_instance->getRenderedChildComponentId('1P4NSN8');
    $componentTag = $_instance->getRenderedChildComponentTagName('1P4NSN8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('1P4NSN8');
} else {
    $response = \Livewire\Livewire::mount('assets.assets.types',['editType'=>$edit->asset_type]);
    $html = $response->html();
    $_instance->logRenderedChild('1P4NSN8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Asset Image', 'Asset Image', array('class'=>'control-label')); ?>

                              <input type="file" name="asset_image" accept="image/*" id="assetImage">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Asset Tag', 'Asset Tag', array('class'=>'control-label')); ?>

                              <?php echo Form::text('asset_tag', null, array('class' => 'form-control', 'placeholder' => 'Enter tag')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Serial', 'Serial', array('class'=>'control-label')); ?>

                              <?php echo Form::text('serial', null, array('class' => 'form-control', 'placeholder' => 'Enter serial')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Asset Model', 'Asset Model', array('class'=>'control-label')); ?>

                              <?php echo Form::text('asset_model', null, array('class' => 'form-control', 'placeholder' => 'Enter model')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Asset condition', 'Asset condition', array('class'=>'control-label')); ?>

                              <?php echo Form::select('asset_condition',['' => 'Choose','New' => 'New','Used' => 'Used','Damaged' => 'Damaged','Good' => 'Good','Poor' => 'Poor'], null, array('class' => 'form-control select2')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Asset color', 'Asset color', array('class'=>'control-label')); ?>

                              <?php echo Form::select('asset_color',['' => 'Choose','Red' => 'Red','Black' => 'Black','Blue' => 'Blue','Yellow' => 'Yellow','Brown' => 'Brown','Pink' => 'Pink','Purple' => 'Purple','Grey' => 'Grey','White' => 'White','Silver' => 'Silver','Gold' => 'Gold','Nevy Blue' => 'Nevy Blue','Orange' => 'Orange','Green' => 'Green'], null, array('class' => 'form-control select2')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Brand', 'Brand', array('class'=>'control-label')); ?>

                              <?php echo Form::text('brand', null, array('class' => 'form-control', 'placeholder' => 'Enter brand name')); ?>

                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <?php echo Form::label('Note', 'Note', array('class'=>'control-label')); ?>

                              <?php echo Form::textarea('note', null, array('class' => 'form-control tinymcy')); ?>

                           </div>
                        </div>

                     </div>
                  </div>
                  <div class="col-md-4">
                     <?php if($edit->asset_image): ?>
                        <img src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/assets/'.$edit->asset_image); ?>" alt="" class="img-responsive">
                     <?php else: ?>
                        <img src="<?php echo asset('assets/img/image_placeholder.png'); ?>" alt="" class="img-responsive" id="placeholderImage">
                     <?php endif; ?>
                     <div id="previewImage"></div>
                  </div>
               </div>
            </div>

            <div class="tab-pane fade" id="additionalInfo">
               <div class="row">
                  <div class="col-md-8">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('manufacture', 'Manufacture', array('class'=>'control-label')); ?>

                              <?php echo Form::text('manufacture', null, array('class' => 'form-control', 'placeholder' => 'Enter manufacture')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Insurance expiry date', 'Insurance expiry date', array('class'=>'control-label')); ?>

                              <?php echo Form::date('insurance_expiry_date', null, array('class' => 'form-control')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Last Audit Date', 'Last Audit Date', array('class'=>'control-label')); ?>

                              <?php echo Form::date('last_audit', null, array('class' => 'form-control')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('End of life', 'End of life', array('class'=>'control-label')); ?>

                              <?php echo Form::date('end_of_life', null, array('class' => 'form-control', 'placeholder' => 'Choose date')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Is asset maintainable', 'Is asset maintainable ', array('class'=>'control-label')); ?>

                              <?php echo Form::select('maintained', ['' => 'Choose','Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control select2')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Accessories', 'Accessories linked to asset', array('class'=>'control-label')); ?>

                              <?php echo Form::text('accessories', null, array('class' => 'form-control', 'placeholder' => 'Enter accessories')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Warranty', 'Warranty (In months)', array('class'=>'control-label')); ?>

                              <?php echo Form::number('warranty', null, array('class' => 'form-control', 'placeholder' => 'Enter warranty')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('warranty expiration', 'warranty expiration', array('class'=>'control-label')); ?>

                              <?php echo Form::date('warranty_expiration', null, array('class' => 'form-control')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Has insurance cover', 'Has insurance cover', array('class'=>'control-label')); ?>

                              <?php echo Form::select('has_inurance_cover',['' => 'choose', 'Yes' => 'Yes', 'No' => 'No'], null, array('class' => 'form-control multiselect')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Next maintenance date', 'Next maintenance date', array('class'=>'control-label')); ?>

                              <?php echo Form::date('next_maintenance', null, array('class' => 'form-control')); ?>

                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="address-autocomplete">Asset Location</label>
                        <?php echo Form::text('default_location', null, array('class' => 'form-control', 'id' => 'location', 'placeholder' => 'Nairobi, Kenya')); ?>

                     </div>

                     <div class="map_canvas" id="map" ></div>
                     <div class="form-group mt-1">
                        <label for="">Latitude</label>
                        <input type="text" class="form-control" value="<?php echo $edit->latitude; ?>" name="lat" data-geo="lat">
                     </div>
                     <div class="form-group">
                        <label for="">Longitude</label>
                        <input type="text" class="form-control" value="<?php echo $edit->longitude; ?>"  name="lng" data-geo="lng">
                     </div>
                  </div>
               </div>
            </div>

            <div class="tab-pane fade" id="financial">
               <div class="row">
                  <div class="col-md-8">
                     <div class="row">
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('assets.assets.suppliers')->html();
} elseif ($_instance->childHasBeenRendered('8nmg54A')) {
    $componentId = $_instance->getRenderedChildComponentId('8nmg54A');
    $componentTag = $_instance->getRenderedChildComponentTagName('8nmg54A');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('8nmg54A');
} else {
    $response = \Livewire\Livewire::mount('assets.assets.suppliers');
    $html = $response->html();
    $_instance->logRenderedChild('8nmg54A', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Order Number', 'Order Number', array('class'=>'control-label')); ?>

                              <?php echo Form::text('order_number', null, array('class' => 'form-control', 'placeholder' => 'Enter number')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Depreciable assets', 'Depreciable assets', array('class'=>'control-label')); ?>

                              <?php echo Form::select('depreciable_assets',['' => 'Choose','Yes'=>'Yes','No'=>'No'], null, array('class' => 'form-control select2')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Purchase Cost', 'Purchase Cost', array('class'=>'control-label')); ?>

                              <?php echo Form::text('purches_cost', null, array('class' => 'form-control', 'placeholder' => 'Enter Cost','step'=>'0.01')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Purchase date', 'Purchase date', array('class'=>'control-label')); ?>

                              <?php echo Form::date('purchase_date', null, array('class' => 'form-control', 'placeholder' => 'Enter date')); ?>

                           </div>
                        </div>
                        
                     </div>
                  </div>
                  <div class="col-md-4">

                  </div>
               </div>
            </div>

            <div class="tab-pane fade" id="vehicle">
               <div class="row">
                  <div class="col-md-8">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Mileage', 'Mileage', array('class'=>'control-label')); ?>

                              <?php echo Form::text('mileage', null, array('class' => 'form-control', 'placeholder' => 'Enter mileage')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Next oil change', 'Next oil change', array('class'=>'control-label')); ?>

                              <?php echo Form::date('oil_change', null, array('class' => 'form-control', 'placeholder' => 'Enter date')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Licence plate', 'Licence plate', array('class'=>'control-label')); ?>

                              <?php echo Form::text('licence_plate', null, array('class' => 'form-control', 'placeholder' => 'Enter licence plate')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Vehicle Types', 'Vehicle Types', array('class'=>'control-label')); ?>

                              <?php echo Form::select('vehicle_type',$carTypes, null, array('class' => 'form-control select2')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Vehicle make', 'Vehicle make', array('class'=>'control-label')); ?>

                              <?php echo e(Form::select('vehicle_make',$makes, null, ['class' => 'form-control select2', 'id'=>'car_make','onchange' => 'get_model()'])); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="Car Model">Model</label>
                              <select name="vehicle_model" class="form-control select2" id="model">
                                 <option value="<?php echo $edit->vehicle_model; ?>"><?php echo Asset::car_model($edit->vehicle_model)->name; ?></option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('year of manufacture', 'Year of manufacture', array('class'=>'control-label')); ?>

                              <?php echo Form::number('vehicle_year_of_manufacture', null, array('class' => 'form-control','placeholder'=>'Enter year')); ?>

                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('Vehicle color', 'Vehicle color', array('class'=>'control-label')); ?>

                              <?php echo Form::select('vehicle_color',['' => 'Choose','Red' => 'Red','Black' => 'Black','Blue' => 'Blue','Yellow' => 'Yellow','Brown' => 'Brown','Pink' => 'Pink','Purple' => 'Purple','Grey' => 'Grey','White' => 'White','Silver' => 'Silver','Gold' => 'Gold','Nevy Blue' => 'Nevy Blue','Orange' => 'Orange','Green' => 'Green'], null, array('class' => 'form-control select2')); ?>

                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                  </div>
               </div>
            </div>

            <div class="tab-pane fade" id="Images">
               <div class="row">
                  <div class="col-md-12">
                     <div class="my-masonry-grid">
                        <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <div class="my-masonry-grid-item">
                              <a data-fancybox="light-masonry" href="<?php echo asset('businesses/'.Wingu::business()->business_code.'/assets/'.$gallery->file_name); ?>">
                                 <img src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/assets/'.$gallery->file_name); ?>" class="img-fluid masonry">
                              </a>
                              <a href="<?php echo route('assets.image.remove',$gallery->id); ?>" class="badge badge-danger mt-1 delete">Remove</a>
                           </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </div>
                  </div>
                  <div class="col-md-12 mt-5">
                     <div class="input-field">
                        <div class="input-images" style="padding-top: .5rem;"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <button class="btn btn-success submit float-right mt-3" type="submit"><i class="fal fa-save"></i> Update Asset</button>
         <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none float-right" alt="" width="8%">
      </div>
	<?php echo Form::close(); ?>

   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('assets.assets.add-types')->html();
} elseif ($_instance->childHasBeenRendered('SHHTZSM')) {
    $componentId = $_instance->getRenderedChildComponentId('SHHTZSM');
    $componentTag = $_instance->getRenderedChildComponentTagName('SHHTZSM');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('SHHTZSM');
} else {
    $response = \Livewire\Livewire::mount('assets.assets.add-types');
    $html = $response->html();
    $_instance->logRenderedChild('SHHTZSM', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('assets.assets.add-supplier')->html();
} elseif ($_instance->childHasBeenRendered('B7PqAo5')) {
    $componentId = $_instance->getRenderedChildComponentId('B7PqAo5');
    $componentTag = $_instance->getRenderedChildComponentTagName('B7PqAo5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('B7PqAo5');
} else {
    $response = \Livewire\Livewire::mount('assets.assets.add-supplier');
    $html = $response->html();
    $_instance->logRenderedChild('B7PqAo5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('assets.assets.add-employees')->html();
} elseif ($_instance->childHasBeenRendered('QrSkqmZ')) {
    $componentId = $_instance->getRenderedChildComponentId('QrSkqmZ');
    $componentTag = $_instance->getRenderedChildComponentTagName('QrSkqmZ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('QrSkqmZ');
} else {
    $response = \Livewire\Livewire::mount('assets.assets.add-employees');
    $html = $response->html();
    $_instance->logRenderedChild('QrSkqmZ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('assets.assets.add-department')->html();
} elseif ($_instance->childHasBeenRendered('YEjBsFQ')) {
    $componentId = $_instance->getRenderedChildComponentId('YEjBsFQ');
    $componentTag = $_instance->getRenderedChildComponentTagName('YEjBsFQ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('YEjBsFQ');
} else {
    $response = \Livewire\Livewire::mount('assets.assets.add-department');
    $html = $response->html();
    $_instance->logRenderedChild('YEjBsFQ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('assets.assets.add-status')->html();
} elseif ($_instance->childHasBeenRendered('DwZetVD')) {
    $componentId = $_instance->getRenderedChildComponentId('DwZetVD');
    $componentTag = $_instance->getRenderedChildComponentTagName('DwZetVD');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('DwZetVD');
} else {
    $response = \Livewire\Livewire::mount('assets.assets.add-status');
    $html = $response->html();
    $_instance->logRenderedChild('DwZetVD', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
		$(document).ready(function() {
			$('#assignedTo').on('change', function() {
				if (this.value == 'Employee') {
					$('#employee').show();
				} else {
					$('#employee').hide();
				}

				if(this.value == 'Customer') {
					$('#customer').show();
				} else {
					$('#customer').hide();
				}
			});
			$('#type').on('change', function() {
				if(this.value == 'xxxxxxx') {
					$('#vehicle-details').show();
				} else {
					$('#vehicle-details').hide();
				}
			});
		});
		function get_model() {
			var url = '<?php echo url('/'); ?>';
			var make = document.getElementById("car_make").value;
			$.get(url+'/assets/retrive/model/'+make, function(data){
				//success data
				$('#model').empty();
				$.each(data, function(car_model, carModel){
						$('#model').append('<option value="'+ carModel.id +'">'+ carModel.name +'</option>');
				});
			});
		}
	</script>

   <!-- preview uploaded image -->
   <script type="text/javascript">
      $(document).ready(function() {
         if(window.File && window.FileList && window.FileReader) {
            $("#assetImage").on("change",function(e) {
            var files = e.target.files ,
            filesLength = files.length ;
            for (var i = 0; i < filesLength ; i++) {
               var f = files[i]
               var fileReader = new FileReader();
               fileReader.onload = (function(e) {
                  var file = e.target;
                  $("<img></img>",{
                  class : "img-responsive",
                  src : e.target.result,
                  title : file.name
                  }).insertAfter("#previewImage");
               });
               $('#placeholderImage').hide();
               fileReader.readAsDataURL(f);
            }
         });
         } else { alert("Your browser doesn't support to File API") }
      });
   </script>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#addType').modal('hide');
         $('#addSupplier').modal('hide');
         $('#addEmployee').modal('hide');
         $('#addDepartment').modal('hide');
         $('#addStatus').modal('hide');
      });
   </script>
   <script>
      var latitude = <?php echo $edit->latitude; ?>;
      var longitude = <?php echo $edit->longitude; ?>;
      var setloc = new google.maps.LatLng(latitude,longitude);

      $('#location').geocomplete({
         map: '#map',
         details: "form",
         location: setloc,
         detailsAttribute:"data-geo",
         mapOptions: {
            zoom: 15
         },
         markerOptions: {
            draggable: true
         }
      });
      $("#location").bind("geocode:dragged", function(event, latLng){
         $("input[name=lat]").val(latLng.lat());
         $("input[name=lng]").val(latLng.lng());
      });
   </script>
   <script>
      $(document).ready(function(){
         $('.input-images').imageUploader();
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/assets/assets/edit.blade.php ENDPATH**/ ?>