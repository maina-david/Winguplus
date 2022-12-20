<?php

namespace App\Http\Controllers\app\wingu;

use App\Http\Controllers\Controller;
use App\Models\wingu\Email;
use Illuminate\Http\Request;

class trackerController extends Controller
{
   public function email($mailCode){
      $track = Email::where('mail_code',$mailCode)->first();

      $count = $track->view_count;

      if($track->date_view == ""){
         $track->view_status = 'Read';
         $track->date_view = date("Y-m-d H:i:s");
         $track->view_count = $count + 1;
      }else{
         $track->view_count = $count + 1;
      }
      $track->save();
   }
}
