<div class="col-md-6">
   <div class="form-group form-group-default">
      <label for="">Suppliers <a href="" class="float-right" data-toggle="modal" data-target="#addSupplier">Add Supplier</a></label>
      {!! Form::select('supplier', $suppliers, null, array('class' => 'form-control select2')) !!}
   </div>
</div>

{{-- <div class="col-md-6">
   <div class="form-group form-group-default">
      <label for="">Suppliers <a href="" class="float-right" data-toggle="modal" data-target="#addSupplier">Add Supplier</a></label>
      {!! $editSupplier !!}
      <select name="supplier" class="form-control select2" wire:model="supplier">
         @if($editSupplier)
            @if(Finance::check_supplier($editSupplier) == 1)
               <option value="{!! $editSupplier !!}">{!! Finance::supplier($editSupplier)->supplier_name !!}</option>
            @else
               <option value="">Choose Supplier</option>
            @endif
         @else
           <option value="">Choose Supplier</option>
         @endif
         @foreach($suppliers as $supplier)
            <option value="{!! $supplier->supplier_code !!}">{!! $supplier->supplier_name !!}</option>
         @endforeach
      </select>
   </div>
</div> --}}
