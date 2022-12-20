@extends('layouts.app')
@section('title','E-commerce | Dashboard')
@section('sidebar')
@include('app.ecommerce.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <div class="row">
         <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-blue">
               <div class="stats-icon stats-icon-lg"><i class="fa fa-dollar-sign fa-fw"></i></div>
               <div class="stats-content">
                  <div class="stats-title">Today's Sales</div>
                  <div class="stats-number">{!! $currency !!}{!! number_format($todaySales) !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="{!! route('sales.history') !!}" class="text-white">view sales</a></div>
               </div>
            </div>
         </div>
         <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-black">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-funnel-dollar"></i></div>
               <div class="stats-content">
                  <div class="stats-title">Sales This Month</div>
                  <div class="stats-number">{!! $currency !!}{!! number_format($monthSales) !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="{!! route('sales.history') !!}" class="text-white">view sales</a></div>
               </div>
            </div>
         </div>
         <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-green">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-badge-percent"></i></div>
               <div class="stats-content">
                  <div class="stats-title">AVERAGE SALE VALUE</div>
                  <div class="stats-number">{!! $currency !!}{!! number_format($averageSale) !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="{!! route('sales.history') !!}" class="text-white">view sales</a></div>
               </div>
            </div>
         </div>
         <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-indigo">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-shopping-basket"></i></div>
               <div class="stats-content">
                  <div class="stats-title">Products Sold this month</div>
                  <div class="stats-number">{!! number_format($itemsSold) !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="{!! route('sales.history') !!}" class="text-white">view sales</a></div>
               </div>
            </div>
         </div>
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <div id="chart-container"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end #content -->
@endsection
@section('scripts')
	<script src="{!! asset('assets/plugins/highcharts/highcharts.js') !!}"></script>
	<script>
		var datas = {!! json_encode($datas) !!}
		Highcharts.chart('chart-container',{
			title:{
				text:'Sales This year'
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
@endsection
