
<div id="header" class="header navbar-default">
   <!-- begin navbar-header -->
   <div class="navbar-header">
      <a href="<?php echo route('wingu.dashboard'); ?>" class="navbar-brand">
         <img src="<?php echo asset('assets/img/logo-black.png'); ?>" alt="winguPlus" class="logo">
      </a>
      <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
      </button>
      <?php
         $plan = Wingu::plan();
         $daysLeft = Helper::date_difference(Wingu::business()->due_date,date('Y-m-d'));
      ?>
      <a href="<?php echo route('settings.account.subscription'); ?>" class="btn btn-sm mt-2 btn-outline-black">
         <i class="fas fa-rocket-launch"></i> <b><?php echo $plan->title; ?></b>
         <?php if($daysLeft < 8): ?>
            ----
            <b><?php echo number_format(max($daysLeft,0)); ?> Days Left</b>
         <?php endif; ?>
      </a>
   </div>
   <!-- end navbar-header -->
   <!-- begin header-nav -->
   <ul class="navbar-nav navbar-right">
      
      

      
      <li>
         <a href="<?php echo route('winguplus.apps'); ?>" title="App Store">
            <i class="fad fa-flower-tulip f-s-22"></i>
         </a>
      </li>
      <li>
         <a href="#" data-toggle="modal" data-target="#rightSlideNotes">
            <i class="fad fa-sticky-note f-s-22"></i>
         </a>
      </li>
      <li class="dropdown">
         <a href="<?php echo route('wingu.dashboard'); ?>" class="dropdown-toggle">
            <i class="fad fa-chart-network f-s-22"></i>
         </a>
         
      </li>
      <li class="dropdown">
         
         <ul class="dropdown-menu media-list dropdown-menu-right">
            
            
            
            
         </ul>
      </li>
      <li class="dropdown navbar-user">
         <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
            <img src="https://ui-avatars.com/api/?name=<?php echo Auth::user()->name; ?>&rounded=true&size=70" alt="<?php echo Auth::user()->name; ?>">
            <span class="d-none d-md-inline"><?php echo Auth::user()->name; ?></span> <b class="caret"></b>
         </a>
         <div class="dropdown-menu dropdown-menu-right">
            <a href="<?php echo route('settings.business.index'); ?>" class="dropdown-item">
               <i class="fal fa-building"></i>
               <b><?php echo Wingu::business()->name; ?></b>
            </a>

            <div class="dropdown-divider"></div>
            <a href="<?php echo route('settings.business.index'); ?>" class="dropdown-item"><i class="fal fa-user-circle"></i> Edit Profile</a>
            <a href="<?php echo route('settings.business.edit'); ?>" class="dropdown-item"><i class="fal fa-tools"></i> Setting</a>
            
            <div class="dropdown-divider"></div>
            <a href="<?php echo url('logout'); ?>" class="dropdown-item"><i class="fal fa-sign-out"></i> Log Out</a>
         </div>
      </li>
   </ul>
   <!-- end header navigation right -->
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/partials/_header.blade.php ENDPATH**/ ?>