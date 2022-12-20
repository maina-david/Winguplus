<div class="form-group form-group-default">
   <label for="customer" class="text-danger">
      Choose Customer *
      <a href="" class="pull-right" data-toggle="modal" data-target="#addCustomer">Add Customer</a>
   </label>
   <select name="customer" class="form-control select2" required>
      @if($editCustomer=='True')
         <option value="{!! $customerCode !!}" selected>{!! Finance::client($customerCode)->customer_name !!}</option>
      @else
         <option value="">Choose customer</option>
      @endif
      @foreach($clients as $client)
         <option value="{!! $client->customer_code !!}">{!! $client->customer_name !!}</option>
      @endforeach
   </select>
</div>
