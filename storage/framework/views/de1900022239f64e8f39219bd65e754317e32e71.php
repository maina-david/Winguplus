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
               <i class="fas fa-list"></i> List view
            </button>
            <ul class="dropdown-menu" role="menu">
               <li><a href="<?php echo route('crm.leads.events',$code); ?>"><i class="fas fa-th-large"></i> Grid view</a></li>
            </ul>
         </div>
         <a href="#" class="btn btn-pink mt-3 mb-3 float-right" data-toggle="modal" data-target="#eventCreate"><i class="fas fa-calendar-plus"></i> Add Events</a>
      </div>
   </div>

   <div class="row mt-3">
      <div class="col-md-12">
         <table class="table table-striped mb-3">
            <thead>
               <th width="1%">#</th>
               <th>Title</th>
               <th>From</th>
               <th>To</th>
               <th>Host</th>
               <th>Status</th>
               <th></th>
            </thead>
            <tbody>
               <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if(Auth::user()->business_code == $event->business_code): ?>
                     <?php
                        $getEventCode = json_encode($event->event_code);
                     ?>
                     <tr>
                        <td><?php echo $count+1; ?></td>
                        <td>
                           <a wire:click="details(<?php echo e($getEventCode); ?>)" data-toggle="modal" data-target="#detail" href="#"><?php echo $event->event_name; ?></a><br>
                           <small><b>Meeting Type:</b> <?php echo ucfirst($event->meeting_type); ?></small>
                        </td>
                        <td><?php echo date("M jS, Y", strtotime($event->start_date)); ?> <?php if($event->start_time): ?>@ <?php echo $event->start_time; ?><?php endif; ?></td>
                        <td><?php echo date("M jS, Y", strtotime($event->end_date)); ?> <?php if($event->end_time): ?>@ <?php echo $event->end_time; ?><?php endif; ?></td>
                        <td>
                           <?php if($event->owner != ""): ?>
                              <?php echo Wingu::user($event->owner)->name; ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if($event->status): ?>
                              <?php
                                 $status = Wingu::status($event->status);
                              ?>
                              <span class="badge <?php echo $status->name; ?>"><?php echo $status->name; ?></span>
                           <?php endif; ?>
                        </td>
                        <td>
                           <a wire:click="edit(<?php echo e($getEventCode); ?>)" data-toggle="modal" data-target="#eventEdit" class="btn btn-sm btn-primary text-white">Edit</a>
                        </td>
                     </tr>
                  <?php endif; ?>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
         <?php echo $events->links('pagination.custom'); ?>

      </div>
   </div>

   <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crm.leads.events.create', ['leadCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('iwAmJRf')) {
    $componentId = $_instance->getRenderedChildComponentId('iwAmJRf');
    $componentTag = $_instance->getRenderedChildComponentTagName('iwAmJRf');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('iwAmJRf');
} else {
    $response = \Livewire\Livewire::mount('crm.leads.events.create', ['leadCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('iwAmJRf', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php if($this->eventCode): ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crm.leads.events.edit', ['eventCode'=>$this->eventCode])->html();
} elseif ($_instance->childHasBeenRendered('QzmN6NJ')) {
    $componentId = $_instance->getRenderedChildComponentId('QzmN6NJ');
    $componentTag = $_instance->getRenderedChildComponentTagName('QzmN6NJ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('QzmN6NJ');
} else {
    $response = \Livewire\Livewire::mount('crm.leads.events.edit', ['eventCode'=>$this->eventCode]);
    $html = $response->html();
    $_instance->logRenderedChild('QzmN6NJ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php endif; ?>
   <?php if($this->eventDetailCode): ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crm.leads.events.details', ['eventCode' => $eventDetailCode])->html();
} elseif ($_instance->childHasBeenRendered('DjNtZ53')) {
    $componentId = $_instance->getRenderedChildComponentId('DjNtZ53');
    $componentTag = $_instance->getRenderedChildComponentTagName('DjNtZ53');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('DjNtZ53');
} else {
    $response = \Livewire\Livewire::mount('crm.leads.events.details', ['eventCode' => $eventDetailCode]);
    $html = $response->html();
    $_instance->logRenderedChild('DjNtZ53', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   <?php endif; ?>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/livewire/crm/leads/events/list-view.blade.php ENDPATH**/ ?>