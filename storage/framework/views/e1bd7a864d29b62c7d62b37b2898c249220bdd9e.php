<!-- ================== native functions ================== -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="<?php echo asset('assets/plugins/jquery/jquery-3.2.1.min.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/bootstrap/4.1.0/js/bootstrap.bundle.min.js'); ?>"></script>
<!--[if lt IE 9]>
   <script src="<?php echo asset('assetsowserjs/html5shiv.js'); ?>"></script>
   <script src="<?php echo asset('assetsowserjs/respond.min.js'); ?>"></script>
   <script src="<?php echo asset('assetsowserjs/excanvas.min.js'); ?>"></script>
<![endif]-->
<script src="<?php echo asset('assets/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/js-cookie/js.cookie.js'); ?>"></script>
<script src="<?php echo asset('assets/js/apps.min.js'); ?>"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!-- responsive tables -->
<script src="<?php echo asset('assets/plugins/DataTables/media/js/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>
<!-- ================== END BASE JS ================== -->

<!-- bootstrap-datepicker -->
<link href="<?php echo asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css'); ?>" rel="stylesheet">
<script src="<?php echo asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/moment/moment.min.js'); ?>"></script>
<script src="<?php echo asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js'); ?>"></script>

<script>
   $('.datepicker-rs').datepicker({
      format: 'yyyy-mm-dd',
      startDate: 'd',
      todayHighlight: true,
   });
   $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      todayHighlight: true,
      //startDate: '-3d'
   });
   $('.datetimepicker').datetimepicker();
</script>


<!-- select 2 -->
<link href="<?php echo asset('assets/plugins/select2/dist/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo asset('assets/plugins/select2/dist/js/select2.min.js'); ?>"></script>
<script>
   $('.select2').select2({
      width: '100%',
      allowClear: true,
   });
</script>
<script src="<?php echo asset('assets/js/demo/form-plugins.demo.min.js'); ?>"></script>

<!-- preview uploaded image -->
<script type="text/javascript">
   $(document).ready(function() {
      if(window.File && window.FileList && window.FileReader) {
      $("#thumbnail").on("change",function(e) {
      var files = e.target.files ,
      filesLength = files.length ;
      for (var i = 0; i < filesLength ; i++) {
         var f = files[i]
         var fileReader = new FileReader();
         fileReader.onload = (function(e) {
            var file = e.target;
            $("<img></img>",{
            class : "imageThumb",
            src : e.target.result,
            title : file.name
            }).insertAfter("#thumbnail");
         });
         fileReader.readAsDataURL(f);
      }
   });
   } else { alert("Your browser doesn't support to File API") }
   });
</script>

<!--- dropzone js -->
<link href="<?php echo asset('assets/plugins/dropzone/dropzone.css'); ?>" rel="stylesheet" />
<script src="<?php echo asset('assets/plugins/dropzone/dropzone.js'); ?>"></script>
<style>
  Dropzone.options.addimages = {
    MaxFilesize:0.7,
    acceptedFile:'image/*',
    parallelUploads: 2,
    thumbnailHeight: 120,
    thumbnailWidth: 120,
    thumbnail: function(file, dataUrl) {
      if (file.previewElement) {
        file.previewElement.classList.remove("dz-file-preview");
        var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
        for (var i = 0; i < images.length; i++) {
          var thumbnailElement = images[i];
          thumbnailElement.alt = file.name;
          thumbnailElement.src = dataUrl;
        }
        setTimeout(function() { file.previewElement.classList.add("dz-image-preview"); }, 1);
      }
    }
  };
</style>


<script src="<?php echo asset('assets/plugins/tinymce/js/tinymce/tinymce.min.js'); ?>"></script>
<script>
   var editor_config = {
      path_absolute : '/',
      selector: 'textarea.tinymcy',
      relative_urls: true,
      convert_urls: false,
      height : "380",
      plugins: "paste,lists",
      menubar: 'edit',
      paste_as_text: true,
      toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link pastetext",
   };

   tinymce.init(editor_config);
</script>

<!-- sweet alert delete -->
<script src="<?php echo asset('assets/plugins/bootstrap-sweetalert/sweetalert.min.js'); ?>"></script>
<script src="<?php echo asset('assets/js/demo/ui-modal-notification.demo.min.js'); ?>"></script>

<!-- initiate modules -->
<script>
   $(document).ready(function() {
      App.init();
      TableManageDefault.init();
      Notification.init();
      //FormPlugins.init();
   });
</script>
<script type="text/javascript">
   $(document).ready(function(){
      $("form").on("submit", function(){
         $(".submit").hide();
         $(".submit-load").show();
      });//submit
   });//document ready
</script>
<script>
    $(".delete").on("click", function(){
        return confirm("Are you sure?");
    });
</script>

<!-- slim scroll -->
<script src="<?php echo asset('assets/plugins/jQuery-slimScroll/jquery.slimscroll.min.js'); ?>"></script>
<script>
   $('.slimscroll').slimscroll({
      height: 'auto'
   });
</script>
<script>
   $(function() {
      $('#cycle-count').hide();
      $('#cycles-option').change(function(){
         if($('#cycles-option').val() == 'Specify') {
            $('#cycle-count').show();
         } else {
            $('#cycle-count').hide();
         }
      });
   });
</script>

<!-- ================== multiselect ================== -->
<script src="<?php echo asset('assets/plugins/multi-select/js/jquery.multi-select.js'); ?>" type="text/javascript"></script>

<!-- ================== clipboard ================== -->



<!-- x-editable (bootstrap 3) -->
<link href="<?php echo asset('assets/plugins/x-editable/bootstrap3-editable/css/bootstrap-editable.css'); ?>" rel="stylesheet">
<script src="<?php echo asset('assets/plugins/x-editable/bootstrap3-editable/js/bootstrap-editable.js'); ?>"></script>

<!-- ================== toastr ================== -->
<link href="<?php echo asset('assets/plugins/toastr/build/toastr.css'); ?>" rel="stylesheet"/>
<script src="<?php echo asset('assets/plugins/toastr/build/toastr.min.js'); ?>"></script>
<?php if(Session::has('success')): ?>
   <script>
		toastr.options =
		{
			"closeButton" : true,
			"progressBar" : true
		}
      toastr.success('<?php echo Session::get('success'); ?>');
   </script>
<?php endif; ?>

<?php if(Session::has('error')): ?>
   <script>
		toastr.options =
		{
			"closeButton": true,
			"progressBar" : true
		}
      toastr.error('<?php echo Session::get('error'); ?>');
   </script>
<?php endif; ?>

<?php if(Session::has('warning')): ?>
   <script>
		toastr.options =
		{
			"closeButton": true,
			"progressBar" : true
		}
      toastr.warning('<?php echo Session::get('warning'); ?>');
   </script>
<?php endif; ?>

<!-- ================== lazy load ================== -->
<script src="<?php echo asset('assets/plugins/lazy-load/jquery.lazyload.min.js'); ?>"></script>
<script>
   $(document).ready(function(){
      $('img').lazyload();
   })
</script>

<script src="<?php echo asset('assets/plugins/sweetalert/dist/sweetalert2.min.js'); ?>"></script>
<script>
   const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      showCloseButton: true,
      timer: 5000,
      timerProgressBar:true,
      didOpen: (toast) => {
         toast.addEventListener('mouseenter', Swal.stopTimer)
         toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
   });

   window.addEventListener('alert',({detail:{type,message}})=>{
      Toast.fire({
         icon:type,
         title:message
      })
   })
</script>

<!-- ================== clonedata ================== -->
<script src="<?php echo asset('assets/js/cloneData.js'); ?>"></script>

<!-- geocomplete -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUrMDJXH_pjp46t-D6un_fRFeULSYeNAk&amp;libraries=places"></script>
<script src="<?php echo asset('assets/plugins/geocomplete/jquery.geocomplete.js'); ?>"></script>

<!-- ================== image uploader ================== -->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link type="text/css" rel="stylesheet" href="<?php echo asset('assets/plugins/image-uploader/dist/image-uploader.min.css'); ?>">
<script type="text/javascript" src="<?php echo asset('assets/plugins/image-uploader/dist/image-uploader.min.js'); ?>"></script>

<!-- ================== image tiled ================== -->
<link href="<?php echo asset('assets/plugins/lightbox/src/css/lightbox.css'); ?>" rel="stylesheet" />
<script src="<?php echo asset('assets/plugins/lightbox/src/js/lightbox.js'); ?>"></script>

<script src="<?php echo asset('assets/js/fancybox.min.js'); ?>"></script>
<link href="<?php echo asset('assets/css/fancybox.min.css'); ?>" rel="stylesheet" />

<script src="<?php echo asset('assets/plugins/masonry/dist/jquery.masonryGrid.js'); ?>"></script>
<script type="text/javascript">
   $(function(){
      $('.my-masonry-grid').masonryGrid({
         'columns': 7,
         'breakpoint': 767
      });
   });
</script>
<script>
   window.onbeforeunload = function() {
      if (data_needs_saving()) {
         return "Are you sure you want to leave ?";
      } else {
         return;
      }
   };
</script>

<!-- ================== chart ================== -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="<?php echo asset('assets/plugins/chart.js/2.7.1/Chart.min.js'); ?>" charset="utf-8"></script>

<!-- ================== high charts ================== -->
<script src="<?php echo asset('assets/plugins/highcharts/highcharts.js'); ?>"></script>


<?php echo \Livewire\Livewire::scripts(); ?>


<!-- ================== side note================== -->
<script type="text/javascript">
   window.livewire.on('ModalSlideNote', () => {
      $('#rightSlideNotes').modal('hide');
   });

   window.livewire.on('ModalSlideNoteArea', () => {
      $('#leftSlideNoteArea').modal('hide');
   });

   window.livewire.on('ModalSlideNoteDelete', () => {
      $('#deleteSideNote').modal('hide');
   });

   window.livewire.on('ModalSlideNoteView', () => {
      $('#rightSideNoteDetails').modal('hide');
   });
</script>
<?php echo $__env->yieldContent('scripts'); ?>
<?php echo $__env->yieldContent('script2'); ?>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/partials/_footer.blade.php ENDPATH**/ ?>