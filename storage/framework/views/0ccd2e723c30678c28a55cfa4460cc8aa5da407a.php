<?php if($paginator->hasPages()): ?>
   <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
         
         <?php if($paginator->onFirstPage()): ?>
            <li class="page-item disabled mr-2"><a class="page-link">Previous</a></li>
         <?php else: ?>
            <li class="page-item mr-2"><a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">Previous</a></li>
         <?php endif; ?>

         <?php if($paginator->currentPage() > 3): ?>
            <li class="hidden-xs mr-2"><a class="page-link" href="<?php echo e($paginator->url(1)); ?>">1</a></li>
         <?php endif; ?>
         <?php if($paginator->currentPage() > 4): ?>
            <li class="page-item mr-2"><a class="page-link">...</a></li>
         <?php endif; ?>
         <?php $__currentLoopData = range(1, $paginator->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2): ?>
                  <?php if($i == $paginator->currentPage()): ?>
                     <li class="page-item active mr-2"><a class="page-link"><?php echo e($i); ?></a></li>
                  <?php else: ?>
                     <li class="page-item mr-2"><a class="page-link" href="<?php echo e($paginator->url($i)); ?>"><?php echo e($i); ?></a></li>
                  <?php endif; ?>
            <?php endif; ?>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php if($paginator->currentPage() < $paginator->lastPage() - 3): ?>
            <li class="page-item mr-2"><a class="page-link">...</a></li>
         <?php endif; ?>
         <?php if($paginator->currentPage() < $paginator->lastPage() - 2): ?>
            <li class="page-item hidden-xs mr-2"><a class="page-link" href="<?php echo e($paginator->url($paginator->lastPage())); ?>"><?php echo e($paginator->lastPage()); ?></a></li>
         <?php endif; ?>

         
         <?php if($paginator->hasMorePages()): ?>
            <li class="page-item"><a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">Next</a></li>
         <?php else: ?>
            <li class="page-item disabled"><a class="page-link">Next</a></li>
         <?php endif; ?>
      </ul>
   </nav>
<?php endif; ?>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/pagination/custom.blade.php ENDPATH**/ ?>