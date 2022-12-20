@extends('layouts.app')
{{-- page header --}}
@section('title','Mail Invoice')
{{-- page styles --}}
@section('stylesheet')
@endsection
{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('finance.invoice.show',$details->invoiceCode) !!}" class="btn btn-pink"><i class="fas fa-chevron-left"></i> Back to view</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Mail Invoice To {!! $client->customer_name !!}</h1>
		@include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <form class="" action="{!! route('finance.invoice.send.mail') !!}" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="invoiceCode" value="{!! $details->invoiceCode !!}" required>
                     @csrf
                     <div class="form-group col-md-12">
   							<label for="">Form</label>
   							<input type="email" name="email_from" value="{!! $details->email !!}" class="form-control">
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Send To</label>
                        <input type="text" name="send_to" value="{!! $client->email !!}" class="form-control" required readonly>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Cc</label>
                        <select name="email_cc[]" id="" class="form-control select2" style="width:100%" multiple>
                           @if($client->email_cc != "")
   								   <option value="{!! $client->email_cc !!}">{!! $client->email_cc !!}</option>
                           @endif
   								@foreach ($contacts as $contact)
                           <option value="{!! $contact->contact_email !!}">{!! $contact->contact_email !!}</option>
   								@endforeach
   							</select>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Subject</label>
   							<input type="text" name="subject" value="Invoice - {!! $details->invoice_prefix !!}{!! $details->invoice_number !!} from {!! $details->businessName !!}" class="form-control" required>
   						</div>
   						<div class="form-group col-md-12">
   							<textarea name="message" cols="30" rows="10" class="tinymcy">
   								<span style="font-size: 12pt;">Dear {!! $client->customer_name !!}</span><br/><br/>
                           <span style="font-size: 12pt;">
                              We have prepared the following invoice for you: <strong># {!! $details->prefix !!}{!! $details->invoice_number !!}</strong>
                           </span>
                           <br /><br />
                           <span style="font-size: 12pt;">
                              <strong>Invoice status</strong>:<i>{!! ucfirst($details->status_name) !!}</i>
                           </span><br />
                           <span style="font-size: 12pt;">Please contact us for more information.</span><br /><br />
                           <span style="font-size: 12pt;">Kind Regards,</span><br />
                           <span style="font-size: 12pt;">{!! $details->businessName !!}</span>
   							</textarea>
   						</div>
   						<div class="form-group mt-3">
                        <input type="checkbox" value="Yes" name="attaches" id="attach" class="ml-2" checked>
                        <label for="">Attach Invoice</label><br>
                        <a href="{!! asset('businesses/'.$details->business_code.'/finance/invoices/'.$details->prefix.$details->invoice_number.'.pdf') !!}" target="_blank" class="ml-3" id="preview"> Preview current Attached Invoice</a>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Attach Files</label>
   							<select name="attach_files[]" class="form-control select2" style="width:100%" multiple>
   								@foreach ($files as $file)
   									<option value="{!! $file->id !!}">{!! $file->file_name !!}</option>
   								@endforeach
   							</select>
   						</div>
                     <div class="form-group mt-5">
                        <button type="submit" name="button" class="offset-md-10 btn btn-pink submit"><i class="fas fa-paper-plane"></i> Send Invoice</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      $('#attach').click(function(){
         this.checked?$('#preview').show(1000):$('#preview').hide(1000); //time for show
      });
   </script>
@endsection
