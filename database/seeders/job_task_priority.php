<?php

namespace Database\Seeders;

use App\Models\jobs\priority;
use Illuminate\Database\Seeder;

class job_task_priority extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      priority::create([
         'id' => '1',
         'name' => 'Urgent',
         'status' => '15'
      ]);

      priority::create([
         'id' => '2',
         'name' => 'High',
         'status' => '15'
      ]);

      priority::create([
         'id' => '3',
         'name' => 'Low',
         'status' => '15'
      ]);
   }
}
