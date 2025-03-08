
<script>
    var totalError = <?php echo json_encode($summary['totalError'], 15, 512) ?>;
</script>
<script src="<?php echo e(asset('js/dashboardlog.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('css/dashboardLog.css')); ?>">

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Welcome Section -->
    <div class="container-fluid px-4">
        <?php if(Auth::check() && (Auth::user()->hasRole('student') || Auth::user()->hasRole('teacher') || Auth::user()->hasRole('staff'))): ?>
            <div class="welcome-section bg-light p-4 rounded-3 mb-4">
                <h3 class="text-primary mb-3"><?php echo e(trans('message.welcome')); ?></h3>
                <h4 class="text-dark"><?php echo e(trans('message.hello')); ?> <?php echo e(Auth::user()->position_th); ?> <?php echo e(Auth::user()->fname_th); ?>

                    <?php echo e(Auth::user()->lname_th); ?>

                </h4>
            </div>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
            <?php echo $__env->make('dashboardLog.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="<?php echo e(asset('js/dashboardlog.js')); ?>" defer></script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboards.users.layouts.user-dash-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\year3_2\softwareEng\soften_jectgroup\git-group-repository-group-2-sec-1\InitialProject\SourceCode\resources\views/dashboards/users/index.blade.php ENDPATH**/ ?>