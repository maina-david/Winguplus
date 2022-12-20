<div class="col-md-12 mb-3">
   <ul class="nav nav-pills pull-right">
      <li class="nav-item">
         <a class="nav-link <?php echo Nav::isRoute('propertywingu.property.show'); ?>" href="<?php echo route('propertywingu.property.show', $code); ?>"><i class="fal fa-info-circle"></i> Overview</a>
      </li>
      <li class="nav-item <?php echo Nav::isRoute('propertywingu.property.tenants'); ?>">
         <a class="nav-link <?php echo Nav::isRoute('propertywingu.property.tenants'); ?>" href="<?php echo route('propertywingu.property.tenants', $code); ?>"><i class="fal fa-users"></i> Tenants</a>
      </li>
      <?php if($property->property_type == 13 or $property->property_type == 14): ?>
         <li class="nav-item dropdown <?php echo Nav::isResource('units'); ?>">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fal fa-car-building"></i> Units</a>
            <div class="dropdown-menu">
               <a class="dropdown-item <?php echo Nav::isRoute('propertywingu.property.units'); ?>" href="<?php echo route('propertywingu.property.units', $code); ?>">All Units</a>
               <a class="dropdown-item <?php echo Nav::isRoute('propertywingu.property.units.create'); ?>" href="<?php echo route('propertywingu.property.units.create', $code); ?>">Add Units</a>
               <a class="dropdown-item <?php echo Nav::isRoute('propertywingu.property.units.bulk.create'); ?>" href="<?php echo route('propertywingu.property.units.bulk.create', $code); ?>">Add Bulk Units</a>
               <a class="dropdown-item <?php echo Nav::isRoute('propertywingu.property.vacant'); ?>" href="<?php echo route('propertywingu.property.vacant', $code); ?>">Vacant Units</a>
               <a class="dropdown-item <?php echo Nav::isRoute('propertywingu.property.occupied'); ?>" href="<?php echo route('propertywingu.property.occupied', $code); ?>">Occupied Units</a>
            </div>
         </li>
      <?php endif; ?>
      <li class="nav-item dropdown <?php echo Nav::isResource('leases'); ?>">
         <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fal fa-file-contract"></i> Leases</a>
         <div class="dropdown-menu">
            <a class="dropdown-item" href="<?php echo route('propertywingu.property.leases',$code); ?>">All Lease</a>
            <a class="dropdown-item" href="<?php echo route('propertywingu.property.leases',$code); ?>">Active Leases</a>
            <?php if($property->property_type == 13 or $property->property_type == 14): ?>
               <a class="dropdown-item" href="<?php echo route('propertywingu.property.leases.create',$code); ?>">Add Lease</a>
            <?php else: ?>
               <?php if($property->lease == ""): ?>
                  <a class="dropdown-item" href="<?php echo route('propertywingu.property.leases.create',$code); ?>">Add Lease</a>
               <?php endif; ?>
            <?php endif; ?>
         </div>
      </li>
      <li class="nav-item dropdown <?php echo Nav::isResource('invoices'); ?> <?php echo Nav::isRoute('propertywingu.property.payments'); ?> <?php echo Nav::isRoute('propertywingu.property.payments.create'); ?> <?php echo Nav::isRoute('propertywingu.property.payments.edit'); ?> <?php echo Nav::isRoute('propertywingu.property.payments.show'); ?> <?php echo Nav::isRoute('propertywingu.property.expense'); ?> <?php echo Nav::isRoute('propertywingu.property.expense.create'); ?> <?php echo Nav::isRoute('propertywingu.property.expense.edit'); ?> <?php echo Nav::isResource('creditnote'); ?> <?php echo Nav::isResource('utility'); ?>">
         <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fal fa-usd-circle"></i> Accounting</a>
         <div class="dropdown-menu">
            <a class="dropdown-item" href="<?php echo route('propertywingu.property.invoice.index',$code); ?>">Rent Billing</a>
            <a class="dropdown-item" href="<?php echo route('propertywingu.property.utility.billing.index',$code); ?>">Utility Billing</a>
            <a class="dropdown-item <?php echo Nav::isResource('creditnote'); ?>" href="<?php echo route('propertywingu.property.creditnote.index',$code); ?>">
               Credit Note
            </a>
            <a class="dropdown-item <?php echo Nav::isRoute('propertywingu.property.payments'); ?>" href="<?php echo route('propertywingu.property.payments',$code); ?>">
               Payments
            </a>
            <a class="dropdown-item  <?php echo Nav::isRoute('propertywingu.property.expense'); ?>" href="<?php echo route('propertywingu.property.expense',$code); ?>"> Expenses</a>
         </div>
      </li>
      <li class="nav-item <?php echo Nav::isRoute('propertywingu.property.documents'); ?>">
         <a class="nav-link" href="<?php echo route('propertywingu.property.documents',$code); ?>"><i class="fal fa-folder"></i> Documents</a>
      </li>
      <li class="nav-item <?php echo Nav::isRoute('propertywingu.property.images'); ?>">
         <a class="nav-link" href="<?php echo route('propertywingu.property.images',$code); ?>"><i class="fal fa-images"></i> Images</a>
      </li>
      <li class="nav-item <?php echo Nav::isRoute('propertywingu.property.edit'); ?>">
         <a class="nav-link" href="<?php echo route('propertywingu.property.edit',$code); ?>"><i class="fal fa-edit"></i> Edit</a>
      </li>
      <li class="nav-item <?php echo Nav::isRoute('propertywingu.property.reports'); ?>  <?php echo Nav::isResource('reports'); ?> ">
         <a class="nav-link" href="<?php echo route('propertywingu.property.reports',$code); ?>"><i class="far fa-chart-pie"></i> Reports</a>
      </li>
      <li class="nav-item dropdown <?php echo Nav::isResource('settings'); ?>">
         <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fal fa-tools"></i> Settings</a>
         <div class="dropdown-menu">
            <a class="dropdown-item <?php echo Nav::isRoute('propertywingu.property.invoice.settings'); ?>" href="<?php echo route('propertywingu.property.invoice.settings',$code); ?>">Invoice</a>
            <a class="dropdown-item <?php echo Nav::isRoute('propertywingu.property.creditnote.settings'); ?>" href="<?php echo route('propertywingu.property.creditnote.settings',$code); ?>">Credit Note</a>
            <a class="dropdown-item <?php echo Nav::isRoute('propertywingu.property.payment.integration.settings'); ?>" href="<?php echo route('propertywingu.property.payment.integration.settings',$code); ?>">Payment details</a>
         </div>
      </li>
   </ul>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/propertywingu/partials/_property_menu.blade.php ENDPATH**/ ?>