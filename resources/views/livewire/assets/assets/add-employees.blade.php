<div wire:ignore.self class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Employee</h5>
            <button type="button" class="close" wire:click="close()">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <label for="">Employee Name</label>
               <input type="text" wire:model="employee_name" class="form-control" required>
               @error('employee_name')<span class="error text-danger">{{$message}}</span>@enderror
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
            <button class="btn btn-success" wire:click.prevent="add_employee()">Save changes</button>
         </div>
      </div>
   </div>
</div>
