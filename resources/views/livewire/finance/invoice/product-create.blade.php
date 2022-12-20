<div wire:ignore.self class="modal fade" id="addProducts" tabindex="-1" role="dialog" aria-labelledby="addProducts" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form id="expressCustomerForm" action="javascript:void(0)">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="addExpressCustomer">Add Product</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               @csrf
               <div class="form-group">
                  <label for="">Product Type</label>
                  <select wire:model="type" class="form-control" required>
                     <option value="">Choose Product Type</option>
                     <option value="product" selected>Standard Product</option>
                     <option value="service">Service</option>
                  </select>
                  @error('product_name')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
               <div class="form-group">
                  <label for="">Product Name</label>
                  <input type="text" class="form-control" wire:model="product_name" placeholder="Enter product name" required>
                  @error('product_name')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
               <div class="form-group">
                  <label for="">Price</label>
                  <input type="number" class="form-control" wire:model="price" placeholder="Enter price">
                  @error('price')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
               <div class="form-group">
                  <label for="">Quantity</label>
                  <input type="number" class="form-control" wire:model="quantity" placeholder="Enter quantity" required>
                  @error('quantity')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" wire:click.prevent="AddProduct()" class="btn btn-success">Add Product</button>
            </div>
         </div>
      </form>
   </div>
</div>
