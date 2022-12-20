<script>
    let calendar;
    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar-<?php echo e($id); ?>')
        calendar = new Calendar(calendarEl,
            <?php echo $options; ?>,
        );
        calendar.render();
    });
</script>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/vendor/acaronlex/laravel-calendar/src/views/script-es6.blade.php ENDPATH**/ ?>