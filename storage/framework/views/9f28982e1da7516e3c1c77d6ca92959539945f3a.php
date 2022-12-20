<div class="col-md-3" style="min-height: 300px;">
   <div class="panel panel-white">
      <div class="panel-body">
         <ul class="nav nav-pills nav-stacked product">
            <li class="<?php echo Nav::isRoute('subscriptions.products.edit'); ?> mb-2">
               <a href="#"> <i class="fa fa-info-circle" aria-hidden="true"></i> Information</a>
            </li>
            <li class="<?php echo Nav::isResource('plan'); ?> mb-2"><a href="<?php echo route('subscriptions.plan.index',$productID); ?>"> <i class="fas fa-cheese"></i> Plans</a></li>
            
         </ul>
      </div>
   </div>
</div><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/subscriptions/partials/_shop_menu.blade.php ENDPATH**/ ?>