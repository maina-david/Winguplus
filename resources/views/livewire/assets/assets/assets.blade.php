<div class="panel panel-default">
   <div class="panel-heading">
      <div class="row">
         <div class="col-md-5">
            <label for="">Search</label>
            <input type="text" class="form-control" wire:model="search" placeholder="Search by name, serial or assettag">
         </div>
         <div class="col-md-1"></div>
         <div class="col-md-3">
            <label for="">Type</label>
            <select wire:model="asset_type" class="form-control">
               <option value="">Choose</option>
               <option value="xxxxxxx">Vehicle</option>
               @foreach($types as $type)
                  <option value="{!! $type->type_code !!}">{!! $type->name !!}</option>
               @endforeach
            </select>
         </div>
         <div class="col-md-3">
            <label for="">Status</label>
            <select wire:model="status" class="form-control">
               <option value="">Choose</option>
               @foreach($statuses as $status)
               <option value="{!! $status->status_code !!}">{!! $status->title !!}</option>
               @endforeach
            </select>
         </div>
      </div>
   </div>
   <div class="panel-body">
      <table class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th width="10%">Image</th>
               <th>Name </th>
               <th>Type</th>
               <th>Asset Tag</th>
               <th>Serial</th>
               <th>Status</th>
               <th>Assigned To</th>
               <th width="12%">Action</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($assets as $count=>$asset)
               <tr>
                  <td>{!! $count+1 !!}</td>
                  <td>
                     @if($asset->asset_image == "")
                        <img src="{!! asset('assets/img/product_placeholder.jpg') !!}" width="80px" height="60px">
                     @else
                        <img src="{!! asset('businesses/'.Wingu::business()->business_code.'/assets/'.$asset->asset_image) !!}" alt="" class="img-responsive">
                     @endif
                  </td>
                  <td>{!! $asset->asset_name !!}</td>
                  <td>
                     @if($asset->asset_type == 'xxxxxxx')
                        Vehicle
                     @else
                        @if($asset->asset_type)
                           {!! Asset::type($asset->asset_type)->name !!}
                        @endif
                     @endif
                  </td>
                  <td>{!! $asset->asset_tag !!}</td>
                  <td>{!! $asset->serial !!}</td>
                  <td>
                     @if($asset->status)
                        @php
                           $label = Asset::label($asset->status);
                        @endphp
                        <span class="badge" style="background-color:{!! $label->color !!}">{!! $label->title !!}</span>
                     @endif
                  </td>
                  <td>
                     @if($asset->employee)
                        <b>Employee :</b> {!! Hr::employee($asset->employee)->names !!}
                     @endif
                     @if($asset->customer)
                        <b>Customer :</b> {!! Finance::client($asset->customer)->customer_name !!}
                     @endif
                  </td>
                  <td>
                     <a href="{!! route('assets.edit',$asset->asset_code) !!}" class="btn btn-primary btn-sm"><i class="fal fa-edit"></i></a>
                     <a href="{!! route('assets.show',$asset->asset_code) !!}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                     <a href="{!! route('assets.delete',$asset->asset_code) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
