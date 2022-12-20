<div class="row">
   <div class="col-md-6">
      <div class="panel panel-inverse">
         <div class="panel-body">
            <div class="panel-body">
               <div class="row">
                  <div class="col-md-12">
                     <input type="text" placeholder="Search by name" wire:model="search" class="form-control">
                  </div>
               </div>
               <table class="table table-striped table-bordered mt-3">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th width="20%">Name</th>
                        <th width="20%">Parent</th>
                        <th width="13%">Items</th>
                        <th class="text-center" width="15.5%">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($categories as $count=>$all)
                        @if(Auth::user()->business_code == $all->business_code)
                           <tr>
                              <td>{!! $count+1 !!}</td>
                              <td>{!! $all->name !!}</td>
                              <td class="font-weight-bold">
                                 @if(Finance::check_product_category($all->parent) == 1)
                                    {!! Finance::product_category($all->parent)->name !!}
                                 @endif
                              </td>
                              <td>{!! Finance::products_by_category_count($all->category_code) !!}</td>
                              <td>
                                 @php
                                    $getCode = json_encode($all->category_code);
                                 @endphp
                                 <a href="#" wire:click="edit({{$getCode}})" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                 <a href="#" wire:click="confirmDelete({{$getCode}})" data-toggle="modal" data-target="#delete" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                              </td>
                           </tr>
                        @endif
                     @endforeach
                  </tbody>
               </table>
               {!! $categories->links() !!}
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <div class="panel panel-default">
         <div class="panel-heading">
            @if($editMode)
               <h4 class="panel-title">Edit Category</h4>
            @else
               <h4 class="panel-title">Add Category</h4>
            @endif
         </div>
         <div class="panel-body">
            <div class="panel-body">
               <div class="form-group form-group-default required">
                  {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                  <input type="text" wire:model="name" class="form-control" placeholder="Enter Category Name" required>
                  @error('name')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
               <div class="form-group">
                  {!! Form::label('title', 'Parent Category', array('class'=>'control-label')) !!}
                  <select wire:model="parent" class="form-control">
                     <option value="">Choose parent category</option>
                     @foreach($allCategories as $cat)
                        @if(Auth::user()->business_code == $cat->business_code)
                           <option value="{{$cat->category_code}}">{!! $cat->name !!}</option>
                        @endif
                     @endforeach
                  </select>
                  @error('parent')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
               <div class="form-group mt-4">
                  <center>
                     @if($editMode)
                        <button class="btn btn-primary" wire:click.prevent="update" wire:loading.class="none"><i class="fas fa-save"></i> Update Category</button>
                     @else
                        <button class="btn btn-pink" wire:click.prevent="store" wire:loading.class="none"><i class="fas fa-save"></i> Add Category</button>
                     @endif

                     <div wire:loading wire:target="update,store">
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load" alt="loader" width="25%">
                     </div>
                  </center>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Delete -->
   <div wire:ignore.self id="delete" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="cancel_delete()">Cancel</button>
               <button type="button" class="btn btn-danger" wire:click="delete()">Delete</button>
            </div>
         </div>
      </div>
   </div>
</div>
