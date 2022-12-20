<div class="row">
   <div class="col-md-12">
      <a href="" class="btn btn-primary float-right mb-2" data-toggle="modal" data-target="#addFiles"><i class="fa fa-plus-circle"></i> Add Files</a>
   </div>
   <div class="col-md-12">
      <div class="my-masonry-grid">
         <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(Helper::like_match('%image%',$file->file_mime)): ?>
               <div class="my-masonry-grid-item ml-2 mt-2">
                  <a data-fancybox="light-masonry" href="<?php echo asset('businesses/'.Wingu::business()->business_code.'/assets/'.$file->file_name); ?>">
                     <img src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/assets/'.$file->file_name); ?>" class="img-fluid masonry">
                     <?php echo $file->name; ?>

                  </a><br>
                  <a href="<?php echo route('assets.image.remove',$file->id); ?>" class="badge badge-danger delete">Remove</a>
               </div>
            <?php else: ?>
               <div class="my-masonry-grid-item ml-2 mt-2">
                  <a target="_blank" href="<?php echo asset('businesses/'.Wingu::business()->business_code.'/assets/'.$file->file_name); ?>">
                     <?php if(Helper::like_match('%word%',$file->file_mime)): ?>
                        <img src="<?php echo asset('assets/img/placeholders/docs.jpg'); ?>" class="img-fluid masonry">
                     <?php elseif(Helper::like_match('%pdf%',$file->file_mime)): ?>
                        <img src="<?php echo asset('assets/img/placeholders/pdf.jpg'); ?>" class="img-fluid masonry">
                     <?php elseif(Helper::like_match('%zip%',$file->file_mime)): ?>
                        <img src="<?php echo asset('assets/img/placeholders/zip.jpg'); ?>" class="img-fluid masonry">
                     <?php else: ?>
                        <img src="<?php echo asset('assets/img/placeholders/docs.jpg'); ?>" class="img-fluid masonry">
                     <?php endif; ?>
                     <?php echo $file->name; ?>

                  </a><br>
                  <a href="<?php echo route('assets.image.remove',$file->id); ?>" class="badge badge-danger delete">Remove</a>
               </div>
            <?php endif; ?>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
   </div>
</div>


<div class="modal fade" id="addFiles" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="<?php echo route('assets.files.add',$code); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
               <h3 class="modal-title" id="exampleModalLabel">Add Files</h3>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="">File Name</label>
                  <input type="text" name="file_name" class="form-control">
               </div>
               <div class="input-field">
                  <div class="input-images" style="padding-top: .5rem;"></div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submitDonateForm">Save Files</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </form>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/assets/assets/files.blade.php ENDPATH**/ ?>