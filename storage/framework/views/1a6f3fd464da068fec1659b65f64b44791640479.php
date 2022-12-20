<!-- bank account -->
<div class="modal fade" id="bankandcash" tabindex="-1" role="dialog" aria-labelledby="bankandcash" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form id="bankandcashForm" action="javascript:void(0)">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="bankandcash">Add Bank or Cash Account</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <?php echo csrf_field(); ?>
               <div class="form-group">
                  <label for="">Account Name</label>
                  <input type="text" name="title" class="form-control" id="accountTitle" placeholder="Enter account name" required>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" id="saveBankCash" class="btn btn-success">Save changes</button>
               <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%" style="display: none">
            </div>
         </div>
      </form>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/accounts/express.blade.php ENDPATH**/ ?>