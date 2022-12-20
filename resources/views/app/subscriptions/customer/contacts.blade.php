<div class="card">
   <div class="card-body">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <tr>
            <th>#</th>
            <th>Names</th>
            <th>Email Address</th>
            <th>Work Phone</th>
            <th>Mobile</th>
            <th>Skype Name/Number</th>
            <th>Designation</th>
            <th>Department</th>
            <th>Action</th>
         </tr>
         @foreach ($contacts as $v => $cp)
            <tr>
               <td>{{ $v+1 }}</td>
               <td>{!! $cp->names !!}</td>
               <td>{!! $cp->contact_email !!}</td>
               <td>{!! $cp->work_phone !!}</td>
               <td>{!! $cp->mobile_phone !!}</td>
               <td>{!! $cp->skype_id !!}</td>
               <td>{!! $cp->designation !!}</td>
               <td>{!! $cp->department !!}</td>
               <td colspan="" rowspan="" headers="">
                  <div class="btn-group sm-m-t-10">
                     <a class="btn btn-danger" href="{{ route('finance.contactperson.delete',$cp->id) }}"><i class="fas fa-trash-alt"></i></a>
                  </div>
               </td>
            </tr>
         @endforeach
      </table>
   </div>
</div>
