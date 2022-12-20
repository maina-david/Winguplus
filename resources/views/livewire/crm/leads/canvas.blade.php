<div>
   <div class="row mb-2">
      <div class="col-md-6">
         <input type="text" wire:model="search" class="form-control" placeholder="Search by lead name, phone number or email">
      </div>
   </div>
   <div class="panel panel-default">
      <div class="panel-body">
         <table class="table table-striped">
            @foreach($leads as $count=>$lead)
               @if(Auth::user()->business_code == $lead->business_code)
                  <tr>
                     <td width="0.5%">{!! $count+1 !!}</td>
                     <td width="3%">
                        @if($lead->image == "")
                           <img src="https://ui-avatars.com/api/?name={!! $lead->customer_name !!}&size=84" alt="{!! $lead->customer_name !!}">
                        @else
                           <img width="84" height="81" alt="{!! $lead->customer_name !!}" src="{!! asset('businesses/'.$lead->business_code.'/customer/'. $lead->customerCode.'/'.$lead->image) !!}">
                        @endif
                     </td>
                     <td class="text-left" width="60%">
                        <a href="{{ route('crm.leads.show', $lead->customer_code) }}" class="text-black"><h4 class="font-weight-bolder">{!! $lead->customer_name !!}</h4></a>
                        <p class="font-small">
                           <b>Phone :</b> <a href="tel:{!! $lead->primary_phone_number !!}">{!! $lead->primary_phone_number !!}</a>
                           | <b>Email :</b> <a href="mailto:{!! $lead->email !!}">{!! $lead->email !!}</a>
                           | <b>Mobile :</b> <a href="tel:{!! $lead->other_phone_number !!}">{!! $lead->other_phone_number !!}</a>
                           {{-- | <b>Company :</b> {!! $lead->company !!} --}}
                           | <b>Title :</b> {!! $lead->designation !!}
                           | <b>Lead Status :</b> @if(Crm::check_lead_status($lead->status) == 1)<span class="badge badge-pink">{!! Crm::lead_status($lead->status)->name !!}</span> @endif
                        </p>
                     </td>
                     <td>
                        @if(Wingu::check_user($lead->assigned) == 1)
                           @php
                              $user = Wingu::user($lead->assigned);
                           @endphp
                           <div class="row mb-3">
                              <div class="col-md-2">
                                 @if($user->avatar)
                                    <img width="40" height="40" alt="{!! $user->name !!}" src="{!! asset('businesses/'.$lead->business_code.'/documents/images/'. $lead->avatar) !!}">
                                 @else
                                    <img src="https://ui-avatars.com/api/?rounded=true&name={!! $user->name !!}&size=40" alt="{!! $user->name !!}">
                                 @endif
                              </div>
                              <div class="col-md-8 text-left">
                                 <b>{!! $user->name !!}</b><br>
                                 <i>{!! date('F jS, Y', strtotime($lead->created_at)) !!}</i>
                              </div>
                           </div>
                        @endif
                        <a href="{{ route('crm.leads.show', $lead->customer_code) }}" class="btn btn-sm btn-outline-black"><i class="fas fa-eye"></i> View</a>
                        <a href="{!! route('crm.leads.edit',$lead->customer_code) !!}" class="btn btn-sm btn-outline-black"><i class="fas fa-edit"></i> Edit</a>
                        <a href="{!! route('crm.leads.delete', $lead->customer_code) !!}" class="btn btn-sm btn-outline-black delete"><i class="fas fa-trash-alt"></i> Delete</a>
                     </td>
                  </tr>
               @endif
            @endforeach
         </table>
         {!! $leads->links('pagination.custom') !!}
      </div>
   </div>
</div>
