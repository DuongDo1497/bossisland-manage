<div class="sidebar bg--dark">
    <button class="res-sidebar-close-btn"><i class="la la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar__main-logo">
                <img src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png')); ?>" alt="<?php echo app('translator')->get('image'); ?>">
            </a>
        </div>

        <?php
            $admin = auth()
                ->guard('admin')
                ->user();
        ?>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">

                <li class="sidebar-menu-item <?php echo e(menuActive('admin.dashboard')); ?>">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link ">
                        <i class="menu-icon la la-home"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Dashboard'); ?></span>
                    </a>
                </li>

                <?php if($admin->role == Status::SUPER_ADMIN): ?>
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="<?php echo e(menuActive('admin.product*', 3)); ?>">
                            <i class="menu-icon lab la-product-hunt"></i>
                            <span class="menu-title"><?php echo app('translator')->get('Manage Product'); ?></span>
                        </a>
                        <div class="sidebar-submenu <?php echo e(menuActive('admin.product*', 2)); ?> ">
                            <ul>
                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.product.category.index')); ?> ">
                                    <a href="<?php echo e(route('admin.product.category.index')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Categories'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.product.brand.index')); ?> ">
                                    <a href="<?php echo e(route('admin.product.brand.index')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Brands'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.product.unit.index')); ?> ">
                                    <a href="<?php echo e(route('admin.product.unit.index')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Units'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.product.index')); ?> ">
                                    <a href="<?php echo e(route('admin.product.index')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Products'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="sidebar-menu-item <?php echo e(menuActive('admin.product.index')); ?> ">
                        <a href="<?php echo e(route('admin.product.index')); ?>" class="nav-link">
                            <i class="menu-icon la la-product-hunt"></i>
                            <span class="menu-title"><?php echo app('translator')->get('Products'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if($admin->role == Status::SUPER_ADMIN): ?>
                    <li class="sidebar-menu-item <?php echo e(menuActive('admin.warehouse.*')); ?>">
                        <a href="<?php echo e(route('admin.warehouse.index')); ?>" class="nav-link ">
                            <i class="menu-icon la la-warehouse"></i>
                            <span class="menu-title"><?php echo app('translator')->get('Warehouse'); ?></span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item <?php echo e(menuActive('admin.staff.index')); ?> ">
                        <a href="<?php echo e(route('admin.staff.index')); ?>" class="nav-link">
                            <i class="menu-icon la la-user"></i>
                            <span class="menu-title"><?php echo app('translator')->get('Staff'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="sidebar-menu-item <?php echo e(menuActive(['admin.customer.index', 'admin.customer.payment.*', 'admin.customer.notification.*'])); ?> ">
                    <a href="<?php echo e(route('admin.customer.index')); ?>" class="nav-link">
                        <i class="menu-icon la la-users"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Customer'); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item <?php echo e(menuActive(['admin.supplier.index', 'admin.supplier.payment.*'])); ?> ">
                    <a href="<?php echo e(route('admin.supplier.index')); ?>" class="nav-link">
                        <i class="menu-icon la la-user-friends"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Supplier'); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="<?php echo e(menuActive('admin.purchase*', 3)); ?>">
                        <i class="menu-icon la la-shopping-bag"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Purchase'); ?></span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.purchase*', 2)); ?> ">
                        <ul>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.purchase.index')); ?> ">
                                <a href="<?php echo e(route('admin.purchase.index')); ?>" class="nav-link">
                                    <i class="menu-icon la la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('All Purchases'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.purchase.return.index')); ?> ">
                                <a href="<?php echo e(route('admin.purchase.return.index')); ?>" class="nav-link">
                                    <i class="menu-icon la la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Purchases Return'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="<?php echo e(menuActive('admin.sale*', 3)); ?>">
                        <i class="menu-icon la la-shopping-cart"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Sale'); ?></span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.sale*', 2)); ?> ">
                        <ul>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.sale.index')); ?> ">
                                <a href="<?php echo e(route('admin.sale.index')); ?>" class="nav-link">
                                    <i class="menu-icon la la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('All Sales'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.sale.return.index')); ?> ">
                                <a href="<?php echo e(route('admin.sale.return.index')); ?>" class="nav-link">
                                    <i class="menu-icon la la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Sales Return'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>



                <li class="sidebar-menu-item <?php echo e(menuActive('admin.adjustment.*')); ?>">
                    <a href="<?php echo e(route('admin.adjustment.index')); ?>" class="nav-link ">
                        <i class="menu-icon la la-balance-scale"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Adjustment'); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item <?php echo e(menuActive('admin.transfer.*')); ?>">
                    <a href="<?php echo e(route('admin.transfer.index')); ?>" class="nav-link ">
                        <i class="menu-icon la la-retweet"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Transfer'); ?></span>
                    </a>
                </li>


                <?php if($admin->role == Status::SUPER_ADMIN): ?>
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="<?php echo e(menuActive('admin.expense*', 3)); ?>">
                            <i class="menu-icon la la-wallet"></i>
                            <span class="menu-title"><?php echo app('translator')->get('Expense'); ?></span>
                        </a>
                        <div class="sidebar-submenu <?php echo e(menuActive('admin.expense*', 2)); ?> ">
                            <ul>
                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.expense.type.index')); ?> ">
                                    <a href="<?php echo e(route('admin.expense.type.index')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Type'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.expense.index')); ?> ">
                                    <a href="<?php echo e(route('admin.expense.index')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('All Expenses'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="sidebar-menu-item <?php echo e(menuActive('admin.expense.index')); ?> ">
                        <a href="<?php echo e(route('admin.expense.index')); ?>" class="nav-link">
                            <i class="menu-icon la la-dot-circle"></i>
                            <span class="menu-title"><?php echo app('translator')->get('Expenses'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>



                <li class="sidebar__menu-header"><?php echo app('translator')->get('Reports'); ?></li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="<?php echo e(menuActive('admin.report.payment.*', 3)); ?>">
                        <i class="menu-icon la la-money-check-alt"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Payment Report'); ?></span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.report.payment.*', 2)); ?> ">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.payment.supplier')); ?> ">
                                <a href="<?php echo e(route('admin.report.payment.supplier')); ?>" class="nav-link">
                                    <i class="menu-icon la la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Supplier Payments'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.payment.customer')); ?> ">
                                <a href="<?php echo e(route('admin.report.payment.customer')); ?>" class="nav-link">
                                    <i class="menu-icon la la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Customer Payments'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.stock')); ?> ">
                    <a href="<?php echo e(route('admin.report.stock')); ?>" class="nav-link">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Stock Report'); ?></span>
                    </a>
                </li>

                <?php if($admin->role == Status::SUPER_ADMIN): ?>
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="<?php echo e(menuActive('admin.report.data.entry*', 3)); ?>">
                            <i class="menu-icon la la-database"></i>
                            <span class="menu-title"><?php echo app('translator')->get('Data Entry Report'); ?></span>
                        </a>


                        <div class="sidebar-submenu <?php echo e(menuActive('admin.report.data.entry*', 2)); ?> ">
                            <ul>
                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.data.entry.product')); ?> ">
                                    <a href="<?php echo e(route('admin.report.data.entry.product')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Product'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.data.entry.customer')); ?> ">
                                    <a href="<?php echo e(route('admin.report.data.entry.customer')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Customer'); ?></span>
                                    </a>
                                </li>


                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.data.entry.supplier')); ?> ">
                                    <a href="<?php echo e(route('admin.report.data.entry.supplier')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Supplier'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.data.entry.purchase')); ?> ">
                                    <a href="<?php echo e(route('admin.report.data.entry.purchase')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span pan class="menu-title"><?php echo app('translator')->get('Purchase'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.data.entry.purchase.return')); ?> ">
                                    <a href="<?php echo e(route('admin.report.data.entry.purchase.return')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Purchase Return'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.data.entry.sale')); ?> ">
                                    <a href="<?php echo e(route('admin.report.data.entry.sale')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span pan class="menu-title"><?php echo app('translator')->get('Sale'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.data.entry.sale.return')); ?> ">
                                    <a href="<?php echo e(route('admin.report.data.entry.sale.return')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Sale Return'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.data.entry.adjustment')); ?> ">
                                    <a href="<?php echo e(route('admin.report.data.entry.adjustment')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Adjustment'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.data.entry.transfer')); ?> ">
                                    <a href="<?php echo e(route('admin.report.data.entry.transfer')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Transfer'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.data.entry.expense')); ?> ">
                                    <a href="<?php echo e(route('admin.report.data.entry.expense')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Expense'); ?></span>
                                    </a>
                                </li>


                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.data.entry.supplier.payment')); ?> ">
                                    <a href="<?php echo e(route('admin.report.data.entry.supplier.payment')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Supplier Payment'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.data.entry.customer.payment')); ?> ">
                                    <a href="<?php echo e(route('admin.report.data.entry.customer.payment')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Customer Payment'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="sidebar__menu-header"><?php echo app('translator')->get('Settings'); ?></li>

                    <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.index')); ?>">
                        <a href="<?php echo e(route('admin.setting.index')); ?>" class="nav-link">
                            <i class="menu-icon la la-life-ring"></i>
                            <span class="menu-title"><?php echo app('translator')->get('General Setting'); ?></span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.system.configuration')); ?>">
                        <a href="<?php echo e(route('admin.setting.system.configuration')); ?>" class="nav-link">
                            <i class="menu-icon la la-cog"></i>
                            <span class="menu-title"><?php echo app('translator')->get('System Configuration'); ?></span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.logo.icon')); ?>">
                        <a href="<?php echo e(route('admin.setting.logo.icon')); ?>" class="nav-link">
                            <i class="menu-icon la la-images"></i>
                            <span class="menu-title"><?php echo app('translator')->get('Logo & Favicon'); ?></span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="<?php echo e(menuActive('admin.setting.notification*', 3)); ?>">
                            <i class="menu-icon la la-bell"></i>
                            <span class="menu-title"><?php echo app('translator')->get('Notification Setting'); ?></span>
                        </a>
                        <div class="sidebar-submenu <?php echo e(menuActive('admin.setting.notification*', 2)); ?> ">
                            <ul>
                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.notification.global')); ?> ">
                                    <a href="<?php echo e(route('admin.setting.notification.global')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Global Template'); ?></span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.notification.email')); ?> ">
                                    <a href="<?php echo e(route('admin.setting.notification.email')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Email Setting'); ?></span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.notification.sms')); ?> ">
                                    <a href="<?php echo e(route('admin.setting.notification.sms')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('SMS Setting'); ?></span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.notification.templates')); ?> ">
                                    <a href="<?php echo e(route('admin.setting.notification.templates')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Notification Templates'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if($admin->role == Status::SUPER_ADMIN): ?>
                    <li class="sidebar__menu-header"><?php echo app('translator')->get('Extra'); ?></li>

                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="<?php echo e(menuActive('admin.system*', 3)); ?>">
                            <i class="menu-icon la la-server"></i>
                            <span class="menu-title"><?php echo app('translator')->get('System'); ?></span>
                        </a>
                        <div class="sidebar-submenu <?php echo e(menuActive('admin.system*', 2)); ?> ">
                            <ul>
                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.system.info')); ?> ">
                                    <a href="<?php echo e(route('admin.system.info')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Application'); ?></span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.system.server.info')); ?> ">
                                    <a href="<?php echo e(route('admin.system.server.info')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Server'); ?></span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item <?php echo e(menuActive('admin.system.optimize')); ?> ">
                                    <a href="<?php echo e(route('admin.system.optimize')); ?>" class="nav-link">
                                        <i class="menu-icon la la-dot-circle"></i>
                                        <span class="menu-title"><?php echo app('translator')->get('Cache'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-menu-item  <?php echo e(menuActive('admin.request.report')); ?>">
                        <a href="<?php echo e(route('admin.request.report')); ?>" class="nav-link" data-default-url="<?php echo e(route('admin.request.report')); ?>">
                            <i class="menu-icon la la-bug"></i>
                            <span class="menu-title"><?php echo app('translator')->get('Report & Request'); ?> </span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="text-center mb-3 text-uppercase">
                <span class="text--primary"><?php echo e(__(systemDetails()['name'])); ?></span>
                <span class="text--success"><?php echo app('translator')->get('V'); ?><?php echo e(systemDetails()['version']); ?> </span>
            </div>
        </div>
    </div>
</div>
<!-- sidebar end -->

<?php $__env->startPush('script'); ?>
    <script>
        if ($('li').hasClass('active')) {
            $('#sidebar__menuWrapper').animate({
                scrollTop: eval($(".active").offset().top - 320)
            }, 500);
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\www\bossislandinv\core\resources\views/admin/partials/sidenav.blade.php ENDPATH**/ ?>