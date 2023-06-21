<?php $__env->startSection('panel'); ?>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body">
                    <form action="">
                        <div class="row gy-4 justfi-conent-end align-items-end">
                            <div class="col-lg-4">
                                <label class="required"><?php echo app('translator')->get('Filter By'); ?></label>
                                <select class="form-control" name="type">
                                    <option value="warehouse" <?php if(request()->type == 'warehouse'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Warehouse'); ?></option>
                                    <option value="product" <?php if(request()->type == 'product'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Product'); ?></option>
                                </select>
                            </div>

                            <div class="col-lg-4">
                                <div class="warehouse-field <?php if(request()->product): ?> d-none <?php endif; ?>">
                                    <label class="required"><?php echo app('translator')->get('Warehouse'); ?></label>
                                    <select class="form-control" name="warehouse" <?php if(!request()->product): ?> d-none <?php endif; ?>>
                                        <option value=""><?php echo app('translator')->get('Select One'); ?></option>
                                        <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($warehouse->id); ?>" <?php if(request()->warehouse == $warehouse->id): echo 'selected'; endif; ?>> <?php echo e(__($warehouse->name)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="product-field position-relative <?php if(!request()->product): ?> d-none <?php endif; ?>">
                                    <label class="required"><?php echo app('translator')->get('Product'); ?></label>
                                    <select name="product" class="form-control " id="product">
                                        <?php if(request()->product): ?>
                                            <option value="<?php echo e(request()->product); ?>"> <?php echo e($productName); ?></option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <button type="submit" class="btn btn--primary h-45 w-100">
                                    <i class="la la-filter"></i><?php echo app('translator')->get('Filter'); ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- card end -->
        </div>
    </div>


    <?php echo $__env->make('admin.reports.stock.partials.by_product', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.reports.stock.partials.by_warehouse', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <?php $__env->startPush('script'); ?>
        <script>
            (function($) {
                "use strict";
                $('[name=type]').on('change', function() {

                    if ($(this).val() === 'warehouse') {
                        $('.warehouse-field').removeClass('d-none');
                        $('.product-field').addClass('d-none');
                        $('[name=product]').val('');
                    } else {
                        $('.warehouse-field').addClass('d-none');
                        $('.product-field').removeClass('d-none');
                        $('[name=warehouse]').val('');
                    }
                });

                $('#product').select2({
                    ajax: {
                        url: '<?php echo e(route('admin.product.list')); ?>',
                        type: "get",
                        dataType: 'json',
                        delay: 1000,
                        data: function(params) {
                            return {
                                search: params.term,
                                page: params.page, // Page number, page breaks
                            };
                        },
                        processResults: function(response, params) {
                            params.page = params.page || 1;
                            let data = response.products.data;
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: `${item.name} (${item.sku})`,
                                        id: item.id
                                    }
                                }),
                                pagination: {
                                    more: response.more
                                }
                            };
                        },
                        cache: false
                    },
                    dropdownParent: $(".product-field")
                }); //end here


            })(jQuery);
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\www\bossislandinv\core\resources\views/admin/reports/stock/index.blade.php ENDPATH**/ ?>