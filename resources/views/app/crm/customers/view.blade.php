@extends('layouts.app')
{{-- page header --}}
@section('title')
	Details |
	@if($client->contact_type == 'Individual')
		{!! $client->salutation !!} {!! $client->customer_name !!}
	@else
		{!! $client->customer_name !!}
	@endif
@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<div class="row">
			<div class="col-md-3">
				<div class="card-box text-center">
               @if($client->image != "")
						<img src="{!! asset('businesses/'.Wingu::business()->business_code.'/customer/'.$client->customer_code.'/images/'.$client->image) !!}" alt="" style="width:90px;height:90px" class="rounded-circle">
					@else
						<img src="https://ui-avatars.com/api/?name={!! $client->customer_name !!}&rounded=true&size=90" alt="">
					@endif
					<h4 class="mb-1 mt-2">
						@if($client->contact_type == 'Individual')
							{!! $client->salutation !!} {!! $client->customer_name !!}
						@else
							{!! $client->customer_name !!}
						@endif
					</h4>
					<p class="text-muted"><i class="fas fa-at"></i> {!! $client->email !!}<br><i class="fas fa-phone"></i> {!! $client->primary_phone_number !!}</p>
					<a href="{{ route('crm.customers.edit', $code) }}" class="btn btn-success btn-xs waves-effect mb-2 waves-light"><i class="fal fa-edit"></i> Edit</a>
					@if(Wingu::business()->plan != 1)
						<a href="{!! route('crm.customer.mail',$code) !!}" class="btn btn-primary btn-xs waves-effect mb-2 waves-light"><i class="fal fa-paper-plane"></i> Send Email</a>
					@endif
					<a href="{!! route('crm.customers.delete', $code) !!}" class="btn btn-danger btn-xs waves-effect mb-2 waves-light delete"><i class="fas fa-trash"></i> Delete</a>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fal fa-file-invoice-dollar"></i> Billing Information</h4>
					</div>
					<div class="panel-body">
						<p>{!! $client->bill_attention !!}<br>
							{!! $client->bill_country !!}<br>
							{!! $client->bill_city !!}<br>
							{!! $client->bill_street !!}<br>
							{!! $client->bill_state !!}<br>
							{!! $client->bill_address !!}<br>
							{!! $client->bill_zip_code !!}<br>
							{!! $client->bill_fax !!}</br>
						</p>
					</div>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fal fa-shipping-fast"></i> Shipping Information</h4>
					</div>
					<div class="panel-body">
						<p>{!! $client->ship_attention !!}<br>
							{!! $client->ship_country !!}
							{!! $client->ship_city !!}<br>
							{!! $client->ship_street !!}<br>
							{!! $client->ship_state !!}<br>
							{!! $client->ship_address !!} <br>
							{!! $client->ship_zip_code !!}<br>
							{!! $client->ship_fax !!}</br>
						</p>
					</div>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fal fa-users-medical"></i> Contact Persons</h4>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								@foreach ($contacts as $contact)
									<div class="row">
										<div class="col-md-3">
											<img src="https://ui-avatars.com/api/?name={!! $contact->names !!}&rounded=true&size=50" alt="">
										</div>
										<div class="col-md-9">
											<p>
												<b>Name :</b> <span class="text-pink">{!! $contact->names !!}</span><br>
												<b>Phone number :</b> <span class="text-pink">{!! $contact->phone_number !!}</span><br>
												<b>Email :</b> <span class="text-pink">{!! $contact->contact_email !!}</span><br>
												<b>Designation :</b> <span class="text-pink">{!! $contact->designation !!}</span><br>
											</p>
										</div>
										<div class="col-md-12">
											<hr>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				{{-- <div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fas fa-info-circle"></i> Other Information</h4>
					</div>
					<div class="panel-body">
						<p>Currency Code <span class="float-right text-primary"> @if($client->currency != "") {!! Finance::currency($client->currency)->currency_name !!} - {!! Finance::currency($client->currency)->symbol !!} @endif</span></p>
						<p>Portal Status <span class="float-right text-primary">@if($client->portal != "") Portal Set @else Not Set @endif</span></p>
						<p>Portal Language <span class="float-right text-primary">@if($client->language != "") {!! Wingu::Language($client->language)->name !!} @endif </span></p>
					</div>
				</div> --}}
			</div>
			<div class="col-md-9">
				<div class="row mb-3">
					<div class="col-md-12">
                  <div class="float-right">
							<a href="{{ route('crm.customers.edit', $code) }}" class="btn btn-white"><i class="fas fa-edit"></i> Edit</a>
								<a href="{{ route('crm.customer.send', $code) }}" class="btn btn-white"><i class="fal fa-paper-plane"></i> Send Mail</a>
   						<div class="btn-group">
   							<button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"> New Transaction </button>
   							<ul class="dropdown-menu pull-right">
   								<li><a href="{!! route('finance.invoice.product.create') !!}">Invoice</a></li>
   								<li><a href="{!! route('finance.payments.create') !!}">Payment</a> </li>
   								<li><a href="{!! route('finance.quotes.create') !!}">Quotes</a> </li>
   								<li><a href="{!! route('finance.creditnote.create') !!}">Credit Note</a> </li>
   								<li class="divider"></li>
   								<li> <a href="">Project</a> </li>
   							</ul>
   						</div>
   						<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-white dropdown-toggle pull-right"> More </button>
								<ul class="dropdown-menu">
                           {{-- <li><a href="{!! route('crm.customer.sms',$code) !!}"><i class="fal fa-sms"></i> SMS</a></li> --}}
                           {{-- <li><a href="{!! route('crm.customer.mail',$code) !!}"><i class="fal fa-paper-plane"></i> Mail</a></li> --}}
                           <li class="divider"></li>
									{{-- <li><a href="{!! route('crm.customer.notes',$code) !!}"><i class="fal fa-sticky-note"></i> Notes</a></li> --}}
									{{-- <li><a href="{!! route('crm.customer.events',$code) !!}"><i class="fal fa-calendar-alt"></i> Meeting</a></li> --}}
									{{-- <li><a href="{!! route('crm.customer.calllog',$code) !!}"><i class="fal fa-phone-office"></i> Call log</a></li> --}}
									<li class="divider"></li>
									<li><a href="{!! route('crm.customers.delete', $code) !!}"><i class="fas fa-trash"></i> Delete</a></li>
								</ul>
							</div>
							@if(Wingu::business()->plan != 1)
								<a href="{!! route('crm.customer.documents',$code) !!}" class="btn btn-white"><i class="fal fa-folder"></i> Documents</a>
							@endif
                  </div>
					</div>
				</div>
				@include('partials._messages')
				<!-- begin nav -->
				@include('app.crm.customers._nav')
				<!-- end nav -->

				<!-- main client page -->
				@if(Request::is('crm/customer/'.$code.'/show'))
					@include('app.crm.customers.show')
				@endif

				<!-- comments -->
				@if(Request::is('crm/customer/'.$code.'/comments'))
					@include('app.crm.customers.comments')
				@endif

				<!-- invoice -->
				@if(Request::is('crm/customer/'.$code.'/invoices'))
					@include('app.crm.customers.invoices')
				@endif

            <!-- estimates -->
				@if(Request::is('crm/customer/'.$code.'/quotes'))
					@include('app.crm.customers.quotes')
				@endif

            <!-- creditnote -->
				@if(Request::is('crm/customer/'.$code.'/creditnotes'))
					@include('app.crm.customers.creditnotes')
				@endif

				<!-- projects -->
				@if(Request::is('crm/customer/'.$code.'/projects'))
					@include('app.crm.customers.projects')
				@endif

				<!-- statement -->
				@if(Request::is('crm/customer/'.$code.'/statement'))
					@include('app.crm.customers.statement')
				@endif

				<!-- statement mail -->
				@if(Request::is('crm/customer/'.$code.'/statement/mail'))
					@include('app.crm.customers.statementMail')
				@endif

				<!-- subscription -->
				@if(Request::is('crm/customer/'.$code.'/subscriptions'))
					@include('app.crm.customers.subscriptions')
				@endif

            <!-- contacts -->
				@if(Request::is('crm/customer/'.$code.'/contacts'))
					@include('app.crm.customers.contacts')
				@endif

				<!-- mails -->
				@if(Request::is('crm/customer/'.$code.'/mail'))
					@include('app.crm.customers.mail.index')
				@endif

				<!-- send -->
				@if(Request::is('crm/customer/'.$code.'/send'))
					@include('app.crm.customers.mail.mail')
				@endif

				<!-- documents -->
				@if(Request::is('crm/customer/'.$code.'/documents'))
					@include('app.crm.customers.documents')
				@endif

				<!-- sms -->
				@if(Request::is('crm/customer/'.$code.'/sms'))
					@include('app.crm.customers.sms')
				@endif

				<!-- notes -->
				@if(Request::is('crm/customer/'.$code.'/notes'))
					@include('app.crm.customers.notes')
				@endif

				<!-- events -->
				@if(Request::is('crm/customer/'.$code.'/events'))
               @livewire('crm.leads.events.grid-view', ['leadCode' => $code])
				@endif

            @if(Request::is('crm/customer/'.$code.'/events/list'))
               @livewire('crm.leads.events.list-view', ['leadCode' => $code])
            @endif

				<!-- events -->
				@if(Request::is('crm/customer/'.$code.'/calllogs'))
					@include('app.crm.customers.calllogs')
				@endif
			</div>
		</div>
	</div>
@endsection
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#eventCreate').modal('hide');
      });
   </script>
   <script type="text/javascript">
      window.livewire.on('editModal', () => {
         $('#eventEdit').modal('hide');
      });
   </script>
   <script type="text/javascript">
      window.livewire.on('detailsModal', () => {
         $('#detail').modal('hide');
      });
   </script>
   <script type="text/javascript">
      window.livewire.on('deleteModal', () => {
         $('#delete').modal('hide');
      });
   </script>
@endsection

