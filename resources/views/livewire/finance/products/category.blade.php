<div class="row">
   <div class="col-md-6">
      <div class="panel panel-inverse">
         <div class="panel-body">
            <div class="panel-body">
               <div class="row">
                  <div class="col-md-12 mb-3">
                     <input type="text" wire:model="search" placeholder="Search by category name" class="form-control">
                  </div>
               </div>
               <table class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th width="20%">Name</th>
                        <th width="20%">Parent</th>
                        <th class="text-center" width="20%">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($category as $count=>$all)
                        @if($all->business_code == Auth::user()->business_code)
                           <tr>
                              <td>{!! $count+1 !!}</td>
                              <td>{!! $all->name !!}</td>
                              <td class="font-weight-bold">
                                 @if(Finance::check_product_category($all->parent) == 1)
                                    {!! Finance::product_category($all->parent)->name !!}
                                 @endif
                              </td>
                              <td>
                                 @php
                                    $code = json_encode($all->category_code);
                                 @endphp
                                 <a href="#" wire:click="edit({{$code}})" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                 <a href="#" wire:click="remove({{$code}})" data-toggle="modal" data-target="#delete"  class="btn btn-danger"><i class="fas fa-trash"></i></a>
                              </td>
                           </tr>
                        @endif
                     @endforeach
                  </tbody>
               </table>
               {!! $category->links() !!}
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">@if($editMode) Edit @else Add @endif Category</h4>
         </div>
         <div class="panel-body">
            <div class="panel-body">
               <div class="form-group form-group-default required">
                  {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                  <input type="text" class="form-control" wire:model="name" placeholder="Enter Category Name" required>
               </div>
               <div class="form-group">
                  {!! Form::label('title', 'Parent Category', array('class'=>'control-label')) !!}
                  <select wire:model="parent" class="form-control select2">
                     <option value="">Choose parent category</option>
                     @foreach($category as $cat)
                        <option value="{!! $cat->category_code !!}">{!! $cat->name !!}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group mt-4">
                  <center>
                     @if($editMode)
                        <button type="submit" class="btn btn-primary submit" wire:click.prevent="update()"><i class="fas fa-save"></i> Update Category</button>
                     @else
                        <button type="submit" class="btn btn-pink submit" wire:click.prevent="store()"><i class="fas fa-save"></i> Add Category</button>
                     @endif
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
                  </center>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Modal HTML -->
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
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close()">Cancel</button>
               <button type="button" class="btn btn-danger" wire:click="delete()">Delete</button>
            </div>
         </div>
      </div>
   </div>

</div>
