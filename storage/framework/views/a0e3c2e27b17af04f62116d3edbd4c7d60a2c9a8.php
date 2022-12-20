<div>

   <div class="row mb-3">
      <div class="col-md-8">
         <a href="#" class="btn btn-pink float-left" data-toggle="modal" data-target=".add-file"><i class="fal fa-folder-plus"></i> Add File</a>
      </div>
      <div class="col-md-4">
         <input type="text" wire:model="file_name" class="form-control" placeholder="Search by file name">
      </div>
   </div>

   <div class="row">
      <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div class="col-md-3">
            <div class="widget-list widget-list-rounded mb-2">
               <!-- begin widget-list-item -->
               <div class="widget-list-item">
                  <div class="widget-list-media">
                     <?php if(Helper::like_match('%image%',$file->file_mime)): ?>
                        <i class="fas fa-file-image fa-3x"></i>
                     <?php elseif(Helper::like_match('%pdf%',$file->file_mime)): ?>
                        <i class="fas fa-file-pdf fa-3x"></i>
                     <?php elseif(Helper::like_match('%word%',$file->file_mime)): ?>
                        <i class="fas fa-file-word fa-3x"></i>
                     <?php elseif(Helper::like_match('%zip%',$file->file_mime)): ?>
                        <i class="fas fa-file-archive fa-3x"></i>
                     <?php elseif(Helper::like_match('%excel%',$file->file_mime)): ?>
                        <i class="fas fa-file-excel fa-3x"></i>
                     <?php elseif(Helper::like_match('%powerpoint%',$file->file_mime)): ?>
                        <i class="fas fa-file-powerpoint fa-3x"></i>
                     <?php elseif(Helper::like_match('%application%',$file->file_mime)): ?>
                        <i class="far fa-file-code fa-3x"></i>
                     <?php else: ?>
                        <i class="far fa-file fa-3x"></i>
                     <?php endif; ?>
                  </div>
                  <div class="widget-list-content">
                     <h4 class="widget-list-title font-weight-bold"><?php echo $file->name; ?></h4>
                     <p class="widget-list-desc mt-1">
                        <b>File Type :</b> <?php echo $file->file_mime; ?><br>
                        <b>File Size :</b> <?php echo round($file->file_size / 1000000, 2); ?> mb<br>
                     </p>
                  </div>
                  <div class="widget-list-action">
                     <a href="#" data-toggle="dropdown" class="text-muted pull-right">
                     <i class="fa fa-ellipsis-h f-s-14"></i>
                     </a>
                     <?php
                        $getFileCode = json_encode($file->file_code);
                     ?>
                     <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="<?php echo asset('businesses/'.Wingu::business()->business_code.'/jobs/'.$jobCode.'/'.$file->file_name); ?>" target="_blank">View document</a></li>
                        <li><a wire:click="delete_alert(<?php echo e($getFileCode); ?>,<?php echo e($file->id); ?>)" data-toggle="modal" data-target="#delete">Delete</a></li>
                     </ul>
                  </div>
               </div>
               <!-- end widget-list-item -->
            </div>
         </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </div>

   <!-- Modal HTML -->
   <div wire:ignore.self id="delete" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-confirm">
         <div class="modal-content">
            <div class="modal-header flex-column">
               <div class="icon-box">
                  <i class="fal fa-times"></i>
               </div>
               <h4 class="modal-title w-100">Are you sure?</h4>
            </div>
            <div class="modal-body">
               <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="delete_close()">Cancel</button>
               <?php
                  $fileCode2 = json_encode($fileCode);
               ?>
               <button type="button" class="btn btn-danger" wire:click="delete(<?php echo e($fileCode2); ?>,<?php echo e($fileID); ?>)">Delete</button>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/jobs/job/files.blade.php ENDPATH**/ ?>