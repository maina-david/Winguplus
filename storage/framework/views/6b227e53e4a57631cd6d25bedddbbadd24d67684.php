<?php $__env->startSection('title'); ?>
	Details |
	<?php if($client->contact_type == 'Individual'): ?>
		<?php echo $client->salutation; ?> <?php echo $client->customer_name; ?>

	<?php else: ?>
		<?php echo $client->customer_name; ?>

	<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<div class="row">
			<div class="col-md-3">
				<div class="card-box text-center">
               <?php if($client->image != ""): ?>
						<img src="<?php echo asset('businesses/'.Wingu::business()->business_code.'/customer/'.$client->customer_code.'/images/'.$client->image); ?>" alt="" style="width:90px;height:90px" class="rounded-circle">
					<?php else: ?>
						<img src="https://ui-avatars.com/api/?name=<?php echo $client->customer_name; ?>&rounded=true&size=90" alt="">
					<?php endif; ?>
					<h4 class="mb-1 mt-2">
						<?php if($client->contact_type == 'Individual'): ?>
							<?php echo $client->salutation; ?> <?php echo $client->customer_name; ?>

						<?php else: ?>
							<?php echo $client->customer_name; ?>

						<?php endif; ?>
					</h4>
					<p class="text-muted"><i class="fas fa-at"></i> <?php echo $client->email; ?><br><i class="fas fa-phone"></i> <?php echo $client->primary_phone_number; ?></p>
					<a href="<?php echo e(route('crm.customers.edit', $code)); ?>" class="btn btn-success btn-xs waves-effect mb-2 waves-light"><i class="fal fa-edit"></i> Edit</a>
					<?php if(Wingu::business()->plan != 1): ?>
						<a href="<?php echo route('crm.customer.mail',$code); ?>" class="btn btn-primary btn-xs waves-effect mb-2 waves-light"><i class="fal fa-paper-plane"></i> Send Email</a>
					<?php endif; ?>
					<a href="<?php echo route('crm.customers.delete', $code); ?>" class="btn btn-danger btn-xs waves-effect mb-2 waves-light delete"><i class="fas fa-trash"></i> Delete</a>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fal fa-file-invoice-dollar"></i> Billing Information</h4>
					</div>
					<div class="panel-body">
						<p><?php echo $client->bill_attention; ?><br>
							<?php echo $client->bill_country; ?><br>
							<?php echo $client->bill_city; ?><br>
							<?php echo $client->bill_street; ?><br>
							<?php echo $client->bill_state; ?><br>
							<?php echo $client->bill_address; ?><br>
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
						<h4 class="panel-title"><i class="fal fa-shipping-fast"></i> Shipping Information</h4>
					</div>
					<div class="panel-body">
						<p><?php echo $client->ship_attention; ?><br>
							<?php echo $client->ship_country; ?>

							<?php echo $client->ship_city; ?><br>
							<?php echo $client->ship_street; ?><br>
							<?php echo $client->ship_state; ?><br>
							<?php echo $client->ship_address; ?> <br>
							<?php echo $client->ship_zip_code; ?><br>
							<?php echo $client->ship_fax; ?></br>
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
								<?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="row">
										<div class="col-md-3">
											<img src="https://ui-avatars.com/api/?name=<?php echo $contact->names; ?>&rounded=true&size=50" alt="">
										</div>
										<div class="col-md-9">
											<p>
												<b>Name :</b> <span class="text-pink"><?php echo $contact->names; ?></span><br>
												<b>Phone number :</b> <span class="text-pink"><?php echo $contact->phone_number; ?></span><br>
												<b>Email :</b> <span class="text-pink"><?php echo $contact->contact_email; ?></span><br>
												<b>Designation :</b> <span class="text-pink"><?php echo $contact->designation; ?></span><br>
											</p>
										</div>
										<div class="col-md-12">
											<hr>
										</div>
									</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<div class="col-md-9">
				<div class="row mb-3">
					<div class="col-md-12">
                  <div class="float-right">
							<a href="<?php echo e(route('crm.customers.edit', $code)); ?>" class="btn btn-white"><i class="fas fa-edit"></i> Edit</a>
								<a href="<?php echo e(route('crm.customer.send', $code)); ?>" class="btn btn-white"><i class="fal fa-paper-plane"></i> Send Mail</a>
   						<div class="btn-group">
   							<button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"> New Transaction </button>
   							<ul class="dropdown-menu pull-right">
   								<li><a href="<?php echo route('finance.invoice.product.create'); ?>">Invoice</a></li>
   								<li><a href="<?php echo route('finance.payments.create'); ?>">Payment</a> </li>
   								<li><a href="<?php echo route('finance.quotes.create'); ?>">Quotes</a> </li>
   								<li><a href="<?php echo route('finance.creditnote.create'); ?>">Credit Note</a> </li>
   								<li class="divider"></li>
   								<li> <a href="">Project</a> </li>
   							</ul>
   						</div>
   						<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-white dropdown-toggle pull-right"> More </button>
								<ul class="dropdown-menu">
                           
                           
                           <li class="divider"></li>
									
									
									
									<li class="divider"></li>
									<li><a href="<?php echo route('crm.customers.delete', $code); ?>"><i class="fas fa-trash"></i> Delete</a></li>
								</ul>
							</div>
							<?php if(Wingu::business()->plan != 1): ?>
								<a href="<?php echo route('crm.customer.documents',$code); ?>" class="btn btn-white"><i class="fal fa-folder"></i> Documents</a>
							<?php endif; ?>
                  </div>
					</div>
				</div>
				<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<!-- begin nav -->
				<?php echo $__env->make('app.crm.customers._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<!-- end nav -->

				<!-- main client page -->
				<?php if(Request::is('crm/customer/'.$code.'/show')): ?>
					<?php echo $__env->make('app.crm.customers.show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- comments -->
				<?php if(Request::is('crm/customer/'.$code.'/comments')): ?>
					<?php echo $__env->make('app.crm.customers.comments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- invoice -->
				<?php if(Request::is('crm/customer/'.$code.'/invoices')): ?>
					<?php echo $__env->make('app.crm.customers.invoices', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

            <!-- estimates -->
				<?php if(Request::is('crm/customer/'.$code.'/quotes')): ?>
					<?php echo $__env->make('app.crm.customers.quotes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

            <!-- creditnote -->
				<?php if(Request::is('crm/customer/'.$code.'/creditnotes')): ?>
					<?php echo $__env->make('app.crm.customers.creditnotes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- projects -->
				<?php if(Request::is('crm/customer/'.$code.'/projects')): ?>
					<?php echo $__env->make('app.crm.customers.projects', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- statement -->
				<?php if(Request::is('crm/customer/'.$code.'/statement')): ?>
					<?php echo $__env->make('app.crm.customers.statement', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- statement mail -->
				<?php if(Request::is('crm/customer/'.$code.'/statement/mail')): ?>
					<?php echo $__env->make('app.crm.customers.statementMail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- subscription -->
				<?php if(Request::is('crm/customer/'.$code.'/subscriptions')): ?>
					<?php echo $__env->make('app.crm.customers.subscriptions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

            <!-- contacts -->
				<?php if(Request::is('crm/customer/'.$code.'/contacts')): ?>
					<?php echo $__env->make('app.crm.customers.contacts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- mails -->
				<?php if(Request::is('crm/customer/'.$code.'/mail')): ?>
					<?php echo $__env->make('app.crm.customers.mail.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- send -->
				<?php if(Request::is('crm/customer/'.$code.'/send')): ?>
					<?php echo $__env->make('app.crm.customers.mail.mail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- documents -->
				<?php if(Request::is('crm/customer/'.$code.'/documents')): ?>
					<?php echo $__env->make('app.crm.customers.documents', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- sms -->
				<?php if(Request::is('crm/customer/'.$code.'/sms')): ?>
					<?php echo $__env->make('app.crm.customers.sms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- notes -->
				<?php if(Request::is('crm/customer/'.$code.'/notes')): ?>
					<?php echo $__env->make('app.crm.customers.notes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<!-- events -->
				<?php if(Request::is('crm/customer/'.$code.'/events')): ?>
               <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crm.leads.events.grid-view', ['leadCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('GSo1N24')) {
    $componentId = $_instance->getRenderedChildComponentId('GSo1N24');
    $componentTag = $_instance->getRenderedChildComponentTagName('GSo1N24');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('GSo1N24');
} else {
    $response = \Livewire\Livewire::mount('crm.leads.events.grid-view', ['leadCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('GSo1N24', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
				<?php endif; ?>

            <?php if(Request::is('crm/customer/'.$code.'/events/list')): ?>
               <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crm.leads.events.list-view', ['leadCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('LCLLiV4')) {
    $componentId = $_instance->getRenderedChildComponentId('LCLLiV4');
    $componentTag = $_instance->getRenderedChildComponentTagName('LCLLiV4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('LCLLiV4');
} else {
    $response = \Livewire\Livewire::mount('crm.leads.events.list-view', ['leadCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('LCLLiV4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php endif; ?>

				<!-- events -->
				<?php if(Request::is('crm/customer/'.$code.'/calllogs')): ?>
					<?php echo $__env->make('app.crm.customers.calllogs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/customers/view.blade.php ENDPATH**/ ?>