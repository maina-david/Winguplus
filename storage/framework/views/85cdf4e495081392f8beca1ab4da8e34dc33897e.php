<?php $__env->startSection('title','Settings'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('pos.dashboard'); ?>">P.O.S</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('pos.products'); ?>">Products</a></li>
         <li class="breadcrumb-item active">Settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-file-alt"></i> Settings | <?php echo $product->product_name; ?></h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.pos.products.products._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <?php echo $product->product_name; ?> -  Settings
               </div>
               <div class="panel-body">
                  <div class="col-md-12">
                     <div class="form-group">
                        <?php echo Form::label('title', 'Online Payment Link', array('class'=>'control-label')); ?>

                        <input type="text" class="form-control" value="<?php echo Wingu::payment_link(); ?>/product/<?php echo Wingu::business()->businessID; ?>/<?php echo $product->product_code; ?>" readonly>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/basic/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/products/products/settings.blade.php ENDPATH**/ ?>