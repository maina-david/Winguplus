<div wire:ignore class="col-md-12">
   <div class="panel">
      <div class="panel-heading">
         <h4>Task completed over time </h4>
      </div>
      <div class="panel-body">
         {!! $taskovertime->container() !!}
      </div>
   </div>
   {!! $taskovertime->script() !!}
</div>
