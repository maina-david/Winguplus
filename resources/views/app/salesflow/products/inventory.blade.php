@extends('layouts.app')
{{-- page header --}}
@section('title','Product Inventory | Finance')

{{-- dashboard menu --}}
@section('sidebar')
	@include('app.salesflow.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="#">Sales Flow</a></li>
      <li class="breadcrumb-item"><a href="#">Products</a></li>
      <li class="breadcrumb-item active">Product Inventory</li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-inventory"></i> Product Inventory | {!! $product->product_name !!}</h1>
   <!-- end page-header -->
   @include('partials._messages')
   <div class="row">
      @include('app.salesflow.partials._shop_menu')
      <div class="col-md-9">
         <div class="panel panel-default">
            <div class="panel-body">
               <div class="col-md-12 mt-3">
                  {!! Form::model($product, ['route' => ['salesflow.inventory.settings.update',$productCode],'class' => 'row', 'method'=>'post','enctype'=>'multipart/form-data']) !!}
                     @csrf
                     <div class="col-md-6">
                        <h5 class="font-bold">Track inventory for this product</h5>
                        <p>Would you like WinguPlus to track inventory movement for this product?</p>
                        <div class="form-group required">
                           {!! Form::select('track_inventory',[''=>'Choose','Yes' => 'Yes','No' => 'No'],null,['class' => 'form-control multiselect']) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <h5 class="font-bold">Use the same retail price for all outlets</h5>
                        <p class="mb-4">Using one retail price for all outlets? </p>
                        <div class="form-group required">
                           {!! Form::select('same_price',['Yes' => 'Yes','No' => 'No'],null,['class' => 'form-control multiselect']) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <button type="submit" class="btn btn-success float-left"><i class="fas fa-save"></i> Update</button>
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
         @if($product->track_inventory == "Yes")
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title mb-1">Inventory
                     <a href="#" class="pull-right badge badge-primary text-white" data-toggle="modal" data-target="#exampleModal">Link to outlet</a>
                  </h4>
               </div>
               <div class="panel-body">
                  <div class="col-md-12 mt-3">
                     <div class="row">
                        <div class="col-md-12">
                           <table class="table table-striped">
                              <thead>
                                 <th width="25%">Out Let</th>
                                 <th>Available stock</th>
                                 <th>Reorder point</th>
                                 <th>Reorder Qty</th>
                                 <th>Expiration Date</th>
                                 <th width="13%"></th>
                              </thead>
                              <tbody>
                                 @foreach($inventories as $inventory)
                                    <form action="{!! route('salesflow.products.inventory.update',[$inventory->id,$productCode]) !!}" method="POST" >
                                       @csrf
                                       <tr>
                                          <td>
                                             @if($inventory->default_inventory == 'Yes')
                                                {!! $mainBranch->name !!}
                                             @else
                                                @if(Hr::check_branch($inventory->branch_code) == 1)
                                                   {!! Hr::branch($inventory->branch_code)->name !!}
                                                @endif
                                             @endif
                                          </td>
                                          <td><input type="text" class="form-control" name="current_stock" value="{!! $inventory->current_stock !!}"></td>
                                          <td><input type="text" class="form-control" name="reorder_point" value="{!! $inventory->reorder_point !!}"> </td>
                                          <td><input type="text" class="form-control" name="reorder_qty" value="{!! $inventory->reorder_qty !!}"> </td>
                                          <td><input type="date" class="form-control" name="expiration_date" value="{!! $inventory->expiration_date !!}"> </td>
                                          <td>
                                             <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                             @if($inventory->default_inventory != 'Yes')
                                                @if(Hr::check_branch($inventory->branch_code) == 1)
                                                   <a href="{!! route('finance.inventory.outlet.link.delete',[$productCode,$inventory->branch_code]) !!}" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></a>
                                                @endif
                                             @endif
                                          </td>
                                       </tr>
                                    </form>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         @endif
      </div>
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Outlet </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="{!! route('finance.inventory.outlet.link') !!}" method="post" enctype="multipart/form-data">
               @csrf
               <div class="form-group">
                  <label for="">Choose Outlet</label>
                  <select name="outlets[]" id="" class="form-control" multiple required style="width:100%">
                     @foreach($outlets as $outlet)
                        @if($mainBranch->code != $outlet->code)
                           <option value="{!! $outlet->code !!}">{!! $outlet->branch_name !!}</option>
                        @endif
                     @endforeach
                  </select>
                  <input type="hidden" name="productCode" value="{!! $productCode !!}" required>
               </div>
               <div class="form-group">
                  <center><button class="btn btn-success btn-sm">Add Outlets</button></center>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
