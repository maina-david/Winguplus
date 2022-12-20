<div
    <?php if($eventClickEnabled): ?>
        wire:click.stop="onEventClick('<?php echo e($event['id']); ?>')"
    <?php endif; ?>
    class="bg-white rounded-lg border py-2 px-3 shadow-md cursor-pointer">

    <p class="text-sm font-medium">
        <?php echo e($event['title']); ?>

    </p>
    <p class="mt-2 text-xs">
        <?php echo e($event['description'] ?? 'No description'); ?>

    </p>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/vendor/asantibanez/livewire-calendar/resources/views/event.blade.php ENDPATH**/ ?>