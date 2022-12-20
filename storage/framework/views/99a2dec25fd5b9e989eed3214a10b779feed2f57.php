<?php $__env->startSection('title','Deals | Customer Relationship Management'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="float-right">
         <a href="<?php echo route('crm.deals.create'); ?>" class="btn btn-pink"><i class="fas fa-plus-circle"></i> New Deal</a>
         <a href="" class="btn btn-success"><i class="far fa-list"></i> List View</a>
         <a href="<?php echo route('crm.deals.grid'); ?>" class="btn btn-warning"><i class="fas fa-columns"></i> Grid view</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">
         <i class="fas fa-bullseye"></i> Deals

      </h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">Deals List</h4>
         </div>
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr role="row">
                     <th width="1%">#</th>
                     <th>Title</th>
                     <th>Value</th>
                     <th>Pipeline</th>
                     <th>Stage</th>
                     <th>Owner</th>
                     <th>Customer</th>
                     <th>Closing</th>
                     <th>Status</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count+1; ?></td>
                        <td><?php echo $deal->title; ?></td>
                        <td><?php echo $deal->currency; ?> <?php echo number_format($deal->value); ?></td>
                        <td>
                           <span class="badge badge-warning">
                              <?php if(Crm::check_pipeline($deal->pipeline)): ?>
                                 <?php echo Crm::pipeline($deal->pipeline)->title; ?>

                              <?php endif; ?>
                           </span>
                        </td>
                        <td>
                           <span class="badge badge-primary">
                              <?php if(Crm::check_pipeline_stage($deal->stage)): ?>
                                 <?php echo Crm::pipeline_stage($deal->stage)->title; ?>

                              <?php endif; ?>
                           </span>
                        </td>
                        <td>
                           <?php if(Wingu::check_user($deal->owner) == 1): ?>
                              <?php echo Wingu::user($deal->owner)->name; ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if(Finance::check_client($deal->contact) == 1): ?>
                              <?php echo Finance::client($deal->contact)->customer_name; ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if($deal->close_date): ?>
                              <?php echo date('F jS Y', strtotime($deal->close_date)); ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if($deal->status): ?>
                              <?php echo Wingu::status($deal->status)->name; ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                              <ul class="dropdown-menu">
                                 <li><a href="<?php echo route('crm.deals.show',$deal->deal_code); ?>"><i class="fal fa-eye" aria-hidden="true"></i> View</a></li>
                                 <li><a href="<?php echo route('crm.deals.edit',$deal->deal_code); ?>"><i class="fal fa-edit"></i> Edit</a></li>
                                 <li><a href="<?php echo route('crm.deals.delete',$deal->deal_code); ?>" class="delete"><i class="fal fa-trash-alt"></i> Delete</a></li>
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

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/deals/deal/index.blade.php ENDPATH**/ ?>