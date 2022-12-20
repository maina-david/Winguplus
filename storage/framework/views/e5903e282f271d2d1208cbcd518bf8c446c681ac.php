<?php if(Auth::user()->langID == ""): ?>
   <?php echo App::setLocale(Helper::language(Auth::user()->langID)->short ); ?>

<?php else: ?>
   <?php echo App::setLocale(Helper::language({!! Helper::settings()->language_id; ?>)->short ) !!}
<?php endif; ?><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/partials/_language.blade.php ENDPATH**/ ?>