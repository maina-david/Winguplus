<div class="col-md-6">
   <div class="form-group form-group-default">
      <label for="">Department <a href="" class="float-right" data-toggle="modal" data-target="#addDepartment">Add Department</a></label>
      <select name="department" class="form-control select2">
         @foreach($departments as $department)
            <option value="{!! $department->department_code !!}">{!! $department->title !!}</option>
         @endforeach
      </select>
   </div>
</div>
