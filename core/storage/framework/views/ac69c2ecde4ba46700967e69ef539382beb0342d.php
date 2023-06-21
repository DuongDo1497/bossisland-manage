<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 bg--transparent">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two bg-white">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Invoice No.'); ?> | <?php echo app('translator')->get('Date'); ?></th>
                                    <th><?php echo app('translator')->get('Customer'); ?> | <?php echo app('translator')->get('Mobile'); ?></th>
                                    <th><?php echo app('translator')->get('Warehouse'); ?> | <?php echo app('translator')->get('Total Amount'); ?></th>
                                    <th><?php echo app('translator')->get('Discount'); ?> | <?php echo app('translator')->get('Receivable'); ?></th>
                                    <th><?php echo app('translator')->get('Received'); ?> | <?php echo app('translator')->get('Due'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <?php if($sale->return_status == 1): ?>
                                                <small><i class="fa fa-circle text--danger" title="<?php echo app('translator')->get('Returned'); ?>" aria-hidden="true"></i></small>
                                            <?php endif; ?>
                                            <span class="fw-bold"> <?php echo e($sale->invoice_no); ?></span>
                                            <br>
                                            <em><?php echo e(showDateTime($sale->sale_date, 'd M, Y')); ?></em>
                                        </td>

                                        <td>
                                            <span class="text--primary fw-bold"> <?php echo e($sale->customer->name); ?></span>
                                            <br>
                                            +<?php echo e($sale->customer->mobile); ?>

                                        </td>

                                        <td>
                                            <?php echo e($sale->warehouse->name); ?>

                                            <br>
                                            <span class="fw-bold"><?php echo e($general->cur_sym . showAmount($sale->total_price)); ?></span>
                                        </td>

                                        <td><?php echo e($general->cur_sym . showAmount($sale->discount_amount)); ?>

                                            <br>
                                            <span class="fw-bold">
                                                <?php echo e($general->cur_sym . showAmount($sale->receivable_amount)); ?></span>
                                        </td>

                                        <td>
                                            <?php echo e($general->cur_sym . showAmount($sale->received_amount)); ?>

                                            <br>
                                            <span <?php if($sale->due_amount < 0): ?> class="text--danger" title="<?php echo app('translator')->get('Give Payment To Customer'); ?>" <?php endif; ?> class="fw-bold">
                                                <?php echo e($general->cur_sym . showAmount($sale->due_amount)); ?>

                                            </span>
                                        </td>

                                        <td>
                                            <div class="button--group">

                                                <a href="<?php echo e(route('admin.sale.edit', $sale->id)); ?>" class="btn btn-sm btn-outline--primary ms-1">
                                                    <i class="la la-pen"></i> <?php echo app('translator')->get('Edit'); ?>
                                                </a>

                                                <button type="button" class="btn btn-sm btn-outline--info ms-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="la la-ellipsis-v"></i><?php echo app('translator')->get('More'); ?>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <a href="javascript:void(0)" class="dropdown-item paymentModalBtn" data-customer_id="<?php echo e($sale->customer_id); ?>" data-customer="<?php echo e($sale->customer->name); ?>" data-invoice="<?php echo e($sale->invoice_no); ?>" data-id="<?php echo e($sale->id); ?>" data-due_amount="<?php echo e($sale->due_amount); ?>">

                                                        <?php if($sale->due_amount > 0): ?>
                                                            <i class="la la-hand-holding-usd"></i>
                                                            <?php echo app('translator')->get('Receive Payment'); ?>
                                                        <?php elseif($sale->due_amount < 0): ?>
                                                            <i class="la la-money-bill-wave"></i>
                                                            <?php echo app('translator')->get('Give Payment'); ?>
                                                        <?php endif; ?>
                                                    </a>

                                                    <?php if($sale->return_status == 0 && $sale->due_amount > 0): ?>
                                                        <li>
                                                            <a href="<?php echo e(route('admin.sale.return.items', $sale->id)); ?>" class="dropdown-item">
                                                                <i class="la la-redo"></i> <?php echo app('translator')->get('Return Sale'); ?>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>

                                                    <?php if($sale->return_status): ?>
                                                        <li>
                                                            <a href="<?php echo e(route('admin.sale.return.edit', $sale->saleReturn->id)); ?>" class="dropdown-item editBtn">
                                                                <i class="la la-undo"></i> <?php echo app('translator')->get('View Return Details'); ?>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>

                                                    <li>
                                                        <a class="dropdown-item" href="<?php echo e(route('admin.sale.pdf', $sale->id)); ?>/?print=true">
                                                            <i class="la la-download"></i> <?php echo app('translator')->get('Download Invoice'); ?>
                                                        </a>
                                                    </li>
                                                </div>
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
                <?php if($sales->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo paginateLinks($sales) ?>
                    </div>
                <?php endif; ?>
            </div><!-- card end -->
        </div>
    </div>
    <!-- Start Receive Payment Modal  -->
    <div id="paymentModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Payment'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Invoice No.'); ?></label>
                            <input type="text" class="form-control invoice-no" readonly>
                        </div>
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Customer'); ?></label>
                            <input type="text" class="form-control customer-name" readonly>
                        </div>
                        <div class="form-group">
                            <label class="amountType"></label>
                            <div class="input-group">
                                <button type="button" class="input-group-text"><?php echo e($general->cur_sym); ?></button>
                                <input type="text" class="form-control receivable_amount" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="payment-type"></label>
                            <div class="input-group">
                                <button type="button" class="input-group-text"><?php echo e($general->cur_sym); ?></button>
                                <input type="number" step="any" name="amount" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100 permit"><?php echo app('translator')->get('Submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Start Payment Modal  -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .table-responsive {
            min-height: 400px;
            background: transparent
        }

        .card {
            box-shadow: none;
        }
    </style>
<?php $__env->stopPush(); ?>

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

    <a href="<?php echo e(route('admin.sale.create')); ?>" class="btn btn-outline--primary h-45">
        <i class="la la-plus"></i><?php echo app('translator')->get('Add New'); ?>
    </a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.paymentModalBtn', function() {
                var modal = $('#paymentModal');

                let data = $(this).data();
                var due = parseFloat(Math.abs(data.due_amount)).toFixed(2);

                let amountTypeLabel = modal.find('.amountType')
                let payingReceivingLabel = modal.find('.payment-type')

                if (parseFloat(data.due_amount).toFixed(2) > 0) {
                    amountTypeLabel.text('Receivable Amount');
                    payingReceivingLabel.text('Receiving Amount');
                } else {
                    amountTypeLabel.text('Payable Amount');
                    payingReceivingLabel.text('Paying Amount');
                }

                modal.find('.invoice-no').val(`${data.invoice}`);
                modal.find('.customer-name').val(`${data.customer}`);
                modal.find('.receivable_amount').val(`${due}`);
                let form = modal.find('form')[0];
                form.action = `<?php echo e(route('admin.customer.payment.store', '')); ?>/${data.id}`

                modal.modal('show');
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\www\bossislandinv\core\resources\views/admin/sale/index.blade.php ENDPATH**/ ?>