<div>
   <div class="row mb-3">
      <div class="col-md-10">
         <label for="">Search</label>
         <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Enter Product name">
      </div>
      <div class="col-md-1">
         <label for="">Type</label>
         <select wire:model="type" class="form-control">
            <option value="" selected>All</option>
            <option value="product">Products</option>
            <option value="service">Services</option>
         </select>
      </div>
      <div class="col-md-1">
         <label for="">Per Page</label>
         <select wire:model="perPage" class="form-control">
            <option value="25" selected>25</option>
            <option value="50">50</option>
            <option value="75">75</option>
            <option value="100">100</option>
         </select>
      </div>
   </div>
   <div class="panel panel-default">
      <div class="panel-body">
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th width="1%">#</th>
                  <th width="5%">Image</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>SKU Code</th>
                  <th width="10%">Price</th>
                  <th width="13%">Current Stock</th>
                  <th width="12%">Actions</th>
               </tr>
            </thead>
            <tbody>
               @foreach($products as $key => $product)
                  @if(Auth::user()->business_code == $product->businessID)
                     <tr>
                        <td>{!! $key + 1 !!}</td>
                        <td>
                           <center>
                              @if(Finance::check_product_image($product->productCode) == 1)
                                 <img src="{!! asset('businesses/'.Wingu::business()->business_code .'/finance/products/'.Finance::product_image($product->productCode)->file_name) !!}" width="80px" height="60px">
                              @else
                                 <img src="{!! asset('assets/img/product_placeholder.jpg') !!}" width="80px" height="60px">
                              @endif
                           </center>
                        </td>
                        <td>{!! $product->product_name !!}</td>
                        <td>{!! $product->type !!}</td>
                        <td>{!! $product->sku_code !!}</td>
                        <td>
                           {!! $product->currency !!}{!! number_format($product->price) !!}
                        </td>
                        <td>
                           @if($product->type != 'service')
                              {!! $product->stock !!}
                           @endif
                        </td>
                        <td>
                           <a href="{{ route('finance.products.details', $product->productCode) }}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                           <a href="{{ route('finance.products.edit', $product->productCode) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                           <a href="{!! route('finance.products.destroy', $product->productCode) !!}" class="btn btn-danger delete btn-sm"><i class="fas fa-trash"></i></a>
                        </td>
                     </tr>
                  @endif
               @endforeach
            </tbody>
         </table>
         {!! $products->links('pagination.custom') !!}
      </div>
   </div>
</div>
