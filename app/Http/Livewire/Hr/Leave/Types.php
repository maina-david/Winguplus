<?php

namespace App\Http\Livewire\Hr\Leave;

use App\Models\hr\leaves;
use App\Models\hr\type;
use Livewire\Component;
use Auth;
use Helper;

class Types extends Component
{
   public $name;
   public $typeCode;
   public function render()
   {
      $types = type::where('business_code',Auth::user()->business_code)->orderby('id','desc')->get();

      return view('livewire.hr.leave.types', compact('types'));
   }

   //reset field
   public function restFields(){
      $this->name = "";
      $this->typeCode = "";
   }

   //add type
   public function store(){
      $this->validate([
			'name' => 'required',
		]);

		$store = new type;
      $store->type_code     = Helper::generateRandomString(30);
		$store->name          = $this->name;
		$store->created_by    = Auth::user()->user_code;
		$store->business_code = Auth::user()->business_code;
		$store->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Leave type successfully added"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //edit
   public function edit($code){
      $edit = type::where('business_code',Auth::user()->business_code)->where('type_code',$code)->first();
      $this->typeCode = $code;
      $this->name = $edit->name;
   }

   //update
   public function update(){
      $this->validate([
			'name' => 'required',
		]);

      $edit = type::where('business_code',Auth::user()->business_code)->where('type_code',$this->typeCode)->first();
		$edit->name          = $this->name;
		$edit->updated_by    = Auth::user()->user_code;
		$edit->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Leave type successfully updated"
      ]);

      $this->restFields();

      $this->emit('popModal');
   }

   //remove
   public function remove($code){
      $this->typeCode = $code;
   }

   //delete
	public function delete()
	{
      //check if type is in use
      $check = leaves::where('type_code',$this->typeCode)->where('business_code',Auth::user()->business_code)->count();
      if($check == 0){
         type::where('business_code',Auth::user()->business_code)->where('type_code',$this->typeCode)->delete();

         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Leave type successfully deleted"
         ]);

         $this->restFields();

         $this->emit('popModal');
      }else{
         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'warning',
            'message'=>"This Leave type is linked to several leave applications"
         ]);

         $this->restFields();

         $this->emit('popModal');
      }
	}

   //close
   public function close(){
      $this->restFields();
      $this->emit('popModal');
   }

}
