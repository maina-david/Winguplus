<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\finance\payments\payment_methods as payment_method;
class payment_methods extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      payment_method::create([
         'type_code' => 'cash',
         'name' => 'Cash',
         'business_code' => '0'
     ]);

      payment_method::create([
         'type_code' => 'cheque',
         'name' => 'Cheque',
         'business_code' => '0'
      ]);

      payment_method::create([
         'type_code' => 'mpesa',
         'name' => 'Mpesa',
         'business_code' => '0'
      ]);

      payment_method::create([
         'type_code' => 'banktransfer',
         'name' => 'Bank transfer',
         'business_code' => '0'
      ]);

      payment_method::create([
         'type_code' => 'ipay',
         'name' => 'Ipay',
         'business_code' => '0'
      ]);

      payment_method::create([
         'type_code' => 'kepler9',
         'name' => 'Kepler9',
         'business_code' => '0'
      ]);

      payment_method::create([
         'type_code' => 'daraja',
         'name' => 'Safaricom daraja',
         'business_code' => '0'
      ]);

      payment_method::create([
         'type_code' => 'till',
         'name' => 'Mpesa Till',
         'business_code' => '0'
      ]);

      payment_method::create([
         'type_code' => 'paybill',
         'name' => 'Mpesa Paybill',
         'business_code' => '0'
      ]);

      payment_method::create([
         'type_code' => 'phonenumber',
         'name' => 'Phone Numbe',
         'business_code' => '0'
      ]);
   }
}
