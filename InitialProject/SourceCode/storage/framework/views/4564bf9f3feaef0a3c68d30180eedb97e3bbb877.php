<script src="<?php echo e(asset('js/dashboardlog.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('css/dashboardLog.css')); ?>">


<script>
    const criticalEventsData = <?php echo json_encode($criticalEvents, 15, 512) ?>;
    var totalError = <?php echo json_encode($summary['totalError'], 15, 512) ?>;
    var selectedDate = <?php echo json_encode(session('selectedDate', date('Y-m-d')), 512) ?>;
</script>

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

    <!-- Welcome Section -->
    <div class="container-fluid px-4">
        <!-- Admin Dashboard Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 py-3 bg-light border-bottom">
            <div class="d-flex align-items-center gap-4 dashbord-for-align ">
                <h1 class="display-6 fw-bold text-gradient mb-0">Dashboard</h1>
                <form action="<?php echo e(route('dashboard')); ?>" method="GET" class="d-flex align-items-center dashbord-for-align pt-3">
                    <div class="input-group dashboard-input-group  d-flex align-items-center " style="max-width: 350px;">
                        <!-- <label for="datePicker" class="input-group-text bg-light fw-medium">Select Date:</label> -->
                        <input type="date" class="form-control" id="datePicker" name="date"
                            value="<?php echo e(old('date', date('Y-m-d'))); ?>" required>
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-filter me-1"></i>Apply
                        </button>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- Active Users Indicator -->
                <div class="d-inline-flex align-items-center me-2">
                    <span
                        class="badge bg-light text-success border border-success d-flex align-items-center gap-2 px-2 py-2">
                        <div class="pulse-dot bg-success"></div>
                        <i class="fas fa-users"></i>
                        <span><?php echo e(count($activeUser) ?? '12'); ?> active</span>
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 align-items-center">
                    <button class="btn btn-outline-primary py-2" onclick="window.location.reload();" title="Reload Page">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button class="btn btn-dark btn-modern py-2" onclick="window.location.href='<?php echo e(route('logs.index')); ?>'">
                        <i class="fas fa-list me-2"></i>View Full Log
                    </button>
                </div>
            </div>
        </div>



        <div class="row g-4 mb-4">
            <!-- Total Users Card -->
            <div class="col-xl-3 col-md-6">
                <a href="<?php echo e(url('/users')); ?>" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-card rounded-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-primary-soft rounded-circle me-3">
                                    <i class="fas fa-users text-primary fa-2x"></i>
                                </div>
                                <h6 class="card-title text-muted mb-0">จำนวนผู้ใช้ทั้งหมด</h6>
                            </div>
                            <h2 class="mb-0 text-primary"><?php echo e($summary['totalUsers'] ?? '0'); ?> <small
                                    class="text-muted">คน</small></h2>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Total Research Card -->
            <div class="col-xl-3 col-md-6">
                <a href="<?php echo e(url('/papers')); ?>" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-card rounded-2">
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
            <div class="col-xl-3 col-md-6">
                <a href="#" onclick="redirectToLogs(event, this.dataset.url, 'Login')" data-url="<?php echo e(route('logs.index')); ?>"
                    class="text-decoration-none">

                    <div class="card h-100 border-0 shadow-sm hover-card rounded-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-info-soft rounded-circle me-3">
                                    <i class="fas fa-sign-in-alt text-info fa-2x"></i>
                                </div>
                                <h6 class="card-title text-muted mb-0">จำนวนผู้เข้าสู่ระบบในวันนี้</h6>
                            </div>
                            <h2 class="mb-0 text-info"><?php echo e($summary['totalLogin'] ?? '0'); ?> <small
                                    class="text-muted">คน</small></h2>
                        </div>
                    </div>
                </a>
            </div>

            <!-- API Calls Card -->
            <div class="col-xl-3 col-md-6">
                <a href="#" onclick="redirectToLogs(event, this.dataset.url, 'Call Paper')"
                    data-url="<?php echo e(route('logs.index')); ?>" class="text-decoration-none">

                    <div class="card h-100 border-0 shadow-sm hover-card rounded-2">
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
        </div>


        <!-- Critical Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <!-- Header Section -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-wrapper bg-danger-soft rounded-circle me-3 p-3">
                                <i class="fas fa-exclamation-triangle text-danger fa-2x"></i>
                            </div>
                            <h5 class="card-title mb-0 fw-bold">เหตุการณ์สำคัญที่ต้องตรวจสอบ</h5>
                        </div>

                        <!-- Events List Container with Fixed Height -->
                        <div class="events-container" style="max-height: 400px; overflow-y: auto;">
                            <?php if(!empty($criticalEvents) && count($criticalEvents) > 0): ?>
                                <div class="list-group">
                                    <?php $__currentLoopData = $criticalEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($event['date'] === session('selectedDate', date('Y-m-d'))): ?>
                                            <a href="#" onclick="redirectToLogs(event, this.dataset.url, '<?php echo e($event['type']); ?>')"
                                                data-url="<?php echo e(route('logs.index')); ?>" data-date="<?php echo e($event['date']); ?>"
                                                class="list-group-item border-0 rounded mb-3 text-decoration-none p-3 d-flex align-items-center hover-shadow transition card-critical ">
                                                <div class="text-danger me-3">
                                                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                                                </div>
                                                <div class="w-100">
                                                    <h6 class="mb-2 text-danger fw-bold"><?php echo e($event['title']); ?></h6>
                                                    <div class="d-flex flex-column flex-md-row gap-2">
                                                        <p class="mb-1 text-primary fw-semibold"><?php echo e($event['email']); ?></p>
                                                        <p class="mb-1 text-dark"><?php echo e($event['description']); ?></p>
                                                    </div>
                                                    <small class="text-muted d-block mt-2">
                                                        <i class="far fa-clock me-1"></i><?php echo e($event['timeAgo']); ?>

                                                    </small>
                                                </div>
                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                                    <p class="text-muted mb-0">ไม่มีเหตุการณ์สำคัญปรากฎในขณะนี้</p>
                                </div>
                            <?php endif; ?>
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
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="<?php echo e(asset('js/dashboardlog.js')); ?>"></script>
    <?php endif; ?>
    <script>
        // ส่งข้อมูล criticalEvents ไปยัง JavaScript
        const criticalEventsData = <?php echo json_encode($criticalEvents, 15, 512) ?>;

    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH D:\File\CS Term 6\SoftEnProject\git-group-repository-group-2-sec-1\InitialProject\SourceCode\resources\views/dashboardLog/index.blade.php ENDPATH**/ ?>