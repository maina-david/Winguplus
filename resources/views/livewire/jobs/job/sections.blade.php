<div>
   <div wire:ignore.self class="modal fade" id="add-section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Add Section</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="">Section Title</label>
                  <input type="text" wire:model.defer="title" class="form-control" required>
                  @error('title')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:loading.class="none">Close</button>
               <button type="button" class="btn btn-success" wire:click.prevent="store()" wire:loading.class="none">Add Section</button>
               <div wire:loading wire:target="store">
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load float-right" alt="" width="30%">
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

