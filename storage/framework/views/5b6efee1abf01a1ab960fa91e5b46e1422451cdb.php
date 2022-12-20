<?php $__env->startSection('title','Properties | Property Wingu'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.propertywingu.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Property Wingu</a></li>
         <li class="breadcrumb-item"><a href="javascript:;">Property</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-building"></i> Property</h1>
      <div class="card card-default">
         <div class="card-body">
            <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="8%"></th>
                     <th width="21%">Name</th>
                     <th>Address</th>
                     <th>Type</th>
                     <th>Units</th>
                     <th>Tenants</th>
                     <th width="12%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count+1; ?></td>
                        <td>
                           <center>
                              <?php if($property->image != ""): ?>
                                 <img src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/property/'.$property->property_code.'/'.$property->image); ?>" alt="<?php echo $property->title; ?>" class="img-circle" width="40" height="40">
                              <?php else: ?>
                                 <img class="rounded-circle" width="40" height="40" alt="" class="img-circle" src="<?php echo asset('assets/img/icon.png'); ?>">
                              <?php endif; ?>
                           </center>
                        </td>
                        <td><?php echo $property->title; ?></td>
                        <td><?php echo $property->street_address; ?></td>
                        <td>
                           
                        </td>
                        <td>
                           <?php if($property->property_type == 'house'): ?>
                              1
                           <?php else: ?>
                              <?php echo Propertywingu::total_units_per_property($property->property_code); ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if($property->property_type == 'house' || $property->property_type == 'flat' || $property->property_type == 'hostels' || $property->property_type == 'offices' || $property->property_type == 'land' || $property->property_type == 'commercial'): ?>
                              <?php if($property->tenant != ""): ?>
                                 1
                              <?php else: ?>
                                 <?php if($property->listing_status == 49): ?>
                                    <button class="btn btn-sm btn-success"><i class="fal fa-check-circle"></i> Listed</button>
                                 <?php else: ?>
                                    <a href="<?php echo route('list.property',$property->property_code); ?>" class="btn btn-sm btn-danger"><i class="fal fa-cloud-upload-alt"></i> List Property</a>
                                 <?php endif; ?>
                              <?php endif; ?>
                           <?php else: ?>
                              <?php echo Propertywingu::occupied_units($property->property_code); ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <a href="<?php echo route('propertywingu.property.show',$property->property_code); ?>" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                           <a href="<?php echo route('propertywingu.property.edit',$property->property_code); ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                           <a href="<?php echo route('propertywingu.property.delete',$property->property_code); ?>" class="delete btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/propertywingu/property/index.blade.php ENDPATH**/ ?>