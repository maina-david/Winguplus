<?php $__env->startSection('title','Mail Invoice'); ?>

<?php $__env->startSection('stylesheet'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="<?php echo route('finance.invoice.show',$details->invoiceCode); ?>" class="btn btn-pink"><i class="fas fa-chevron-left"></i> Back to view</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Mail Invoice To <?php echo $client->customer_name; ?></h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-8">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <form class="" action="<?php echo route('finance.invoice.send.mail'); ?>" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="invoiceCode" value="<?php echo $details->invoiceCode; ?>" required>
                     <?php echo csrf_field(); ?>
                     <div class="form-group col-md-12">
   							<label for="">Form</label>
   							<input type="email" name="email_from" value="<?php echo $details->email; ?>" class="form-control">
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Send To</label>
                        <input type="text" name="send_to" value="<?php echo $client->email; ?>" class="form-control" required readonly>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Cc</label>
                        <select name="email_cc[]" id="" class="form-control select2" style="width:100%" multiple>
                           <?php if($client->email_cc != ""): ?>
   								   <option value="<?php echo $client->email_cc; ?>"><?php echo $client->email_cc; ?></option>
                           <?php endif; ?>
   								<?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo $contact->contact_email; ?>"><?php echo $contact->contact_email; ?></option>
   								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   							</select>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Subject</label>
   							<input type="text" name="subject" value="Invoice - <?php echo $details->invoice_prefix; ?><?php echo $details->invoice_number; ?> from <?php echo $details->businessName; ?>" class="form-control" required>
   						</div>
   						<div class="form-group col-md-12">
   							<textarea name="message" cols="30" rows="10" class="tinymcy">
   								<span style="font-size: 12pt;">Dear <?php echo $client->customer_name; ?></span><br/><br/>
                           <span style="font-size: 12pt;">
                              We have prepared the following invoice for you: <strong># <?php echo $details->prefix; ?><?php echo $details->invoice_number; ?></strong>
                           </span>
                           <br /><br />
                           <span style="font-size: 12pt;">
                              <strong>Invoice status</strong>:<i><?php echo ucfirst($details->status_name); ?></i>
                           </span><br />
                           <span style="font-size: 12pt;">Please contact us for more information.</span><br /><br />
                           <span style="font-size: 12pt;">Kind Regards,</span><br />
                           <span style="font-size: 12pt;"><?php echo $details->businessName; ?></span>
   							</textarea>
   						</div>
   						<div class="form-group mt-3">
                        <input type="checkbox" value="Yes" name="attaches" id="attach" class="ml-2" checked>
                        <label for="">Attach Invoice</label><br>
                        <a href="<?php echo asset('businesses/'.$details->business_code.'/finance/invoices/'.$details->prefix.$details->invoice_number.'.pdf'); ?>" target="_blank" class="ml-3" id="preview"> Preview current Attached Invoice</a>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Attach Files</label>
   							<select name="attach_files[]" class="form-control select2" style="width:100%" multiple>
   								<?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   									<option value="<?php echo $file->id; ?>"><?php echo $file->file_name; ?></option>
   								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   							</select>
   						</div>
                     <div class="form-group mt-5">
                        <button type="submit" name="button" class="offset-md-10 btn btn-pink submit"><i class="fas fa-paper-plane"></i> Send Invoice</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      $('#attach').click(function(){
         this.checked?$('#preview').show(1000):$('#preview').hide(1000); //time for show
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/invoices/mail.blade.php ENDPATH**/ ?>