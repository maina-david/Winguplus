@extends('layouts.app')
{{-- page header --}}
@section('title')
	@if($client->contact_type == 'Individual') 
		{!! $client->salutation !!} {!! $client->customer_name !!}
	@else 
		{!! $client->customer_name !!}
	@endif
@endsection

@section('stylesheet')
   <!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
   <link href="{!! asset('assets/plugins/jquery-jvectormap/jquery-jvectormap.css') !!}" rel="stylesheet" />
   <link href="{!! asset('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css') !!}" rel="stylesheet" />
   <link href="{!! asset('assets/plugins/gritter/css/jquery.gritter.css') !!}" rel="stylesheet" />
   <link href="{!! asset('assets/plugins/nvd3/build/nv.d3.css') !!}" rel="stylesheet" />
@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.subscriptions.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<div class="row">
			<div class="col-md-3">
				<div class="card-box text-center">
               @if($client->image == "")
                  <img alt="{!! $client->names !!}" src="{!! "https://www.gravatar.com/avatar/". md5(strtolower(trim($client->email))) . "?s=200&d=wavatar" !!}" class="img-circle" width="80" height="80">
               @else
                  <img width="150" height="150" alt="" class="img-circle" src="{!! asset('businesses/'.$client->businessID.'/clients/'.$client->customer_code.'/images'.$client->image) !!}">
               @endif
					<h4 class="mb-1 mt-2">
						@if($client->contact_type == 'Individual') 
							{!! $client->salutation !!} {!! $client->customer_name !!}
						@else 
							{!! $client->customer_name !!}
						@endif
					</h4>
					<p class="text-muted"><i class="fas fa-at"></i> {!! $client->email !!}<br><i class="fas fa-phone"></i> {!! $client->primary_phone_number !!}</p>
					<a href="{{ route('finance.contact.edit', $client->cid) }}" class="btn btn-success btn-xs waves-effect mb-2 waves-light"><i class="fas fa-user-edit"></i> Edit</a>
					<a href="#" class="btn btn-primary btn-xs waves-effect mb-2 waves-light"><i class="fas fa-envelope-open-text"></i> Send Email</a>
					<a href="{!! route('finance.contact.delete', $client->cid) !!}" class="btn btn-danger btn-xs waves-effect mb-2 waves-light delete"><i class="fas fa-trash"></i> Delete</a>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fas fa-file-invoice-dollar"></i> Billing Address</h4>
					</div>
					<div class="panel-body">
						<p><b>Billing Information</b></p>
						<p>{!! $client->bill_attention !!}<br>
							@if($client->bill_country != "")
							{!! Limitless::country($client->bill_country)->name !!}<br>
							@endif
							{!! $client->bill_city !!}<br>
							{!! $client->bill_street !!}<br>
							{!! $client->bill_state !!}<br>
							{!! $client->bill_address !!} <br>
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
						<h4 class="panel-title"><i class="fas fa-truck"></i> Shipping Address</h4>
					</div>
					<div class="panel-body">
						<p><b>Shipping Information</b></p>
						<p>{!! $client->ship_attention !!}<br>
							@if($client->ship_country != "")
							{!! Limitless::country($client->ship_country)->name !!}<br>
							@endif
							{!! $client->ship_city !!}<br>
							{!! $client->ship_street !!}<br>
							{!! $client->ship_state !!}<br>
							{!! $client->ship_address !!} <br>
							{!! $client->ship_zip_code !!}<br>
							{!! $client->ship_fax !!}</br>
						</p>
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
						<p>Portal Language <span class="float-right text-primary">@if($client->language != "") {!! Limitless::Language($client->language)->name !!} @endif </span></p>
					</div>
				</div> --}}
			</div>
			<div class="col-md-9">
				<div class="row mb-3">
					<div class="col-md-6"></div>
					<div class="col-md-6">
                  <div class="float-right">
   						<a href="{{ route('finance.contact.edit', $client->cid) }}" class="btn btn-default"><i class="fas fa-user-edit"></i> Edit</a>
   						{{-- <a href="#" class="btn btn-default"><i class="fas fa-paperclip"></i> Attach Files</a> --}}
   						<div class="btn-group">
   							<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"> New Transaction </button>
   							<ul class="dropdown-menu pull-right">
   								<li><a href="{!! route('finance.invoice.product.create') !!}">Invoice</a></li>
   								<li><a href="{!! route('finance.payments.create') !!}">Customer Payment</a> </li>
   								<li><a href="{!! route('finance.estimate.create') !!}">Estimate</a> </li>
   								<li><a href="{!! route('finance.invoice.recurring.create') !!}">Recurring Invoice  </a> </li>
   								<li><a href="{!! route('finance.creditnote.create') !!}">Credit Note</a> </li>
   								<li><a href="{!! route('finance.estimate.create') !!}">Expense</a> </li>
   								{{-- <li><a href="">Recurring Expense</a> </li>
   								<li class="divider"></li>
   								<li> <a href="">Project</a> </li> --}}
   							</ul>
   						</div>
   						<div class="btn-group">
							<button data-toggle="dropdown" class="btn btn-default dropdown-toggle pull-right"> More </button>
							<ul class="dropdown-menu">
								{{-- <li><a href="#">Associate Templates</a></li> --}}
								{{-- <li><a href="">Stop all Reminders</a></li> --}}
								{{-- <li class="divider"></li>
								<li><a href="">Configure Client Portal</a></li>
								<li><a href="">Clone</a></li>
								<li><a href="">Merge Contacts</a></li>
								<li class="divider"></li>
								<li><a href="">Mark as Inactive</a></li> --}}
								<li><a href="{!! route('finance.contact.delete', $client->cid) !!}">Delete</a></li>
							</ul>
						</div>
                  </div>
					</div>
				</div>
				@include('app.partials._messages')
				<!-- begin nav -->
				@include('app.finance.contacts._nav')
				<!-- end nav -->

				<!-- main client page -->
				@if(Request::is('finance/customer/'.$customerID.'/show'))
					<div class="contact-dashboard">
						<div class="row">
							<!-- begin col-3 -->
							<div class="col-lg-6 col-md-6 contact-top-info">
								<h3>Outstanding Receivables</h3>
								<h4 class="text-danger">ksh 500.00</h4>
							</div>
							<div class="col-lg-6 col-md-6 contact-top-info-right">
								<h3 class="">Unused Credits</h3>
								<h4 class=""><b>ksh 30,000.00</b></h4>
							</div>
						</div>
						<hr>
						<div class="col-md-12">
							<div id="monthly-sale" class="height-sm"></div>
						</div>
					</div>
				@endif

				<!-- comments -->
				@if(Request::is('finance/customer/'.$customerID.'/comments'))
					@include('app.finance.contacts.comments')
				@endif

				<!-- invoice -->
				@if(Request::is('finance/customer/'.$customerID.'/invoices'))
					@include('app.finance.contacts.invoices')
				@endif

            <!-- estimates -->
				@if(Request::is('finance/customer/'.$customerID.'/estimates'))
					@include('app.finance.contacts.estimates')
				@endif

            <!-- creditnote -->
				@if(Request::is('finance/customer/'.$customerID.'/creditnotes'))
					@include('app.finance.contacts.creditnotes')
				@endif

            <!-- contacts -->
				@if(Request::is('finance/customer/'.$customerID.'/contacts'))
					@include('app.finance.contacts.contacts')
				@endif

			</div>
		</div>
	</div>
@endsection
@section('scripts')
   <!-- ================== BEGIN PAGE LEVEL JS ================== -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.2/d3.min.js"></script>
   <script src="{!! asset('assets/plugins/nvd3/build/nv.d3.js') !!}"></script>
   <script src="{!! asset('assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js') !!}"></script>
   <script src="{!! asset('assets/plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js') !!}"></script>
   <script src="{!! asset('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js') !!}"></script>
	<script src="{!! asset('assets/plugins/gritter/js/jquery.gritter.js') !!}"></script>
	<script src="{!! asset('assets/js/demo/dashboard-v2.min.js') !!}"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			DashboardV2.init();

			if (Cookies) {
    			if (!Cookies.get('theme-panel') && $(window).width() > 767) {
    				$('.theme-panel').addClass('active');
    			}
    		}
    		$('[data-click="theme-panel-expand"]').click(function() {
    			Cookies.set('theme-panel', 'active');
    		});
		});
	</script>
	<script type="text/javascript">
      var sales = <?php echo $sales ?>;
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
         var data = google.visualization.arrayToDataTable(sales);

         var options = {
            curveType: 'function',
            legend: { position: 'bottom' }
         };

         var chart = new google.visualization.BarChart(document.getElementById('monthly-sale'));

         chart.draw(data, options);
      }
   </script>
@endsection

