<?php $__env->startSection('title','Edit Project'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.jobs.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div class="content">
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('jobs.job.head', ['jobCode' => $code])->html();
} elseif ($_instance->childHasBeenRendered('Xwtdxde')) {
    $componentId = $_instance->getRenderedChildComponentId('Xwtdxde');
    $componentTag = $_instance->getRenderedChildComponentTagName('Xwtdxde');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Xwtdxde');
} else {
    $response = \Livewire\Livewire::mount('jobs.job.head', ['jobCode' => $code]);
    $html = $response->html();
    $_instance->logRenderedChild('Xwtdxde', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row mb-3">
         <div class="col-md-12">
            <h4><i class="fal fa-file-edit"></i> Edit Job</h4>
         </div>
      </div>
      <?php echo Form::model($project, ['route' => ['job.update',$code], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

         <?php echo csrf_field(); ?>

         <div class="row">
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-body">
                     <div class="form-group form-group-default required ">
                        <?php echo Form::label('Project name', 'Whats the Project Name?', array('class'=>'control-label')); ?>

                        <?php echo Form::text('job_title', null, array('class' => 'form-control', 'placeholder' => 'Project Name', 'required' => '')); ?>

                     </div>
                     <div class="form-group form-group-default required ">
                        <?php echo Form::label('job_type', 'Is this an Internal or External project ?', array('class'=>'control-label')); ?>

                        <?php echo e(Form::select('job_type',[''=>'Choose','Internal'=>'Internal','External'=>'External'], null, ['class' => 'form-control','id' => 'project' ])); ?>

                     </div>
                     <?php if($project->job_type == 'External'): ?>
                        <div class="form-group form-group-default required" id="company_name">
                           <?php echo Form::label('Client', 'Client', array('class'=>'control-label')); ?>

                           <?php echo Form::select('customer',$clients,null,['class'=>'form-control select2']); ?>

                        </div>

                        <div class="form-group form-group-default">
                           <label for="">Notify Client</label>
                           <?php echo e(Form::select('notify_client', ['' => 'Choose','Yes' => 'Yes','No' => 'No'], null, ['class' => 'form-control'])); ?>

                        </div>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-body">

                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Choose Employee', 'Allocate Job Managers', array('class'=>'control-label')); ?>

                        <?php echo e(Form::select('job_leads[]', $users, null, ['class' => 'form-control multiple-select2','required' =>'','multiple' => ''  ])); ?>

                     </div>
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('start Date', 'start Date', array('class'=>'control-label')); ?>

                              <?php echo Form::date('start_date', null, array('class' => 'form-control', 'required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('End Date', 'Due Date', array('class'=>'control-label')); ?>

                              <?php echo Form::date('end_date', null, array('class' => 'form-control', 'required' => '')); ?>

                           </div>
                        </div>
                     </div>
                     <div class="form-group form-group-default required ">
                        <?php echo Form::label('project_status', 'Project Status', array('class'=>'control-label')); ?>

                        <?php echo e(Form::select('status',[''=>'Choose Project Status',17=>'Started',21 => 'Open',16=>'Complete',22=>'Closed',24=>'Ongoing'], null, ['class' => 'form-control multiselect','required'=> ''])); ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                  <?php echo Form::label('Project name', 'Brief project introduction', array('class'=>'control-label')); ?>

                  <?php echo Form::textarea('brief_info', null, array('class' => 'form-control', 'size' => '5 x 5','placeholder' => 'type...............')); ?>

               </div>
               <div class="form-group required">
                  <?php echo Form::label('Description', 'Description', array('class'=>'control-label mb-3')); ?>

                  <?php echo Form::textarea('description',null,['class'=>'form-control tinymcy', 'rows' => 5, 'placeholder'=>'content']); ?>

               </div>
            </div>
         </div>
         <div class="row">
            <div class="panel-body">
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Project</button>
               <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
            </div>
         </div>
      <?php echo Form::close(); ?>

   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      $(".multiple-select2").select2().val(<?php echo json_encode($currentemp); ?>).trigger('change');
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/jobs/job/edit.blade.php ENDPATH**/ ?>