<div>
   <div class="row">
      <div class="col-md-12 mt-2">
         <div class="row">
            <div class="col-md-10">
               <h4 class="font-weight-bold"><i class="fal fa-sticky-note"></i> Notes</h4>
            </div>
            <div class="col-md-2">
               <button data-toggle="modal" data-target="#addNote" class="btn btn-block btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Add Note</button>
            </div>
            <div class="col-md-12">
               <div class="row">
                  <div class="col-md-6">
                     <input type="text" class="form-control" wire:model="search" wire:model="search" placeholder="Search here .... ">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row mt-3">
      @foreach($notes as $note)
         @php
            $getcode = json_encode($note->note_code);
         @endphp
         <div class="col-md-4">
            <div class="panel @if($note->label)text-white @else panel-default @endif">
               <div class="panel-heading @if($note->label){{$note->label}}-700 @endif">
                  <h4 class="panel-title">{{$note->title}}</h4>
                  <div class="panel-heading-btn">
                     <a href="{!! route('job.notes.edit',[$jobCode,$note->note_code]) !!}" class="badge badge-primary"><i class="fa fa-edit"></i> Edit</a>
                     <a href="#" wire:click="delete_note({{$getcode}})" class="badge badge-danger delete"><i class="fa fa-trash-alt"></i> Delete</a>
                  </div>
               </div>
               <div class="panel-body @if($note->label){{ $note->label }} @else @endif" style="min-height: 230px">
                  <p>{{$note->brief}}</p>
               </div>
            </div>
         </div>
      @endforeach
   </div>

   {{-- add note --}}
   <div wire:ignore.self class="modal fade" id="addNote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!--begin::Modal dialog-->
      <div class="modal-dialog">
         <!--begin::Modal content-->
         <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header no-border">
               <h5 class="modal-title" id="exampleModalLongTitle">Create Note</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row mb-5">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control" placeholder="Enter title" wire:model="title" />
                        @error('title')<span class="error text-danger">{{$message}}</span>@enderror
                     </div>
                     <div class="form-group">
                        <label for="">Brief</label>
                        <textarea type="text" class="form-control" placeholder="Enter title" rows="4" wire:model="brief"/></textarea>
                     </div>
                     <div class="form-group">
                        <label for="">Label</label>
                        <select wire:model="label" class="form-control">
                           <option value="">Choose Label</option>
                           {{-- <option value="bg-green">Green</option> --}}
                           <option value="bg-blue">Blue</option>
                           <option value="bg-orange">Orange</option>
                           <option value="bg-red">Red</option>
                           <option value="bg-cyan">Cyan / Aqua</option>
                           <option value="bg-gray">Gray</option>
                           <option value="bg-teal">Teal</option>
                        </select>
                     </div>
                     <button class="btn btn-success btn-sm mt-4" wire:click="create_note()"><i class="fal fa-save"></i> Create Note</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
