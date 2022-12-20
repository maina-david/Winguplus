<?php $__env->startSection('title','Edit | Customers'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.pos.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('pos.dashboard'); ?>">Point Of Sale</a></li>
			<li class="breadcrumb-item"><a href="<?php echo route('pos.contact.index'); ?>">Customers</a></li>
			<li class="breadcrumb-item"><a href="#"><?php echo $contact->customer_name; ?></a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user-plus"></i> Update Customers </h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo Form::model($contact, ['route' => ['pos.contact.update',$contact->customer_code], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

         <?php echo csrf_field(); ?>

         <div class="row">
            <div class="col-md-6">
               <div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Details</h4>
						</div>
                  <div class="panel-body">
							<div class="form-group form-group-default required">
								<?php echo Form::label('customer_name', 'Customer Name', array('class'=>'control-label')); ?>

								<?php echo Form::text('customer_name', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter customer names', 'required' => '')); ?>

							</div>
							<div class="form-group form-group-default">
								<label>Customer Category</label>
								<?php echo e(Form::select('groups[]', $groups, null, ['class' => 'form-control multiple-select2','multiple' => 'multiple'])); ?>

							</div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Details</h4>
						</div>
                  <div class="panel-body">
                     <div class="form-group form-group-default">
                        <?php echo Form::label('email', 'Email', array('class'=>'control-label')); ?>

                        <?php echo Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Contact email')); ?>

                     </div>
                     <div class="form-group form-group-default">
								<label for="">
									Phone Number
								</label>
								<?php echo Form::text('primary_phone_number', null, array('class' => 'form-control','placeholder' => 'e.x +254 700 000 000')); ?>

							</div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="panel-body">
					<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Contact</button>
					<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="20%">
            </div>
         </div>
      <?php echo Form::close(); ?>

	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
		$(".multiple-select2").select2();
		$(".multiple-select2").select2().val(<?php echo json_encode($connectedGroup); ?>).trigger('change');
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/contacts/edit.blade.php ENDPATH**/ ?>