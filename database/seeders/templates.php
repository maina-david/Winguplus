<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\wingu\templates as temp;

class templates extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      temp::create([
         'template_code' => 'eRm2wzrA7P',
         'title' => 'Blue',
         'template_name' => 'blue',
         'type' => 'Free',
         'price' => '0',
         'status' => '15',
      ]);
      temp::create([
         'template_code' => 'QJp1Y61S',
         'title' => 'Default',
         'template_name' => 'default',
         'type' => 'Free',
         'price' => '0',
         'status' => '15',
      ]);
      temp::create([
         'template_code' => '8zhvwH0',
         'title' => 'Bootstrap 3',
         'template_name' => 'bootstrap-3',
         'type' => 'Free',
         'price' => '0',
         'status' => '15',
      ]);
   }
}
