<div>
   <div wire:ignore.self class="modal right fade modal-side-draw" id="detail" tabindex="-1" role="dialog" aria-labelledby="detail" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-xl" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">
                  <?php echo $details->event_name; ?><br>
                  <small>Hosted by <?php if($details->owner != ""): ?><?php echo Wingu::user($details->owner)->name; ?> <?php endif; ?></small>
               </h4><br>
               <button type="button" class="close" wire:click="close()" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="modal-row row">
                  <div class="col-md-9 modal-col-left" style="background: #f7f7f7">
                     <ul class="nav nav-pills">
                        <li class="nav-item">
                           <a  class="nav-link pointer-cursor <?php if($this->currentView == 'details'): ?> active <?php endif; ?>" wire:click="change_view('details')">Overview</a>
                        </li>
                        <li class="nav-item">
                           <a  class="nav-link pointer-cursor <?php if($this->currentView == 'notes'): ?> active <?php endif; ?>" wire:click="change_view('notes')">Notes</a>
                        </li>
                     </ul>

                     <?php if($this->currentView == 'details'): ?>
                        <div class="card">
                           <div class="card-body">
                              <h5>
                                 <i class="fal fa-calendar-alt"></i> <?php echo date('F jS, Y', strtotime($details->start_date)); ?> @ <?php echo date('g:i A', strtotime($details->start_time)); ?> <b><i>Until</i></b> <?php echo date('F jS, Y', strtotime($details->end_date)); ?> @ <?php echo date('g:i A', strtotime($details->start_time)); ?>

                              </h5>
                              <h5>
                                 <b>Meeting Type :</b> <?php echo ucfirst($details->meeting_type); ?>

                              </h5>
                              <?php if($details->location): ?>
                                 <h5>
                                    <i class="fal fa-map-marker-alt"></i> <?php echo $details->location; ?>

                                 </h5>
                              <?php endif; ?>
                              <?php if($details->meeting_link): ?>
                                 <h5>
                                    <i class="fal fa-globe"></i> <a href="<?php echo $details->meeting_link; ?>" target="_blank">Meeting Link</a>
                                 </h5>
                              <?php endif; ?>
                              <h5>
                                 <b><i class="fal fa-exclamation-circle"></i> Status :</b>  <?php if($details->status): ?>
                                    <?php
                                       $status = Wingu::status($details->status);
                                    ?>
                                    <span class="badge <?php echo $status->name; ?>"><?php echo $status->name; ?></span>
                              <?php endif; ?>
                              </h5>
                           </div>
                        </div>

                        <div class="card">
                           <div class="card-body">
                              <?php echo nl2br($details->description); ?>

                           </div>
                        </div>
                     <?php endif; ?>
                     <?php if($this->currentView == 'notes'): ?>
                        <div class="card">
                           <div class="card-header">Notes</div>
                           <div class="card-body">
                              <table class="table table-striped">
                                 <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                       $theCode = json_encode($note->note_code);
                                    ?>
                                    <tr>
                                       <td>

                                       </td>
                                       <td>
                                          <b><?php echo $note->subject; ?></b><br>
                                          <p><?php echo nl2br($note->note); ?></p>
                                          <a href="#noteArea" class="badge badge-primary float-right ml-2" wire:click="edit_note(<?php echo e($theCode); ?>)">Edit</a>
                                          <a href="#" class="badge badge-danger float-right" data-toggle="modal" data-target="#delete" wire:click="delete_note(<?php echo e($theCode); ?>)">Delete</a>
                                       </td>
                                    </tr>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </table>
                           </div>
                           <div class="card-footer">
                              <div class="" id="noteArea">
                                 <input type="text" class="form-control mb-2" wire:model.defer="subject" placeholder="Enter Note title">
                                 <textarea class="form-control" cols="4" rows="4" wire:model.defer="note" placeholder="type here ...... "></textarea>
                                 <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error text-danger"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                 <?php if($this->noteCode): ?>
                                    <button class="btn btn-primary mt-2" wire:click.prevent="update_note()"><i class="fa fa-save"></i> Update Note</button>
                                 <?php else: ?>
                                    <button class="btn btn-success mt-2" wire:click.prevent="add_note()"><i class="fa fa-save"></i> Add Note</button>
                                 <?php endif; ?>
                              </div>
                           </div>
                        </div>
                     <?php endif; ?>
                  </div>
                  <div class="col-md-3 modal-col-right" style="background: #fff">
                     <a href="#" data-toggle="modal" data-target="#eventEdit" class="btn btn-block btn-outline-black"><i class="fa fa-edit"></i> Edit </a>
                     <a data-toggle="modal" data-target="#delete" wire:click="delete_event()" class="btn btn-block btn-outline-black"><i class="fas fa-trash-alt"></i>  Delete</a>
                  </div>
               </div>
            </div>
            <div class="modal-footer modal-footer-fixed">
               <button type="button" class="btn btn-secondary" wire:click="close()">Close</button>
            </div>
         </div>
      </div>
   </div>

   <!-- delete modal -->
   <div wire:ignore.self id="delete" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
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
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_delete()">Cancel</button>
               <?php if($this->deleteNoteCode): ?>
                  <button type="button" class="btn btn-danger" wire:click="remove_note()">Delete</button>
               <?php endif; ?>
               <?php if($this->deleteEventCode): ?>
                  <button type="button" class="btn btn-danger" wire:click="remove_event()">Delete</button>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>

   <?php if($this->eventCode): ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crm.leads.events.edit', ['eventCode'=>$this->eventCode])->html();
} elseif ($_instance->childHasBeenRendered('cdWgoyI')) {
    $componentId = $_instance->getRenderedChildComponentId('cdWgoyI');
    $componentTag = $_instance->getRenderedChildComponentTagName('cdWgoyI');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('cdWgoyI');
} else {
    $response = \Livewire\Livewire::mount('crm.leads.events.edit', ['eventCode'=>$this->eventCode]);
    $html = $response->html();
    $_instance->logRenderedChild('cdWgoyI', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php endif; ?>

</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/crm/leads/events/details.blade.php ENDPATH**/ ?>