<div class="panel panel-default">
   <div class="panel-heading">
      <div class="row">
         <div class="col-md-5">
            <label for="">Search</label>
            <input type="text" class="form-control" wire:model="search" placeholder="Search by name, serial or assettag">
         </div>
         <div class="col-md-1"></div>
         <div class="col-md-3">
            <label for="">Type</label>
            <select wire:model="asset_type" class="form-control">
               <option value="">Choose</option>
               <option value="xxxxxxx">Vehicle</option>
               <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo $type->type_code; ?>"><?php echo $type->name; ?></option>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
         </div>
         <div class="col-md-3">
            <label for="">Status</label>
            <select wire:model="status" class="form-control">
               <option value="">Choose</option>
               <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <option value="<?php echo $status->status_code; ?>"><?php echo $status->title; ?></option>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
         </div>
      </div>
   </div>
   <div class="panel-body">
      <table class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th width="10%">Image</th>
               <th>Name </th>
               <th>Type</th>
               <th>Asset Tag</th>
               <th>Serial</th>
               <th>Status</th>
               <th>Assigned To</th>
               <th width="12%">Action</th>
            </tr>
         </thead>
         <tbody>
            <?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                  <td><?php echo $count+1; ?></td>
                  <td>
                     <?php if($asset->asset_image == ""): ?>
                        <img src="<?php echo asset('assets/img/product_placeholder.jpg'); ?>" width="80px" height="60px">
                     <?php else: ?>
                        <img src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/assets/'.$asset->asset_image); ?>" alt="" class="img-responsive">
                     <?php endif; ?>
                  </td>
                  <td><?php echo $asset->asset_name; ?></td>
                  <td>
                     <?php if($asset->asset_type == 'xxxxxxx'): ?>
                        Vehicle
                     <?php else: ?>
                        <?php if($asset->asset_type): ?>
                           <?php echo Asset::type($asset->asset_type)->name; ?>

                        <?php endif; ?>
                     <?php endif; ?>
                  </td>
                  <td><?php echo $asset->asset_tag; ?></td>
                  <td><?php echo $asset->serial; ?></td>
                  <td>
                     <?php if($asset->status): ?>
                        <?php
                           $label = Asset::label($asset->status);
                        ?>
                        <span class="badge" style="background-color:<?php echo $label->color; ?>"><?php echo $label->title; ?></span>
                     <?php endif; ?>
                  </td>
                  <td>
                     <?php if($asset->employee): ?>
                        <b>Employee :</b> <?php echo Hr::employee($asset->employee)->names; ?>

                     <?php endif; ?>
                     <?php if($asset->customer): ?>
                        <b>Customer :</b> <?php echo Finance::client($asset->customer)->customer_name; ?>

                     <?php endif; ?>
                  </td>
                  <td>
                     <a href="<?php echo route('assets.edit',$asset->asset_code); ?>" class="btn btn-primary btn-sm"><i class="fal fa-edit"></i></a>
                     <a href="<?php echo route('assets.show',$asset->asset_code); ?>" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                     <a href="<?php echo route('assets.delete',$asset->asset_code); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
                  </td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/assets/assets/assets.blade.php ENDPATH**/ ?>