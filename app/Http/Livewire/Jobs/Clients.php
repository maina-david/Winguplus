<?php

namespace App\Http\Livewire\Jobs;

use App\Models\finance\creditnote\creditnote;
use App\Models\finance\customer\address;
use App\Models\finance\customer\contact_persons;
use App\Models\finance\customer\customers;
use App\Models\finance\invoice\invoices;
use App\Models\finance\quotes\quotes;
use App\Models\jobs\jobs;
use Livewire\WithPagination;
use Livewire\Component;
use Helper;
use Auth;
use Wingu;

class Clients extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';

   public $search;
   public $perPage = 28;
   public $client_name,$email,$website,$phone_number;
   public $editCode;

   public function render()
   {
      $query = customers::where('business_code',Auth::user()->business_code);
                        if($this->search){
                           $query->where('customer_name','like','%'.$this->search.'%');
                        }

      $clients = $query->orderby('id','desc')->simplePaginate($this->perPage);

      return view('livewire.jobs.clients', compact('clients'));
   }

   //reset fiels
   public function restFields(){
      $this->email         = "";
      $this->client_name   = "";
      $this->website       = "";
      $this->phone_number  = "";
   }

   //add client
   public function add_client(){
      $this->validate([
         'client_name' => 'required',
      ]);

      $customerCode = Helper::generateRandomString(20);
      $client = new customers;
      $client->customer_code        = $customerCode;
      $client->email                = $this->email;
      $client->customer_name        = $this->client_name;
      $client->website              = $this->website;
      $client->primary_phone_number = $this->phone_number;
      $client->business_code        = Auth::user()->business_code;
		$client->created_by           = Auth::user()->user_code;
 		$client->save();

      $address = new address;
      $address->customer_code = $customerCode;
      $address->business_code = Auth::user()->business_code;
      $address->save();

      //recorded activity
      $activities = Auth::user()->name.' Has added a new customer '.$this->client_name;
      $module     = 'Jobs Management';
      $section    = 'Client';
      $action     = 'Create';
      $activityID = $customerCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Client has been successfully Added"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //update mode
   public function edit_mode($code){
      $this->editCode = $code;
      $edit = customers::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $this->email        = $edit->email;
      $this->client_name  = $edit->customer_name;
      $this->website      = $edit->website;
      $this->phone_number = $edit->primary_phone_number;
   }

   //update client
   public function update_client($code){
      $this->validate([
         'client_name' => 'required',
      ]);

      $customerCode = Helper::generateRandomString(20);

      $client = customers::where('customer_code',$code)->where('business_code',Auth::user()->business_code)->first();
      $client->email                = $this->email;
      $client->customer_name        = $this->client_name;
      $client->website              = $this->website;
      $client->primary_phone_number = $this->phone_number;
		$client->updated_by           = Auth::user()->user_code;
 		$client->save();

      //recorded activity
      $activities = Auth::user()->name.' Has updated '.$this->client_name.' customer details';
      $module     = 'Jobs Management';
      $section    = 'Client';
      $action     = 'Edit';
      $activityID = $customerCode;

      Wingu::activity($activities,$section,$action,$activityID,$module);

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Client has been successfully updated"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //delete notification
   public function delete_notification($code){
      $this->editCode = $code;
   }

   //close
   public function close(){
      $this->editCode = "";
      $this->restFields();
      $this->emit('popModal');
   }

   //delete
   public function delete($code){
      $this->editCode = $code;

      $invoice = invoices::where('business_code',Auth::user()->business_code)->where('customer',$code)->count();

		//credit note
		$creditnote = creditnote::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->count();

		//quotes
		$quotes = quotes::where('business_code',Auth::user()->business_code)->where('customer_code',$code)->count();

		//project
		$job = jobs::where('business_code',Auth::user()->business_code)->where('customer',$code)->count();

		if($invoice == 0 && $creditnote == 0 && $quotes == 0 && $job == 0){
         //client info
			$check = customers::where('id','=',$code)->where('business_code',Auth::user()->business_code)->where('image','!=', "")->count();
			if ($check > 0){
				$deleteinfo = customers::where('customer_code','=',$code)
                                 ->where('business_code',Auth::user()->business_code)
                                 ->select('image','customer_code')
                                 ->first();

				$path = base_path().'/public/businesses/'.Wingu::business()->business_code.'/customer/'.$deleteinfo->customer_code.'/images/';

				$delete = $path.$deleteinfo->image;
				if (File::exists($delete)) {
					unlink($delete);
				}
			}

			//delete contact person
			$persons = contact_persons::where('customer_code',$code)->get();
			foreach ($persons as $person) {
				$person->delete();
			}

			//delete contact
			customers::where('customer_code','=',$code)->where('business_code',Auth::user()->business_code)->delete();

			//delete address
			address::where('customer_code',$code)->delete();

         //recorded activity
         $activities = Auth::user()->name.' Has deleted '.$this->client_name.' customer details';
         $module     = 'Jobs Management';
         $section    = 'Client';
         $action     = 'Edit';
         $activityID = $code;

         Wingu::activity($activities,$section,$action,$activityID,$module);

         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Client has been successfully deleted"
         ]);

         $this->restFields();

         $this->emit('popModal');

      }else{
         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'warning',
            'message'=>"You have recorded transactions for this client. Hence, this client cannot be deleted."
         ]);

         $this->restFields();

         $this->emit('popModal');
      }
   }
}
