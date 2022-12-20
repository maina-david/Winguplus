<div class="row">
   <!-- begin timeline -->
	<ul class="timeline">
		<li>
			<!-- begin timeline-icon -->
			<div class="timeline-icon">
				<a href="javascript:;">&nbsp;</a>
			</div>
			<!-- end timeline-icon -->
			<!-- begin timeline-body -->
			<div class="timeline-body">
				<form action="<?php echo route('crm.customers.comments.post'); ?>" method="post">
					<?php echo csrf_field(); ?>
					<input type="hidden" value="<?php echo $code; ?>" name="customer">
					<div class="form-group mb-5 mt-4">
						<textarea name="comment" rows="8" cols="80" class="form-control"></textarea>
						<button type="submit" class="btn btn-success submit float-right mt-3">Add Comment</button>
						<img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none float-right mt-3" alt="wingu loader" width="20%" style="display: none">
					</div>
				</form>

			</div>
			<!-- begin timeline-body -->
		</li>
		<?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li>
				<!-- begin timeline-time -->
				<div class="timeline-time">
					<span class="date"><?php echo date('d F, Y', strtotime($comment->created_at)); ?></span>
					<span class="time"><?php echo date('h:i a', strtotime($comment->created_at)); ?></span>
				</div>
				<!-- end timeline-time -->
				<!-- begin timeline-icon -->
				<div class="timeline-icon">
					<a href="javascript:;">&nbsp;</a>
				</div>
				<!-- end timeline-icon -->
				<!-- begin timeline-body -->
				<div class="timeline-body">
					<div class="card">
						<div class="card-body">
							<p><?php echo $comment->comment; ?></p>
						</div>
						<div class="card-footer">
							<a href="<?php echo route('crm.customers.comments.delete', $comment->comment_code); ?>" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> delete</a>
						</div>
					</div>
				</div>
				<!-- end timeline-body -->

			</li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	</ul>
	<!-- end timeline -->
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/customers/comments.blade.php ENDPATH**/ ?>