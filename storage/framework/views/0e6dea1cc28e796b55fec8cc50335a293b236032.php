<div class="row">
   <div class="col-md-12" id="location">
      <div class="map_canvas" id="map" style="width: 100%;height: 400px;"></div>
   </div>
   <?php $__env->startSection('script2'); ?>
      <script>
         var latitude = <?php echo $details->latitude; ?>;
         var longitude = <?php echo $details->longitude; ?>;
         var setloc = new google.maps.LatLng(latitude,longitude);

         $('#location').geocomplete({
            map: '#map',
            details: "form",
            location: setloc,
            detailsAttribute:"data-geo",
            mapOptions: {
               zoom: 15
            },
            markerOptions: {
               draggable: true
            }
         });
      </script>
   <?php $__env->stopSection(); ?>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/assets/assets/location.blade.php ENDPATH**/ ?>