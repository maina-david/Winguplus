<?php $__env->startSection('title','Inventory | Point Of Sale'); ?>
<?php $__env->startSection('stylesheet'); ?>
	<style>
      .select2-container {
         z-index: 9999 !important;
      }
      ul.product li {
         width: 100%;
      }
   </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo route('pos.dashboard'); ?>">Point Of Sale</a></li>
      <li class="breadcrumb-item"><a href="<?php echo route('pos.products'); ?>">Products</a></li>
      <li class="breadcrumb-item active">Inventory</li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-inventory"></i> Inventory | <?php echo $product->product_name; ?></h1>
   <!-- end page-header -->
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="row">
      <?php echo $__env->make('app.pos.products.products._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-9">
         <div class="panel panel-default">
            <div class="panel-body">
               <div class="col-md-12 mt-3">
                  <?php echo Form::model($product, ['route' => ['pos.inventory.settings.update',$productCode], 'class' => 'row', 'method'=>'post','enctype'=>'multipart/form-data']); ?>

                     <?php echo csrf_field(); ?>
                     <div class="col-md-6">
                        <h5>Track inventory for this product</h5>
                        <p>Would you like WinguPlus to track inventory movement for this product?</p>
                        <div class="form-group required">
                           <?php echo Form::select('track_inventory',[''=>'Choose','Yes' => 'Yes','No' => 'No'],null,['class' => 'form-control multiselect']); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <h5>Same retail price for all outlets</h5>
                        <p>Using one retail price for all outlets? </p><br>
                        <div class="form-group required">
                           <?php echo Form::select('same_price',[''=>'Choose','Yes' => 'Yes','No' => 'No'],null,['class' => 'form-control multiselect']); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <button type="submit" class="btn btn-success float-left"><i class="fas fa-save"></i> Update</button>
                     </div>
                  <?php echo Form::close(); ?>

               </div>
            </div>
         </div>
         <?php if($product->track_inventory == "Yes"): ?>
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title mb-1">Inventory
                     <a href="#" class="pull-right badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Link to outlet</a>
                  </h4>
               </div>
               <div class="panel-body">
                  <div class="col-md-12 mt-3">
                     <div class="row">
                        <div class="col-md-12">
                           <table class="table table-striped">
                              <thead>
                                 <th width="25%">Out Let</th>
                                 <th>Available stock</th>
                                 <th>Reorder point</th>
                                 <th>Reorder Qty</th>
                                 <th>Expiration Date</th>
                                 <th width="13%"></th>
                              </thead>
                              <tbody>
                                 <?php $__currentLoopData = $inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <form action="<?php echo route('pos.inventory.update',[$inventory->id,$productCode]); ?>" method="POST" >
                                       <?php echo csrf_field(); ?>
                                       <tr>
                                          <td>
                                             <?php if($inventory->default_inventory == 'Yes'): ?>
                                                <?php echo $mainBranch->name; ?>

                                             <?php else: ?>
                                                <?php if(Hr::check_branch($inventory->branch_code) == 1): ?>
                                                   <?php echo Hr::branch($inventory->branch_code)->name; ?>

                                                <?php endif; ?>
                                             <?php endif; ?>
                                          </td>
                                          <td><input type="text" class="form-control" name="current_stock" value="<?php echo $inventory->current_stock; ?>"></td>
                                          <td><input type="text" class="form-control" name="reorder_point" value="<?php echo $inventory->reorder_point; ?>"> </td>
                                          <td><input type="text" class="form-control" name="reorder_qty" value="<?php echo $inventory->reorder_qty; ?>"> </td>
                                          <td><input type="date" class="form-control" name="expiration_date" value="<?php echo $inventory->expiration_date; ?>"> </td>
                                          <td>
                                             <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                             <?php if($inventory->default_inventory != 'Yes'): ?>
                                                <?php if(Hr::check_branch($inventory->branch_code) == 1): ?>
                                                   <a href="<?php echo route('finance.inventory.outlet.link.delete',[$productCode,$inventory->branch_code]); ?>" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></a>
                                                <?php endif; ?>
                                             <?php endif; ?>
                                          </td>
                                       </tr>
                                    </form>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         <?php endif; ?>

      </div>
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Outlet </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="<?php echo route('finance.inventory.outlet.link'); ?>" method="post" enctype="multipart/form-data">
               <?php echo csrf_field(); ?>
               <div class="form-group">
                  <label for="">Choose Outlet</label>
                  <select name="outlets[]" id="" class="form-control select2" multiple required style="width:100%">
                     <?php $__currentLoopData = $outlets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outlet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($mainBranch->branch_code != $outlet->branch_code): ?>
                           <option value="<?php echo $outlet->branch_code; ?>"><?php echo $outlet->branch_name; ?></option>
                        <?php endif; ?>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <input type="hidden" name="product_code" value="<?php echo $productCode; ?>" required>
               </div>
               <div class="form-group">
                  <center><button class="btn btn-success btn-sm">Add Outlets</button></center>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/products/products/inventory.blade.php ENDPATH**/ ?>