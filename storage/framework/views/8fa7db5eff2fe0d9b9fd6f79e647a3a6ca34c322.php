<?php $__env->startSection('title','All Credit notes'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="<?php echo route('finance.creditnote.create'); ?>" class="btn btn-pink"><i class="fas fa-plus-circle"></i> New  Credit note</a>
         
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> All  Credit notes</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-inverse">
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Number</th>
                     <th>Client</th>
                     <th>Reference #</th>
                     <th>Amount</th>
                     <th>Balance</th>
                     <th>Status</th>
                     <th>Credit note date</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $creditnotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr role="row" class="odd">
                        <td><?php echo e($crt+1); ?></td>
                        <td>
                           <b><?php echo $v->credit_note_prefix; ?><?php echo $v->credit_note_number; ?></b>
                        </td>
                        <td>
                           <?php echo $v->customer_name; ?>

                        </td>
                        <td class="text-uppercase font-weight-bold">
                           <?php echo $v->reference_number; ?>

                        </td>
                        <td><?php echo $v->currency; ?><?php echo number_format($v->total,2); ?> </td>
                        <td><span class="text-success font-bold"><?php echo $v->currency; ?><?php echo number_format($v->balance,2); ?></span></td>
                        <td>
                           <span class="badge <?php echo $v->statusName; ?>">
                              <?php echo ucfirst($v->statusName); ?>

                           </span>
                        </td>
                        <td>
                           <?php echo date('F j, Y',strtotime($v->creditnote_date)); ?>

                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                              <ul class="dropdown-menu">
                                 <li><a href="<?php echo e(route('finance.creditnote.show', $v->creditnote_code)); ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>

                                 <?php if(!$v->payment_code): ?>
                                    <li><a href="<?php echo route('finance.creditnote.edit', $v->creditnote_code); ?>"><i class="fas fa-edit"></i> Edit</a></li>
                                 <?php endif; ?>
                                 <li><a href="<?php echo route('finance.creditnote.delete', $v->creditnote_code); ?>" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
                              </ul>
                           </div>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/creditnote/index.blade.php ENDPATH**/ ?>