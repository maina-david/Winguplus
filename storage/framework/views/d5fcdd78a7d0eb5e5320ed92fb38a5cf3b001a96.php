<div class="card mt-3">
   <div class="card-header">Lead Information</div>
   <div class="card-body">
      <div class="row">
         <div class="col-md-3">
            <?php if($lead->image != ""): ?>
               <img class="rounded-circle" alt="" class="<?php echo $lead->names; ?>" src="<?php echo asset('businesses/'.$lead->businessID.'/clients/'.$lead->customer_code.'/images/'.$lead->image); ?>" style="width:178px;height:178px">
            <?php else: ?>
               <img src="https://ui-avatars.com/api/?name=<?php echo $lead->customer_name; ?>&rounded=false&size=178" alt="">
            <?php endif; ?>
         </div>
         <div class="col-md-5">
            <table>
               <tr class="mb-3">
                  <td align="right"><b>Lead Owner :</b></td>
                  <td>
                     <?php if($lead->assignedID != ""): ?>
                        <?php if(Wingu::check_user($lead->assignedID) == 1): ?>
                           <span class="text-pink"> <?php echo Wingu::user($lead->assignedID)->name; ?></span>
                        <?php endif; ?>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="40%" align="right"><b>Title :</b></td>
                  <td><span class="text-pink"> <?php echo $lead->title; ?></span></td>
               </tr>
               <tr class="mb-2">
                  <td width="40%"  align="right"><b>Phone :</b></td>
                  <td><span class="text-pink"> <?php echo $lead->primary_phone_number; ?></span></td>
               </tr>
               <tr class="mb-2">
                  <td width="40%"  align="right"><b>Lead Source :</b></td>
                  <td>
                     <?php if(Hr::check_source($lead->sourceID) == 1): ?>
                        <span class="text-pink"> <?php echo Hr::source($lead->sourceID)->name; ?></span>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="40%"  align="right"><b>Industry :</b></td>
                  <td>
                     <?php if($lead->industryID != ""): ?>
                        <span class="text-pink"> <?php echo Wingu::industry($lead->industryID)->name; ?></span>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="40%"  align="right"><b>Created By :</b></td>
                  <td>
                     <?php if(Wingu::check_user($lead->created_by) == 1): ?>
                        <span class="text-pink"> <?php echo Wingu::user($lead->created_by)->name; ?></span> @ <?php echo date('Y-m-d h:i:sa', strtotime($lead->created_at)); ?>

                     <?php endif; ?>
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="40%"  align="right"><b>Updated By :</b></td>
                  <td>
                     <?php if(Wingu::check_user($lead->updated_by) == 1): ?>
                        <span class="text-pink"> <?php echo Wingu::user($lead->updated_by)->name; ?></span> @ <?php echo date('Y-m-d h:i:sa', strtotime($lead->updated_at)); ?>

                     <?php endif; ?>
                  </td>
               </tr>
            </table>
         </div>
         <div class="col-md-4">
            <table>
               <tr class="mb-2">
                  <td width="45%"  align="right"><b>Email :</b></td>
                  <td>
                     <span class="text-pink"> <?php echo $lead->emails; ?></span>
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="45%"  align="right"><b>Postal address :</b></td>
                  <td>
                     <span class="text-pink"> <?php echo $lead->bill_postal_address; ?></span>
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="45%"  align="right"><b>zip code :</b></td>
                  <td>
                     <span class="text-pink"> <?php echo $address->bill_zip_code; ?></span>
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="45%"  align="right"><b>Country :</b></td>
                  <td>
                     <span class="text-pink"> <?php echo $address->bill_country; ?></span>
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="45%"  align="right"><b>City :</b></td>
                  <td>
                     <span class="text-pink"> <?php echo $address->bill_city; ?></span>
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="45%"  align="right"><b>State :</b></td>
                  <td>
                     <span class="text-pink"> <?php echo $address->bill_state; ?></span>
                  </td>
               </tr>
            </table>
         </div>
      </div>
   </div>
</div>
<div class="card mt-3">
   <div class="card-header">Lead Description</div>
   <div class="card-body">
      <?php echo $lead->remarks; ?>

   </div>
</div>
<div class="card mt-3">
   <div class="card-header"> Contact persons </div>
   <div class="card-body">
      <table class="table table-bordered">
         <tr>
            <th width="1%">#</th>
            <th>Names</th>
            <th>Email Address</th>
            <th>Phone number</th>
            <th>Designation</th>
         </tr>
         <?php $__currentLoopData = $persons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <td><?php echo $count++; ?></td>
               <td>
                  <?php echo $cp->salutation; ?> <?php echo $cp->names; ?>

               </td>
               <td><?php echo $cp->contact_email; ?></td>
               <td><?php echo $cp->phone_number; ?></td>
               <td><?php echo $cp->designation; ?></td>
            </tr>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </table>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/leads/view.blade.php ENDPATH**/ ?>