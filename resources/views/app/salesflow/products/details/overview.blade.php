<div class="col-md-12 mt-3">
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-md-4">
               @if(Finance::check_product_image($details->productCode) == 1)
                  <img src="{!! asset('businesses/'.Wingu::business()->business_code.'/finance/products/'.Finance::product_image($details->productCode)->file_name) !!}" class="img-responsive">
               @else
                  <img src="{!! asset('assets/img/product_placeholder.jpg') !!}" class="img-responsive">
               @endif
            </div>
            <div class="col-md-4">
               <h4>
                  Product Name : <span class="text-primary"><b>{!! $details->product_name !!}</b></span><br>
                  Item Type : <span class="text-primary"><b>{!! $details->type !!}</b></span><br>
                  Serial : <span class="text-primary"><b>{!! $details->sku_code !!}</b></span><br>
                  Created by :
                     @if($details->creator != "")
                        <span class="text-primary"><b>{!! Wingu::user($details->creator)->name !!}</b></span><br>
                     @endif
                  Supplier :
                     @if($details->supplier)
                        <span class="text-primary"><b>{!! Finance::supplier($details->supplier)->supplierName !!}</b></span>
                     @endif<br>
                  Brand :
                     @if($details->brand)
                        <span class="text-primary"><b>{!! $details->brand !!}</b></span>
                     @endif<br>
               </h4>
               <hr>
               <h4>
                  Buying Price : <span class="text-primary"><b>{!! $details->code !!} {!! number_format($details->buying_price) !!}</b></span><br>
                  Selling Price : <span class="text-primary"><b>{!! $details->code !!} {!! number_format($details->selling_price) !!}</b></span><br>
               </h4>
               <hr>
               <h4>
                  Category<br>
                  @foreach (Finance::get_products_categories($details->productCode) as $category)
                     <span class="badge badge-primary">{!!$category->name  !!}</span>
                  @endforeach
                  <br><br>
                  Tags <br>
                  <span class="badge badge-warning">{!!$details->tag  !!}</span>
               </h4>
            </div>
            @if( $details->type != 'service')
               <div class="col-md-4">
                  <h4>
                     Current Stock  : <span class="text-primary"><b>{!! $details->current_stock !!}</b></span><br>
                     Available for Sale : <span class="text-primary"><b>{!! $details->current_stock !!}</b></span><br>
                     Reorder Point : <span class="text-primary"><b>{!! $details->reorder_level !!}</b></span><br>
                     Replenish level : <span class="text-primary"><b>{!! $details->replenish_level !!}</b></span><br>
                     Expiration date : @if($details->expiration_date != "")<span class="text-primary"><b>{!! date('F jS, Y', strtotime($details->expiration_date)) !!}</b></span>@endif<br>
                  </h4>
               </div>
            @endif
         </div>

      </div>
   </div>
</div>
