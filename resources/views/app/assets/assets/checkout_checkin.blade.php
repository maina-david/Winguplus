<div class="row">
   <div class="col-md-12">
      @if($details->current_status == 38)
         <a data-toggle="modal" data-target=".checkin" class="btn btn-success text-white pull-right"><i class="fal fa-sign-in-alt"></i> Record Check In</a>
      @else
         <a data-toggle="modal" data-target=".checkout" class="btn btn-primary text-white pull-right"><i class="fal fa-sign-out-alt"></i> Record Check out</a>
      @endif
   </div>
   <div class="col-md-12 mt-2">
      <table class="table table-bordered">
         @foreach ($events as $event)
            <tr>
               <td>
                  <small class="text-primary">{!! $event->name !!} Date</small>
                  <p><b>{!! date('F jS, Y', strtotime($event->action_date)) !!}</b></p>
               </td>
               <td>
                  <span class="btn {!! Helper::seoUrl($event->name) !!} btn-block">{!! $event->name !!}</span>
               </td>
               <td>
                  @if($event->status == 38)
                     @if($event->check_out_to == 'Location')
                        <small class="text-primary">Assigned to location</small>
                     @else
                        <small class="text-primary">Assigned to</small>
                     @endif
                  @endif
                  @if($event->status == 43)
                     <small class="text-primary">Checked in by</small>
                     <p>
                        <b>{!! Wingu::user($event->created_by)->name !!}</b>
                     </p>
                     <small class="text-primary">Checked in at</small>
                     <p>
                        <i class="fal fa-map-marked"></i> <b>{!! $event->site_location !!}</b>
                     </p>
                  @endif
                  @if($event->check_out_to == 'Person')
                     <p>
                        @if($event->employee)
                           <b>{!! Hr::employee($event->employee)->names !!}</b>
                        @endif
                     </p>
                  @endif
                  @if($event->check_out_to == 'Location')
                     <p>
                        @if($event->check_out_to)
                           <b>{!! $event->site_location !!}</b>
                        @endif
                     </p>
                  @endif
               </td>
               <td>
                  @if($event->status != 43)
                     <small class="text-primary">Due date</small>
                     <p>
                        @if($event->due_action_date == "")
                           <b>No due date</b>
                        @else
                           <b>{!! date('F jS, Y', strtotime($event->due_action_date)) !!}</b>
                        @endif
                     </p>
                  @endif
                  @if($event->status == 43)
                     <small class="text-primary">Check in date</small>
                     <p><b>{!! date('F jS, Y', strtotime($event->action_date)) !!}</b></p>
                  @endif
               </td>
               <td width="20%">
                  <small class="text-primary">Note</small><br>
                  {!! substr($event->note, 0,180) !!} {!! strlen($event->note) > 180 ? "..." : "" !!}
               </td>
               <td width="12%">
                  @if($event->status == 38)
                     <a href="javascript;" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".checkout{!! $event->code !!}">Edit</a>
                  @endif
                  @if($event->status == 39)
                     <a href="javascript;" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".lease{!! $event->code !!}">Edit</a>
                  @endif
                  @if($event->status == 43)
                     <a href="javascript;" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".checkin{!! $event->code !!}">Edit</a>
                  @endif
                  <a href="{!! route('assets.checkout.checkin.delete',[$code,$event->code]) !!}" class="btn btn-sm btn-danger delete">Delete</a>
               </td>
            </tr>

            {{-- check out --}}
            <div class="modal fade checkout{!! $event->code !!}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     {!! Form::model($event, ['route' => ['assets.event.checkout.update',$event->code], 'method'=>'post','id'=>'checkoutForm', 'autocomplete' => 'off']) !!}
                        @csrf
                        <div class="modal-header">
                           <h3 class="modal-title" id="exampleModalLabel">Update Check out</h3>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Check-out Date</label>
                                    {!! Form::text('action_date',null,['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'choose date']) !!}
                                    <input type="hidden" name="status" value="38">
                                    <input type="hidden" name="assetID" value="{!! $code !!}">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Due Date</label>
                                    {!! Form::text('due_action_date',null,['class' => 'form-control datepicker', 'placeholder' => 'choose date']) !!}
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Check-out to</label>
                                    {!! Form::select('check_out_to',['' => 'Choose','Person' => 'Person','Branch' => 'Branch','Location' => 'Site / Location'],null,['class' => 'form-control select2', 'required' => '', 'id'=>'checkouttoedit']) !!}
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Branch</label>
                                    {!! Form::select('branch',$branches,null,['class' => 'form-control select2']) !!}
                                 </div>
                              </div>
                              @livewire('assets.assets.employees')
                              @livewire('assets.assets.departments')
                              @if($event->check_out_to == 'Location')
                                 <div class="col-md-12">
                                    <div class="form-group form-group-default required">
                                       <label for="">Site / Location </label>
                                       {!! Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']) !!}
                                    </div>
                                 </div>
                              @else
                                 <div class="col-md-12" style="display:none" id="checkoutLocationEdit">
                                    <div class="form-group form-group-default required">
                                       <label for="">Site / Location </label>
                                       {!! Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']) !!}
                                    </div>
                                 </div>
                              @endif
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="">Note </label>
                                    {!! Form::textarea('note',null,['class' => 'form-control tinymcy']) !!}
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <center>
                              <button type="submit" class="btn btn-pink submitCheckoutForm">Update information</button>
                              <img src="{!! asset('/assets/img/btn-loader.gif') !!}" class="checkout-load none" width="15%">
                           </center>
                        </div>
                     {!! Form::close() !!}
                  </div>
               </div>
            </div>

            {{-- Lease --}}
            {{-- <div class="modal fade lease{!! $event->code !!}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     {!! Form::model($event, ['route' => ['assets.event.lease.update',$event->code], 'method'=>'post','id'=>'leaseForm', 'autocomplete' => 'off']) !!}
                        @csrf
                        <div class="modal-header">
                           <h3 class="modal-title" id="exampleModalLabel">Lease</h3>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="" class="text-danger">Lease Begins</label>
                                    {!! Form::date('action_date',null,['class' => 'form-control', 'required' => '']) !!}
                                    <input type="hidden" name="status" value="39">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="" class="text-danger">Lease Expires</label>
                                    {!! Form::date('due_action_date',null,['class' => 'form-control', 'required' => '']) !!}
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="" class="text-danger">Leasing Customer </label>
                                    {!! Form::select('allocated_to',$customers,null,['class' => 'form-control', 'required' => '']) !!}
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Send Email</label>
                                    {!! Form::select('send_email',['No' => 'No','Yes' => 'Yes'],null,['class' => 'form-control','id'=>'lease_email']) !!}
                                 </div>
                              </div>
                              <div class="col-md-6" id="leaseEmail" style="display: none">
                                 <div class="form-group form-group-default required">
                                    <label for="">Email</label>
                                    {!! Form::email('email',null,['class' => 'form-control', 'placeholder' => 'Enter email']) !!}
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="">Note </label>
                                    {!! Form::textarea('note',null,['class' => 'form-control ckeditor']) !!}
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <center>
                              <button type="submit" class="btn btn-pink submitLeaseForm">Update Lease</button>
                              <img src="{!! url('/') !!}/public/backend/img/btn-loader.gif" class="lease-load none" width="15%">
                           </center>
                        </div>
                     {!! Form::close() !!}
                  </div>
               </div>
            </div> --}}

            {{-- checkin --}}
            <div class="modal fade checkin{!! $event->code !!}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     {!! Form::model($event, ['route' => ['assets.event.checkin.update',$event->code], 'method'=>'post','id'=>'leaseForm', 'autocomplete' => 'off']) !!}
                        @csrf
                        <div class="modal-header">
                           <h3 class="modal-title" id="exampleModalLabel"><i class="fal fa-sign-in-alt"></i> Update Check in</h3>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Return Date </label>
                                    {!! Form::date('action_date',null,['class' => 'form-control', 'required' => '']) !!}
                                    <input type="hidden" name="status" value="43">
                                    <input type="hidden" name="asset_code" value="{!! $code !!}" required>
                                 </div>
                              </div>
                              <div class="col-md-6" id="checkoutLocation">
                                 <div class="form-group form-group-default required">
                                    <label for="">Site / Location </label>
                                    {!! Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']) !!}
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="">Note </label>
                                    {!! Form::textarea('note',null,['class' => 'form-control tinymcy']) !!}
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <center>
                              <button type="submit" class="btn btn-pink submitCheckinForm">Update Information</button>
                              <img src="{!! url('/') !!}/public/backend/img/btn-loader.gif" class="checkin-load none" width="15%">
                           </center>
                        </div>
                     {!! Form::close() !!}
                  </div>
               </div>
            </div>
         @endforeach
      </table>
   </div>
</div>
