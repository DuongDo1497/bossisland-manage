<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['buttonName' => 'PDF']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['buttonName' => 'PDF']); ?>
<?php foreach (array_filter((['buttonName' => 'PDF']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php if(isSuperAdmin()): ?>
    <a class="btn btn-outline--dark" href="<?php echo e(request()->fullUrlWithQuery(['print' => true])); ?>"><i class="la la-download"></i> <?php echo e(__($buttonName)); ?></a>
<?php endif; ?>
<?php /**PATH C:\xampp\www\bossislandinv\core\resources\views/components/pdf-btn.blade.php ENDPATH**/ ?>