<div div="row">
   <div class="col-md-12">
      <div class="row">
         <div class="col-md-7">
            <h4 class="font-weight-bold"><i class="fal fa-comments-alt"></i> Discussions</h4>
         </div>
         <div class="col-md-5">
            <input type="text" wire:model="search" class="form-control" placeholder="Search discussion">
         </div>
      </div>
   </div>
   <div class="row mt-3">
      <div class="col-md-7">
         <div class="blog-comment">
            <ul class="comments">
               @foreach($comments as $comment)
                  <li class="clearfix">
                     @if($comment->avatar)
                        <img src="{!! asset('businesses/'.Auth::user()->business_code.'/images/'.$comment->avatar) !!}" class="avatar" alt="{!! $comment->name !!}">
                     @else
                        <img src="https://ui-avatars.com/api/?name={!! $comment->name !!}&rounded=false&size=70" class="avatar" alt="{!! $comment->name !!}">
                     @endif
                     <div class="post-comments">
                        <p class="meta">
                           <b><a href="#">{!! $comment->name !!}</a></b>
                           | <i class="fal fa-clock-o"></i> {!! Helper::get_timeago(strtotime($comment->comment_date)) !!}
                           {{-- <i class="pull-right cursor action-collapse"><a data-toggle="collapse" aria-expanded="true" aria-controls="collapse{!! $comment->comment_code !!}" href="#collapse{!! $comment->comment_code !!}"><small>Reply</small></a></i> --}}
                        </p>
                        <p>{!! $comment->comment !!}</p>
                        <hr>
                        
                     </div>
                     {{-- <ul class="comments">
                        <div id="collapse{!! $comment->comment_code !!}" class="mb-3 collapse">
                           <div class="d-flex flex-row align-items-start">
                              @if(Auth::user()->avatar)
                                 <img src="{!! asset('businesses/'.Auth::user()->business_code.'/images/'.Auth::user()->avatar) !!}" alt="{!! Auth::user()->name !!}">
                              @else
                                 <img src="https://ui-avatars.com/api/?name={!! Auth::user()->name !!}&rounded=false&size=40"  alt="{!! Auth::user()->name !!}">
                              @endif
                              <textarea class="form-control ml-1" wire:model="reply" rows="4"></textarea>
                              <input type="text" wire:model="parent_comment" class="form-control" value="{!! $comment->comment_code !!}">
                              <input type="text" class="form-control" value="{!! $taskCode !!}">
                           </div>
                           <div class="mt-2 text-right">
                              <button class="btn btn-success btn-sm" type="button">Post Reply</button>
                           </div>
                        </div>
                        @foreach(Job::task_comment_replies($jobCode,$comment->comment_code) as $reply)
                           <li class="clearfix">
                              <img src="https://bootdey.com/img/Content/user_3.jpg" class="avatar" alt="">
                              <div class="post-comments">
                                 <p class="meta">
                                    Dec 20, 2014 <a href="#">JohnDoe</a>
                                    <i class="pull-right"><a href="#"><small>Reply</small></a></i>
                                 </p>
                                 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam a sapien odio, sit amet</p>
                              </div>
                           </li>
                        @endforeach
                     </ul> --}}
                  </li>
               @endforeach
            </ul>
         </div>
      </div>
      <div class="col-md-5">
         <div class="panel">
            <div class="panel-heading mb-0">
               <h4><i class="fal fa-comment-alt-plus"></i> Add Discussion</h4>
            </div>
            <div class="panel-body mt-0">
               <form action="{!! route('job.discussions.store') !!}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group mt-0">
                     <textarea name="comment" data-comment="@this" class="form-control" id="comment" rows="6"></textarea>
                     @error('comment')<span class="error text-danger">{{$message}}</span>@enderror
                  </div>
                  <div class="form-group">
                     <label for="customFile">Attach File</label><br>
                     <input type="text" name="file_title" class="form-control mb-2" placeholder="File title">
                     <input type="file" name="comment_files[]" class="form-control" multiple>
                  </div>
                  <input type="hidden" name="jobCode" value="{!! $jobCode !!}" required>
                  <button type="submit" class="btn btn-success submit mb-3" id="save_task"><i class="fas fa-save"></i> Post comment</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </form>
            </div>
         </div>
      </div>
   </div>
</div>


