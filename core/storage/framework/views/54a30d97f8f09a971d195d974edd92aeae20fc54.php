<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('S.N.'); ?></th>
                                    <th><?php echo app('translator')->get('Name'); ?></th>
                                    <th><?php echo app('translator')->get('Username'); ?></th>
                                    <th><?php echo app('translator')->get('E-mail'); ?></th>
                                    <th><?php echo app('translator')->get('Mobile'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $staffs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td> <?php echo e($staffs->firstItem() + $loop->index); ?> </td>
                                        <td> <?php echo e($staff->name); ?> </td>
                                        <td> <span class="fw-bold"><?php echo e($staff->username); ?></span> </td>
                                        <td> <?php echo e($staff->email); ?> </td>
                                        <td> +<?php echo e($staff->mobile); ?> </td>
                                        <td>
                                            <?php
                                                echo $staff->statusBadge;
                                            ?>
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="<?php echo e($staff); ?>" data-modal_title="<?php echo app('translator')->get('Edit Staff'); ?>" data-has_status="1">
                                                    <i class="la la-pencil"></i><?php echo app('translator')->get('Edit'); ?>
                                                </button>

                                                <a href="<?php echo e(route('admin.staff.login', $staff->id)); ?>" class="btn btn-sm btn-outline--info" target="blank">
                                                    <i class="la la-sign-in-alt"></i><?php echo app('translator')->get('Login'); ?>
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
                        </table>
                        <?php if($staffs->hasPages()): ?>
                            <div class="card-footer py-4">
                                <?php echo  paginateLinks($staffs) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Update Modal -->
    <div class="modal fade" id="cuModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="la la-times"></i>
                    </button>
                </div>

                <form action="<?php echo e(route('admin.staff.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Name'); ?></label>
                                    <input type="text" name="name" class="form-control" autocomplete="off" value="<?php echo e(old('name')); ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Username'); ?></label>
                                    <input type="text" name="username" class="form-control" autocomplete="off" value="<?php echo e(old('username')); ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label"><?php echo app('translator')->get('E-Mail'); ?></label>
                                    <input type="email" class="form-control " name="email" value="<?php echo e(old('email')); ?>" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label"><?php echo app('translator')->get('Password'); ?></label>
                                    <div class="input-group">
                                        <input type="text" name="password" class="form-control" value="<?php echo e(old('password')); ?>" required>
                                        <button type="button" class="input-group-text generatePassword"><?php echo app('translator')->get('Generate'); ?></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label"><?php echo app('translator')->get('Mobile'); ?>
                                        <i class="fa fa-info-circle text--primary" title="<?php echo app('translator')->get('Type the mobile number including the country code. Otherwise, SMS won\'t send to that number.'); ?>">
                                        </i>
                                    </label>
                                    <input type="number" name="mobile" value="<?php echo e(old('mobile')); ?>" class="form-control " required>
                                </div>
                            </div>


                        </div>

                        <div class="status"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45"><?php echo app('translator')->get('Submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <!-- Modal Trigger Button -->
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="<?php echo app('translator')->get('Add New Staff'); ?>">
        <i class="la la-plus"></i><?php echo app('translator')->get('Add New'); ?>
    </button>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            'use strict';

            let modal = $('#cuModal');
            let passField = modal.find('[name=password]');

            modal.on('show.bs.modal', function() {
                let title = $('.modal-title').text();
                let label = passField.parents('.form-group').find('label').first();

                if (title == 'Edit Staff') {
                    passField.removeAttr('required');
                    label.removeClass('required');
                    passField.val('');
                } else {
                    passField.val(generatePassword());
                    passField.attr('required', 'required');
                    label.addClass('required');
                }
            });

            $('.generatePassword').on('click', function() {
                passField.val(generatePassword());
            });

            function generatePassword(length = 12) {
                let charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+<>?/";
                let password = '';

                for (var i = 0, n = charset.length; i < length; ++i) {
                    password += charset.charAt(Math.floor(Math.random() * n));
                }

                return password
            }

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\www\bossislandinv\core\resources\views/admin/staff/index.blade.php ENDPATH**/ ?>