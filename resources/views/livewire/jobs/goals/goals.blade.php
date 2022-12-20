<div>
   <div class="row">
      <div class="col-md-12 mb-3">
         <div class="row">
            <div class="col-md-10">
               <h4 class="font-weight-bold">
                  <i class="far fa-bullseye-arrow"></i>
                  <a href="{!! route('job.dashboard',$this->jobCode) !!}">{!! $job->job_title !!}</a> | Goals
               </h4>
            </div>
            <div class="col-md-2">
               <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#goalModal">
                  <i class="fas fa-plus-circle"></i> Add Goal
               </button>
            </div>
         </div>
      </div>
      <div class="col-md-12 mt-3">
         <div class="card">
            <div class="card-body">
               <div class="row mb-3">
                  <div class="col-md-6">
                     <label for="">Search</label>
                     <input type="text" wire:model="search" class="form-control" placeholder="Enter goal name">
                  </div>
               </div>
               <table class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th>Goal</th>
                        <th>Progress</th>
                        {{-- <th>Staff</th> --}}
                        <th>Achievement</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Goal Type</th>
                        <th>Status</th>
                        <th width="12%">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($goals as $count=>$goal)
                        @if($goal->business_code == Auth::user()->business_code)
                           <tr>
                              <td>{!! $count+1 !!}</td>
                              <td>{!! $goal->title !!}</td>
                              <td>
                                 @if($goal->goal_type == 'Custom')
                                    @php
                                       $progress = Job::calculate_goal_progress($goal->goal_code,$goal->achievement)->getData();
                                    @endphp
                                    <b>Achievement : </b> {!! $progress->total_achievement !!}</br>
                                    @if($progress->total_achievement >= $goal->achievement)
                                       <div class="progress h-10px rounded-pill mb-5px">
                                          <div class="progress-bar progress-bar-striped progress-bar-animated bg-green fs-10px fw-bold" style="width: 100%;">100%</div>
                                       </div>
                                    @else
                                       <div class="progress h-10px rounded-pill mb-5px">
                                          <div class="progress-bar progress-bar-striped progress-bar-animated bg-orange fs-10px fw-bold" style="width: {!! $progress->percentage !!}%;">{!! $progress->percentage !!}%</div>
                                       </div>
                                    @endif
                                 @endif
                              </td>
                              <td>{!! number_format($goal->achievement) !!}</td>
                              <td>{!! date('F jS, Y', strtotime($goal->start_date)) !!}</td>
                              <td>{!! date('F jS, Y', strtotime($goal->end_date)) !!}</td>
                              <td>{!! $goal->goal_type !!}</td>
                              <td>
                                 @if($goal->goal_type == 'Custom')
                                    @if($progress->total_achievement >= $goal->achievement)
                                       <a href="" class="badge badge-success">Complete</a>
                                    @else
                                       <a href="" class="badge badge-warning">In-progress</a>
                                    @endif
                                 @endif
                              </td>
                              <td>
                                 @php
                                    $getCode = json_encode($goal->goal_code);
                                 @endphp
                                 <a href="#" wire:click="goal_details({{$getCode}})" data-toggle="modal" data-target="#goalDetails" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                                 <a href="#" wire:click="edit_goal({{$getCode}})" data-toggle="modal" data-target="#goalModal" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                 <a href="#" wire:click="delete({{$getCode}},'goal')" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                              </td>
                           </tr>
                        @endif
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>

   <!-- Goal -->
   <div  wire:ignore.self class="modal fade" id="goalModal" tabindex="-1" role="dialog" aria-labelledby="addGoalTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               @if($editMode == 'on')
                  <h5 class="modal-title" id="exampleModalLongTitle">Edit Goal</h5>
               @else
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Goal</h5>
               @endif
               <button type="button" class="close" wire:click="close()">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 mb-1">
                     <label for="">Goal Title</label>
                     <input type="text" wire:model="title" class="form-control">
                     @error('title')<span class="error text-danger">{{$message}}</span>@enderror
                  </div>
                  <div class="col-md-6 mb-1">
                     <label for="">Goal Type</label>
                     <select type="text" wire:model="type" class="form-control">
                        <option value="">Choose type</option>
                        <option value="Custom">Custom Goal</option>
                     </select>
                     @error('type')<span class="error text-danger">{{$message}}</span>@enderror
                  </div>
                  <div class="col-md-6 mb-1">
                     <label for="">Achievement</label>
                     <input type="number" wire:model="achievement" class="form-control">
                     @error('achievement')<span class="error text-danger">{{$message}}</span>@enderror
                  </div>
                  <div class="col-md-6 mb-1">
                     <label for="">Start date</label>
                     <input type="date" wire:model="start_date" class="form-control">
                     @error('start_date')<span class="error text-danger">{{$message}}</span>@enderror
                  </div>
                  <div class="col-md-6 mb-1">
                     <label for="">End date</label>
                     <input type="date" wire:model="end_date" class="form-control">
                     @error('end_date')<span class="error text-danger">{{$message}}</span>@enderror
                  </div>
                  <div class="col-md-12 mb-1">
                     <label for="">Description</label>
                     <textarea type="text" wire:model="description" class="form-control" rows="10"></textarea>
                     @error('description')<span class="error text-danger">{{$message}}</span>@enderror
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" wire:click="close()">Close</button>
               @if($editMode == 'on')
                  <button type="button" class="btn btn-primary" wire:click.prevent="update_goal()"><i class="fas fa-save"></i> Edit Information</button>
               @else
                  <button type="button" class="btn btn-success" wire:click.prevent="store_goal()"><i class="fas fa-save"></i> Submit Information</button>
               @endif
            </div>
         </div>
      </div>
   </div>

   <!-- Goal details -->
   <div  wire:ignore.self class="modal right fade" id="goalDetails" tabindex="-1" role="dialog" aria-labelledby="right_modal_xl">
      <div class="modal-dialog modal-xl" role="document">
         <div class="modal-content">
            @if($goalDetails)
               <div class="modal-header">
                  <h3 class="modal-title font-weight-bold">{!! $goalDetails->title !!}</h3>
                  <button type="button" class="close" wire:click="close()" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6">
                        <h4>Progress Records <a href="" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#progressModal"><i class="fas fa-plus-circle"></i> Add Progress</a></h4>
                        <hr>
                        <table class="table table-bordered table-striped">
                           <thead>
                              <th width="1%">#</th>
                              <th>Details</th>
                              <th width="1%"></th>
                           </thead>
                           <tbody>
                              @foreach($progresses as $count=>$progress)
                                 <tr>
                                    <td>{!! $count + 1 !!}</td>
                                    <td>
                                       <h4><b>Achievement</b> {!! $progress->achievement !!}</h4>
                                       <p>{!! date('F jS, Y', strtotime($progress->from_date)) !!} - {!! date('F jS, Y', strtotime($progress->to_date)) !!}</p>
                                       <hr>
                                       <p>{!! $progress->note !!}</p>
                                    </td>
                                    @php
                                       $getProgressCode = json_encode($progress->progress_code);
                                    @endphp
                                    <td><a href="" wire:click="delete({{$getProgressCode}},'progress')" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                     <div class="col-md-6">
                        @php
                           $detailProgress = Job::calculate_goal_progress($goalDetails->goal_code,$goalDetails->achievement)->getData();
                        @endphp
                        <h5>Details</h5>
                        <p>
                           <b>Start Date  :</b> {!! date('F jS, Y', strtotime($goalDetails->start_date)) !!}</br>
                           <b>End Date    :</b> {!! date('F jS, Y', strtotime($goalDetails->end_date)) !!}<br>
                           <b>Achievement Goal:</b> {!! $goalDetails->achievement !!}<br>
                           <b>Progress :</b> {!! $detailProgress->total_achievement !!}
                        </p>
                        <hr>
                        <p>{!! $goalDetails->description !!}</p>
                        <hr>
                        <h5>Progress</h5>
                        @if($detailProgress->total_achievement >= $goalDetails->achievement)
                           <div class="progress h-10px rounded-pill mb-5px">
                              <div class="progress-bar progress-bar-striped progress-bar-animated bg-green fs-10px fw-bold" style="width: 100%;">100%</div>
                           </div>
                        @else
                           <div class="progress h-10px rounded-pill mb-5px">
                              <div class="progress-bar progress-bar-striped progress-bar-animated bg-orange fs-10px fw-bold" style="width: {!! $detailProgress->percentage !!}%;">{!! $detailProgress->percentage !!}%</div>
                           </div>
                        @endif
                     </div>
                  </div>
               </div>
               <div class="modal-footer modal-footer-fixed">
                  <button type="button" class="btn btn-danger" wire:click="close()" data-dismiss="modal">Close</button>
               </div>
            @endif
         </div>
      </div>
   </div>

   <!-- progress -->
   <div  wire:ignore.self class="modal fade" id="progressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Add Progress</h5>
               <button type="button" class="close" wire:click="close_progress()">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 mb-2">
                     <label for="">Achievement</label>
                     <input type="number" class="form-control" wire:model="progress_achievement">
                  </div>
                  <div class="col-md-12 mb-2">
                     <label for="">From</label>
                     <input type="date" class="form-control" wire:model="progress_from">
                  </div>
                  <div class="col-md-12 mb-2">
                     <label for="">To</label>
                     <input type="date" class="form-control" wire:model="progress_to">
                  </div>
                  <div class="col-md-12 mb-2">
                     <label for="">Achievement</label>
                     <textarea type="number" class="form-control" wire:model="progress_note" rows="10"></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger btn-sm" wire:click="close_progress()">Close</button>
               <button type="button" class="btn btn-success btn-sm" wire:click.prevent="add_progress()"><i class="fas fa-save"></i> Save Information</button>
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
               <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close()">Cancel</button>
               @if($deleteType == 'goal')
                  <button type="button" class="btn btn-danger" wire:click="delete_goal()">Delete</button>
               @endif
               @if($deleteType == 'progress')
                  <button type="button" class="btn btn-danger" wire:click="delete_progress()">Delete</button>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
