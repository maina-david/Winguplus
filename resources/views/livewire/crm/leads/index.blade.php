<div>
   <div class="row mb-2">
      <div class="col-md-6">
         <input type="text" wire:model="search" class="form-control" placeholder="Search by lead name, phone number or email">
      </div>
   </div>
   <div class="panel panel-default">
      <div class="panel-body">
         <table id="data-table-default" class="table table-striped table-bordered">
            <thead>
               <tr role="row">
                  <th width="1%">#</th>
                  <th>Lead Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Assigned</th>
                  <th>Status</th>
                  <th>Date Added</th>
                  <th width="10%">Action</th>
               </tr>
            </thead>
            <tbody>
               @foreach($leads as $count=>$lead)
                  @if(Auth::user()->business_code == $lead->business_code)
                  <tr>
                     <td>{!! $count+1 !!}</td>
                     <td>{!! $lead->customer_name !!}</td>
                     <td>{!! $lead->email !!}</td>
                     <td>{!! $lead->primary_phone_number !!}</td>
                     <td>
                        @if(Wingu::check_user($lead->assigned) == 1)
                           {!! Wingu::user($lead->assigned)->name !!}
                        @endif
                     </td>
                     <td>
                        @if(Crm::check_lead_status($lead->status))
                           <span class="badge badge-pink">{!! Crm::lead_status($lead->status)->name !!}</span>
                        @endif
                     </td>
                     <td>
                        {!! date("F d, Y", strtotime($lead->created_at)) !!}
                     </td>
                     <td>
                        <div class="btn-group">
                           <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                           <ul class="dropdown-menu">
                              <li><a href="{{ route('crm.leads.show', $lead->customer_code) }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                              <li><a href="{!! route('crm.leads.edit',$lead->customer_code) !!}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                              <li><a href="{!! route('crm.leads.delete', $lead->customer_code) !!}" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                           </ul>
                        </div>
                     </td>
                  </tr>
                  @endif
               @endforeach
            </tbody>
         </table>
         {!! $leads->links('pagination.custom') !!}
      </div>
   </div>
</div>
