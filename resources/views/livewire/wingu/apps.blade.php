<div class="container">
   <div class="py-5 text-center">
     <h2 class="text-center">Select the perfect applications for your business.</h2>
   </div>
   <div class="row">
      <div class="col-md-4 order-md-2 mb-4">
         <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Selected Applications</span>
            <span class="badge badge-pink badge-pill">{!!  number_format($cart->sum('qty')) !!}</span>
         </h4>
         <form action="{!! route('winguplus.apps.install') !!}" method="post">
            @csrf
            <ul class="list-group mb-3">
               @foreach($cart as $item)
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                     <div>
                        <h6 class="my-0">{!! $item->module_name !!}</h6>
                        <small class="text-muted"><i>{!! $item->description !!}</i></small><br>
                        <a href="#" wire:click="confirm_remove({{$item->id}})" data-toggle="modal" data-target="#delete"><span class="badge badge-danger">Remove</span></a>
                     </div>
                     <span class="text-muted">${!! $item->price !!}/Mo</span>
                  </li>
               @endforeach
               {{-- <li class="list-group-item d-flex justify-content-between bg-light">
                  <div class="text-success">
                     <h6 class="my-0">Promo code</h6>
                     <small>EXAMPLECODE</small>
                  </div>
                  <span class="text-success">-$5</span>
               </li> --}}
               <li class="list-group-item d-flex justify-content-between">
                  <span>Amount (USD)</span>
                  <strong>${!!  number_format($cart->sum('total_amount')) !!}/Mo</strong>
               </li>
               <li class="list-group-item d-flex justify-content-between">
                  <span class="text-pink">Trial Discount (USD)</span>
                  <strong class="text-pink">${!!  number_format($cart->sum('total_amount')) !!}/Mo</strong>
               </li>
               <li class="list-group-item d-flex justify-content-between">
                  <span>Total (USD)</span>
                  <strong>$0/Mo</strong>
               </li>
            </ul>
            {{-- <div class="card p-2">
               <div class="input-group">
                  <input type="text" class="form-control" placeholder="Promo code">
                  <div class="input-group-append">
                     <button type="submit" class="btn btn-secondary">Redeem</button>
                  </div>
               </div>
            </div> --}}
            <div class="card">
               <div class="card-body">
                  <button class="btn btn-primary btn-lg btn-block mt-2 submit" type="submit">Install Applications</button>
                  <center><img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="45%"></center>
               </div>
            </div>
         </form>
      </div>
      <div class="col-md-8 order-md-1">
         <h4 class="mb-3">Applications</h4>
         <div class="row">
            @foreach($applications as $app)
               @if($app->module_code != 'settings')
                  @if(Wingu::check_business_modules($app->module_code) != 1)
                     <div class="col-md-4">
                        <div class="card">
                           <div class="card-body text-center">
                              {!! $app->icon !!}
                              <p class="mt-1">{!! $app->name !!}</p>
                           </div>
                           <div class="card-footer">
                              <div class="row">
                                 <div class="col-md-6">
                                    <h4 class="font-weight-bold text-pink">${!! number_format($app->price) !!}/Mo</h4>
                                 </div>
                                 <div class="col-md-6">
                                    @php
                                       $appCode = json_encode($app->module_code);
                                    @endphp
                                    @if($app->status == 15)
                                       <a wire:click="add_to_cart({{$appCode}})" class="btn btn-sm btn-success float-right" href="#"><i class="fal fa-plus-circle"></i></a>
                                    @endif
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  @endif
               @endif
            @endforeach
         </div>
      </div>
   </div>

   <!-- delete modal -->
   <div wire:ignore.self id="delete" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-confirm">
         <div class="modal-content">
            <div class="modal-header flex-column">
               <div class="icon-box">
                  <i class="fal fa-times"></i>
               </div>
               <h4 class="modal-title w-100">Are you sure?</h4>
            </div>
            <div class="modal-body">
               <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
               <button type="button" class="btn btn-secondary" wire:click="close()">Cancel</button>
               <button type="button" class="btn btn-danger" wire:click="remove_cart()">Delete</button>
            </div>
         </div>
      </div>
   </div>

</div>
