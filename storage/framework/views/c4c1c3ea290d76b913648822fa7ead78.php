

<?php if($paginator->hasPages()): ?> 
<ul class="pagination">
      <?php if($paginator->onFirstPage()): ?> 
      <li class="paginate_button page-item previous" id="DataTables_Table_3_previous">
        <a href="#" aria-controls="DataTables_Table_3" role="link" data-dt-idx="previous" tabindex="0" class="page-link">First</a>
      </li>
      
      <?php else: ?> 
      
      <li class="page-item"><a class="page-link"
         href="<?php echo e($paginator->previousPageUrl()); ?>"> 
         Previous</a> 
         
      </li>
      <?php endif; ?> 
      
      <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
      <?php if(is_string($element)): ?> 
      <li class="paginate_button page-item next disabled" id="DataTables_Table_3_next"><a href="#" aria-controls="DataTables_Table_3" role="link" data-dt-idx="next" tabindex="0" class="page-link">...</a></li>
      
      <?php endif; ?> 
      
      <?php if(is_array($element)): ?> 
      <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
      <?php if($page == $paginator->currentPage()): ?> 
      <li class="paginate_button page-item active"><a href="#" aria-controls="DataTables_Table_3" role="link" data-dt-idx="0" tabindex="0" class="page-link"><?php echo e($page); ?></a></li>
      
      <?php else: ?> 
      <li class="paginate_button page-item "><a href="<?php echo e($url); ?>" aria-controls="DataTables_Table_3" role="link" data-dt-idx="1" tabindex="0" class="page-link"><?php echo e($page); ?></a></li>
      
      <?php endif; ?> 
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
      <?php endif; ?> 
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
      
      <?php if($paginator->hasMorePages()): ?> 
      <li class="paginate_button page-item next " id="DataTables_Table_3_next"><a href="<?php echo e($paginator->nextPageUrl()); ?>" aria-controls="DataTables_Table_3" role="link" data-dt-idx="next" tabindex="0" class="page-link">Next</a></li>
      
      <?php else: ?> 
      
      <li class="paginate_button page-item next disabled" id="DataTables_Table_3_next"><a href="<?php echo e($paginator->nextPageUrl()); ?>" aria-controls="DataTables_Table_3" role="link" data-dt-idx="next" tabindex="0" class="page-link">Next</a></li>
      <?php endif; ?> 
      
   </ul>
<?php endif; ?><?php /**PATH /var/www/html/kgadmission/resources/views/pagination.blade.php ENDPATH**/ ?>