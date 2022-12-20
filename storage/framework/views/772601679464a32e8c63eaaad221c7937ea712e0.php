<?php $__env->startSection('title','Dashboard | Finance'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- begin #content -->
<div id="content" class="content">
   <form class="row mb-2" action="<?php echo route('finance.index'); ?>" method="GET">
      <div class="col-md-7">

      </div>
      <div class="col-md-2">
         <div class="form-group">
            <?php
               $currentYear = date("Y");
            ?>
            <select name="year" class="form-control select2">
               <?php if($year): ?>
                  <option value="<?php echo $year; ?>" selected><?php echo $year; ?></option>
               <?php endif; ?>
               <option value="<?php echo $currentYear; ?>"><?php echo $currentYear; ?></option>
               <option value="<?php echo $currentYear-1; ?>"><?php echo $currentYear-1; ?></option>
               <option value="<?php echo $currentYear-2; ?>"><?php echo $currentYear-2; ?></option>
               <option value="<?php echo $currentYear-3; ?>"><?php echo $currentYear-3; ?></option>
               <option value="<?php echo $currentYear-4; ?>"><?php echo $currentYear-4; ?></option>
               <option value="<?php echo $currentYear-5; ?>"><?php echo $currentYear-5; ?></option>
            </select>
         </div>
      </div>
      <div class="col-md-2">
         <div class="form-group">
            <?php
               $currentMonth = date("m");
               $currentMonthName = date("F");
            ?>
            <select name="month" class="form-control select2">
               <option value="">All Months</option>
               <?php if($month): ?>
                  <option value="<?php echo $month; ?>" selected><?php echo $monthName; ?></option>
               <?php else: ?>
                  <option value="<?php echo $currentMonth; ?>" selected><?php echo $currentMonthName; ?></option>
               <?php endif; ?>
               <option value="01">January</option>
               <option value="02">February</option>
               <option value="03">March</option>
               <option value="04">April</option>
               <option value="05">May</option>
               <option value="06">June</option>
               <option value="07">July</option>
               <option value="08">August</option>
               <option value="09">September</option>
               <option value="10">October</option>
               <option value="11">November</option>
               <option value="12">December</option>
            </select>
         </div>
      </div>
      <div class="col-md-1">
         <button class="btn btn-success btn-block float-right" type="submit">Apply</button>
      </div>
   </form>
   <div class="row">
      <!-- begin col-3 -->
      <div class="col-lg-3 col-md-6">
         <div class="widget widget-stats bg-gradient-teal">
            <div class="stats-icon stats-icon-lg"><i class="fas fa-file-invoice-dollar"></i></div>
            <div class="stats-content">
               <div class="stats-title text-white font-bold">Due invoices</div>
               <div class="stats-number"><?php echo $dueInvoicesCount; ?></div>
               <div class="stats-progress progress">
                  <div class="progress-bar" style="width: 100%;"></div>
               </div>
               <div class="stats-desc"><a href="<?php echo route('finance.invoice.due'); ?>" class="text-white"> View Invoice </a></div>
            </div>
         </div>
      </div>
      <!-- end col-3 -->
      <!-- begin col-3 -->
      <div class="col-lg-3 col-md-6">
         <div class="widget widget-stats bg-gradient-blue">
            <div class="stats-icon stats-icon-lg"><i class="fal fa-funnel-dollar"></i></div>
            <div class="stats-content">
               <div class="stats-title text-white font-bold">Sales this month</div>
               <div class="stats-number"><?php echo $currency; ?><?php echo number_format($monthTotalSales); ?></div>
               <div class="stats-progress progress">
                  <div class="progress-bar" style="width: 100%;"></div>
               </div>
               <div class="stats-desc"><a href="<?php echo route('finance.invoice.index'); ?>" class="text-white">View sales</a></div>
            </div>
         </div>
      </div>
      <!-- end col-3 -->
      <!-- begin col-3 -->
      <div class="col-lg-3 col-md-6">
         <div class="widget widget-stats bg-gradient-purple">
            <div class="stats-icon stats-icon-lg"><i class="fal fa-credit-card"></i></div>
            <div class="stats-content">
               <div class="stats-title text-white font-bold">Expenses this month</div>
               <div class="stats-number"><?php echo $currency; ?><?php echo number_format($expensesThisMonth); ?></div>
               <div class="stats-progress progress">
                  <div class="progress-bar" style="width: 100%;"></div>
               </div>
               <div class="stats-desc"><a href="<?php echo route('finance.expense.index'); ?>" class="text-white">View Expenses</a></div>
            </div>
         </div>
      </div>
      <!-- end col-3 -->
      <!-- begin col-3 -->
      <div class="col-lg-3 col-md-6">
         <div class="widget widget-stats bg-gradient-black">
            <div class="stats-icon stats-icon-lg"><i class="fal fa-chart-line fa-fw"></i></div>
            <div class="stats-content">
               <div class="stats-title text-white font-bold">Profit this month</div>
               <div class="stats-number"><?php echo $currency; ?><?php echo number_format($monthTotalSales - $expensesThisMonth); ?></div>
               <div class="stats-progress progress">
                  <div class="progress-bar" style="width: 100%;"></div>
               </div>
               <?php
                  $lastDayOfMonth = \Carbon\Carbon::now()->endOfMonth()->toDateString();
                  $firstDate = \Carbon\Carbon::now()->startOfMonth()->toDateString();
               ?>
               <div class="stats-desc">
                  <a href="<?php echo url('/'); ?>/finance/report/profilandloss?from=<?php echo $firstDate; ?>&to=<?php echo $lastDayOfMonth; ?>" class="text-white">View profits</a>
               </div>
            </div>
         </div>
      </div>
      <!-- end col-3 -->
   </div>
   <div class="row">
      <div class="col-md-6">
         <div class="card">
            <div class="card-header">Sales Overview</div>
            <div class="card-body">
               <div id="chart-container"></div>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card">
            <div class="card-header">Expense Overview</div>
            <div class="card-body">
               <?php echo $expenseOverview->container(); ?>

            </div>
         </div>
      </div>
      
      
      
      
      
      

      <div class="col-md-6">
         <div class="row">
            <div class="col-md-6">
               <div class="card">
                  <div class="card-body" style="height: 100px;">
                     <h3 class="text-center"><i class="fal fa-bell-on"></i> <?php echo $stockAlert; ?> stock alarm</h3>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="card">
                  <div class="card-body" style="height: 100px;">
                     <h3 class="text-center"><i class="fal fa-exclamation-circle"></i> <?php echo e($withNoStock); ?> Products have no stock</h3>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="card">
                  <div class="card-body" style="height: 100px;">
                     <h3 class="text-center"><i class="fal fa-boxes-alt"></i> <?php echo $products->count(); ?> Total Products</h3>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="card">
                  <div class="card-body" style="height: 100px;">
                     <h3 class="text-center"><i class="fal fa-inventory"></i> <?php echo $products->sum('current_stock'); ?> Current stock</h3>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end #content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script>
		var datas = <?php echo json_encode($salesOverviewData); ?>

		Highcharts.chart('chart-container',{
			title:{
				text:'Sales Overview'
			},
			xAxis:{
				categories:['Jan','Feb','Mar','Apr','May','Jun','July','Aug','Sep','Oct','Nov','Dec']
			},
			yAxis:{
				title:{
					text:'Total Sales per month'
				}
			},
			legend:{
				layouts:'Vertical',
				align:'right',
				verticalAlign:'middle'
			},
			plotOptions:{
				series:{
					allowPointSelect:true
				}
			},
			series:[{
				name:'sales',
				data:datas
			}],
			responsive:{
				rules:[
					{
						condition:{
							maxWidth:500
						},
						chartOptions:{
							legend:{
								layout:'horizontal',
								align:'center',
								verticalAlign:'bottom'
							}
						}
					}
				]
			}
		})
	</script>
   <?php echo $expenseOverview->script(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/dashboard/dashboard.blade.php ENDPATH**/ ?>