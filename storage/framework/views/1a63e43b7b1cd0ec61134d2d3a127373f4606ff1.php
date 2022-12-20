<?php $__env->startSection('title'); ?>
	<?php if($client->contact_type == 'Individual'): ?> 
		<?php echo $client->salutation; ?> <?php echo $client->customer_name; ?>

	<?php else: ?> 
		<?php echo $client->customer_name; ?>

	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('stylesheet'); ?>
   <!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
   <link href="<?php echo asset('assets/plugins/jquery-jvectormap/jquery-jvectormap.css'); ?>" rel="stylesheet" />
   <link href="<?php echo asset('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css'); ?>" rel="stylesheet" />
   <link href="<?php echo asset('assets/plugins/gritter/css/jquery.gritter.css'); ?>" rel="stylesheet" />
   <link href="<?php echo asset('assets/plugins/nvd3/build/nv.d3.css'); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.subscriptions.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<div class="row">
			<div class="col-md-3">
				<div class="card-box text-center">
               <?php if($client->image == ""): ?>
                  <img alt="<?php echo $client->names; ?>" src="<?php echo "https://www.gravatar.com/avatar/". md5(strtolower(trim($client->email))) . "?s=200&d=wavatar"; ?>" class="img-circle" width="80" height="80">
               <?php else: ?>
                  <img width="150" height="150" alt="" class="img-circle" src="<?php echo asset('businesses/'.$client->businessID.'/clients/'.$client->customer_code.'/images'.$client->image); ?>">
               <?php endif; ?>
					<h4 class="mb-1 mt-2">
						<?php if($client->contact_type == 'Individual'): ?> 
							<?php echo $client->salutation; ?> <?php echo $client->customer_name; ?>

						<?php else: ?> 
							<?php echo $client->customer_name; ?>

						<?php endif; ?>
					</h4>
					<p class="text-muted"><i class="fas fa-at"></i> <?php echo $client->email; ?><br><i class="fas fa-phone"></i> <?php echo $client->primary_phone_number; ?></p>
					<a href="<?php echo e(route('finance.contact.edit', $client->cid)); ?>" class="btn btn-success btn-xs waves-effect mb-2 waves-light"><i class="fas fa-user-edit"></i> Edit</a>
					<a href="#" class="btn btn-primary btn-xs waves-effect mb-2 waves-light"><i class="fas fa-envelope-open-text"></i> Send Email</a>
					<a href="<?php echo route('finance.contact.delete', $client->cid); ?>" class="btn btn-danger btn-xs waves-effect mb-2 waves-light delete"><i class="fas fa-trash"></i> Delete</a>
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
						<p><?php echo $client->bill_attention; ?><br>
							<?php if($client->bill_country != ""): ?>
							<?php echo Limitless::country($client->bill_country)->name; ?><br>
							<?php endif; ?>
							<?php echo $client->bill_city; ?><br>
							<?php echo $client->bill_street; ?><br>
							<?php echo $client->bill_state; ?><br>
							<?php echo $client->bill_address; ?> <br>
							<?php echo $client->bill_zip_code; ?><br>
							<?php echo $client->bill_fax; ?></br>
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
						<p><?php echo $client->ship_attention; ?><br>
							<?php if($client->ship_country != ""): ?>
							<?php echo Limitless::country($client->ship_country)->name; ?><br>
							<?php endif; ?>
							<?php echo $client->ship_city; ?><br>
							<?php echo $client->ship_street; ?><br>
							<?php echo $client->ship_state; ?><br>
							<?php echo $client->ship_address; ?> <br>
							<?php echo $client->ship_zip_code; ?><br>
							<?php echo $client->ship_fax; ?></br>
						</p>
					</div>
				</div>
				
			</div>
			<div class="col-md-9">
				<div class="row mb-3">
					<div class="col-md-6"></div>
					<div class="col-md-6">
                  <div class="float-right">
   						<a href="<?php echo e(route('finance.contact.edit', $client->cid)); ?>" class="btn btn-default"><i class="fas fa-user-edit"></i> Edit</a>
   						
   						<div class="btn-group">
   							<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"> New Transaction </button>
   							<ul class="dropdown-menu pull-right">
   								<li><a href="<?php echo route('finance.invoice.product.create'); ?>">Invoice</a></li>
   								<li><a href="<?php echo route('finance.payments.create'); ?>">Customer Payment</a> </li>
   								<li><a href="<?php echo route('finance.estimate.create'); ?>">Estimate</a> </li>
   								<li><a href="<?php echo route('finance.invoice.recurring.create'); ?>">Recurring Invoice  </a> </li>
   								<li><a href="<?php echo route('finance.creditnote.create'); ?>">Credit Note</a> </li>
   								<li><a href="<?php echo route('finance.estimate.create'); ?>">Expense</a> </li>
   								
   							</ul>
   						</div>
   						<div class="btn-group">
							<button data-toggle="dropdown" class="btn btn-default dropdown-toggle pull-right"> More </button>
							<ul class="dropdown-menu">
								
								
								
								<li><a href="<?php echo route('finance.contact.delete', $client->cid); ?>">Delete</a></li>
							</ul>
						</div>
                  </div>
					</div>
				</div>
				<?php echo $__env->make('app.partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<!-- begin nav -->
				<?php echo $__env->make('app.finance.contacts._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<!-- end nav -->

				<!-- main client page -->
				<?php if(Request::is('finance/customer/'.$customerID.'/show')): ?>
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
				<?php endif; ?>

				<!-- comments -->
				<?php if(Request::is('finance/customer/'.$customerID.'/comments')): ?>
					<?php echo $__env->make('app.finance.contacts.comments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- invoice -->
				<?php if(Request::is('finance/customer/'.$customerID.'/invoices')): ?>
					<?php echo $__env->make('app.finance.contacts.invoices', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

            <!-- estimates -->
				<?php if(Request::is('finance/customer/'.$customerID.'/estimates')): ?>
					<?php echo $__env->make('app.finance.contacts.estimates', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

            <!-- creditnote -->
				<?php if(Request::is('finance/customer/'.$customerID.'/creditnotes')): ?>
					<?php echo $__env->make('app.finance.contacts.creditnotes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

            <!-- contacts -->
				<?php if(Request::is('finance/customer/'.$customerID.'/contacts')): ?>
					<?php echo $__env->make('app.finance.contacts.contacts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <!-- ================== BEGIN PAGE LEVEL JS ================== -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.2/d3.min.js"></script>
   <script src="<?php echo asset('assets/plugins/nvd3/build/nv.d3.js'); ?>"></script>
   <script src="<?php echo asset('assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js'); ?>"></script>
   <script src="<?php echo asset('assets/plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js'); ?>"></script>
   <script src="<?php echo asset('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js'); ?>"></script>
	<script src="<?php echo asset('assets/plugins/gritter/js/jquery.gritter.js'); ?>"></script>
	<script src="<?php echo asset('assets/js/demo/dashboard-v2.min.js'); ?>"></script>
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/customer/view.blade.php ENDPATH**/ ?>