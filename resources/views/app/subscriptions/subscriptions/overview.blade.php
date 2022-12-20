<div class="row mt-3">
   <!-- begin col-3 -->
   <div class="col-lg-3 col-md-6">
      <div class="widget widget-stats bg-gradient-teal">
         <div class="stats-icon stats-icon-lg"><i class="fal fa-dollar-sign fa-fw"></i></div>
         <div class="stats-content">
            <div class="stats-title text-white">Subscription Amount</div>
            <div class="stats-number">{!! $subscription->code !!} {!! number_format($subscription->amount) !!}</div>                    
            <div class="stats-desc text-white">Every {!! $subscription->bill_count !!} {!! $subscription->billing_period !!}(s)</div>
         </div>
      </div>
   </div>
   <!-- end col-3 -->
   <!-- begin col-3 -->
   @if($subscription->trial_days != "")
      <div class="col-lg-3 col-md-6">
         <div class="widget widget-stats bg-gradient-blue">
            <div class="stats-icon stats-icon-lg"><i class="fal fa-calendar-times fa-fw"></i></div>
            <div class="stats-content">
               <div class="stats-title text-white">Trial Expiry Date</div>
               <div class="stats-number">{!! date('jS M, Y', strtotime($subscription->trial_end_date)) !!}</div>
               <div class="stats-desc">.</div>
            </div>
         </div>
      </div>
   @endif
   <div class="col-lg-3 col-md-6">
      <div class="widget widget-stats bg-gradient-red">
         <div class="stats-icon stats-icon-lg"><i class="fal fa-calendar-day"></i></div>
         <div class="stats-content">
            <div class="stats-title text-white">Next Billing Date</div>
            <div class="stats-number">{!! date('jS M, Y', strtotime($subscription->next_billing)) !!}</div>
            <div class="stats-desc">.</div>
         </div>
      </div>
   </div>
   <!-- end col-3 -->
   <!-- begin col-3 -->
   <div class="col-lg-3 col-md-6">
      <div class="widget widget-stats bg-gradient-purple">
         <div class="stats-icon stats-icon-lg"><i class="fal fa-calendar-check "></i></div>
         <div class="stats-content">
            <div class="stats-title text-white">Activation Date</div>
            <div class="stats-number">{!! date('jS M, Y', strtotime($subscription->starts_on)) !!}</div>
            <div class="stats-desc">.</div>
         </div>
      </div>
   </div>
   <!-- end col-3 -->
   <!-- begin col-3 -->
   <div class="col-lg-3 col-md-6">
      <div class="widget widget-stats bg-gradient-black">
         <div class="stats-icon stats-icon-lg"><i class="fal fa-sync"></i></div>
         <div class="stats-content">
            <div class="stats-title text-white">Expiration cycle</div>
            <div class="stats-number">
               @if($subscription->expiration_cycle == 'never')
                  {!! $subscription->expiration_cycle !!}
               @else 
                  after {!! $subscription->cycles !!} cycles
               @endif                        
            </div>
            <div class="stats-desc">.</div>
         </div>
      </div>
   </div>
   <!-- end col-3 -->
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <table class="table table-striped table-bordered">
               <thead>
                  <th>Plan</th>
                  <th>Qty</th>
                  <th>Amount</th>
                  <th>Tax</th>
                  <th>Total</th>
               </thead>
               <tbody>
                  <tr>
                     <td>{!! $subscription->product_name !!}</td>
                     <td>{!! $subscription->qty !!}</td>
                     <td>{!! $subscription->code !!} {!! number_format($subscription->price) !!}</td>
                     <td>@if( $subscription->tax_rate != ""){!! $subscription->tax_rate !!}% @endif </td>
                     <td>{!! $subscription->code !!} {!! number_format($subscription->amount) !!}</td>
                  </tr>
                  <tr>
                     <td colspan="3"></td>
                     <td>Total</td>
                     <td>{!! $subscription->code !!} {!! number_format($subscription->amount) !!}</td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>