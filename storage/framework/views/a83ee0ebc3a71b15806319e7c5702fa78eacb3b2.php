<div class="row">
   <div class="col-md-6">
      <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
         <tbody>
            <tr>
               <td>Vehicle type</td>
               <td>
                  <?php if(Asset::check_car_type($details->vehicle_type) == 1): ?>
                     <b><?php echo Asset::car_type($details->vehicle_type)->name; ?></b>
                  <?php endif; ?>
               </td>
            </tr>
            <tr>
               <td>Vehicle make</td>
               <td>
                  <?php if(Asset::check_car_make($details->vehicle_make) == 1): ?>
                     <b><?php echo Asset::car_make($details->vehicle_make)->name; ?></b>
                  <?php endif; ?>
               </td>
            </tr>
            <tr>
               <td>Vehicle model</td>
               <td>
                  <?php if(Asset::check_car_model($details->vehicle_model) == 1): ?>
                     <b><?php echo Asset::car_model($details->vehicle_model)->name; ?></b>
                  <?php endif; ?>
               </td>
            </tr>
            <tr><td>Mileage</td><td><b><?php echo $details->mileage; ?></b></td></tr>
            <tr>
               <td>Last oil change</td>
               <td>
                  <?php if($details->oil_change != ""): ?>
                     <b><?php echo date('F jS, Y', strtotime($details->oil_change)); ?></b>
                  <?php endif; ?>
               </td>
            </tr>
            <tr><td>Licence plate</td><td><b><?php echo $details->licence_plate; ?></b></td></tr>
            <tr><td>Vehicle year of manufacture</td><td><b><?php echo $details->vehicle_year_of_manufacture; ?></b></td></tr>
            <tr><td>Vehicle color</td><td><b><?php echo $details->vehicle_color; ?></b></td></tr>
         </tbody>
     </table>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/assets/assets/vehicle.blade.php ENDPATH**/ ?>