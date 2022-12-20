<script>
    var calendar;
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar-<?php echo e($id); ?>')
        calendar = new FullCalendar.Calendar(calendarEl,
            <?php echo $options; ?>,
        );
        calendar.render();
    });
</script>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/vendor/acaronlex/laravel-calendar/src/views/script.blade.php ENDPATH**/ ?>