<div wire:ignore class="col-md-6">
   <div class="panel">
      <div class="panel-heading">
         <h4>Task per user</h4>
      </div>
      <div class="panel-body">
         {!! $tasksperuser->container() !!}
      </div>
   </div>
   {!! $tasksperuser->script() !!}
</div>
