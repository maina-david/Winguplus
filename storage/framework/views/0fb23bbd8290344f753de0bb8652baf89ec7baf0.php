<div class="row">
   <div class="col-md-12">
      <?php if($details->current_status == 38): ?>
         <a data-toggle="modal" data-target=".checkin" class="btn btn-success text-white pull-right"><i class="fal fa-sign-in-alt"></i> Record Check In</a>
      <?php else: ?>
         <a data-toggle="modal" data-target=".checkout" class="btn btn-primary text-white pull-right"><i class="fal fa-sign-out-alt"></i> Record Check out</a>
      <?php endif; ?>
   </div>
   <div class="col-md-12 mt-2">
      <table class="table table-bordered">
         <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <td>
                  <small class="text-primary"><?php echo $event->name; ?> Date</small>
                  <p><b><?php echo date('F jS, Y', strtotime($event->action_date)); ?></b></p>
               </td>
               <td>
                  <span class="btn <?php echo Helper::seoUrl($event->name); ?> btn-block"><?php echo $event->name; ?></span>
               </td>
               <td>
                  <?php if($event->status == 38): ?>
                     <?php if($event->check_out_to == 'Location'): ?>
                        <small class="text-primary">Assigned to location</small>
                     <?php else: ?>
                        <small class="text-primary">Assigned to</small>
                     <?php endif; ?>
                  <?php endif; ?>
                  <?php if($event->status == 43): ?>
                     <small class="text-primary">Checked in by</small>
                     <p>
                        <b><?php echo Wingu::user($event->created_by)->name; ?></b>
                     </p>
                     <small class="text-primary">Checked in at</small>
                     <p>
                        <i class="fal fa-map-marked"></i> <b><?php echo $event->site_location; ?></b>
                     </p>
                  <?php endif; ?>
                  <?php if($event->check_out_to == 'Person'): ?>
                     <p>
                        <?php if($event->employee): ?>
                           <b><?php echo Hr::employee($event->employee)->names; ?></b>
                        <?php endif; ?>
                     </p>
                  <?php endif; ?>
                  <?php if($event->check_out_to == 'Location'): ?>
                     <p>
                        <?php if($event->check_out_to): ?>
                           <b><?php echo $event->site_location; ?></b>
                        <?php endif; ?>
                     </p>
                  <?php endif; ?>
               </td>
               <td>
                  <?php if($event->status != 43): ?>
                     <small class="text-primary">Due date</small>
                     <p>
                        <?php if($event->due_action_date == ""): ?>
                           <b>No due date</b>
                        <?php else: ?>
                           <b><?php echo date('F jS, Y', strtotime($event->due_action_date)); ?></b>
                        <?php endif; ?>
                     </p>
                  <?php endif; ?>
                  <?php if($event->status == 43): ?>
                     <small class="text-primary">Check in date</small>
                     <p><b><?php echo date('F jS, Y', strtotime($event->action_date)); ?></b></p>
                  <?php endif; ?>
               </td>
               <td width="20%">
                  <small class="text-primary">Note</small><br>
                  <?php echo substr($event->note, 0,180); ?> <?php echo strlen($event->note) > 180 ? "..." : ""; ?>

               </td>
               <td width="12%">
                  <?php if($event->status == 38): ?>
                     <a href="javascript;" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".checkout<?php echo $event->code; ?>">Edit</a>
                  <?php endif; ?>
                  <?php if($event->status == 39): ?>
                     <a href="javascript;" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".lease<?php echo $event->code; ?>">Edit</a>
                  <?php endif; ?>
                  <?php if($event->status == 43): ?>
                     <a href="javascript;" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".checkin<?php echo $event->code; ?>">Edit</a>
                  <?php endif; ?>
                  <a href="<?php echo route('assets.checkout.checkin.delete',[$code,$event->code]); ?>" class="btn btn-sm btn-danger delete">Delete</a>
               </td>
            </tr>

            
            <div class="modal fade checkout<?php echo $event->code; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     <?php echo Form::model($event, ['route' => ['assets.event.checkout.update',$event->code], 'method'=>'post','id'=>'checkoutForm', 'autocomplete' => 'off']); ?>

                        <?php echo csrf_field(); ?>
                        <div class="modal-header">
                           <h3 class="modal-title" id="exampleModalLabel">Update Check out</h3>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Check-out Date</label>
                                    <?php echo Form::text('action_date',null,['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'choose date']); ?>

                                    <input type="hidden" name="status" value="38">
                                    <input type="hidden" name="assetID" value="<?php echo $code; ?>">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Due Date</label>
                                    <?php echo Form::text('due_action_date',null,['class' => 'form-control datepicker', 'placeholder' => 'choose date']); ?>

                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Check-out to</label>
                                    <?php echo Form::select('check_out_to',['' => 'Choose','Person' => 'Person','Branch' => 'Branch','Location' => 'Site / Location'],null,['class' => 'form-control select2', 'required' => '', 'id'=>'checkouttoedit']); ?>

                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Branch</label>
                                    <?php echo Form::select('branch',$branches,null,['class' => 'form-control select2']); ?>

                                 </div>
                              </div>
                              <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('assets.assets.employees')->html();
} elseif ($_instance->childHasBeenRendered('o2g7E3z')) {
    $componentId = $_instance->getRenderedChildComponentId('o2g7E3z');
    $componentTag = $_instance->getRenderedChildComponentTagName('o2g7E3z');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('o2g7E3z');
} else {
    $response = \Livewire\Livewire::mount('assets.assets.employees');
    $html = $response->html();
    $_instance->logRenderedChild('o2g7E3z', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                              <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('assets.assets.departments')->html();
} elseif ($_instance->childHasBeenRendered('FBRUGNY')) {
    $componentId = $_instance->getRenderedChildComponentId('FBRUGNY');
    $componentTag = $_instance->getRenderedChildComponentTagName('FBRUGNY');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('FBRUGNY');
} else {
    $response = \Livewire\Livewire::mount('assets.assets.departments');
    $html = $response->html();
    $_instance->logRenderedChild('FBRUGNY', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                              <?php if($event->check_out_to == 'Location'): ?>
                                 <div class="col-md-12">
                                    <div class="form-group form-group-default required">
                                       <label for="">Site / Location </label>
                                       <?php echo Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']); ?>

                                    </div>
                                 </div>
                              <?php else: ?>
                                 <div class="col-md-12" style="display:none" id="checkoutLocationEdit">
                                    <div class="form-group form-group-default required">
                                       <label for="">Site / Location </label>
                                       <?php echo Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']); ?>

                                    </div>
                                 </div>
                              <?php endif; ?>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="">Note </label>
                                    <?php echo Form::textarea('note',null,['class' => 'form-control tinymcy']); ?>

                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <center>
                              <button type="submit" class="btn btn-pink submitCheckoutForm">Update information</button>
                              <img src="<?php echo asset('/assets/img/btn-loader.gif'); ?>" class="checkout-load none" width="15%">
                           </center>
                        </div>
                     <?php echo Form::close(); ?>

                  </div>
               </div>
            </div>

            
            

            
            <div class="modal fade checkin<?php echo $event->code; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     <?php echo Form::model($event, ['route' => ['assets.event.checkin.update',$event->code], 'method'=>'post','id'=>'leaseForm', 'autocomplete' => 'off']); ?>

                        <?php echo csrf_field(); ?>
                        <div class="modal-header">
                           <h3 class="modal-title" id="exampleModalLabel"><i class="fal fa-sign-in-alt"></i> Update Check in</h3>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Return Date </label>
                                    <?php echo Form::date('action_date',null,['class' => 'form-control', 'required' => '']); ?>

                                    <input type="hidden" name="status" value="43">
                                    <input type="hidden" name="asset_code" value="<?php echo $code; ?>" required>
                                 </div>
                              </div>
                              <div class="col-md-6" id="checkoutLocation">
                                 <div class="form-group form-group-default required">
                                    <label for="">Site / Location </label>
                                    <?php echo Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']); ?>

                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="">Note </label>
                                    <?php echo Form::textarea('note',null,['class' => 'form-control tinymcy']); ?>

                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <center>
                              <button type="submit" class="btn btn-pink submitCheckinForm">Update Information</button>
                              <img src="<?php echo url('/'); ?>/public/backend/img/btn-loader.gif" class="checkin-load none" width="15%">
                           </center>
                        </div>
                     <?php echo Form::close(); ?>

                  </div>
               </div>
            </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </table>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/assets/assets/checkout_checkin.blade.php ENDPATH**/ ?>