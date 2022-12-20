<div class="col-md-3">
	<div class="panel panel-white">
      <div class="panel-body">
         <ul class="nav nav-pills nav-stacked hr-menu">
            <li class="<?php echo e(Nav::isRoute('hrm.employee.edit')); ?> mb-2">
					<a href="<?php echo e(route('hrm.employee.edit', $employee->employee_code)); ?>"> <i class="fal fa-info-circle"></i> <b> Employement Information</b></a>
				</li>
            <li class="<?php echo e(Nav::isResource('personal-info')); ?>">
               <a href="<?php echo e(route('hrm.personalinfo.edit',$employee->employee_code)); ?>">
                  <i class="fal fa-male"></i> <b>Personal Information</b>
               </a>
            </li>
            <li class="<?php echo e(Nav::isResource('salary')); ?>">
               <a href="<?php echo e(route('hrm.employee.salary.edit',$employee->employee_code)); ?>">
						<i class="fal fa-money-check-alt"></i> <b>Salary & Bank information</b>
					</a>
            </li>
            <li class="<?php echo e(Nav::isRoute('hrm.employee.deductions')); ?>">
               <a href="<?php echo e(route('hrm.employee.deductions', $employee->employee_code)); ?>">
						<i class="fal fa-minus"></i> <b> Salary Deductions</b>
					</a>
            </li>
            
            <li class="<?php echo e(Nav::isResource('academic')); ?>">
               <a href="<?php echo e(route('hrm.employeeacademicinformation.edit',$employee->employee_code)); ?>">
						<i class="fal fa-graduation-cap"></i> <b>Academic training Information</b>
					</a>
            </li>
            <li class="<?php echo e(Nav::isResource('experience')); ?>">
              	<a href="<?php echo e(route('hrm.experience.edit', $employee->employee_code)); ?>">
						<i class="fal fa-business-time"></i> <b>Work experience</b>
					</a>
            </li>
            <li class="<?php echo e(Nav::isResource('family')); ?>">
               <a href="<?php echo e(route('hrm.famillyinfo.edit', $employee->employee_code)); ?>">
               	<i class="fa fa-users" aria-hidden="true"></i> <b> Family Information / Dependent</b>
               </a>
            </li>
            
            
            
            <li>
               <a href="javascript:alert('Please submit the employment information first')">
                  <i class="fa fa-cogs" aria-hidden="true"></i> <b> Account Settings</b>
               </a>
            </li>
         </ul>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/partials/_hr_employee_menu.blade.php ENDPATH**/ ?>