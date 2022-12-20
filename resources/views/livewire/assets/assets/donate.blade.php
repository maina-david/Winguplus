<div>
   <div class="row">
      <div class="col-md-12">
         <a href="" data-toggle="modal" data-target=".disposed" class="btn btn-sm btn-primary pull-right"><i class="fal fa-plus-circle"></i> Record Asset As Donate</a>
      </div>
      <div class="col-md-12 mt-3">
         <table class="table table-bordered table-striped">
            <thead>
               <th width="1%">#</th>
               <th>Event Date</th>
               <th>Donated To</th>
               <th>Deductible</th>
               <th>Cost</th>
               <th>Note</th>
               <th width="12%">Action </th>
            </thead>
            <tbody>
               @foreach($events as $count=>$event)
                  <tr>
                     <th>{!! $count+1 !!}</th>
                     <th>{!! date('F jS, Y', strtotime($event->action_date)) !!}</th>
                     <th>{!! $event->action_to !!}</th>
                     <th>{!! $event->deductible !!}</th>
                     <th>{!! $event->cost !!}</th>
                     <th>{!! $event->note !!}</th>
                     <th>
                        @php
                           $getCode = json_encode($event->code);
                        @endphp
                        <a wire:click="edit({{$getCode}})" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editRepair" href="#">Edit</a>
                        <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete" wire:click="remove({{$getCode}})" href="#" >Delete</a>
                     </th>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
      <div wire:ignore.self class="modal fade" id="editRepair" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            @if($editMode == 'on')
               <div class="modal-content">
                  <div class="modal-header">
                     <h3 class="modal-title" id="exampleModalLabel"><i class="fal fa-box-heart"></i> Edit Donate </h3>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <label for="" class="text-danger">Donation date </label>
                              <input type="date" class="form-control" wire:model="action_date" required>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Dispose to</label>
                              <input type="text" class="form-control" wire:model="action_to">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <label for="" class="text-danger">Cost </label>
                              <input type="number" class="form-control" wire:model="cost" required>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Deductible </label>
                              <select wire:model="deductible" class="form-control">
                                 <option value="">Choose</option>
                                 <option value="No">No</option>
                                 <option value="Yes">Yes</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Note </label>
                              <textarea name="note" class="form-control tinymcy" wire:model="note" rows="6"></textarea>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <center>
                        <button type="submit" class="btn btn-pink submitRepairForm" wire:click.prevent="update()">Update Information</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                     </center>
                  </div>
               </div>
            @endif
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
</div>
