<div class="col-md-3" style="min-height: 300px;">
   <div class="panel panel-white">
      <div class="panel-body">
         <ul class="nav nav-pills nav-stacked product">
            <li class="{!! Nav::isRoute('subscriptions.products.edit') !!} mb-2">
               <a href="#"> <i class="fa fa-info-circle" aria-hidden="true"></i> Information</a>
            </li>
            <li class="{!! Nav::isResource('plan') !!} mb-2"><a href="{!! route('subscriptions.plan.index',$productID) !!}"> <i class="fas fa-cheese"></i> Plans</a></li>
            {{-- <li class="mb-2"><a href="#"> <i class="fa fa-info-circle" aria-hidden="true"></i> Addon</a></li> --}}
         </ul>
      </div>
   </div>
</div>