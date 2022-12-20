<?php

namespace App\Http\Livewire\Hr\Employees;

use App\Models\asset\assets;
use App\Models\asset\events;
use App\Models\finance\invoice\invoices;
use App\Models\hr\department_heads;
use App\Models\hr\employee_bank_info;
use App\Models\hr\employee_personal_info;
use App\Models\hr\employee_primary_info;
use App\Models\hr\employee_salary;
use App\Models\hr\employee_secondary_info;
use App\Models\hr\employees;
use App\Models\hr\leaves;
use App\Models\hr\report_to;
use App\Models\hr\travel;
use Livewire\Component;
use Auth;

class Index extends Component
{
   public $search,$employeeCode;
   public $perPage = 30;

   public function updateSearch()
   {
      $this->reset($this->search);
      $this->goToPage(1);
   }


   public function render()
   {
      $query = employees::join('hr_employee_personal_info','hr_employee_personal_info.employee_code','=','hr_employees.employee_code');
                        if($this->search){
                           $query->where('names','like','%'.$this->search.'%');
                        }
     $employees =  $query->join('wp_business','wp_business.business_code','=','hr_employees.business_code')
                           ->where('hr_employees.business_code',Auth::user()->business_code)
                           ->select('*','hr_employees.employee_code as employeeID','wp_business.business_code as businessCode')
                           ->orderby('hr_employees.id','desc')
                           ->paginate($this->perPage);

      return view('livewire.hr.employees.index', compact('employees'));
   }

   public function confirm_delete($code){
      $this->employeeCode = $code;
   }

   public function delete(){
      //check leave
      $checkLeave = leaves::where('employee_code',$this->employeeCode)->where('business_code',Auth::user()->business_code)->count();

      //check asset
      $checkAsset = assets::where('employee',$this->employeeCode)->where('business_code',Auth::user()->business_code)->count();

      //check asset event
      $checkAssetEvent = events::where('employee',$this->employeeCode)->where('business_code',Auth::user()->business_code)->count();

      //invoice sales person
      $checkSalesPerson = invoices::where('sales_person',$this->employeeCode)->where('business_code',Auth::user()->business_code)->count();

      //check travel
      $checkTravel = travel::where('employee_code',$this->employeeCode)->where('business_code',Auth::user()->business_code)->count();

      if($checkLeave == 0 && $checkAsset == 0 && $checkAssetEvent == 0 && $checkSalesPerson == 0 && $checkTravel == 0){
         employees::where('employee_code',$this->employeeCode)->where('business_code',Auth::user()->business_code)->delete();

         employee_personal_info::where('employee_code',$this->employeeCode)->where('business_code',Auth::user()->business_code)->delete();
         report_to::where('employee',$this->employeeCode)->where('business_code',Auth::user()->business_code)->delete();
         department_heads::where('employee',$this->employeeCode)->where('business_code',Auth::user()->business_code)->delete();
         employee_bank_info::where('employee_code',$this->employeeCode)->where('business_code',Auth::user()->business_code)->delete();
         employee_primary_info::where('employee_code',$this->employeeCode)->where('business_code',Auth::user()->business_code)->delete();
         employee_secondary_info::where('employee_code',$this->employeeCode)->where('business_code',Auth::user()->business_code)->delete();
         employee_salary::where('employee_code',$this->employeeCode)->where('business_code',Auth::user()->business_code)->delete();

         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Employee deleted successfully"
         ]);

         $this->employeeCode = "";

         $this->emit('Modal');
      }else{
         // Set Flash Message
         $this->dispatchBrowserEvent('alert',[
            'type'=>'warning',
            'message'=>"This employee has other records linked to them"
         ]);

         $this->employeeCode = "";

         $this->emit('Modal');
      }

   }

   public function close(){
      $this->employeeCode = "";
      $this->emit('Modal');
   }
}
