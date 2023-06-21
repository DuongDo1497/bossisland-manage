<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php echo app('translator')->get('Easy Activator by ViserLab'); ?></title>
	<link rel="stylesheet" href="<?php echo e(asset('assets/global/css/bootstrap.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('assets/global/css/all.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('assets/global/css/installer.css')); ?>">
	<link rel="shortcut icon" href="<?php echo e(getImage('assets/images/logoIcon/favicon.png')); ?>" type="image/x-icon">
</head>
<body>
	<header class="py-3 border-bottom border-primary bg--dark">
		<div class="container">
			<div class="d-flex align-items-center justify-content-between header gap-3">
				<img class="logo" src="<?php echo e(getImage('assets/images/logoIcon/logo.png')); ?>" alt="ViserLab">
				<h3 class="title"><?php echo app('translator')->get('Easy Activation'); ?></h3>
			</div>
		</div>
	</header>
	<div class="installation-section padding-bottom padding-top">
		<div class="container">
			<div class="installation-wrapper">
				<div class="install-content-area">
					<div class="install-item">
						<h3 class="title text-center"><?php echo e(systemDetails()['name']); ?> <?php echo app('translator')->get('License Activation'); ?></h3>
                        <div class="box-item">
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="alert-area alert alert-danger d-none">
                                        <h5 class="resp-msg"></h5>
                                        <p class="my-3"><?php echo app('translator')->get('You can ask for support by creating a support ticket.'); ?></p>
                                        <a href="<?php echo e(Laramin\Utility\VugiChugi::splnk()); ?>" class="btn btn-outline-light btn-sm" target="_blank"><?php echo app('translator')->get('create  ticket'); ?></a>
                                    </div>

                                </div>
                                <div class="col-lg-5">
                                    <div class="alert alert-success" role="alert">
                                        <p class="fs-17 mb-0"><?php echo app('translator')->get('To validate your purchase details, following information will sent to ViserLab server.'); ?></p>
                                    </div>
                                    <div class="alert alert-primary" role="alert">
                                        <p class="fs-17"><?php echo app('translator')->get('Application'); ?>: <?php echo e(systemDetails()['name']); ?> - v<?php echo e(systemDetails()['version']); ?></p>
                                        <p class="fs-17"><?php echo app('translator')->get('Envato Username'); ?>: <span class="envato_username"></span></p>
                                        <p class="fs-17"><?php echo app('translator')->get('Purchase Code'); ?>: <span class="purchase_code"> </span></p>
                                        <p class="fs-17"><?php echo app('translator')->get('Your Email'); ?>: <span class="email"></span></p>
                                        <p class="fs-17 mb-0 word-break-all"><?php echo app('translator')->get('Activation URL'); ?>: <?php echo e(Laramin\Utility\Helpmate::appUrl()); ?></p>
                                    </div>
                                    <div class="alert alert-warning" role="alert">
                                        <p class="fs-17 mb-0"><?php echo app('translator')->get('We never collect any sensitive or confidential data.'); ?></p>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <p><?php echo app('translator')->get('The purchase code(license) is for one website or domain only. Please activate the license into the correct domain(URL) to avoid any unwanted issues in the future.'); ?></p>
                                    <form class="verForm">
                                        <div class="information-form-group">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <label for="purchase_code" class="mb-1"><?php echo app('translator')->get('Enter Purchase Code'); ?> <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="p-code-info" data-bs-toggle="tooltip" data-bs-html="true" title='To get the purchase code <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">click here</a>'>
                                                    <i class="fas fa-info-circle"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="purchase_code" id="purchase_code" required>
                                        </div>
                                        <div class="information-form-group">
                                            <label for="username" class="mb-1"><?php echo app('translator')->get('Enter Envato Username'); ?> <span class="text-danger">*</span></label>
                                            <input type="text" name="envato_username" id="username" required>
                                        </div>
                                        <div class="information-form-group">
                                            <label for="email" class="mb-1"><?php echo app('translator')->get('Enter Your Email'); ?> <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email" required>
                                        </div>

                                        <div class="information-form-group d-flex">
                                            <input type="checkbox" id="agree" class="w-auto h-auto mt-1" required>
                                            <label for="agree" class="agree-label"><?php echo app('translator')->get('I accept the terms of the'); ?> <a href="https://codecanyon.net/licenses/standard" target="_blank"><?php echo app('translator')->get('Envato Standard License'); ?></a> <?php echo app('translator')->get('as well as the Viserlab terms and conditions.'); ?></label>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="theme-button choto sbmBtn"><?php echo app('translator')->get('Activate Now'); ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<footer class="py-3 text-center bg--dark border-top border-primary">
		<div class="container">
			<p class="m-0 font-weight-bold">&copy;<?php echo Date('Y') ?> - <?php echo app('translator')->get('All Right Reserved by'); ?> <a href="https://viserlab.com/"><?php echo app('translator')->get('ViserLab'); ?></a></p>
		</div>
	</footer>
	<script src="<?php echo e(asset('assets/global/js/bootstrap.bundle.min.js')); ?>"></script>
	<script src="<?php echo e(asset('assets/global/js/jquery-3.6.0.min.js')); ?>"></script>
    <?php echo $__env->make('partials.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        (function($){
            "use strict"

            $('.verForm').submit(function (e) {
                e.preventDefault();
                $('.alert-area').addClass('d-none');
                $('.sbmBtn').text('Processing...');
                var url = '<?php echo e(route(Laramin\Utility\VugiChugi::acRouterSbm())); ?>';
                var data = {
                    "purchase_code":$(this).find('[name=purchase_code]').val(),
                    "email":$(this).find('[name=email]').val(),
                    "envato_username":$(this).find('[name=envato_username]').val()
                };

                $.post(url, data,function (response) {
                    if (response.type == 'error') {
                        $('.sbmBtn').text('Submit');
                        $('.verForm').trigger("reset");
                        $('.alert-area').removeClass('d-none');
                        $('.resp-msg').text(response.message);
                    }else{
                        location.reload();
                    }
                });

            });

            $(function () {
                $('[data-bs-toggle="tooltip"]').tooltip({
                    animated: 'fade',
                    trigger: 'click'
                })
            })

            $('[name=email]').on('input', function () {
                $('.email').text($(this).val());
            });

            $('[name=envato_username]').on('input', function () {
                $('.envato_username').text($(this).val());
            });

            $('[name=purchase_code]').on('input', function () {
                $('.purchase_code').text($(this).val());
            });

        })(jQuery);
    </script>
</body>

</html>
<?php /**PATH C:\xampp\www\bossislandinv\core\vendor\laramin\utility\src/Views/laramin_start.blade.php ENDPATH**/ ?>