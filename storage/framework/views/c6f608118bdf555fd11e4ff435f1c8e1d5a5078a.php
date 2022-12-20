<?php $__env->startSection('title','Management Dashboard | Customer relationship management'); ?>
<?php $__env->startSection('stylesheet'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin row -->
      <div class="row">
         <div class="col-lg-3 col-md-3">
            <div class="widget widget-stats bg-gradient-teal">
               <div class="stats-icon stats-icon-lg"><i class="fas fa-badge-dollar"></i></div>
               <div class="stats-content">
                  <div class="stats-title font-bold text-white">Deals Created This Month</div>
                  <div class="stats-number">10</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">View Deals</div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-3">
            <div class="widget widget-stats bg-gradient-purple">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-usd-circle"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white font-bold">Revenue This Month</div>
                  <div class="stats-number">ksh 30,000</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc">View Revenue</div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-3">
            <div class="widget widget-stats bg-gradient-green">
               <div class="stats-icon stats-icon-lg"><i class="fas fa-handshake"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white font-bold"> Deals Closing This Month </div>
                  <div class="stats-number">10</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc text-white">View Deals</div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-3">
            <div class="widget widget-stats bg-gradient-red">
               <div class="stats-icon stats-icon-lg"><i class="fas fa-tasks"></i></div>
               <div class="stats-content">
                  <div class="stats-title font-bold text-white">Overdue Tasks</div>
                  <div class="stats-number">30</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc text-white">View Tasks</div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="card" style="height: 550px">
               <div class="card-header"> Last 4 Quarter Performance Overview</div>
               <div class="card-body">
                  <img src="<?php echo asset('assets/img/salestrendfuture.gif'); ?>" alt="" class="img-responsive" height="470px">
               </div>
            </div>
         </div>
         <div class="col-md-8">
            <div class="card" style="height: 550px">
               <div class="card-header">Anomaly In Leads Creation This Quarter</div>
               <div class="card-body">
                  <img src="<?php echo asset('assets/img/salestrend_anomalies.gif'); ?>" alt="" class="img-responsive" height="470px">
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="card" style="height: 550px">
               <div class="card-header">Leads By Source This Month</div>
               <div class="card-body">
                  <table class="table table-striped">
                     <tbody>
                        <tr>
                           <td width="1%">1.</td>
                           <td>Online Store</td>
                           <td>30</td>
                        </tr>
                        <tr>
                           <td width="1%">2.</td>
                           <td>Advertisement</td>
                           <td>10</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-8">
            <div class="card" style="height: 550px">
               <div class="card-header">Anomaly In Deals Closure Amount This Quarter </div>
               <div class="card-body">
                  <img src="<?php echo asset('assets/img/salestrend_anomalies.gif'); ?>" alt="" class="img-responsive" height="470px">
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="card" style="height: 550px">
               <div class="card-header">Pipeline By Stage</div>
               <div class="card-body">
                  <img src="<?php echo asset('assets/img/filter.png'); ?>" alt="" class="img-responsive">
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="card" style="height: 550px">
               <div class="card-header">Top 10 Open Deals This Month</div>
               <div class="card-body">
                  <table class="table table-striped">
                     <tr>
                        <td width="1%">1</td>
                        <td>Benton (Sample)</td>
                        <td>ksh 250,000,000</td>
                     </tr>
                     <tr>
                        <td width="1%">1</td>
                        <td>Chapman (Sample)</td>
                        <td>ksh 150,000,000</td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="card" style="height: 550px">
               <div class="card-header">Top 10 Closed Deals This Month </div>
               <div class="card-body">
                  <table class="table table-striped">
                     <tr>
                        <td width="1%">1</td>
                        <td>Benton (Sample)</td>
                        <td>ksh 250,000,000</td>
                     </tr>
                     <tr>
                        <td width="1%">1</td>
                        <td>Chapman (Sample)</td>
                        <td>ksh 150,000,000</td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="card" style="height: 550px">
               <div class="card-header">Big Deals Lost This Month</div>
               <div class="card-body">
                  <table class="table table-striped">
                     <tr>
                        <td width="1%">1</td>
                        <td>Benton (Sample)</td>
                        <td>ksh 250,000,000</td>
                     </tr>
                     <tr>
                        <td width="1%">1</td>
                        <td>Chapman (Sample)</td>
                        <td>ksh 150,000,000</td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="card" style="height: 550px">
               <div class="card-header">Top 20 Accounts By Revenue </div>
               <div class="card-body">
                  <table class="table table-striped">
                     <tr>
                        <td width="1%">1</td>
                        <td>Benton (Sample)</td>
                        <td>ksh 250,000,000</td>
                     </tr>
                     <tr>
                        <td width="1%">1</td>
                        <td>Chapman (Sample)</td>
                        <td>ksh 150,000,000</td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="card" style="height: 550px">
               <div class="card-header"> Pipeline By Reps This Quarter </div>
               <div class="card-body">
                  <table class="table table-striped">
                     <tr>
                        <td width="1%">1</td>
                        <td>John Doe</td>
                        <td>ksh 250,000,000</td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="card" style="height: 550px">
               <div class="card-header">Top 10 Reps By Revenue this Quarter </div>
               <div class="card-body">
                  <table class="table table-striped">
                     <tr>
                        <td width="1%">1</td>
                        <td>John Doe</td>
                        <td>ksh 250,000,000</td>
                        <td><span class="badge badge-primary">100%</span></span></td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="card" style="height: 550px">
               <div class="card-header">Top 10 Reps By Tasks This Month</div>
               <div class="card-body">
                  <table class="table table-striped">
                     <tr>
                        <td width="1%">1</td>
                        <td>John Doe</td>
                        <td>4</td>
                        <td><span class="badge badge-primary">100%</span></span></td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end #content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/dashboard/manager_dashboard.blade.php ENDPATH**/ ?>