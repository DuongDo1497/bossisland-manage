<?php $__env->startSection('panel'); ?>
    <?php if(@json_decode($general->system_info)->version > systemDetails()['version']): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo app('translator')->get('New Version Available'); ?> <button class="btn btn--dark float-end"><?php echo app('translator')->get('Version'); ?>
                                <?php echo e(json_decode($general->system_info)->version); ?></button> </h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-dark"><?php echo app('translator')->get('What is the Update ?'); ?></h5>
                        <p>
                            <pre class="f-size--24"><?php echo e(json_decode($general->system_info)->details); ?></pre>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if(@json_decode($general->system_info)->message): ?>
        <div class="row">
            <?php $__currentLoopData = json_decode($general->system_info)->message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-12">
                    <div class="alert border border--primary" role="alert">
                        <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
                        <p class="alert__message"><?php echo $msg; ?></p>
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <div class="row gy-4 mb-30">
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-shopping-cart overlay-icon text--primary"></i>
                <div class="widget-two__icon b-radius--5 bg--primary">
                    <i class="las la-shopping-cart"></i>
                </div>
                <div class="widget-two__content">
                    <h3> <?php echo e($general->cur_sym); ?><?php echo e(showAmount($widget['total_sale'])); ?></h3>
                    <p><?php echo app('translator')->get('Sales'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.sale.index')); ?>" class="widget-two__btn border border--primary btn-outline--primary"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="fas la-undo overlay-icon text--warning"></i>
                <div class="widget-two__icon b-radius--5 bg--warning">
                    <i class="las la-undo"></i>
                </div>
                <div class="widget-two__content">
                    <h3><?php echo e($general->cur_sym); ?><?php echo e(showAmount($widget['total_sale_return'])); ?></h3>
                    <p><?php echo app('translator')->get('Sales Return'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.sale.return.index')); ?>" class="widget-two__btn border border--warning btn-outline--warning"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-shopping-bag overlay-icon text--success"></i>
                <div class="widget-two__icon b-radius--5 bg--success">
                    <i class="las la-shopping-bag"></i>
                </div>
                <div class="widget-two__content">
                    <h3><?php echo e($general->cur_sym); ?><?php echo e(showAmount($widget['total_purchase'])); ?></h3>
                    <p><?php echo app('translator')->get('Purchases'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.purchase.index')); ?>" class="widget-two__btn border border--success btn-outline--success"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-share  overlay-icon text--danger"></i>
                <div class="widget-two__icon b-radius--5 bg--danger">
                    <i class="las la-share"></i>
                </div>
                <div class="widget-two__content">
                    <h3><?php echo e($general->cur_sym); ?><?php echo e(showAmount($widget['total_purchase_return'])); ?></h3>
                    <p><?php echo app('translator')->get('Purchases Return'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.purchase.return.index')); ?>" class="widget-two__btn border border--danger btn-outline--danger"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->


    <div class="row gy-4 mb-30">
        <div class="col-xxl-7">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h5><?php echo app('translator')->get('Monthly Purchase & Sales Report'); ?> (<?php echo app('translator')->get('Last 12 Month'); ?>)</h5>
            </div>
            <div class="card">
                <div class="card-body">
                    <div id="apex-bar-chart"> </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-5">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h5><?php echo app('translator')->get('Top Selling Products'); ?></h5>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Product'); ?></th>
                                    <th><?php echo app('translator')->get('SKU'); ?></th>
                                    <th><?php echo app('translator')->get('Quantity'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $topSellingProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>

                                        <td data-label="<?php echo app('translator')->get('Product'); ?>">
                                            <?php echo e($loop->iteration); ?>. &nbsp;
                                            <a class="text--dark" href="<?php echo e(route('admin.product.edit', $product->id)); ?>"><?php echo e(strLimit(__($product->name), 20)); ?></a>
                                        </td>
                                        <td data-label="<?php echo app('translator')->get('Quantity'); ?>"><?php echo e($product->sku); ?> </td>
                                        <td data-label="<?php echo app('translator')->get('Quantity'); ?>"><?php echo e($product->total_sale); ?> <?php echo e($product->unit->name); ?> </td>
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
            </div>
        </div>
    </div>

    <div class="row gy-4 mb-30">
        <div class="col-xl-6">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h5><?php echo app('translator')->get('Product Alert Items'); ?> </h5>
                <a href="<?php echo e(route('admin.product.alert')); ?>" class="btn btn-sm btn-outline--primary"><?php echo app('translator')->get('View All'); ?></a>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Product'); ?></th>
                                    <th><?php echo app('translator')->get('Warehouse'); ?></th>
                                    <th><?php echo app('translator')->get('Alert'); ?></th>
                                    <th><?php echo app('translator')->get('Stock'); ?></th>
                                    <th><?php echo app('translator')->get('Unit'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $widget['alertProductsQty']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alertQty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="fw-bold"> <?php echo e($alertQty->name); ?> </td>
                                        <td> <?php echo e($alertQty->warehouse_name); ?> </td>
                                        <td>
                                            <span class="bg--warning px-2 rounded">
                                                <?php echo e($alertQty->alert_quantity); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="bg--danger px-2 rounded">
                                                <?php echo e($alertQty->quantity); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php echo e($alertQty->unit_name); ?>

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
            </div>
        </div>

        <div class="col-xl-6">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h5><?php echo app('translator')->get('Latest Sale Returns'); ?> </h5>
                <a href="<?php echo e(route('admin.sale.return.index')); ?>" class="btn btn-sm btn-outline--primary"><?php echo app('translator')->get('View All'); ?></a>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Date'); ?></th>
                                    <th><?php echo app('translator')->get('Invoice No.'); ?> </th>
                                    <th><?php echo app('translator')->get('Customer'); ?></th>
                                    <th><?php echo app('translator')->get('Amount'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $saleReturns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <?php echo e(showDateTime($return->return_date, 'd M, Y')); ?>

                                        </td>

                                        <td>
                                            <a class="text--dark" href="<?php echo e(route('admin.sale.return.edit', $return->id)); ?>"><?php echo e($return->sale->invoice_no); ?></a>
                                        </td>

                                        <td>
                                            <?php echo e($return->customer->name); ?>

                                        </td>

                                        <td>
                                            <?php echo e($general->cur_sym . showAmount($return->payable_amount)); ?>

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
            </div>
        </div>


    </div>


    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two style--two box--shadow2 b-radius--5 bg--1">
                <i class="las la-layer-group overlay-icon text--white"></i>
                <div class="widget-two__icon b-radius--5 bg--primary">
                    <i class="lab la-buffer"></i>
                </div>
                <div class="widget-two__content">
                    <h3 class="text-white"><?php echo e($widget['total_category']); ?></h3>
                    <p class="text-white"><?php echo app('translator')->get('Categories'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.product.category.index')); ?>" class="widget-two__btn"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two style--two box--shadow2 b-radius--5 bg--primary">
                <i class="lab la-product-hunt overlay-icon text--white"></i>
                <div class="widget-two__icon b-radius--5 bg--primary">
                    <i class="lab la-product-hunt"></i>
                </div>
                <div class="widget-two__content">
                    <h3 class="text-white"><?php echo e($widget['total_product']); ?></h3>
                    <p class="text-white"><?php echo app('translator')->get('Products'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.product.index')); ?>" class="widget-two__btn"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--18 has-link box--shadow2">
                <a href="<?php echo e(route('admin.supplier.index')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-user-friends f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Supplier'); ?></span>
                            <h2 class="text-white"><?php echo e($widget['total_supplier']); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--12 has-link overflow-hidden box--shadow2">
                <a href="<?php echo e(route('admin.customer.index')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-users f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Customers'); ?></span>
                            <h2 class="text-white"><?php echo e($widget['total_customers']); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .widget-two__btn {
            right: 15px !important;
        }
    </style>
<?php $__env->stopPush(); ?>




<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/admin/js/vendor/apexcharts.min.js')); ?>"></script>

    <script>
        "use strict";
        window.onload = function() {

            var options = {
                series: [{
                        name: 'Total Purchase',
                        data: <?php echo json_encode($purchaseData, 15, 512) ?>
                    },
                    {
                        name: 'Total Purchase Return',
                        data: <?php echo json_encode($purchaseReturnData, 15, 512) ?>
                    },
                    {
                        name: 'Total Sale',
                        data: <?php echo json_encode($saleData, 15, 512) ?>
                    },
                    {
                        name: 'Total Sale Return',
                        data: <?php echo json_encode($saleReturnData, 15, 512) ?>
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 417,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '50%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: <?php echo json_encode($months, 15, 512) ?>
                },
                yaxis: {
                    title: {
                        text: "<?php echo e($general->cur_text); ?>",
                        style: {
                            color: '#7c97bb'
                        }
                    }
                },
                grid: {
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false
                        }
                    },
                },
                fill: {
                    colors: ['#008ffb', '#fbb225', '#00e396', '#ea5455'],
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return `<?php echo e($general->cur_sym); ?> ${val}`
                        }
                    }
                },
                legend: {
                    markers: {
                        width: 12,
                        height: 12,
                        strokeWidth: 0,
                        strokeColor: '#fff',
                        fillColors: ['#008ffb', '#fbb225', '#00e396', '#ea5455'],
                        radius: 12,
                    },
                }
            };

            var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
            chart.render();
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\www\bossislandinv\core\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>