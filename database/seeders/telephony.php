<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\wingu\telephony as phone;

class telephony extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      phone::create([
         'telephony_code' => 'twilio',
         'name' => 'Twilio',
         'logo' => 'twilio.png',
         'status' => '15'
      ]);

      phone::create([
         'telephony_code' => 'Africastalking',
         'name' => 'Africas talking',
         'logo' => 'africas-talking.png',
         'status' => '15'
      ]);
   }
}
