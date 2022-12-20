<?php $__env->startSection('title','Deals | Grid | Customer Relationship Management'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <link rel="stylesheet" href="<?php echo asset('assets/css/project.css'); ?>" />
   <style>
      .select2-container {
         z-index: 9999 !important;
      }
   </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('crm.deals.grid')->html();
} elseif ($_instance->childHasBeenRendered('iL7Yc4P')) {
    $componentId = $_instance->getRenderedChildComponentId('iL7Yc4P');
    $componentTag = $_instance->getRenderedChildComponentTagName('iL7Yc4P');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('iL7Yc4P');
} else {
    $response = \Livewire\Livewire::mount('crm.deals.grid');
    $html = $response->html();
    $_instance->logRenderedChild('iL7Yc4P', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#dealModal').modal('hide');
         $('#stageModal').modal('hide');
         $('#delete').modal('hide');
      });
   </script>
   <script>
      $(function() {
         var url = "<?php echo route('crm.deals.stage.change'); ?>";
         $('ul[id^="sort"]').sortable({
            connectWith: ".sortable",
            receive: function (e, ui) {
               var stage_code = $(ui.item).parent(".sortable").data("stage-code");
               var deal_code = $(ui.item).data("deal-code");
               $.ajax({
                  url: url+'?stage_code='+stage_code+'&deal_code='+deal_code,
                     success: function(response){
                  }
               });
            }
         }).disableSelection();
      } );
   </script>
   <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
   <script>
      ClassicEditor
      .create( document.querySelector('#details'))
      .then(editor => {
         document.querySelector('#save_task').addEventListener('click', ()=>{
            let details = $('#details').data('details');
            eval(details).set('details', editor.getData());
         });
      })
      .catch( error => {
         console.error( error );
      });
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/deals/deal/grid.blade.php ENDPATH**/ ?>