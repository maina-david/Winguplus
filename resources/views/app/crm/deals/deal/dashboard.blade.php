<div class="row mt-3">
   <div class="col-xl-3 col-md-6">
      <div class="widget widget-stats bg-blue">
         <div class="stats-icon"><i class="fas fa-phone"></i></div>
         <div class="stats-info">
            <h4>Call logs</h4>
            <p>{!! number_format($TotalCallLogs) !!}</p>
         </div>
         <div class="stats-link">
            <a href="{!! route('crm.deals.calllog.index',$deal->deal_code) !!}">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
         </div>
      </div>
   </div>
   <div class="col-xl-3 col-md-6">
      <div class="widget widget-stats bg-info">
         <div class="stats-icon"><i class="far fa-sticky-note"></i></div>
         <div class="stats-info">
            <h4>Notes</h4>
            <p>{!! number_format($TotalNotes) !!}</p>
         </div>
         <div class="stats-link">
            <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
         </div>
      </div>
   </div>
   <div class="col-xl-3 col-md-6">
      <div class="widget widget-stats bg-orange">
         <div class="stats-icon"><i class="fas fa-tasks"></i></div>
         <div class="stats-info">
            <h4>Tasks</h4>
            <p>{!! number_format($TotalTasks) !!}</p>
         </div>
         <div class="stats-link">
            <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
         </div>
      </div>
   </div>
   <div class="col-xl-3 col-md-6">
      <div class="widget widget-stats bg-red">
         <div class="stats-icon"><i class="fas fa-calendar-alt"></i></div>
         <div class="stats-info">
            <h4>Appointments</h4>
            <p>{!! number_format($TotalAppointments) !!}</p>
         </div>
         <div class="stats-link">
            <a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
         </div>
      </div>
   </div>
</div>
