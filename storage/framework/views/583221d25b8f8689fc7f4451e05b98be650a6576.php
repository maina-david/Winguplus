<div class="row mb-2">
   <div class="col-md-12">
      <ul class="nav nav-pills">
         <li class="nav-item"><a href="<?php echo route('events.show',$code); ?>" class="nav-link <?php echo Nav::isResource('details'); ?>"><i class="fal fa-analytics"></i> Overview</a></li>
         <?php if($event->type == 'Paid'): ?>
         <li class="nav-item"><a href="<?php echo route('events.ticket.sold',$code); ?>" class="nav-link <?php echo Nav::isResource('sold'); ?>"><i class="fal fa-usd-circle"></i> Tickets sold</a></li>
         <?php endif; ?>
         <li class="nav-item"><a href="<?php echo route('events.attendance',$code); ?>" class="nav-link <?php echo Nav::isResource('attendance'); ?>"><i class="fal fa-users"></i> Attendance</a></li>
         <li class="nav-item"><a href="<?php echo route('events.speakers',$code); ?>" class="nav-link <?php echo Nav::isResource('speakers'); ?>"><i class="fal fa-podium-star"></i> Speakers</a></li>
         <li class="nav-item"><a href="<?php echo route('events.sponsors',$code); ?>" class="nav-link <?php echo Nav::isResource('sponsors'); ?>"><i class="fal fa-tags"></i> Sponsors/Partners</a></li>
         <li class="nav-item"><a href="<?php echo route('events.tickets',$code); ?>" class="nav-link <?php echo Nav::isResource('tickets'); ?>"><i class="fal fa-ticket-alt"></i> Tickets</a></li>
         <li class="nav-item"><a href="<?php echo route('events.schedules',$code); ?>" class="nav-link <?php echo Nav::isResource('schedules'); ?>"><i class="fal fa-clipboard-list-check"></i> Schedules</a></li>
         <li class="nav-item"><a href="<?php echo route('events.edit',$code); ?>" class="nav-link <?php echo Nav::isResource('edit'); ?>"><i class="fal fa-edit"></i> Edit Event</a></li>
      </ul>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/events/events/_menu.blade.php ENDPATH**/ ?>