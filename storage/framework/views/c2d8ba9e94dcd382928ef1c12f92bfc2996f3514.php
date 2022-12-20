<div>
   <div wire:ignore.self class="modal right fade" id="rightSlideNotes" tabindex="-1" role="dialog" aria-labelledby="rightSlideNotes" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-sm" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#leftSlideNoteArea"><i class="fa fa-plus-circle"></i> New Note</a>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                     $getCode = json_encode($note->note_code);
                  ?>
                  <div class="note-side js-single-note">
                     <a href="#" wire:click="delete_confirmation(<?php echo e($getCode); ?>)" data-toggle="modal" data-target="#deleteSideNote"><span class="note-remove js-note-remove"></span></a>
                     <a wire:click="view_note(<?php echo e($getCode); ?>)" data-toggle="modal" data-target="#rightSideNoteDetails">
                        <div class="note-text" wire:click="edit(<?php echo e($getCode); ?>)">
                           <?php echo nl2br($note->note); ?>

                        </div>
                        <div class="note-date">
                           <?php echo date('F jS,Y h:i:s A', strtotime($note->created_at)); ?>

                        </div>
                     </a>
                  </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         </div>
      </div>
   </div>

   <!-- add note -->
   <div wire:ignore.self class="modal fade" id="leftSlideNoteArea" tabindex="-1" role="dialog" aria-labelledby="leftSlideNoteAddTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <?php if($mode == 'edit'): ?>
                  <h5 class="modal-title" id="exampleModalLongTitle">Edit Note</h5>
               <?php else: ?>
                  <h5 class="modal-title" id="exampleModalLongTitle">New Note</h5>
               <?php endif; ?>
               <button type="button" class="close" wire:click="close_crud()"="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <textarea wire:model.defer="note_content" class="form-control" cols="30" rows="30" required></textarea>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" wire:click="close_crud()">Close</button>
               <?php if($mode == 'edit'): ?>
                  <button type="submit" class="btn btn-primary" wire:click.prevent="update()"><i class="fa fa-save"></i> Update Note</button>
               <?php else: ?>
                  <button type="submit" class="btn btn-success" wire:click.prevent="add_note()"><i class="fa fa-save"></i> Save Note</button>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>

   <!-- delete modal -->
   <div wire:ignore.self id="deleteSideNote" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
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
               <button type="button" class="btn btn-danger" wire:click="delete()">Delete</button>
            </div>
         </div>
      </div>
   </div>

   <!-- view note -->
   <?php if($mode == 'view'): ?>
      <div wire:ignore.self class="modal right fade" id="rightSideNoteDetails" tabindex="-1" role="dialog" aria-labelledby="rightSideNoteDetails" data-keyboard="false" data-backdrop="static">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Note Details</h5>
                  <button type="button" class="close" aria-label="Close" wire:click="close_view()">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <?php echo nl2br($details->note); ?>

               </div>
               <?php
                  $viewCode = json_encode($noteCode );
               ?>
               <div class="modal-footer modal-footer-fixed">
                  <button type="button" class="btn btn-secondary" wire:click="close_view()">Close</button>
                  <button type="button" class="btn btn-primary" wire:click="edit(<?php echo e($viewCode); ?>)" data-toggle="modal" data-target="#leftSlideNoteArea"><i class="fa fa-edit"></i> Edit</button>
               </div>
            </div>
         </div>
      </div>
   <?php endif; ?>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/general/notes/note.blade.php ENDPATH**/ ?>