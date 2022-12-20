@extends('layouts.app')
@section('title','Subscription Product')
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
         <li class="breadcrumb-item active">List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shopping-basket"></i> Products</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
		<div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">Product list</h4>
         </div>
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="15%">Name</th>
                     <th width="15%">Code</th>
                     <th width="15%">Notification Address</th>
                     <th>Plans</th>
                     {{-- <th>Addons</th> --}}
                     <th width="12%">Created at</th>
                     <th width="20%">Actions</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($products as $product)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td>{!! $product->product_name !!}</td>
                        <td>{!! $product->sku_code !!}</td>
                        <td>{!! $product->notification_email !!}</td>
                        <td>{!! Subscription::count_plans_per_product($product->id) !!}</td>
                        {{-- <td>0</td> --}}
                        <td>{!! date('jS M,Y', strtotime($product->created_at)) !!}</td>
                        <td>
                           @permission('update-subscriptionproducts')
                              <a href="{!! route('subscriptions.products.edit',$product->id) !!}" class="btn btn-pink btn-sm"><i class="fas fa-edit"></i> Edit</a>
                           @endpermission
                           @permission('read-subscriptionplan')
                              <a href="{!! route('subscriptions.plan.index',$product->id) !!}" class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Plans</a>
                           @endpermission
                           @permission('delete-subscriptionproducts')
                              <a href="{!! route('subscriptions.products.delete',$product->id) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i> Delete</a>
                           @endpermission
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
		</div>
   </div>
@endsection
@section('scripts')

@endsection
