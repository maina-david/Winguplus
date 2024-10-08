<div class="row">
   <div class="col-md-12">
      <div class="email-wrapper wrapper">
         <div class="row align-items-stretch"  style="height: 700px">
            @include('app.crm.leads.mail._sidebar')
            <div class="mail-view d-none d-md-block col-md-9 bg-white">
               <div class="row mt-3 ml-2 mr-2">
                  <form class="col-md-12" method="POST" action="{!! route('crm.leads.mail.store') !!}" enctype="multipart/form-data">
                     @csrf
                     <div class="form-group">
                        <label for="">Subject</label>
                        {!! Form::text('subject',null,['class'=>'form-control','placeholder'=>'Enter subject','required'=>'']) !!}
                        <input type="hidden" name="customer_code"value="{!! $code !!}" required>
                     </div>
                     <div class="form-group">
                        <label for="">Email
                           <span data-toggle="tooltip" data-placement="top" title="If you need to change the Email you can change it on the lead edit section.">
                              <i class="fas fa-info-circle"></i>
                           </span>
                        </label>
                        <input type="email" name="email" class="form-control" value="{!! $lead->email !!}" required readonly>
                     </div>
                     <div class="form-group">
                        <label for="">CC</label>
                        {!! Form::select('email_cc[]',[],null,['class'=>'form-control multiselect']) !!}
                     </div>
                     <div class="form-group">
                        <label for="">Attachment</label>
                        <select name="attach_files[]" class="form-control multiselect" style="width:100%" multiple>
   								@foreach ($files as $file)
   									<option value="{!! $file->id !!}">@if($file->name != ""){!! $file->name !!} -@endif {!! $file->file_name !!}</option>
   								@endforeach
   							</select>
                     </div>
                     <div class="form-group">
                        <label for="">Message</label>
                        {!! Form::textarea('message',null,['class'=>'form-control tinymcy','required'=>'']) !!}
                     </div>
                     <div class="form-group">
                        <button type="submit" class="pull-right btn btn-pink submit"><i class="fal fa-paper-plane"></i> Send email</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
