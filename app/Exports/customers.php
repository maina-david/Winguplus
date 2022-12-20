<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\finance\customer\customers as customer;
use Auth;

class customers implements FromCollection, WithHeadings
{
   /**
 * @return \Illuminate\Support\Collection
   */
   public function collection()
   {
      return customer::join('fn_customer_address','fn_customer_address.customer_code','=','fn_customers.customer_code')
                     ->where('fn_customers.business_code', Auth::user()->business_code)
                     ->select('contact_type','designation','department','salutation','customer_name','email','email_cc','other_phone_number','primary_phone_number','website','facebook','twitter','linkedin','bill_street','bill_city','bill_state','bill_postal_address','bill_zip_code','ship_street','ship_city','ship_state','ship_zip_code','ship_postal_address')
                     ->get();
   }

   public function headings(): array
   {
      return [
         'contact type',
         'Designation',
         'Department',
         'Salutation',
         'Customer name',
         'Email',
         'Email cc',
         'Other phone number',
         'Primary phone number',
         'Website',
         'facebook',
         'Twitter',
         'Linkedin',
         'Bill street',
         'Bill city',
         'Bill state',
         'Bill postal address',
         'Bill zip code',
         'Ship street',
         'Ship city',
         'Ship state',
         'Ship zip code',
         'Ship postal address',
      ];
   }
}
