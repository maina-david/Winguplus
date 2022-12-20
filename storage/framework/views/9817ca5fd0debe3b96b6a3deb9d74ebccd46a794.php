<div id="sidebar" class="sidebar">
   <?php  $module = 'Customer relationship management' ?>
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      <?php echo $__env->make('partials._nav-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">My Menu</li>
         
         
         <li class="nav-header">Menu</li>
         <li class="has-sub <?php echo e(Nav::isResource('customer')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users"></i>
               <span>Contacts</span>
            </a>
            <ul class="sub-menu">
               <li><a href="<?php echo route('crm.customers.index'); ?>">Contacts List</a></li>
                  <li><a href="<?php echo route('crm.customers.create'); ?>">Add Contacts</a></li>
               <li class="<?php echo Nav::isRoute('crm.customers.groups.index'); ?> <?php echo Nav::isRoute('crm.customers.groups.edit'); ?>">
                  <a href="<?php echo route('crm.customers.groups.index'); ?>">Contacts category</a>
               </li>
            </ul>
         </li>
         <li class="has-sub <?php echo e(Nav::isResource('lead')); ?> <?php echo Nav::isRoute('crm.leads.canvas'); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-phone-volume"></i>
               <span>Leads</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo e(Nav::isRoute('crm.leads.canvas')); ?>"><a href="<?php echo route('crm.leads.canvas'); ?>">Leads List</a></li>
               <li class="<?php echo e(Nav::isRoute('crm.leads.create')); ?>"><a href="<?php echo route('crm.leads.create'); ?>">Add Lead</a></li>
               <li class="<?php echo Nav::isRoute('crm.leads.status'); ?>"><a href="<?php echo route('crm.leads.status'); ?>">Lead Status</a></li>
               <li class="<?php echo Nav::isRoute('crm.leads.sources'); ?>"><a href="<?php echo route('crm.leads.sources'); ?>">Lead Sources</a></li>
            </ul>
         </li>
         <li class="has-sub <?php echo Nav::isResource('deals'); ?> <?php echo e(Nav::isResource('pipeline')); ?>">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-bullseye"></i>
               <span>Deals</span>
            </a>
            <ul class="sub-menu">
               <li class="<?php echo Nav::isRoute('crm.deals.index'); ?>"><a href="<?php echo route('crm.deals.index'); ?>">All Deals</a></li>
               <li class="<?php echo Nav::isRoute('crm.deals.create'); ?>"><a href="<?php echo route('crm.deals.create'); ?>">New Deal</a></li>
               <li class="<?php echo Nav::isRoute('crm.pipeline.index'); ?> <?php echo e(Nav::isResource('pipeline')); ?>"><a href="<?php echo route('crm.pipeline.index'); ?>">Pipeline</a></li>
            </ul>
         </li>
         
         
         
         

         
         
         
         
         <!-- begin sidebar minify button -->
         <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
         <!-- end sidebar minify button -->
      </ul>
      <!-- end sidebar nav -->
   </div>
   <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/partials/_menu.blade.php ENDPATH**/ ?>