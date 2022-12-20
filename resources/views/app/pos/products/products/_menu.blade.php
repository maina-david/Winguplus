@section('stylesheet')
   <style>
      ul.product li {
         width: 100%;
      }
   </style>
@endsection
<div class="col-md-3">
   <div class="panel panel-default">
      <div class="panel-body">
         <ul class="nav nav-pills nav-stacked product">
            <li class="{{ Nav::isRoute('pos.products.edit') }} mb-1">
               <a href="{!! route('pos.products.edit',$productCode) !!}"> <i class="fa fa-info-circle" aria-hidden="true"></i> Information</a>
            </li>
            <li class="{{ Nav::isResource('price') }}">
               <a href="{!! route('pos.products.price', $productCode) !!}"><i class="fal fa-usd-circle"></i> Price</a>
            </li>
            <li class="{{ Nav::isResource('inventory') }}">
               <a href="{!! route('pos.inventory', $productCode) !!}"><i class="fal fa-inventory"></i> Inventory</a>
            </li>
            <li class="{{ Nav::isResource('images') }}">
            <a href="{!! route('pos.product.images', $productCode) !!}"><i class="fal fa-images"></i> Images</a>
            </li>
         </ul>
      </div>
   </div>
</div>
