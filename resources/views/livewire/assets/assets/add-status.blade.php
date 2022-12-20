<div wire:ignore.self class="modal fade" id="addStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <label for="">Title</label>
               <input type="text" wire:model="title" class="form-control">
               @error('title')<span class="error text-danger">{{$message}}</span>@enderror
            </div>
         </div>
         <div class="modal-footer">
            <button class="btn btn-danger" wire:click="close()">Close</button>
            <button class="btn btn-success" wire:click.prevent="save_status()"> Add Status</button>
         </div>
      </div>
   </div>
</div>
