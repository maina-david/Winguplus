<div wire:ignore.self class="modal fade" id="addSupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Supplier</h5>
            <button type="button" class="close" wire:click="close()">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <label for="">Supplier Name</label>
               <input type="text" wire:model="supplier_name" class="form-control">
               @error('supplier_name')<span class="error text-danger">{{$message}}</span>@enderror
            </div>
            <div class="form-group">
               <label for="">Phone Number</label>
               <input type="number" wire:model="phone_number" class="form-control">
            </div>
            <div class="form-group">
               <label for="">Email</label>
               <input type="text" wire:model="email" class="form-control">
            </div>
         </div>
         <div class="modal-footer">
            <button class="btn btn-danger" wire:click="close()">Close</button>
            <button class="btn btn-success" wire:click.prevent="save_supplier()">Save changes</button>
         </div>
      </div>
   </div>
</div>
