<div>
   <div class="row mt-3">
      <div class="col-md-4">
         <div class="form-group">
            <label for="">Search</label>
            <input type="text" class="form-control" placeholder="Search by meeting title" wire:model.debounce.500ms="search">
         </div>
      </div>
      <div class="col-md-2">
         <div class="form-group">
            <label for="">Filter by date</label>
            <input type="date" class="form-control" wire:model.debounce.500ms="date">
         </div>
      </div>
      <div class="col-md-6">
         <div class="btn-group mt-3 mb-3 ml-2 float-right">
            <button type="button" class="btn btn-outline-black dropdown-toggle mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-th-large"></i> Grid view
            </button>
            <ul class="dropdown-menu" role="menu">
               <li><a href="<?php echo route('crm.leads.events.list',$leadCode); ?>"><i class="fas fa-list"></i> List view</a></li>
            </ul>
         </div>
         <a href="#" class="btn btn-pink mt-3 mb-3 float-right"  data-toggle="modal" data-target="#eventCreate"><i class="fas fa-calendar-plus"></i> Add Events</a>
      </div>
   </div>

   <div class="row mt-3">
      <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <?php if(Auth::user()->business_code == $event->business_code): ?>
            <?php
               $getEventCode = json_encode($event->event_code);
            ?>
            <div class="col-md-4">
               <!-- begin widget-list -->
               <div class="widget-list widget-list-rounded mb-2">
                  <!-- begin widget-list-item -->
                  <div class="widget-list-item">
                     <div class="widget-list-content">
                        <h4 class="widget-list-title font-weight-bold"><a wire:click="details(<?php echo e($getEventCode); ?>)" data-toggle="modal" data-target="#detail" href="#"><?php echo $event->event_name; ?></a></h4>
                        <p class="widget-list-desc mt-1">
                           <b><i class="fal fa-calendar-check"></i> From:</b> <?php echo date("M jS, Y", strtotime($event->start_date)); ?> <b>@</b> <?php echo $event->start_time; ?><br>
                           <b><i class="fal fa-calendar-times"></i> To :</b> <?php echo date("M jS, Y", strtotime($event->end_date)); ?> <b>@</b> <?php echo $event->end_time; ?><br>
                           <b><i class="fal fa-calendar-plus"></i> Added :</b> <?php echo Helper::get_timeago(strtotime($event->created_at)); ?><br>
                           <b><i class="fal fa-exclamation-circle"></i> Status :</b> <?php if($event->status): ?><span class="badge <?php echo Wingu::status($event->status)->name; ?>"><?php echo ucfirst(Wingu::status($event->status)->name); ?></span><?php endif; ?><br>
                           <?php if($event->owner != ""): ?>
                              <b><i class="fal fa-user-crown"></i> Owner :</b>  <?php echo Wingu::user($event->owner)->name; ?>

                           <?php endif; ?>
                        </p>
                     </div>
                     <div class="widget-list-action">
                        <a href="#" data-toggle="dropdown" class="text-muted pull-right">
                        <i class="fa fa-ellipsis-h f-s-14"></i>
                        </a>
                        <?php
                           $getEventCode = json_encode($event->event_code);
                        ?>
                        <ul class="dropdown-menu dropdown-menu-right">
                           <li><a wire:click="edit(<?php echo e($getEventCode); ?>)" data-toggle="modal" data-target="#eventEdit" href="#">Edit</a></li>
                           
                        </ul>
                     </div>
                  </div>
                  <!-- end widget-list-item -->
               </div>
               <!-- end widget-list -->
            </div>
         <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <div class="col-md-12 mt-3">
         <?php echo $events->links('pagination.custom'); ?>

      </div>
   </div>

   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crm.leads.events.create', ['leadCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('AWGIMBG')) {
    $componentId = $_instance->getRenderedChildComponentId('AWGIMBG');
    $componentTag = $_instance->getRenderedChildComponentTagName('AWGIMBG');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('AWGIMBG');
} else {
    $response = \Livewire\Livewire::mount('crm.leads.events.create', ['leadCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('AWGIMBG', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php if($this->eventCode): ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crm.leads.events.edit', ['eventCode'=>$this->eventCode])->html();
} elseif ($_instance->childHasBeenRendered('YTvzO17')) {
    $componentId = $_instance->getRenderedChildComponentId('YTvzO17');
    $componentTag = $_instance->getRenderedChildComponentTagName('YTvzO17');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('YTvzO17');
} else {
    $response = \Livewire\Livewire::mount('crm.leads.events.edit', ['eventCode'=>$this->eventCode]);
    $html = $response->html();
    $_instance->logRenderedChild('YTvzO17', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php endif; ?>
   <?php if($this->eventDetailCode): ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crm.leads.events.details', ['eventCode' => $eventDetailCode])->html();
} elseif ($_instance->childHasBeenRendered('idUK6OF')) {
    $componentId = $_instance->getRenderedChildComponentId('idUK6OF');
    $componentTag = $_instance->getRenderedChildComponentTagName('idUK6OF');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('idUK6OF');
} else {
    $response = \Livewire\Livewire::mount('crm.leads.events.details', ['eventCode' => $eventDetailCode]);
    $html = $response->html();
    $_instance->logRenderedChild('idUK6OF', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php endif; ?>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/crm/leads/events/grid-view.blade.php ENDPATH**/ ?>