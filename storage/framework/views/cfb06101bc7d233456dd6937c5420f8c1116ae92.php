<div id="sidebar" class="sidebar">
   <?php  $module = 'Property Management' ?>
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      <?php echo $__env->make('partials._nav-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end sidebar user -->
      <ul class="nav">
         <li class="nav-header">Property</li>
         <li class="has-sub <?php echo Nav::isRoute('propertywingu.dashboard'); ?>">
            <a href="<?php echo route('propertywingu.dashboard'); ?>" class="<?php echo Nav::isRoute('propertywingu.dashboard'); ?>">
               <i class="fal fa-draw-circle"></i>
               Dashboard
            </a>
         </li>
         <li class="has-sub <?php echo Nav::isRoute('propertywingu.property.index'); ?> <?php echo Nav::isRoute('propertywingu.property.create'); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-building"></i>
               <span>Properties</span>
            </a>
            <ul class="sub-menu">
               <li> <a href="<?php echo route('propertywingu.property.index'); ?>">All Property</a></li>
               <li> <a href="<?php echo route('propertywingu.property.create'); ?>">Add Property</a></li>
            </ul>
         </li>
         <li class="has-sub <?php echo Nav::isResource('tenants'); ?>">
            <a href="javascript:void()">
               <b class="caret"></b>
               <i class="fal fa-users"></i>
               <span>Tenants</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo Nav::isResource('tenants'); ?>"> <a href="<?php echo route('tenants.index'); ?>">All Tenants</a></li>
               <li class="<?php echo Nav::isRoute('tenants.create'); ?>"><a href="<?php echo route('tenants.create'); ?>">Add Tenants</a></li>
            </ul>
         </li>
         <li class="has-sub <?php echo Nav::isResource('landlord'); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users-crown"></i>
               <span>Owners</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo Nav::isRoute('landlord.index'); ?>"> <a href="<?php echo route('landlord.index'); ?>">All Landlords</a></li>
               <li class="<?php echo Nav::isRoute('landlord.create'); ?>"> <a href="<?php echo route('landlord.create'); ?>">Add Landlords</a></li>
            </ul>
         </li>
         <li class="has-sub <?php echo Nav::isResource('agents'); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-user-tie"></i>
               <span>Agents</span>
            </a>
            <ul class="sub-menu">
               <li> <a href="<?php echo route('propertywingu.property.agents'); ?>">All Agents</a></li>
               <li> <a href="<?php echo route('propertywingu.property.agents.create'); ?>">Add Agent</a></li>
            </ul>
         </li>
         <li class="has-sub <?php echo Nav::isResource('supplier'); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users-cog"></i>
               <span>Suppliers</span>
            </a>
            <ul class="sub-menu">
               <li> <a href="<?php echo route('propertywingu.property.supplier'); ?>">All suppliers</a></li>
               <li> <a href="<?php echo route('propertywingu.property.supplier.create'); ?>">Add suppliers</a></li>
            </ul>
         </li>
         
         <li class="has-sub <?php echo Nav::isResource('marketing'); ?>">
            <a class="has-arrow <?php echo Nav::isResource('marketing'); ?>" href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-bullhorn"></i>
               <span>Marketing</span>
            </a>
            <ul class="sub-menu">
               <li> <a href="<?php echo route('propertywingu.property.lisitng'); ?>">Listing</a></li>
               <li> <a href="<?php echo route('propertywingu.property.inquiry'); ?>">Inquiry</a></li>
            </ul>
         </li>
         <li class="has-sub <?php echo Nav::isResource('settings'); ?>">
            <a class="has-arrow <?php echo Nav::isResource('settings'); ?>" href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-tools"></i>
               <span>Settings</span>
            </a>
            <ul class="sub-menu">
               <li> <a href="<?php echo route('propertywingu.property.income.category'); ?>">Income Categories</a></li>
               <li> <a href="<?php echo route('propertywingu.property.expense.category.index'); ?>">Expense Categories</a></li>
               <li> <a href="<?php echo route('propertywingu.property.taxes'); ?>">Taxes</a></li>
               <li> <a href="<?php echo route('propertywingu.property.payment.method'); ?>">Payment Methods</a></li>
               <li> <a href="<?php echo route('propertywingu.property.utilities'); ?>">Utilities</a></li>
            </ul>
         </li>
         <li><a href="#"> <i class="far fa-chart-pie"></i>Reports</a></li>
      </ul>
   </div>
</div>
<div class="sidebar-bg"></div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/propertywingu/partials/_menu.blade.php ENDPATH**/ ?>