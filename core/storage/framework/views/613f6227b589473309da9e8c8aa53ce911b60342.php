<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Image'); ?></th>
                                    <th><?php echo app('translator')->get('Name'); ?> | <?php echo app('translator')->get('SKU'); ?> </th>
                                    <th><?php echo app('translator')->get('Category'); ?> | <?php echo app('translator')->get('Brand'); ?></th>
                                    <th><?php echo app('translator')->get('Stock'); ?> </th>
                                    <th><?php echo app('translator')->get('Total Sale'); ?> | <?php echo app('translator')->get('Alert Qty'); ?></th>
                                    <th><?php echo app('translator')->get('Unit'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo e(getImage(getFilePath('product') . '/' . $product->image, getFileSize('product'))); ?>">
                                        </td>

                                        <td class="long-text">
                                            <span class="fw-bold text--primary"><?php echo e(__($product->name)); ?></span>
                                            <br>
                                            <span class="text--small "><?php echo e($product->sku); ?> </span>
                                        </td>

                                        <td>
                                            <?php echo e(__($product->category->name)); ?>

                                            <br>
                                            <span class="text--primary"><?php echo e($product->brand->name); ?></span>
                                        </td>

                                        <td>
                                            <?php echo e($product->totalInStock()); ?>

                                        </td>

                                        <td>
                                            <?php echo e($product->totalSale()); ?>

                                            <br>
                                            <span class="badge badge--warning"><?php echo e($product->alert_quantity); ?></span>
                                        </td>

                                        <td> <?php echo e($product->unit->name); ?></td>

                                        <td>
                                            <div class="button--group">
                                                <a href="<?php echo e(route('admin.product.edit', $product->id)); ?>" class="btn btn-sm btn-outline--primary ms-1 editBtn"><i class="las la-pen"></i> <?php echo app('translator')->get('Edit'); ?></a>
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
                <?php if($products->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo paginateLinks($products) ?>
                    </div>
                <?php endif; ?>
            </div><!-- card end -->
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b = $component; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\ConfirmationModal::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b)): ?>
<?php $component = $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b; ?>
<?php unset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['placeholder' => 'Name or SKU']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Name or SKU']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <a href="<?php echo e(route('admin.product.create')); ?>" class="btn btn-outline--primary">
        <i class="la la-plus"></i><?php echo app('translator')->get('Add New'); ?>
    </a>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\www\bossislandinv\core\resources\views/admin/product/index.blade.php ENDPATH**/ ?>