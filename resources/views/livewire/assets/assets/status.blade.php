<div class="col-md-6">
   <div class="form-group form-group-default">
      <label for="">Status <a href="" class="float-right" data-toggle="modal" data-target="#addStatus">Add Status</a></label>
      {!! Form::select('status', $statuses, null, array('class' => 'form-control select2')) !!}
   </div>
</div>
