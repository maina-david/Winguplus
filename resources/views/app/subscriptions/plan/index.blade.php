@extends('layouts.app')
@section('title','Plans | Subscriptions')
@section('sidebar')
   @include('app.subscriptions.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('subscriptions.dashboard') !!}">Subscriptions</a></li>
         <li class="breadcrumb-item"><a href="{!! route('subscriptions.products.index') !!}">Products</a></li>
         <li class="breadcrumb-item active">Plan</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-file-alt"></i> {!! $product->product_name !!}</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">
            <!-- shop menu -->
         <div class="col-md-9">
            <div class="row mb-3">
               <div class="col-md-12">
                  {{-- <a href="#" class="btn btn-white float-right mr-2"> Add Addon</a> --}}
                  @permission('create-subscriptionplan')
                     <a href="{!! route('subscriptions.plan.create',$productID) !!}" class="btn btn-pink float-right mr-2"><i class="fas fa-plus"></i> Add Plan</a>
                  @endpermission
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">All Plans</h4>
               </div>
               <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th></th>
                           <th>Name</th>
                           <th width="12%">Code</th>
                           <th width="12%">Price</th>
                           <th width="15%">Created at</th>
                           <th width="19%">Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($plans as $plan)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td><img src="https://ui-avatars.com/api/?name={!!$plan->product_name !!}&rounded=false&size=32" alt=""></td>
                              <td>{!! $plan->product_name !!}</td>
                              <td>{!! $plan->sku_code !!}</td>
                              <td>{!! $plan->code !!} {!! number_format($plan->selling_price) !!}</td>
                              <td>{!! date('jS M,Y', strtotime($plan->panel_date)) !!}</td>
                              <td>
                                 @permission('update-subscriptionplan')
                                    <a href="{!! route('subscriptions.plan.edit', [$plan->panelID,$productID]) !!}" class="btn btn-pink btn-sm">
                                       <i class="fas fa-edit"></i> Edit
                                    </a>
                                 @endpermission
                                 @permission('delete-subscriptionplan')
                                    <a href="{!! route('subscriptions.plan.delete',$plan->panelID) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i> Delete</a>
                                 @endpermission
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
	<script>
      $(document).ready(function() {
         $('#sku').on('change', function() {
            if (this.value == 'Custom') {
               $('#custom-sku').show();
            }
            if (this.value == 'Auto') {
               $('#custom-sku').hide();
            }
         });
      });
   </script>
   <script src="{!! asset('assets/plugins/ckeditor/4/basic/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
