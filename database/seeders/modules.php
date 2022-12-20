<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\wingu\Modules as winguModules;

class modules extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      winguModules::create([
         'integration_code' => 'pesapal',
         'name' => 'Pesapal',
         'logo' => 'Pesapal.svg',
         'status' => '0'
      ]);
   }
}
