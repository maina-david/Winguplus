<select name="product_code[]" class="form-control dublicateSelect2 onchange solsoCloneSelect2" id="itemName_1" data-init-plugin='select2' required>
   @if($editProduct)
      <option value="{{ $productCode }}">{!! Finance::product($productCode)->product_name !!}</option>
   @else
      <option value="">Choose Product</option>
   @endif
   @foreach ($Itemproducts as $prod)
      <option value="{{ $prod->productCode }}">
         {{ substr($prod->product_name, 0, 100) }} {{ strlen($prod->product_name) > 100 ? '...' : '' }}
         @if($prod->track_inventory == 'Yes')
            @if($prod->type == 'product' && $prod->current_stock <= 0 )***** OUT OF STOCK ***** @endif
         @endif
      </option>
   @endforeach
   @foreach ($Itemservice as $service)
      <option value="{{ $service->productCode }}">
         {{ substr($service->product_name, 0, 100) }} {{ strlen($service->product_name) > 100 ? '...' : '' }}
      </option>
   @endforeach
</select>
