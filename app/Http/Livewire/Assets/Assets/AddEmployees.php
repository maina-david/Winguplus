<?php

namespace App\Http\Livewire\Assets\Assets;

use App\Models\hr\employee_bank_info;
use App\Models\hr\employee_personal_info;
use App\Models\hr\employee_primary_info;
use App\Models\hr\employee_salary;
use App\Models\hr\employee_secondary_info;
use App\Models\hr\employees;
use Livewire\Component;
use Auth;
use Helper;
use Wingu;

class AddEmployees extends Component
{
   public $email,$employee_name,$phone_number;
   public function render()
   {
      return view('livewire.assets.assets.add-employees');
   }

   //rest files
   public function restFields(){
      $this->employee_name= "";
   }

   //add
   public function add_employee(){

      $employeeCode =  Helper::generateRandomString(20);

      $employee = new employees;
      $employee->employee_code   = $employeeCode;
      $employee->names           = $this->employee_name;
      $employee->created_by      = Auth::user()->user_code;
      $employee->business_code   = Auth::user()->business_code;
      $employee->save();

      //employee personal info
      $personalInfo = new employee_personal_info;
      $personalInfo->employee_code   = $employeeCode;
      $personalInfo->personal_number = $this->phone_number;
      $personalInfo->personal_email  = $this->email;
      $personalInfo->created_by      = Auth::user()->user_code;
      $personalInfo->business_code   = Auth::user()->business_code;
      $personalInfo->save();

      // Employee bank info
      $bank_info = new employee_bank_info;
      $bank_info->employee_code = $employeeCode;
      $bank_info->created_by    = Auth::user()->user_code;
      $bank_info->business_code = Auth::user()->business_code;
      $bank_info->save();


      ///primary school information
      $primary_info = new employee_primary_info;
      $primary_info->employee_code = $employeeCode;
      $primary_info->created_by = Auth::user()->user_code;
      $primary_info->business_code = Auth::user()->business_code;
      $primary_info->save();


      ///secondary school information
      $secondary_info = new employee_secondary_info;
      $secondary_info->employee_code = $employeeCode;
      $secondary_info->created_by = Auth::user()->user_code;
      $secondary_info->business_code = Auth::user()->business_code;
      $secondary_info->save();


      ///secondary school information
      $salary = new employee_salary;
      $salary->employee_code = $employeeCode;
      $salary->created_by = Auth::user()->user_code;
      $salary->business_code = Auth::user()->business_code;
      $salary->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>'Employee added successfully'
      ]);

       //recored activity
		$activity     =  Auth::user()->name.' Has added '.$employee->names.' as an employee';
		$module       = 'Human Resource Management';
		$section      = 'Employee';
      $action       = 'Create';
		$activityCode = $employeeCode;

		Wingu::activity($activity,$module,$section,$action,$activityCode);

      $this->restFields();

      $this->emitTo('assets.assets.employees','refreshComponent');
      $this->emit('popModal');
   }


   //close
   public function close(){
      $this->restFields();

      $this->emit('popModal');
   }
}
