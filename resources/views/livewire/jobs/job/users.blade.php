<div>
   <div class="row mb-3">
      <div class="col-md-8">
         <h4><i class="fal fa-users"></i> Users</h4>
      </div>
      <div class="col-md-4">
         <input type="text" wire:model="search" class="form-control" placeholder="Search by name">
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="widget-list rounded bg-none">
            <div class="row">
               @foreach($members as $member)
                  <div class="col-md-3 mb-3">
                     <div class="widget-list-item">
                        <div class="widget-list-media">
                           @if($member->avatar)
                              <img alt="{!! $member->name !!}" src="{!! asset('businesses/'.Wingu::business()->business_code.'/users/'.$member->user_code.'/'.$member->avatar) !!}" class="rounded">
                           @else
                              <img alt="{!! $member->name !!}" src="https://ui-avatars.com/api/?name={!! $member->name !!}&rounded=true&size=50" class="rounded">
                           @endif
                        </div>
                        <div class="widget-list-content">
                           <h4 class="widget-list-title">{!! $member->name !!}</h4>
                           <p class="widget-list-desc">Total Tasks : </p>
                        </div>
                        @php
                           $userCode = json_encode($member->user_code);
                           $code = json_encode($this->jobCode);
                        @endphp
                        <div class="widget-list-action">
                           <a href="#" data-toggle="dropdown" class="text-gray-500"><i class="fa fa-ellipsis-h fs-14px"></i></a>
                           <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item">View Tasks</a>
                              <a class="dropdown-item delete" wire:click="remove_member({{$code}},{{$userCode}})">Remove</a>
                           </div>
                        </div>
                     </div>
                  </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</div>

