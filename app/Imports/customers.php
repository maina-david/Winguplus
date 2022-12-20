<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\finance\customer\customers as customer;
use App\Models\finance\customer\address;
use Helper;
use Auth;

class customers implements ToCollection,WithHeadingRow
{
   /**
   * @param Collection $collection
   */
   public function collection(Collection $rows){
      foreach ($rows as $row){
         $primary = new customer;
   		$code = Helper::generateRandomString(30);
   		$primary->customer_name = $row['name'];
   		$primary->email = $row['email'];
    		$primary->primary_phone_number = $row['phone_number'];
   		$primary->customer_code = $code;
			$primary->website = $row['website'];
         $primary->created_by = Auth::user()->user_code;
			$primary->business_code = Auth::user()->business_code;
    		$primary->save();

    		//address
    		$address = new address;
   		$address->customer_code = $code;
         $address->bill_street = $row['street'];
         $address->bill_state = $row['state'];
    		$address->bill_city = $row['city'];
    		$address->bill_zip_code = $row['zip_code'];
    		$address->bill_country = 'Kenya';
			$address->bill_postal_address = $row['postal_address'];
    		$address->save();
      }
   }
}
