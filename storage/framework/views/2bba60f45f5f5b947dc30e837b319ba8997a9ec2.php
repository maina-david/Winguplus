<div div="row">
   <div class="col-md-12">
      <div class="row">
         <div class="col-md-7">
            <h4 class="font-weight-bold"><i class="fal fa-comments-alt"></i> Discussions</h4>
         </div>
         <div class="col-md-5">
            <input type="text" wire:model="search" class="form-control" placeholder="Search discussion">
         </div>
      </div>
   </div>
   <div class="row mt-3">
      <div class="col-md-7">
         <div class="blog-comment">
            <ul class="comments">
               <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="clearfix">
                     <?php if($comment->avatar): ?>
                        <img src="<?php echo asset('businesses/'.Auth::user()->business_code.'/images/'.$comment->avatar); ?>" class="avatar" alt="<?php echo $comment->name; ?>">
                     <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo $comment->name; ?>&rounded=false&size=70" class="avatar" alt="<?php echo $comment->name; ?>">
                     <?php endif; ?>
                     <div class="post-comments">
                        <p class="meta">
                           <b><a href="#"><?php echo $comment->name; ?></a></b>
                           | <i class="fal fa-clock-o"></i> <?php echo Helper::get_timeago(strtotime($comment->comment_date)); ?>

                           
                        </p>
                        <p><?php echo $comment->comment; ?></p>
                        <hr>
                        
                     </div>
                     
                  </li>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
         </div>
      </div>
      <div class="col-md-5">
         <div class="panel">
            <div class="panel-heading mb-0">
               <h4><i class="fal fa-comment-alt-plus"></i> Add Discussion</h4>
            </div>
            <div class="panel-body mt-0">
               <form action="<?php echo route('job.discussions.store'); ?>" method="POST" enctype="multipart/form-data">
                  <?php echo csrf_field(); ?>
                  <div class="form-group mt-0">
                     <textarea name="comment" data-comment="window.livewire.find('<?php echo e($_instance->id); ?>')" class="form-control" id="comment" rows="6"></textarea>
                     <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                  <div class="form-group">
                     <label for="customFile">Attach File</label><br>
                     <input type="text" name="file_title" class="form-control mb-2" placeholder="File title">
                     <input type="file" name="comment_files[]" class="form-control" multiple>
                  </div>
                  <input type="hidden" name="jobCode" value="<?php echo $jobCode; ?>" required>
                  <button type="submit" class="btn btn-success submit mb-3" id="save_task"><i class="fas fa-save"></i> Post comment</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </form>
            </div>
         </div>
      </div>
   </div>
</div>


<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/jobs/job/discussions.blade.php ENDPATH**/ ?>