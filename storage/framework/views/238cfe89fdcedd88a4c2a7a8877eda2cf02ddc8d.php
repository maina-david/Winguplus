<?php $__env->startSection('title'); ?>
	LPO | <?php echo $lpo->prefix; ?><?php echo $lpo->number; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('stylesheet'); ?> 
	<style>
		body {
			background: #FFFF;
			}
	</style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="row">
			<div class="col-md-6">
				<a href="#"  class="btn <?php echo Wingu::status($lpo->statusID)->name; ?> mb-2"><i class="fas fa-bell"></i> <?php echo ucfirst(Wingu::status($lpo->statusID)->name); ?></a>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-8">
						<a href="<?php echo route('finance.stock.mail', $lpo->lpoID); ?>" class="btn btn-sm btn-default m-b-10 p-l-5">
							<i class="fas fa-envelope"></i> Email
						</a>
						<a href="<?php echo route('finance.product.stock.order.edit', $lpo->lpoID); ?>" class="btn btn-sm btn-default m-b-10 p-l-5">
							<i class="fas fa-edit"></i> Edit
						</a>
						<a href="<?php echo route('finance.product.stock.order.pdf', $lpo->lpoID); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
							<i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
						</a>
						<a href="<?php echo route('finance.product.stock.order.print', $lpo->lpoID); ?>" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
							<i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print
						</a>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								More
							</button>
							<ul class="dropdown-menu dropdown-menu-right">
								
								<li><a href="#" data-toggle="modal" data-target="#attach-files">Attach Files</a></li>
								<?php if($lpo->statusID != 10): ?>
									<li><a href="<?php echo route('finance.lpo.status.change',[$lpo->lpoID,10]); ?>">Mark as Draft</a></li>
								<?php endif; ?>
								<?php if($lpo->statusID != 11): ?>
								<li><a href="<?php echo route('finance.lpo.status.change',[$lpo->lpoID,11]); ?>">Mark as Expired</a></li>
								<?php endif; ?>
								<?php if($lpo->statusID != 12): ?>
								<li><a href="<?php echo route('finance.lpo.status.change',[$lpo->lpoID,12]); ?>">Mark as Declined</a></li>
								<?php endif; ?>
								<?php if($lpo->statusID != 13): ?>
								<li><a href="<?php echo route('finance.lpo.status.change',[$lpo->lpoID,13]); ?>">Mark as Accepted</a></li>
								<?php endif; ?>
								<?php if($lpo->statusID != 6): ?>
								<li><a href="<?php echo route('finance.lpo.status.change',[$lpo->lpoID,6]); ?>">Mark as Sent</a></li>
								<?php endif; ?>
								<?php if($lpo->statusID != 14): ?>
								<li><a href="<?php echo route('finance.stock.delivered',[$lpo->lpoID]); ?>">Mark as Delivered</a></li>
								<?php endif; ?>
								<li class="divider"></li>
								<?php if (app('laratrust')->isAbleTo('delete-stockcontrol')) : ?>
								<li><a href="<?php echo route('finance.lpo.delete',$lpo->lpoID); ?>" class="text-danger">Delete LPO</a></li>
								<?php endif; // app('laratrust')->permission ?>
							</ul>
						</div>
					</div>
				</div>				
			</div>
		</div>
		<?php echo $__env->make('templates.'.$template.'.lpo.preview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>

	
	<div class="modal fade" id="attach-files">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Attachment</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="<?php echo route('finance.stock.attach'); ?>" class="dropzone" id="my-awesome-dropzone" method="post">
						<?php echo csrf_field(); ?>
						<input type="hidden" value="<?php echo $lpo->lpoID; ?>" name="lpoID">
					</form>
					<center><h3 class="mt-5">Attachment Files</h3></center>
					<div class="row">
						<div class="col-md-12">
						<table id="data-table-default" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="1%">#</th>
									<th></th>
									<th width="10%">Name</th> 
									<th>Type</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo $filec++; ?></td>
										<td>
											<?php if(stripos($file->file_mime, 'image') !== FALSE): ?>
												<center><i class="fas fa-image fa-4x"></i></center>
											<?php endif; ?>
											<?php if(stripos($file->file_mime, 'pdf') !== FALSE): ?>
												<center><i class="fas fa-file-pdf fa-4x"></i></center>
											<?php endif; ?>
											<?php if(stripos($file->file_mime, 'octet-stream') !== FALSE): ?>
												<center><i class="fas fa-file-alt fa-4x"></i></center>
											<?php endif; ?>
										</td>
										<td width="10%"><?php echo $file->file_name; ?></td>
										<td><?php echo $file->file_mime; ?></td>
										
										<td>
											<a href="<?php echo route('finance.lpo.attachment.delete',$file->id); ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
										</td>
									</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>
					</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
		function change_status() {
			var url = '<?php echo url('/'); ?>';
			var status = document.getElementById("status").value;
			var file = document.getElementById("fileID").value;
			$.get(url+'/finance/lpo/file/'+status+'/'+file, function(data){
				//success data
				location.reload();
			});
		}
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/pos/items/stock/show.blade.php ENDPATH**/ ?>