<?php $__env->startSection('scripts'); ?>
   <script>
      $('a#addRows').cloneData({
         mainContainerId: 'invoiceItems', // Main container Should be ID
         cloneContainer: 'clone-item', // Which you want to clone
         removeButtonClass: 'remove-item', // Remove button for remove cloned HTML
         removeConfirm: true, // default true confirm before delete clone item
         removeConfirmMessage: 'Are you sure want to delete?', // confirm delete message
         //append: '<a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media">Remove</a>', // Set extra HTML append to clone HTML
         minLimit: 1, // Default 1 set minimum clone HTML required
         maxLimit: 100, // Default unlimited or set maximum limit of clone HTML
         defaultRender: 1,
         init: function () {
            console.info(':: Initialize Plugin ::');
         },
         beforeRender: function () {
            console.info(':: Before rendered callback called');
         },
         afterRender: function () {
            console.info(':: After rendered callback called');
            //$(".selectpicker").selectpicker('refresh');
         },
         afterRemove: function () {
            console.warn(':: After remove callback called');
         },
         beforeRemove: function () {
            console.warn(':: Before remove callback called');
         }
      });
   </script>
   <script>
      //adds extra table rows
      var i=$('table tr').length;
      var no = 0;

      /* === INVOICE === */
      $(document).on('change', '.solsoCloneSelect2','.changesNo', function() {
         inputPrice = $(this).closest('tr').find("[name='price[]']");
         $.ajax({
            url: "<?php echo e(URL::route('finance.ajax.product.price')); ?>",
            type: 'post',
            dataType: 'json',
            data: { product: $(this).val(),"_token": $('#token').val() },
            success:function(data) {
               inputPrice.val(data['selling_price']);
            }
         });
      });
      var readonly = $('#readonly').val();

      //price change
      $(document).on('keyup','.changesNo',function(){
         id_arr = $(this).attr('id');
         id = id_arr.split("_");

         quantity = $('#quantity_'+id[1]).val();
         price = $('#price_'+id[1]).val();
         discount = $('#discount_'+id[1]).val();
         taxRate = $('#tax_'+id[1]).val();
         tax = taxRate/100;

         //if(quantity != "" && price != "")
         amount = price * quantity;
         AmountAfterDiscount = amount - discount;
         TaxValue = AmountAfterDiscount * tax;
         totalSum = TaxValue + AmountAfterDiscount;

         $('#mainAmount_'+id[1]).val(amount);
         $('#taxvalue_'+id[1]).val(TaxValue);
         $('#amount_'+id[1]).val(amount);
         $('#total_'+id[1]).val(AmountAfterDiscount);
         $('#sum_'+id[1]).val(totalSum);
         calculateTotal();
      });

      $(document).on('change','.onchange',function(){
         id_arr = $(this).attr('id');
         id = id_arr.split("_");

         quantity = $('#quantity_'+id[1]).val();
         price = $('#price_'+id[1]).val();
         discount = $('#discount_'+id[1]).val();
         taxRate = $('#tax_'+id[1]).val();
         tax = taxRate/100;

         amount = price * quantity;
         AmountAfterDiscount = amount - discount;
         TaxValue = AmountAfterDiscount * tax;
         totalSum = TaxValue + AmountAfterDiscount;

         $('#mainAmount_'+id[1]).val(amount);
         $('#taxvalue_'+id[1]).val(TaxValue);
         $('#amount_'+id[1]).val(amount);
         $('#total_'+id[1]).val(AmountAfterDiscount);
         $('#sum_'+id[1]).val(totalSum);
         calculateTotal();
      });

      //total price calculation
      function calculateTotal(){
         subTotal = 0 ;
         mainTotal = 0;
         discountTotal = 0;
         taxTotal = 0;
         sumTotal = 0;

         //main total
         $('.mainAmount').each(function(){
            if($(this).val() != '' )
            mainTotal += parseFloat($(this).val() );
            mainTotal = mainTotal;
         });
         $('#mainAmountF').val(mainTotal.toFixed(2));

         //sub total
         $('.totalLinePrice').each(function(){
            if($(this).val() != '' )
            subTotal += parseFloat($(this).val() );
            subTotal = subTotal;
         });
         $('#subTotal').val(subTotal.toFixed(2));

         //tax total
         $('.totalLineTax').each(function(){
            if($(this).val() != '' )
            taxTotal += parseFloat($(this).val());
            taxTotal = taxTotal;
         });
         $('#taxvalue').val(taxTotal.toFixed(2));

         //tax total
         $('.discount').each(function(){
            if($(this).val() != '' )
            discountTotal += parseFloat($(this).val());
            discountTotal = discountTotal;
         });
         $('#discountTotal').val(discountTotal.toFixed(2));

         //total amount
         $('.totalSum').each(function(){
            if($(this).val() != '')
            sumTotal += parseFloat($(this).val());
            sumTotal = sumTotal;
         });
         $('#InvoicetotalAmount').val(sumTotal.toFixed(2) );
      }

      //It restrict the non-numbers
      var specialKeys = new Array();
      specialKeys.push(8,46); //Backspace
      function IsNumeric(e) {
         var keyCode = e.which ? e.which : e.keyCode;
         if(keyCode == 9 )return true;
         var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
         return ret;
      }
   </script>
   <script type="text/javascript">
      $('#client_select').on('change',function(e){
         console.log(e);
         var client_code =  e.target.value;
         var url = "<?php echo e(url('/')); ?>"

         //ajax
         $.get(url+'/finance/retrive_client/'+client_code, function(data){
            //success data
            $('#invoice_no').empty();
            $.each(data, function(invoices, info){
               $('#invoice_no').append('<option value="'+ info.id +'">00'+ info.invoice_number +'</option>');
            });
         });
      });
      $('#taxconfig').on('change', function() {
			if(this.value == 'Exclusive') {
				$('#taxfield').hide();
			} else {
				$('#taxfield').show();
			}
		});
   </script>
   <script>
      $('#products').on('change',function(e){
         console.log(e);
         var product =  e.target.value;
         var url = "<?php echo e(url('/')); ?>"
         //ajax
         $.get(url+'/subscriptions/'+product+'/plans', function(data){
            //success data
            $('#subscriptions').empty();
            $.each(data, function(subscriptions, subscription){
               $('#subscriptions').append('<option value="'+ subscription.productID +'">'+subscription.product_name+'</option>');
               $('.subscription_price').val(subscription.selling_price);
               $('#trial_days').val(subscription.trial_days);
            });
         });
      });
      $('#subscriptions').on('change',function(e){
         console.log(e);
         var product =  e.target.value;
         var url = "<?php echo e(url('/')); ?>"
         //ajax
         $.get(url+'/subscriptions/plans/'+product+'/price', function(data){
            //success data
            $('.subscription_price').empty();
            $.each(data, function(prices, price){
               $('.subscription_price').val(price.selling_price);
            });
         });
      });
      $('#expiration_cycle').on('change', function() {
         if (this.value == 'Enter cycle') {
            $('#cycles').show();
         }else{
            $('#cycles').hide();
         }
      });
      $('#payment_status').on('change', function() {
         if (this.value == 'Yes') {
            $('#amount_paid').show();
         }else{
            $('#amount_paid').hide();
         }
      });
   </script>
   <?php echo $__env->make('app.partials._express_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/finance/partials/_lpo.blade.php ENDPATH**/ ?>