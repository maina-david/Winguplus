<div class="row">
   <div class="col-md-12" id="location">
      <div class="map_canvas" id="map" style="width: 100%;height: 400px;"></div>
   </div>
   @section('script2')
      <script>
         var latitude = {!! $details->latitude !!};
         var longitude = {!! $details->longitude !!};
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
   @endsection
</div>
