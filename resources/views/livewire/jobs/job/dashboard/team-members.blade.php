<div class="col-md-6">
   <div class="panel">
      <div class="panel-heading mb-0">
         <h4>Team Members</h4>
      </div>
      <div class="panel-body">
         <div class="widget-list rounded">
            <div class="row">
               @foreach ($members as $member)
                  <div class="col-md-6 mb-3">
                     <div class="widget-list-item">
                        <div class="widget-list-media">
                           <img src="../assets/img/user/user-12.jpg" width="50" alt=""  />
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
