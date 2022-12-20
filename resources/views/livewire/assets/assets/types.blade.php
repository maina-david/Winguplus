<div class="col-md-6">
   <div class="form-group form-group-default">
      <label for="">Asset Type/Category <a href="" class="float-right" data-toggle="modal" data-target="#addType">Add Type</a></label>
      <select name="asset_type" id="type" class="form-control select2">
         @if($editType)
            @if($editType == 'xxxxxxx')
               <option value="xxxxxxx">Vehicle</option>
            @else
               <option value="{!! $editType !!}">{!! Asset::type($editType)->name !!}</option>
            @endif
         @else
            <option value="" selected>Choose</option>
         @endif
         <option value="xxxxxxx">Vehicle</option>
         @foreach($types as $type)
            <option value="{!! $type->type_code !!}">{!! $type->name !!}</option>
         @endforeach
      </select>
   </div>
</div>
