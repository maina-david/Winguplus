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
            <li class="{{ Nav::isRoute('salesflow.products.edit') }} mb-2">
            <a href="{!! route('salesflow.products.edit',$productCode) !!}"> <i class="fa fa-info-circle" aria-hidden="true"></i> Information</a>
            </li>
            {{-- <li class="{{ Nav::isRoute('salesflow.description') }} mt-2">
               <a href="{!! route('salesflow.description', $productCode) !!}"><i class="far fa-file-alt"></i> Description</a>
            </li> --}}
            <li class="{{ Nav::isResource('price') }}">
               <a href="{!! route('salesflow.product.price', $productCode) !!}"><i class="fal fa-usd-circle"></i> Price</a>
            </li>
            <li class="{{ Nav::isResource('inventory') }}">
               <a href="{!! route('salesflow.products.inventory', $productCode) !!}"><i class="fal fa-inventory"></i> Inventory</a>
            </li>
            <li class="{{ Nav::isResource('images') }}">
            <a href="{!! route('salesflow.product.images', $productCode) !!}"><i class="fal fa-images"></i> Images</a>
            </li>
            {{-- <li class="{{ Nav::isResource('settings') }}">
               <a href="{!! route('salesflow.product.settings.edit', $productCode) !!}"><i class="far fa-cogs"></i> Settings</a>
            </li> --}}
         </ul>
      </div>
   </div>
</div>
