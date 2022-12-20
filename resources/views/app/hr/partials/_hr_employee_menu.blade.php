<div class="col-md-3">
	<div class="panel panel-white">
      <div class="panel-body">
         <ul class="nav nav-pills nav-stacked hr-menu">
            <li class="{{ Nav::isRoute('hrm.employee.edit') }} mb-2">
					<a href="{{ route('hrm.employee.edit', $employee->employee_code) }}"> <i class="fal fa-info-circle"></i> <b> Employement Information</b></a>
				</li>
            <li class="{{ Nav::isResource('personal-info') }}">
               <a href="{{ route('hrm.personalinfo.edit',$employee->employee_code) }}">
                  <i class="fal fa-male"></i> <b>Personal Information</b>
               </a>
            </li>
            <li class="{{ Nav::isResource('salary') }}">
               <a href="{{ route('hrm.employee.salary.edit',$employee->employee_code) }}">
						<i class="fal fa-money-check-alt"></i> <b>Salary & Bank information</b>
					</a>
            </li>
            <li class="{{ Nav::isRoute('hrm.employee.deductions') }}">
               <a href="{{ route('hrm.employee.deductions', $employee->employee_code) }}">
						<i class="fal fa-minus"></i> <b> Salary Deductions</b>
					</a>
            </li>
            {{-- <li class="{{ Nav::isResource('benefits') }}">
               <a href="#">
						<i class="fal fa-plus"></i> <b> Company Benefits</b>
					</a>
            </li> --}}
            <li class="{{ Nav::isResource('academic') }}">
               <a href="{{ route('hrm.employeeacademicinformation.edit',$employee->employee_code) }}">
						<i class="fal fa-graduation-cap"></i> <b>Academic training Information</b>
					</a>
            </li>
            <li class="{{ Nav::isResource('experience') }}">
              	<a href="{{ route('hrm.experience.edit', $employee->employee_code) }}">
						<i class="fal fa-business-time"></i> <b>Work experience</b>
					</a>
            </li>
            <li class="{{ Nav::isResource('family') }}">
               <a href="{{ route('hrm.famillyinfo.edit', $employee->employee_code) }}">
               	<i class="fa fa-users" aria-hidden="true"></i> <b> Family Information / Dependent</b>
               </a>
            </li>
            {{-- <li class="{{ Nav::isResource('files') }}">
               <a href="{{ route('hrm.employeefile.edit', $employee->employee_code) }}">
                  <i class="fal fa-folder"></i> <b> Files</b>
               </a>
            </li> --}}
            {{-- <li class="{{ Nav::isResource('asset') }}">
               <a href="{{ route('hrm.employeefile.edit', $employee->employee_code) }}">
						<i class="fal fa-boxes"></i> <b> Asset Allocation</b>
					</a>
            </li> --}}
            {{-- <li class="{{ Nav::isResource('leave') }}">
               <a href="{{ route('hrm.employeefile.edit', $employee->employee_code) }}">
						<i class="fal fa-calendar-times"></i> <b> Leave Allocation</b>
					</a>
            </li> --}}
            <li>
               <a href="javascript:alert('Please submit the employment information first')">
                  <i class="fa fa-cogs" aria-hidden="true"></i> <b> Account Settings</b>
               </a>
            </li>
         </ul>
      </div>
   </div>
</div>
