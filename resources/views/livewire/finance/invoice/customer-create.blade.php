<div wire:ignore.self class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="bankandcash" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form id="expressCustomerForm" action="javascript:void(0)">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="addExpressCustomer">Add Customer</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               @csrf
               <div class="form-group">
                  <label for="">Name</label>
                  <input type="text" name="customer_name" class="form-control" wire:model="customerName" placeholder="Enter name" required>
                  @error('customerName')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
               <div class="form-group">
                  <label for="">Email</label>
                  <input type="text" name="email" class="form-control" wire:model="customerEmail" placeholder="Enter Email">
                  @error('customerEmail')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
               <div class="form-group">
                  <label for="">Phone Number</label>
                  <input type="text" name="phone_number" class="form-control" wire:model="customerPhonenumber" placeholder="Enter phone number" required>
                  @error('customerPhonenumber')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" id="saveExpressCustomer" wire:click.prevent="AddCustomer()" class="btn btn-success">Add Customer</button>
            </div>
         </div>
      </form>
   </div>
</div>
