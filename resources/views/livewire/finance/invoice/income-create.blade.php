<div wire:ignore.self class="modal fade" id="addIncomeCategory" tabindex="-1" role="dialog" aria-labelledby="bankandcash" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form id="expressIncomeForm" action="javascript:void(0)">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="addExpressIncome">Add Income Category</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               @csrf
               <div class="form-group">
                  <label for="">Title</label>
                  <input type="text" class="form-control" wire:model="category_name" placeholder="Please enter a name" required>
                  @error('category_name')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" id="saveExpressIncome"  wire:click.prevent="AddIncomeCategory()" class="btn btn-success">Add Category</button>
            </div>
         </div>
      </form>
   </div>
</div>
