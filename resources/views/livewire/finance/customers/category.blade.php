<div>
   <!-- begin panel -->
   <div class="row">
      <div class="col-md-6">
         <div class="panel panel-inverse">
            <div class="panel-body">
               <div class="panel-body">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th>Name</th>
                           <th width="30%">Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($groups as $count=>$group)
                           <tr>
                              <td>{!! $count+1 !!}</td>
                              <td>{!! $group->name !!}</td>
                              <td>
                                 <a href="#" wire:click="edit({{$group->id}})"  class="btn btn-pink btn-sm"><i class="far fa-edit"></i> Edit</a>
                                 <a href="#" data-toggle="modal" data-target="#deleteModal" wire:click="confirmDelete({{$group->id}})" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
                  {!! $groups->links() !!}
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">
                  @if($updateMode==true)
                     Edit Category
                  @else
                     Add Category
                  @endif
               </h4>
            </div>
            <div class="panel-body">
               <div class="panel-body">
                  <form>
                     <div class="form-group form-group-default required">
                        {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                        <input type="text" wire:model="name" class="form-control" placeholder="Enter category name" required>
                        @error('name')<span class="error text-danger">{{$message}}</span>@enderror
                     </div>
                     <div class="form-group mt-4">
                        <center>
                           @if($updateMode==true)
                              <button type="button" class="btn btn-warning submit" wire:click.prevent="update()"><i class="fas fa-save"></i> Update Category</button>
                           @else
                              <button type="button" class="btn btn-success submit" wire:click.prevent="store()"><i class="fas fa-save"></i> Add Category</button>
                           @endif
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                        </center>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- delete subject -->
      <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Delete Confirm</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                  </button>
               </div>
               <div class="modal-body">
                  <p>Are you sure, you want to delete this category?</p>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                  <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal" data-dismiss="modal">Yes, Delete</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
