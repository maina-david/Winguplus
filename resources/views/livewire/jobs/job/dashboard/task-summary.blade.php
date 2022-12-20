<div wire:ignore class="col-md-6">
   <!--begin::Summary-->
   <div class="panel">
      <!--begin::Card header-->
      <div class="panel-heading">
         <div class="row">
            <div class="col-md-8">
               <h4>Task summary</h4>
            </div>
            <div class="col-md-4">
               {{-- <input type="date" wire:model="taskDate" class="form-control"> --}}
            </div>
         </div>
      </div>
      <!--end::Card header-->
      <!--begin::Card body-->
      <div class="panel-body">
         {!! $taskStatusSummary->container() !!}
      </div>
      <!--end::Card body-->
   </div>
   <!--end::Summary-->
   {!! $taskStatusSummary->script() !!}
</div>
