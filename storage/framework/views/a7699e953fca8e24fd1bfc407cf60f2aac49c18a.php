<?php $__env->startSection('title','Survey | Questions'); ?>
<?php $__env->startSection('content'); ?>
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0"> Survey | <?php echo $survey->title; ?> - Questions </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Survey</a></li>
                     <li class="breadcrumb-item active">Questions</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="row">
      <div class="col-md-6">
         <?php echo $__env->make('app.survey._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>
      <div class="col-md-12">
         <a href="<?php echo route('survey.questions.create',$survey->code); ?>" class="btn btn-success btn-sm float-right mt-2"> Add a question</a>
      </div>
      <div class="col-md-12">
         <div class="card mt-2">
            <div class="card-body">
               <table class="table table-striped table-bordered zero-configuration">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th>Question</th>
                        <th width="9%">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count=>$question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                           <td><?php echo $count+1; ?></td>
                           <td>
                              <?php echo $question->question; ?><br>
                              <b>Type:</b> <?php echo $question->name; ?><br>
                              <b>Answer:</b> <?php echo $question->answer; ?>

                           </td>
                           <td>
                              <a href="<?php echo route('survey.questions.edit',[$survey->code,$question->questionID]); ?>" class="btn btn-primary btn-sm"><i class="fad fa-edit"></i></a>
                              <a href="" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                           </td>
                        </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/salesflow/survey/questions/index.blade.php ENDPATH**/ ?>