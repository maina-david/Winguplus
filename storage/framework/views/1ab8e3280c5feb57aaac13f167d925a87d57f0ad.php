<?php $__env->startSection('title','Tax Rates'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item active">Tax Rates</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-coins"></i> Tax Rates</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.finance.partials._settings_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-body">
                        <a href="#add-currency" class="btn btn-pink mb-3" data-toggle="modal"><i class="fas fa-plus"></i> Add Tax Rates</a>
                        <table id="data-table-default" class="table table-striped table-bordered table-hover">
                           <thead>
                              <tr>
                                 <th width="1%">#</th>
                                 <th>Tax</th>
                                 <th>Rate</th>
                                 <th>Compound</th>
                                 <th>Description</th>
                                 <th width="20%">Action</th>
                              </tr>
                           </thead>
                           <tfoot>
                              <tr>
                                 <th width="1%">#</th>
                                 <th>Tax</th>
                                 <th>Rate</th>
                                 <th>Compound</th>
                                 <th>Description</th>
                                 <th width="20%">Action</th>
                              </tr>
                           </tfoot>
                           <tbody>
                              <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $tax->name; ?></td>
                                    <td><?php echo $tax->rate; ?>%</td>
                                    <td><?php echo $tax->compound; ?></td>
                                    <td><?php echo $tax->description; ?></td>
                                    <td>
                                       <a href="javascript:;" class="btn btn-sm btn-primary edit-taxes" id="<?php echo $tax->tax_code; ?>"><i class="fas fa-edit"></i> Edit</a>
                                       <a href="<?php echo route('finance.settings.delete', $tax->tax_code); ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                                    </td>
                                 </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="modal fade" id="add-currency">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Add Tax Rates</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <form action="<?php echo route('finance.settings.taxes.store'); ?>" method="POST">
                  <?php echo csrf_field(); ?>
                  <div class="form-group">
                     <label for="">Tax Name</label>
                     <input type="text" class="form-control" name="tax_name" required>
                  </div>
                  <div class="form-group">
                     <label for="">Tax Rates</label>
                     <input type="number" class="form-control" name="tax_rate" required>
                  </div>
                  <div class="form-group">
                     <label for="">Tax Descriptions</label>
                     <textarea type="text" class="form-control" name="description"></textarea>
                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-pink submit">Submit</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </form>
            </div>
            <div class="modal-footer">
               <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Close</a>
            </div>
         </div>
      </div>
   </div>

   <!-- #modal-dialog -->
   <div class="modal fade" id="edit-taxes" tabindex="-1" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Update Tax Rates</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <?php echo Form::open(array('route' => 'finance.settings.update','post','autocomplete'=>'off')); ?>

                  <?php echo csrf_field(); ?>

                  <div class="form-group">
                     <label for="">Tax Name</label>
                     <?php echo Form::text('name', null, array('class' => 'form-control', 'id' => 'name', 'required' => '')); ?>

                     <input type="hidden" name="taxCode" id="taxCode">
                  </div>
                  <div class="form-group">
                     <label for="">Tax Rates</label>
                     <?php echo Form::number('rate', null, array('class' => 'form-control', 'id' => 'rate', 'required' => '')); ?>

                  </div>
                  <div class="form-group">
                     <label for="">Tax Descriptions</label>
                     <?php echo Form::textarea('description', null, array('class' => 'form-control','id' => 'description')); ?>

                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-pink submit">Update Tax Rate</button>
                        <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               <?php echo Form::close(); ?>

            </div>
         </div>
      </div>
   </div>
   <!-- #modal-without-animation -->
   
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script>
      $(document).on('click', '.edit-taxes', function(){
         var code = $(this).attr('id');
			var url = "<?php echo url('/'); ?>";
         $('#edit-taxes').html();
         $.ajax({
            url: url+"/finance/settings/taxes/"+code+"/edit",
            dataType:"json",
            success:function(html){
               $('#name').val(html.data.name);
               $('#rate').val(html.data.rate);
					$('#description').val(html.data.description);
					$('#taxCode').val(code);
               $('#edit-taxes').modal('show');
            }
         })
      });
   </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/taxes/index.blade.php ENDPATH**/ ?>