<?php $__env->startSection('title','Plans | Subscriptions'); ?>
<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.subscriptions.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('subscriptions.dashboard'); ?>">Subscriptions</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('subscriptions.products.index'); ?>">Products</a></li>
         <li class="breadcrumb-item active">Plan</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-file-alt"></i> <?php echo $product->product_name; ?></h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">
            <!-- shop menu -->
         <div class="col-md-9">
            <div class="row mb-3">
               <div class="col-md-12">
                  
                  <?php if (app('laratrust')->isAbleTo('create-subscriptionplan')) : ?>
                     <a href="<?php echo route('subscriptions.plan.create',$productID); ?>" class="btn btn-pink float-right mr-2"><i class="fas fa-plus"></i> Add Plan</a>
                  <?php endif; // app('laratrust')->permission ?>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">All Plans</h4>
               </div>
               <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th></th>
                           <th>Name</th>
                           <th width="12%">Code</th>
                           <th width="12%">Price</th>
                           <th width="15%">Created at</th>
                           <th width="19%">Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td><img src="https://ui-avatars.com/api/?name=<?php echo $plan->product_name; ?>&rounded=false&size=32" alt=""></td>
                              <td><?php echo $plan->product_name; ?></td>
                              <td><?php echo $plan->sku_code; ?></td>
                              <td><?php echo $plan->code; ?> <?php echo number_format($plan->selling_price); ?></td>
                              <td><?php echo date('jS M,Y', strtotime($plan->panel_date)); ?></td>
                              <td>
                                 <?php if (app('laratrust')->isAbleTo('update-subscriptionplan')) : ?>
                                    <a href="<?php echo route('subscriptions.plan.edit', [$plan->panelID,$productID]); ?>" class="btn btn-pink btn-sm">
                                       <i class="fas fa-edit"></i> Edit
                                    </a>
                                 <?php endif; // app('laratrust')->permission ?>
                                 <?php if (app('laratrust')->isAbleTo('delete-subscriptionplan')) : ?>
                                    <a href="<?php echo route('subscriptions.plan.delete',$plan->panelID); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i> Delete</a>
                                 <?php endif; // app('laratrust')->permission ?>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script>
      $(document).ready(function() {
         $('#sku').on('change', function() {
            if (this.value == 'Custom') {
               $('#custom-sku').show();
            }
            if (this.value == 'Auto') {
               $('#custom-sku').hide();
            }
         });
      });
   </script>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/basic/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/plan/index.blade.php ENDPATH**/ ?>