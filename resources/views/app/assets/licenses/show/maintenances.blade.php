<div class="row">
   <div class="col-md-12 mb-2">
      <a href="{!! route('licenses.maintenances.create',$details->asset_code) !!}" class="btn btn-pink pull-right"><i class="fas fa-plus-circle"></i> Add Maintenance</a>
   </div>
   <div class="col-md-12">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead id="assetMaintenancesTable-sticky-header" style="">
            <tr>
               <th width="1%">#</th>
               <th>Maintenance Type</th>
               <th>Title</th>
               <th>Start Date</th>
               <th>Completion Date</th>
               <th>Warranty</th>
               <th>Cost</th>
               <th>Supplier</th>
               <th width="10%">Actions</th>
            </tr>
         </thead>
         <tbody>
            @foreach($maintenances as $count=>$maintenance)
               <tr>
                  <td>{!! $count+1 !!}</td>
                  <td>{!! $maintenance->maintenance_type !!}</td>
                  <td>{!! $maintenance->title !!}</td>
                  <td>
                     @if($maintenance->start_date)
                        {!! date('M jS, Y', strtotime($maintenance->start_date)) !!}
                     @endif
                  </td>
                  <td>
                     @if($maintenance->completion_date)
                        {!! date('M jS, Y', strtotime($maintenance->completion_date)) !!}
                     @endif
                  </td>
                  <td>{!! $maintenance->warranty_improvement !!}</td>
                  <td>{!! number_format($maintenance->cost) !!}</td>
                  <td>
                     @if($maintenance->supplier_code != "")
                        @if(Finance::check_supplier($maintenance->supplier_code) == 1)
                           <b>{!! Finance::supplier($maintenance->supplier_code)->supplier_name !!}</b>
                        @endif
                     @endif
                  </td>
                  <td>
                     <a href="{!! route('licenses.maintenances.edit',[$details->asset_code,$maintenance->maintenance_code]) !!}" class="btn btn-primary btn-sm"><i class="fal fa-edit"></i></a>
                     <a href="{!! route('licenses.maintenances.delete',[$details->asset_code,$maintenance->maintenance_code]) !!}" class="btn btn-sm btn-danger delete"><i class="fal fa-trash"></i></a>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div> <!-- row -->
