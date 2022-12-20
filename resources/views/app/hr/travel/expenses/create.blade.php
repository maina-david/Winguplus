@extends('layouts.app')
{{-- page header --}}
@section('title','Travel Expenses | Human Resource')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{{ Nav::isRoute('hrm.dashboard') }}">Human resource</a></li>
         <li class="breadcrumb-item"><a href="{!! route('hrm.travel.index') !!}">Travel</a></li>
         <li class="breadcrumb-item"><a href="{!! route('hrm.travel.expenses') !!}">Expenses</a></li>
         <li class="breadcrumb-item active">Add Expenses</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-usd-circle"></i> Add Expenses</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <form action="{!! route('hrm.travel.expenses.store') !!}" method="POST" class="row" autocomplete="off" enctype="multipart/form-data">
         @csrf
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">Expense Details</div>
               <div class="panel-body">
                  <div class="form-group form-group-default">
                     <label for="" class="text-danger">Choose Travel</label>
                     <select name="travel" id="" class="from-control select2" required>
                        <option value="">Choose Travel</option>
                        @foreach($travels as $travel)
                           <option value="{!! $travel->travel_code !!}">
                              Place - {!! $travel->place_of_visit !!} | Date - {!! date('F d, Y', strtotime($travel->departure_date)) !!} | Client - {!! $travel->customer_name !!}
                           </option>
                        @endforeach
                     </select>
                  </div>
                  <div class="form-group form-group-default required">
                     {!! Form::label('Title', 'Title', array('class'=>'control-label text-danger')) !!}
                     {!! Form::text('expense_name', null, array('class' => 'form-control', 'placeholder' => 'Expense Title', 'required' =>'', 'autocomplete' => 'off' )) !!}
                  </div>
                  <div class="form-group form-group-default">
                     <label for="" class="text-danger">Choose Expense Category <a href="" class="pull-right" data-toggle="modal" data-target="#expenceCategory">Add category</a></label>
                     {!! Form::select('expense_category',$expenseCategory,null,['class'=>'form-control select2','required'=>'']) !!}
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">Expense Details</div>
               <div class="panel-body">
                  <div class="form-group form-group-default required">
                     {!! Form::label('Date', 'Date', array('class'=>'control-label text-danger')) !!}
                     {!! Form::date('date', null, array('class' => 'form-control', 'placeholder' => 'YYYY-MM-DD', 'required' =>'', 'autocomplete' => 'off')) !!}
                  </div>
                  <div class="form-group form-group-default required">
                     {!! Form::label('Choose status', 'Choose status', array('class'=>'control-label text-danger')) !!}
                     {{ Form::select('status', [''=>'Choose status','1'=>'Paid','2'=>'Unpaid','18'=>'Dept'], null, ['class' => 'form-control multiselect','required' =>'', 'autocomplete' => 'off'  ]) }}
                  </div>
                  <div class="form-group form-group-default">
                     <label for="">Choose Files</label>
                     <input type="file" name="files[]" id="files" multiple>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading">Expense Items</div>
               <div class="panel-body">
                  <table class="table table-bordered table-striped table-responsive" id="table">
                     <thead>
                        <th width="1%">#</th>
                        <th width="40%">Title</th>
                        <th width="20%">Quantity</th>
                        <th width="20%">Price</th>
                        <th>Total</th>
                     </thead>
                     <tbody>
                        <tr>
                           <td><input class="case" type="checkbox"/></td>
                           <td>
                              <div class="form-group">
                                 <textarea name="expense[]" class="form-control calculate" id="expense_1" cols="16" rows="2" required></textarea>
                              </div>
                           </td>
                           <td>
                              <div class="form-group">
                                 <input type="number" name="quantity[]" class="form-control calculate" id="quantity_1" placeholder="Enter Quantity" step="0.01" required>
                              </div>
                           </td>
                           <td>
                              <div class="form-group">
                                 <input type="number"  name="price[]" class="form-control calculate" id="price_1" placeholder="Enter Price" step="0.01" required>
                              </div>
                           </td>
                           <td>
                              <div class="form-group">
                                 <input type="number" class="form-control calculate lineSum" id="total_1" disabled>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                     <tfoot>
                        <tr>
                           <td colspan="2" class="col-md-12 col-lg-8"></td>
                           <td colspan="2" style="width:20%">
                              <h4 class="pull-right top10">Total Amount</h4>
                           </td>
                           <td colspan="3">
                              <h4 class="text-center">
                                 <input readonly value="0" placeholder="0" type="number" class="form-control" id="totalAmount" step="0.01">
                              </h4>
                           </td>
                        </tr>
                     </tfoot>
                  </table>
                  <div class="col-md-12">
                     <button class="btn btn-danger delete" type="button">- Delete</button>
                     <button class="btn btn-primary addmore" type="button">+ Add More</button>
                  </div>
               </div>
            </div>
         </div>
         <div class='col-md-12'>
            <button class="pull-right btn btn-success submit" type="submit"><i class="fal fa-save"></i> Save Expense</button>
            <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="pull-right submit-load none" alt="" width="10%">
         </div>
         <!-- end panel -->
      </form>
   </div>
   @include('app.finance.expense.category.express')
@endsection
@section('scripts')
   <script>
      //adds extra table rows
      var i=$('table tr').length;
      var no = 0;

      $(document).ready(function(){
         var x = 1;
         $(".addmore").click(function () {
            $("#table tbody tr:first").clone().find("input").each(function () {
            $(this).val('').attr({
               'id': function (_, id) {
                  return id + x
               }
            });
            }).end().appendTo("table");
            x++;
         });
      });

      //deletes the selected table rows
      $(".delete").on('click', function() {
         $('.case:checkbox:checked').parents("tr").remove();
         $('#check_all').prop("checked", false);
         calculateTotal();
      });

      //calculate amount
      $(document).on('keyup','.calculate',function(){
         id_arr = $(this).attr('id');
         id = id_arr.split("_");

         quantity = $('#quantity_'+id[1]).val();
         price = $('#price_'+id[1]).val();
         amount = price * quantity;

         $('#total_'+id[1]).val(amount);
         calculateTotal();
      });

      //total price calculation
      function calculateTotal(){
         mainTotal = 0;

         //main total
         $('.lineSum').each(function(){
            if($(this).val() != '' )
            mainTotal += parseFloat($(this).val() );
            mainTotal = mainTotal;
         });
         $('#totalAmount').val(mainTotal.toFixed(2));
      }
   </script>
   @include('app.partials._express_scripts')
@endsection
