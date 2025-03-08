
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

            <!-- Admin Dashboard Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-2">
                    <h1 class="display-6 fw-bold text-gradient">Dashboard</h1>
                    <div class="text-muted">
                        <!-- Date Picker -->
                        <input type="date" class="form-control" id="datePicker" value="<?php echo e(date('Y-m-d')); ?>">
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary me-2 btn-modern" onclick="window.location.reload();">
                        <i class="fas fa-sync-alt me-2"></i>Reload Page
                    </button>
                    <button class="btn btn-dark btn-modern" onclick="window.location.href='<?php echo e(route('logs.index')); ?>'">
                        <i class="fas fa-list me-2"></i>View Full Log
                    </button>
                </div>
            </div>


            <!-- Stats Cards Row -->
            <div class="row g-4">
                <!-- Total Users Card -->
                <div class="col-xl-2 col-md-4">
                    <a href="<?php echo e(url('/users')); ?>" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-primary-soft rounded-circle me-3">
                                        <i class="fas fa-users text-primary fa-2x"></i>
                                    </div>
                                    <h6 class="card-title text-muted mb-0">จำนวนผู้ใช้ทั้งหมด</h6>
                                </div>
                                <h2 class="mb-0 text-primary"><?php echo e($summary['totalUsers'] ?? '0'); ?> <small class="text-muted">คน</small>
                                </h2>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Total Research Card -->
                <div class="col-xl-2 col-md-4">
                    <a href="<?php echo e(url('/papers')); ?>" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-success-soft rounded-circle me-3">
                                        <i class="fas fa-book text-success fa-2x"></i>
                                    </div>
                                    <h6 class="card-title text-muted mb-0">จำนวนงานวิจัยทั้งหมด</h6>
                                </div>
                                <h2 class="mb-0 text-success"><?php echo e($summary['totalResearch'] ?? '0'); ?> <small
                                    class="text-muted">งาน</small></h2>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Total Logins Card -->
                <div class="col-xl-2 col-md-4">
                    <a href="<?php echo e(url('/logs')); ?>" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-info-soft rounded-circle me-3">
                                        <i class="fas fa-sign-in-alt text-info fa-2x"></i>
                                    </div>
                                    <h6 class="card-title text-muted mb-0">จำนวนผู้เข้าสู่ระบบในวันนี้</h6>
                                </div>
                                <h2 class="mb-0 text-info"><?php echo e($summary['totalLogin'] ?? '0'); ?> <small class="text-muted">คน</small></h2>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- API Calls Card -->
                <div class="col-xl-2 col-md-4">
                    <a href="<?php echo e(url('/logs')); ?>" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-warning-soft rounded-circle me-3">
                                        <i class="fas fa-code text-warning fa-2x"></i>
                                    </div>
                                    <h6 class="card-title text-muted mb-0">จำนวนการเรียก API ในวันนี้</h6>
                                </div>
                                <h2 class="mb-0 text-warning"><?php echo e($summary['totalApiCall'] ?? '0'); ?> <small
                                        class="text-muted">ครั้ง</small></h2>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Active Users Card -->
                <div class="col-xl-2 col-md-4">
                    <a href="<?php echo e(url('/logs')); ?>" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-success-soft rounded-circle me-3">
                                        <i class="fas fa-user-check text-success fa-2x"></i>
                                    </div>
                                    <h6 class="card-title text-muted mb-0">ยังอยู่ในระบบจำนวน</h6>
                                </div>
                                <h2 class="mb-0 text-success"><?php echo e(count($activeUser) ?? '12'); ?> <small class="text-muted">คน</small>
                                </h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Critical Events Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-wrapper bg-danger-soft rounded-circle me-3">
                                    <i class="fas fa-exclamation-triangle text-danger fa-2x"></i>
                                </div>
                                <h5 class="card-title mb-0">เหตุการณ์สำคัญที่ต้องตรวจสอบ</h5>
                            </div>
                            <div class="list-group">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error Status -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-danger-soft rounded-circle me-3">
                                        <i class="fas fa-exclamation-circle text-danger fa-2x"></i>
                                    </div>
                                    <h5 class="card-title mb-0">Error Status: <span id="error-count" class="text-danger"></span>
                                    </h5>
                                </div>
                                <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Status" target="_blank"
                                    class="btn btn-outline-info btn-sm d-flex align-items-center gap-2">
                                    <i class="fas fa-info-circle"></i>
                                    <span>HTTP Error Docs</span>
                                </a>
                            </div>
                            <div style="height: 300px;">
                                <canvas id="errorChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="<?php echo e(asset('js/dashboardlog.js')); ?>" defer></script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboards.users.layouts.user-dash-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\File\CS Term 6\SoftEnProject\git-group-repository-group-2-sec-1\InitialProject\SourceCode\resources\views/dashboards/users/index.blade.php ENDPATH**/ ?>