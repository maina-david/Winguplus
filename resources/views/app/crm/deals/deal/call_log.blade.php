<div class="row">
   <div class="col-md-12 mb-3">
      <a href="javascript;" data-toggle="modal" data-target="#call-log" class="btn btn-pink btn-sm float-right"><i class="fas fa-phone-plus"></i> Add call log</a>
   </div>
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <ul class="media-list media-list-with-divider">
               @foreach ($callLogs as $call)
                  <li class="media media-sm">
                     <a class="media-left" href="javascript:;">
                        @php
                           $user = Wingu::user($call->created_by);
                        @endphp
                        @if($user->avatar)
                           <img src="{!! asset('businesses/'.$user->business_code.'/images/'.$user->avatar) !!}" alt="">
                        @else
                           <img src="https://ui-avatars.com/api/?name={!! $user->name  !!}&rounded=true&size=32" alt="">
                        @endif
                     </a>
                     <div class="media-body">
                        <h5 class="media-heading">{!! $call->subject !!}</h5>
                        <p>
                           <b>Contact person :</b> <span class="text-primary">{!! $call->contact_person !!}</span> | <b>Phone Number :</b><span class="text-primary">{!! $call->phone_number !!}</span> | <b>Call Type :</b> <span class="text-primary">{!! $call->call_type !!}</span> | <b>Duration :</b> <span class="text-primary">{!! $call->hours !!}</span> hours, <span class="text-primary">{!! $call->minutes !!}</span> minutes, <span class="text-primary">{!! $call->seconds !!}</span> seconds
                        </p>
                        {!! $call->note !!}
                        <p class="mt-2">
                           Call • <b>by</b> <a href="#">@if(Wingu::check_user($call->created_by) == 1){!! Wingu::user($call->created_by)->name  !!}@else Unknown User @endif</a> • <b>at</b> <a href="#">{!! date('F d, Y', strtotime($call->created_at)) !!} @ {!! date('g:i a', strtotime($call->created_at)) !!}</a>
                           <a href="{!! route('crm.deals.calllog.delete', $call->log_code) !!}" class="btn btn-sm btn-danger float-right delete"><i class="fas fa-trash"></i></a>
                           <a href="#" data-toggle="modal" data-target="#call-log-{!! $call->log_code !!}" class="btn btn-sm btn-default float-right mr-2"><i class="fas fa-edit"></i></a>
                        </p>
                     </div>
                  </li>
                  <hr>
                  <div class="modal fade" id="call-log-{!! $call->log_code !!}">
                     <div class="modal-dialog modal-lg">
                        {!! Form::model($call, ['route' => ['crm.deals.calllog.update', $call->log_code], 'method'=>'post']) !!}
                           @csrf
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h4 class="modal-title"> Update Call Log</h4>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group form-group-default required">
                                          {!! Form::label('Subject', 'Subject', array('class'=>'control-label')) !!}
                                          {!! Form::text('subject', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter call subject')) !!}
                                          <input type="hidden" name="deal_code" value="{!! $deal->deal_code !!}" required>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group form-group-default required">
                                          {!! Form::label('Phone number', 'Phone Number', array('class'=>'control-label')) !!}
                                          {!! Form::number('phone_number', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter phone number')) !!}
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default">
                                          {!! Form::label('Call Type', 'Call Type', array('class'=>'control-label')) !!}
                                          {!! Form::select('call_type', ['' => 'Choose call type','Inbound' => 'Inbound','Outbound' => 'Outbound'], null, array('class' => 'form-control', 'required' => '')) !!}
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default required">
                                          {!! Form::label('Contact Person', 'Contact Person', array('class'=>'control-label')) !!}
                                          {!! Form::text('contact_person', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter contact person')) !!}
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group form-group-default required">
                                          {!! Form::label('Hour', 'Hour', array('class'=>'control-label')) !!}
                                          {!! Form::number('hours', null, array('class' => 'form-control', 'min' => '0', 'max' => '24', 'required' => '','placeholder' => 'Enter Hours')) !!}
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group form-group-default required">
                                          {!! Form::label('Minutes', 'Minutes', array('class'=>'control-label')) !!}
                                          {!! Form::number('minutes', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '','placeholder' => 'Enter minutes')) !!}
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group form-group-default required">
                                          {!! Form::label('Seconds', 'Seconds', array('class'=>'control-label')) !!}
                                          {!! Form::number('seconds', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '','placeholder' => 'Enter seconds')) !!}
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                       <label for="">Note</label>
                                       {!! Form::textarea('note', null, array('class' => 'form-control tinymcy')) !!}
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="modal-footer">
                                 <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit</button>
                                 <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                              </div>
                           </div>
                        {!! Form::close() !!}
                     </div>
                  </div>
               @endforeach
            </ul>
         </div>
      </div>
   </div>
</div>
{{-- normal note --}}
<div class="modal fade" id="call-log">
   <div class="modal-dialog modal-lg">
      <form action="{!! route('crm.deals.calllog.store',$deal->deal_code) !!}" method="post">
         @csrf
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title"> New Call Log</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Subject', 'Subject', array('class'=>'control-label')) !!}
                        {!! Form::text('subject', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter call subject')) !!}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Phone number', 'Phone Number', array('class'=>'control-label')) !!}
                        {!! Form::number('phone_number', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter phone number')) !!}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        {!! Form::label('Call Type', 'Call Type', array('class'=>'control-label')) !!}
                        {!! Form::select('call_type', ['' => 'Choose call type','Inbound' => 'Inbound','Outbound' => 'Outbound'], null, array('class' => 'form-control', 'required' => '')) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Contact Person', 'Contact Person', array('class'=>'control-label')) !!}
                        {!! Form::text('contact_person', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter contact person')) !!}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Hour', 'Hour', array('class'=>'control-label')) !!}
                        {!! Form::number('hours', null, array('class' => 'form-control', 'min' => '0', 'max' => '24', 'required' => '','placeholder' => 'Enter Hours')) !!}
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Minutes', 'Minutes', array('class'=>'control-label')) !!}
      						{!! Form::number('minutes', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '','placeholder' => 'Enter minutes')) !!}
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Seconds', 'Seconds', array('class'=>'control-label')) !!}
      						{!! Form::number('seconds', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '','placeholder' => 'Enter seconds')) !!}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                       <label for="">Note</label>
                       {!! Form::textarea('note', null, array('class' => 'form-control tinymcy')) !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add call log</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
            </div>
         </div>
      </form>
   </div>
</div>
