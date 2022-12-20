<div class="row">
   <div class="col-md-12">
      <div class="email-wrapper wrapper">
         <div class="row align-items-stretch"  style="height: 700px">
            <div class="mail-view d-none d-md-block col-md-12 bg-white">
               <div class="row mt-3 ml-2 mr-2">
                  <form class="col-md-12" method="POST" action="<?php echo route('crm.customer.mail.store'); ?>" enctype="multipart/form-data">
                     <?php echo csrf_field(); ?>
                     <div class="form-group">
                        <label for="">Subject</label>
                        <?php echo Form::text('subject',null,['class'=>'form-control','placeholder'=>'Enter subject','required'=>'']); ?>

                        <input type="hidden" name="leadID"value="<?php echo $code; ?>" required>
                     </div>
                     <div class="form-group">
                        <label for="">Email
                           <span data-toggle="tooltip" data-placement="top" title="If you need to change the Email you can change it on the lead edit section.">
                              <i class="fas fa-info-circle"></i>
                           </span>
                        </label>
                        <input type="email" name="email" class="form-control" value="<?php echo $client->email; ?>" required readonly>
                     </div>
                     <div class="form-group">
                        <label for="">CC</label>
                        <?php echo Form::select('email_cc[]',[],null,['class'=>'form-control select2']); ?>

                     </div>
                     <div class="form-group">
                        <label for="">Attachment</label>
                        <select name="attach_files[]" class="form-control select2" style="width:100%" multiple>
   								<?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   									<option value="<?php echo $file->id; ?>"><?php if($file->name != ""): ?><?php echo $file->name; ?> -<?php endif; ?> <?php echo $file->file_name; ?></option>
   								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   							</select>
                     </div>
                     <div class="form-group">
                        <label for="">Message</label>
                        <?php echo Form::textarea('message',null,['class'=>'form-control tinymcy','required'=>'']); ?>

                     </div>
                     <div class="form-group mb-2">
                        <button type="submit" class="pull-right btn btn-pink submit"><i class="fal fa-paper-plane"></i> Send email</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/customers/mail/mail.blade.php ENDPATH**/ ?>