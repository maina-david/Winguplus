<div class="form-group form-group-default">
   <label for="end" class="text-danger">
      Income account *
      <a href="" class="pull-right" data-toggle="modal" data-target="#addIncomeCategory">Add Income Account</a>
      <span class="pull-right mr-1" data-toggle="tooltip" data-placement="top" title="This will help in categorising the invoice to specific income categories">
         <i class="fas fa-info-circle"></i>
      </span>
   </label>
   <select name="income_category" class="form-control select2" required>
      @if($editIncome)
         <option selected value="{{ $incomeCode }}">{!! Finance::income_category($incomeCode)->name !!}</option>
      @else
         <option value="">Choose category</option>
      @endif
      @foreach($incomeCategory as $category)
         <option value="{!! $category->category_code !!}">{!! $category->name !!}</option>
      @endforeach
   </select>
</div>
