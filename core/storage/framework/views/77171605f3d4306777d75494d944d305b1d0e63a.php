<?php if(request()->warehouse): ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two custom-data-table table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('S.N.'); ?></th>
                                    <th><?php echo app('translator')->get('Name'); ?></th>
                                    <th><?php echo app('translator')->get('SKU'); ?></th>
                                    <th><?php echo app('translator')->get('Category'); ?></th>
                                    <th><?php echo app('translator')->get('Brand'); ?></th>
                                    <th><?php echo app('translator')->get('Stock'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $stocksByWarehouse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($stock->product->name); ?></td>
                                        <td><?php echo e($stock->product->sku); ?></td>
                                        <td><?php echo e($stock->product->category->name); ?> </td>
                                        <td><?php echo e($stock->product->brand->name); ?> </td>
                                        <td><?php echo e($stock->quantity . ' ' . $stock->product->unit->name); ?> </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\www\bossislandinv\core\resources\views/admin/reports/stock/partials/by_warehouse.blade.php ENDPATH**/ ?>