<div>
   <div class="card">
      <div class="card-body">
         <table class="table table-striped table-bordered">
            <thead>
               <th width="1%">#</th>
               <th>Title</th>
               <th>Start Date</th>
               <th>End Date</th>
               {{-- <th>Status</th> --}}
               <th width="13%">Action</th>
            </thead>
            <tbody>
               @foreach ($events as $count=>$event)
                  <tr>
                     <td>{!! $count+1 !!}</td>
                     <td>{!! $event->title !!}</td>
                     <td>{!! $event->start_date !!}</td>
                     <td>{!! $event->end_date !!}</td>
                     {{-- <td>{!! $event->status !!}</td> --}}
                     <td>
                        <a href="{!! route('hrm.events.edit',$event->event_code) !!}" class="btn btn-sm btn-primary">Edit</a>
                        <a href="{!! route('hrm.events.delete',$event->event_code) !!}" class="btn btn-sm btn-danger delete">Delete</a>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
