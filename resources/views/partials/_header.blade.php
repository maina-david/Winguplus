
<div id="header" class="header navbar-default">
   <!-- begin navbar-header -->
   <div class="navbar-header">
      <a href="{!! route('wingu.dashboard') !!}" class="navbar-brand">
         <img src="{!! asset('assets/img/logo-black.png') !!}" alt="winguPlus" class="logo">
      </a>
      <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
      </button>
      @php
         $plan = Wingu::plan();
         $daysLeft = Helper::date_difference(Wingu::business()->due_date,date('Y-m-d'));
      @endphp
      <a href="{!! route('settings.account.subscription') !!}" class="btn btn-sm mt-2 btn-outline-black">
         <i class="fas fa-rocket-launch"></i> <b>{!! $plan->title !!}</b>
         @if($daysLeft < 8)
            ----
            <b>{!! number_format(max($daysLeft,0)) !!} Days Left</b>
         @endif
      </a>
   </div>
   <!-- end navbar-header -->
   <!-- begin header-nav -->
   <ul class="navbar-nav navbar-right">
      {{-- @if(Wingu::business()->plan == 1)
         <li><a href="{!! route('account.plan') !!}" class="btn btn-sm text-danger"><i class="fal fa-engine-warning"></i> Upgrade</a></li>
      @endif --}}
      {{-- <li>
         <form class="navbar-form">
            <div class="form-group">
               <input type="text" class="form-control" placeholder="Enter keyword" />
               <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
            </div>
         </form>
      </li> --}}

      {{-- <li>
         <a href="{!! route('task.all.user.incomplete', Auth::user()->id) !!}" class="f-s-14">
            <i class="fas fa-tasks"></i>
            <span class="label">{!! prm::count_incomplete_tasks_per_user() !!}</span>
         </a>
      </li> --}}
      <li>
         <a href="{!! route('winguplus.apps') !!}" title="App Store">
            <i class="fad fa-flower-tulip f-s-22"></i>
         </a>
      </li>
      <li>
         <a href="#" data-toggle="modal" data-target="#rightSlideNotes">
            <i class="fad fa-sticky-note f-s-22"></i>
         </a>
      </li>
      <li class="dropdown">
         <a href="{!! route('wingu.dashboard') !!}" class="dropdown-toggle">
            <i class="fad fa-chart-network f-s-22"></i>
         </a>
         {{-- <div class="dropdown-menu dropdown-menu-right">
            <a href="{!! route('account.plan') !!}" class="dropdown-item"><b><i class="fal fa-rocket-launch"></i> Upgrade</b></a>
         </div> --}}
      </li>
      <li class="dropdown">
         {{-- <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
            <i class="fa fa-bell"></i>
            <span class="label">{!! prm::count_all_incomplete() !!}</span>
         </a> --}}
         <ul class="dropdown-menu media-list dropdown-menu-right">
            {{-- <li class="dropdown-header">NOTIFICATIONS ({!! Prm::count_all_incomplete() !!})</li> --}}
            {{-- <li class="media">
               <a href="javascript:;">
                  <div class="media-left">
                     <i class="fa fa-bug media-object bg-silver-darker"></i>
                  </div>
                  <div class="media-body">
                     <h6 class="media-heading">Server Error Reports <i class="fa fa-exclamation-circle text-danger"></i></h6>
                     <div class="text-muted f-s-11">3 minutes ago</div>
                  </div>
               </a>
            </li>
            <li class="media">
               <a href="javascript:;">
                  <div class="media-left">
                     <img src="https://seantheme.com/color-admin/admin/assets/img/user/user-1.jpg" class="media-object" alt="" />
                     <i class="fab fa-facebook-messenger text-primary media-object-icon"></i>
                  </div>
                  <div class="media-body">
                     <h6 class="media-heading">John Smith</h6>
                     <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                     <div class="text-muted f-s-11">25 minutes ago</div>
                  </div>
               </a>
            </li>
            <li class="media">
               <a href="javascript:;">
                  <div class="media-left">
                     <img src="https://seantheme.com/color-admin/admin/assets/img/user/user-2.jpg" class="media-object" alt="" />
                     <i class="fab fa-facebook-messenger text-primary media-object-icon"></i>
                  </div>
                  <div class="media-body">
                     <h6 class="media-heading">Olivia</h6>
                     <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                     <div class="text-muted f-s-11">35 minutes ago</div>
                  </div>
               </a>
            </li> --}}
            {{-- @if(prm::count_all_incomplete() > 0)
               <li class="media">
                  <a href="{!! route('task.all.incomplete') !!}">
                     <div class="media-left">
                        <i class="fas fa-tasks media-object bg-silver-darker"></i>
                     </div>
                     <div class="media-body">
                        <h6 class="media-heading"> Total incomplete tasks</h6>
                        <div class="text-muted f-s-11">{!! prm::count_all_incomplete() !!}</div>
                     </div>
                  </a>
               </li>
            @endif --}}
            {{-- <li class="media">
               <a href="javascript:;">
                  <div class="media-left">
                     <i class="fa fa-envelope media-object bg-silver-darker"></i>
                     <i class="fab fa-google text-warning media-object-icon f-s-14"></i>
                  </div>
                  <div class="media-body">
                     <h6 class="media-heading"> New Email From John</h6>
                     <div class="text-muted f-s-11">2 hour ago</div>
                  </div>
               </a>
            </li> --}}
         </ul>
      </li>
      <li class="dropdown navbar-user">
         <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
            <img src="https://ui-avatars.com/api/?name={!! Auth::user()->name !!}&rounded=true&size=70" alt="{!!Auth::user()->name !!}">
            <span class="d-none d-md-inline">{!! Auth::user()->name !!}</span> <b class="caret"></b>
         </a>
         <div class="dropdown-menu dropdown-menu-right">
            <a href="{!! route('settings.business.index') !!}" class="dropdown-item">
               <i class="fal fa-building"></i>
               <b>{!! Wingu::business()->name !!}</b>
            </a>

            <div class="dropdown-divider"></div>
            <a href="{!! route('settings.business.index') !!}" class="dropdown-item"><i class="fal fa-user-circle"></i> Edit Profile</a>
            <a href="{!! route('settings.business.edit') !!}" class="dropdown-item"><i class="fal fa-tools"></i> Setting</a>
            {{-- <a href="{!! route('settings.applications') !!}" class="dropdown-item"><i class="fal fa-gem"></i> Market Place</a> --}}
            <div class="dropdown-divider"></div>
            <a href="{!! url('logout') !!}" class="dropdown-item"><i class="fal fa-sign-out"></i> Log Out</a>
         </div>
      </li>
   </ul>
   <!-- end header navigation right -->
</div>
