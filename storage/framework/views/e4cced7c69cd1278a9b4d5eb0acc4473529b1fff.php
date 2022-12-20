<?php $__env->startSection('title','Travel Expenses | Human Resource '); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         
         <a href="<?php echo route('hrm.travel.expenses.create'); ?>" class="btn btn-pink"><i class="fal fa-plus-circle"></i> Add Expenses</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-usd-circle"></i> Travel Expenses </h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-responsive">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Title</th>
                     <th>Travel Date</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Approved By</th>
                     <th>Approved</th>
                     <th width="12%">Action</th>
                  </tr>
               </thead>
               <tbody>
                 <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count+1; ?></td>
                        <td><?php echo $expense->title; ?></td>
                        <td><?php echo date('M jS, Y', strtotime($expense->date)); ?></td>
                        <td><?php echo $expense->currency; ?> <?php echo number_format($expense->amount); ?></td>
                        <td><span class="badge <?php echo $expense->statusName; ?>"><?php echo $expense->statusName; ?></td>
                        <td>
                           <?php if($expense->approved_by): ?>
                              <?php if(Wingu::check_user($expense->approved_by)): ?>
                                 <?php echo Wingu::user($expense->approved_by)->name; ?>

                              <?php endif; ?>
                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if($expense->approval_date): ?>
                              <?php echo date('M jS, Y', strtotime($expense->approval_date)); ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           
                           <a href="<?php echo route('hrm.travel.expenses.edit',$expense->expenseCode); ?>" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                           <a href="<?php echo route('hrm.travel.expenses.delete',$expense->expenseCode); ?>" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></a>
                        </td>
                     </tr>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
      <!-- end panel -->
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/hr/travel/expenses/index.blade.php ENDPATH**/ ?>