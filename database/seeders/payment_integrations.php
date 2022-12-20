<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\wingu\payment_integrations as integrations;
class payment_integrations extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      integrations::create([
         'integration_code' => 'pesapal',
         'name' => 'Pesapal',
         'logo' => 'Pesapal.svg',
         'status' => '0'
      ]);

      integrations::create([
         'integration_code' => 'Paypal',
         'name' => 'Paypal',
         'logo' => 'paypal.png',
         'status' => '0'
      ]);

      integrations::create([
         'integration_code' => 'mpesadaraja',
         'name' => 'Mpesa daraja',
         'logo' => 'daraja.png',
         'status' => '0'
      ]);

      integrations::create([
         'integration_code' => 'stripe',
         'name' => 'Stripe',
         'logo' => 'stripe.png',
         'status' => '0'
      ]);

      integrations::create([
         'integration_code' => 'braintree',
         'name' => 'Brain tree',
         'logo' => 'braintree.png',
         'status' => '0'
      ]);

      integrations::create([
         'integration_code' => 'cash',
         'name' => 'cash',
         'logo' => '',
         'status' => '0'
      ]);

      integrations::create([
         'integration_code' => 'Cheque',
         'name' => 'Cheque',
         'logo' => '',
         'status' => '0'
      ]);

      integrations::create([
         'integration_code' => 'Mpesapaybill',
         'name' => 'Mpesa Paybill',
         'logo' => 'mpesa.png',
         'status' => '0'
      ]);

      integrations::create([
         'integration_code' => 'mpesatillnumber',
         'name' => 'Mpesa till number',
         'logo' => 'lipa-na-mpesa.png',
         'status' => '0'
      ]);

      integrations::create([
         'integration_code' => 'phonenumber',
         'name' => 'Mpesa phone number',
         'logo' => 'safaricom.png',
         'status' => '0'
      ]);

      integrations::create([
         'integration_code' => 'bongapoints',
         'name' => 'Lipa na bonga points',
         'logo' => 'safaricom.png',
         'status' => '0'
      ]);

      integrations::create([
         'integration_code' => 'ipay',
         'name' => 'Ipay',
         'logo' => 'ipay.png',
         'status' => '0'
      ]);
   }
}
