<div class="card mt-3">
   <div class="card-header"><i class="fal fa-file-alt"></i> Credit notes</div>
   <div class="card-body">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th>Number</th>
               <th>Reference Number</th>
               <th>Amount</th>
               <th>Status</th>
               <th>Date</th>
               <th width="10%">Action</th>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th width="1%">#</th>
               <th>Number</th>
               <th>Reference Number</th>
               <th>Amount</th>
               <th>Status</th>
               <th>Date</th>
               <th width="10%">Action</th>
            </tr>
         </tfoot>
         <tbody>
            <?php $__currentLoopData = $creditnotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr role="row" class="odd">
                  <td><?php echo e($crt+1); ?></td>
                  <td>
                     <b><?php echo Finance::creditnote()->prefix; ?><?php echo $v->creditnote_number; ?></b>
                  </td>
                  <td class="text-uppercase font-weight-bold">
                     <?php echo $v->reference_number; ?>

                  </td>
                  <td><?php echo $client->code; ?> <?php echo number_format($v->total); ?></td>
                  <td><span class="badge <?php echo Limitless::status($v->statusID)->name; ?>"><?php echo ucfirst(Limitless::status($v->statusID)->name); ?></span></td>
                  <td>
                     <?php echo date('F j, Y',strtotime($v->created_at)); ?>

                  </td>
                  <td>
                     <a href="<?php echo e(route('finance.creditnote.show', $v->id)); ?>" class="btn btn-pink btn-sm" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                  </td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
      </table>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/customers/creditnotes.blade.php ENDPATH**/ ?>