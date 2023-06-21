<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">

                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('S.N.'); ?></th>
                                    <th><?php echo app('translator')->get('Tracking No.'); ?></th>
                                    <th><?php echo app('translator')->get('Date'); ?></th>
                                    <th><?php echo app('translator')->get('From'); ?></th>
                                    <th><?php echo app('translator')->get('To'); ?></th>
                                    <th><?php echo app('translator')->get('Products'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $transfers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transfer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($transfers->firstItem() + $loop->index); ?></td>
                                        <td><?php echo e($transfer->tracking_no); ?> </td>
                                        <td><?php echo e(showDateTime($transfer->transfer_date, 'd M, Y')); ?></td>
                                        <td><?php echo e($transfer->warehouse->name); ?> </td>
                                        <td><?php echo e($transfer->toWarehouse->name); ?> </td>
                                        <td><?php echo e($transfer->transfer_details_count); ?></td>
                                        <td>
                                            <div class="button--group">
                                                <a href="<?php echo e(route('admin.transfer.edit', $transfer->id)); ?>" class="btn btn-sm btn-outline--primary ms-1 editBtn"><i class="la la-pen"></i> <?php echo app('translator')->get('Edit'); ?>
                                                </a>
                                                <a class="btn btn-sm  btn-outline--info" href="<?php echo e(route('admin.transfer.pdf', $transfer->id)); ?>">
                                                    <i class="la la-download"></i> <?php echo app('translator')->get('Download'); ?>
                                                </a>
                                            </div>
                                        </td>
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
                <?php if($transfers->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo paginateLinks($transfers) ?>
                    </div>
                <?php endif; ?>
            </div><!-- card end -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['dateSearch' => 'yes']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['dateSearch' => 'yes']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <a href="<?php echo e(route('admin.transfer.create')); ?>" class="btn btn-outline--primary h-45">
        <i class="la la-plus"></i><?php echo app('translator')->get('Add New'); ?>
    </a>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\www\bossislandinv\core\resources\views/admin/transfer/index.blade.php ENDPATH**/ ?>