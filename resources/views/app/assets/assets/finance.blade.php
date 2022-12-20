<div class="row">
   <div class="col-md-4">
      <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
         <tbody>
            <tr>
               <td>Supplier</td>
               <td>
                  <b>
                     @if($details->supplier)
                        @if(Finance::check_supplier($details->supplier) == 1)
                           <b>{!! Finance::supplier($details->supplier)->supplier_name !!}</b>
                        @endif
                     @endif
                  </b>
               </td>
            </tr>
            <tr>
               <td>Depreciable assets</td>
               <td>
                  <b>{!! $details->depreciable_assets !!}</b>
               </td>
            </tr>
            <tr>
               <td>Purchase date</td>
               <td>
                  <b>{!! date('F jS, Y', strtotime($details->purchase_date)) !!}</b>
               </td>
            </tr>
            <tr>
               <td>Order Number</td>
               <td>
                  <b>{!! $details->order_number !!}</b>
               </td>
            </tr>
            <tr>
               <td>Purchase Cost</td>
               <td>
                  <b>{!! $details->purches_cost !!}</b>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
