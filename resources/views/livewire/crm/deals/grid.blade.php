<div>
   <div class="row">
      <div class="col-md-9">
         <h1 class="page-header">
            <i class="fal fa-code-branch"></i> Pipeline | {!! $pipeline->title !!}
         </h1>
      </div>
      <div class="col-md-3">
         <select class="form-control" wire:model="pipelineCode">
            <option value="">Change Pipeline</option>
            @foreach($lines as $line)
               <option value="{!! $line->pipeline_code !!}">{!! $line->title !!}</option>
            @endforeach
         </select>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <a wire:click="add_stage()" data-toggle="modal" data-target="#stageModal" href="#" class="btn btn-sm btn-warning float-right"><i class="fas fa-plus-circle"></i> Add Stage</a>
      </div>
      <div class="col-md-12">
         <div class="task-board">
            @foreach($stages as $stages)
               @php
                  $getStageCode = json_encode($stages->stage_code);
               @endphp
               <div class="status-card">
                  <div class="card-header" @if($stages->color)style="color:#fff;background-color:{!!$stages->color!!};"@endif>
                     <span class="card-header-text mb-2">
                        {!! $stages->title !!}
                        ({!! Crm::stage_deals($stages->stage_code)->count() !!})
                        <i class="far fa-horizontal-rule"></i>
                        <b>[ {!! $business->currency !!} {!! number_format(Crm::stage_deals($stages->stage_code)->sum('value')) !!} ]</b>

                        <a wire:click="delete_alert({{$getStageCode}},'stage')" data-toggle="modal" data-target="#delete" href="#">
                           <i class="fas fa-trash-alt @if($stages->color) text-white @else text-danger @endif float-right mr-2"></i>
                        </a>

                        <a wire:click="edit_stage({{$getStageCode}})" data-toggle="modal" data-target="#stageModal" href="#">
                           <i class="fas fa-edit @if($stages->color) text-white @else text-info @endif float-right mr-2"></i>
                        </a>

                        <a wire:click="add_deal({{$getStageCode}})" data-toggle="modal" data-target="#dealModal" href="#">
                           <i class="fas fa-plus-circle @if($stages->color) text-white @endif float-right mr-2"></i>
                        </a>
                     </span>
                  </div>
                  <ul class="sortable ui-sortable" id="sort{!! $stages->id !!}" data-stage-code="{!! $stages->stage_code !!}">
                     @foreach(Crm::stage_deals($stages->stage_code) as $stageDeals)
                        @php
                           $getDealCode = json_encode($stageDeals->deal_code);
                        @endphp
                        <li class="text-row ui-sortable-handle" data-deal-code="{!! $stageDeals->deal_code !!}" style="border-top: 5px solid {!!$stages->color!!};">
                           <h5>
                              <a href="{!! route('crm.deals.show',$stageDeals->deal_code) !!}" class="text-dark">{!! $stageDeals->title !!}</a>
                           </h5>
                           <p class="font-small">
                              @if($stageDeals->status)
                                 <i class="fal fa-heartbeat"></i> Status :
                                 <span class="badge {!! Wingu::status($stageDeals->status)->name !!}">{!! Wingu::status($stageDeals->status)->name !!}</span><br>
                              @endif
                              @if($stageDeals->close_date)
                                 <b><i class="fal fa-calendar-day"></i> Close Date :</b>  <span class="text-success"><b>{!! date('d F Y', strtotime($stageDeals->close_date)) !!}</b></span>
                              @endif
                              @if($stageDeals->value)
                                 <br><b><i class="far fa-funnel-dollar"></i> Value :</b>  {!! $business->currency !!} {!! number_format($stageDeals->value) !!}
                              @endif
                              @if($stageDeals->owner)
                                 <br><b><i class="far fa-user-headset"></i> Owner :</b>   {!! Wingu::user($stageDeals->owner)->name !!}
                              @endif
                              @if($stageDeals->contact)
                                 @if(Finance::check_client($stageDeals->contact) == 1)
                                    <br><b><i class="far fa-user-crown"></i> Customer :</b> {!! Finance::client($stageDeals->contact)->customer_name !!}
                                 @endif
                              @endif
                           </p>
                           <a href="{!! route('crm.deals.show',$stageDeals->deal_code) !!}" class="btn btn-xs btn-warning text-white"><i class="fal fa-eye"></i> View</a>
                           <a data-toggle="modal" data-target="#dealModal" wire:click="edit_deal({{$getDealCode}})" class="btn btn-xs btn-primary text-white"><i class="fal fa-edit"></i> Edit</a>
                           <a wire:click="delete_alert({{$getDealCode}},'deal')" data-toggle="modal" data-target="#delete" class="btn btn-xs btn-danger text-white"><i class="fal fa-trash"></i> Delete</a>
                        </li>
                     @endforeach
                  </ul>
                  <a wire:click="add_deal({{$getStageCode}})" data-toggle="modal" data-target="#dealModal" href="#" class="badge badge-info ml-2 mt-2 mb-2"><i class="fas fa-plus-circle"></i> Add Deal</a>
               </div>
            @endforeach
         </div>
      </div>
   </div>

   <!-- Deal -->
   <div wire:ignore.self class="modal fade" id="dealModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">
                  @if($this->dealEdit == 'on')
                     Edit Deal
                  @else
                     Add Deal
                  @endif
               </h5>
               <button type="button" class="close" wire:click="close()" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            @if($this->dealEdit == 'on')
               <form wire:submit.prevent="update_deal()">
            @else
               <form wire:submit.prevent="store_deal()">
            @endif
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Deal Title</label>
                           <input type="text" class="form-control" wire:model="title" required>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Deal Value</label>
                           <input type="number" class="form-control" wire:model="value">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Expected close date</label>
                           <input type="date" class="form-control" wire:model="close_date">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Sales Owner</label>
                           <select wire:model="owner" class="form-control select2">
                              <option value="">Choose owner</option>
                              @foreach($users as $user)
                                 <option value="{!! $user->user_code !!}">{!! $user->name !!}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Related Customer</label>
                           <select wire:model="contact" class="form-control select2">
                              <option value="">Choose customer</option>
                              @foreach($customers as $customer)
                                 <option value="{!! $customer->customer_code !!}">{!! $customer->customer_name !!}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Status</label>
                           <select wire:model="status" class="form-control select2">
                              <option value="">Choose status</option>
                              <option value="45">Won</option>
                              <option value="46">Lost</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Details</label>
                           <textarea type="text" class="form-control" wire:model="description" rows="5"></textarea>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button class="btn btn-secondary" wire:click="close()">Close</button>
                  @if($this->dealEdit == 'on')
                     <button class="btn btn-primary"><i class="fas fa-save"></i> Update Deal</button>
                  @else
                     <button class="btn btn-primary"><i class="fas fa-save"></i> Save Deal</button>
                  @endif
               </div>
            </form>
         </div>
      </div>
   </div>

   <!-- stage -->
   <div wire:ignore.self class="modal fade" id="stageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">
                  @if($this->stageModal == 'add')
                     Add Stage
                  @else
                     Edit Stage
                  @endif
               </h5>
               <button type="button" class="close" wire:click="close()" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            @if($this->stageModal == 'add')
               <form wire:submit.prevent="store_stage()">
            @else
               <form wire:submit.prevent="update_stage()">
            @endif
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Stage Title</label>
                           <input type="text" class="form-control" wire:model="stage_title" required>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Label</label>
                           <select wire:model="color" class="form-control">
                              <option value="">Choose Label</option>
                              <option value="#468847">Green</option>
                              <option value="#348fe2">Blue</option>
                              <option value="#ebeb35">Yellow</option>
                              <option value="#000000">Black</option>
                              <option value="#8753de">Purple</option>
                              <option value="#FF0000">Red</option>
                              <option value="#00FFFF">Cyan / Aqua</option>
                              <option value="#FF00FF">Magenta / Fuchsia	</option>
                              <option value="#C0C0C0">Silver</option>
                              <option value="#808080">Gray</option>
                              <option value="#800000">Maroon</option>
                              <option value="#808000">Olive</option>
                              <option value="#008080">Teal</option>
                              <option value="#f59c1a">Orange</option>
                              <option value="#000080">Navy</option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button class="btn btn-secondary" wire:click="close()">Close</button>
                  <button class="btn btn-primary"><i class="fas fa-save"></i> Save Information</button>
               </div>
            </form>
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
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close()">Cancel</button>

               @if($this->deleteType == 'deal')
                  <button type="button" class="btn btn-danger" wire:click="delete_deal({{json_encode($this->deleteCode)}})">Delete</button>
               @endif
               @if($this->deleteType == 'stage')
                  <button type="button" class="btn btn-danger" wire:click="delete_stage({{json_encode($this->deleteCode)}})">Delete</button>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
