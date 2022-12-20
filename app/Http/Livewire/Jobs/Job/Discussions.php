<?php

namespace App\Http\Livewire\Jobs\Job;

use App\Models\jobs\comments;
use Livewire\Component;

class Discussions extends Component
{
   public $jobCode;
   public $search;

   public function render()
   {
      $query = comments::join('wp_users','wp_users.user_code','=','jb_comments.created_by')
                              ->where('job',$this->jobCode);
                              if($this->search){
                                 $query->where('comment','like','%'.$this->search.'%');
                              }

      $comments = $query->orderby('jb_comments.id','desc')
                              ->select('*','jb_comments.created_at as comment_date')
                              ->get();

      return view('livewire.jobs.job.discussions', compact('comments'));
   }
}

