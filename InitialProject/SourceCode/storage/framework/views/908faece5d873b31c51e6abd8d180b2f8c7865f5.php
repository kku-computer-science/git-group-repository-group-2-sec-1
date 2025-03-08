
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<script src="<?php echo e(asset('js/logs.js')); ?>"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php $__env->startSection('title', 'System Logs'); ?>
<style>
    .cursor-pointer {
        cursor: pointer;
    }

    .log-details {
        background-color: #f8f9fa;
        padding: 1rem;
        margin: 0;
    }

    .expand-button:hover {
        background-color: #e9ecef;
    }
</style>

<?php $__env->startSection('content'); ?>
    <!-- Your content goes here (e.g., filters, table of logs) -->
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">System Logs</h1>

            <div class="d-flex gap-2">
                <!-- Refresh Button -->
                <button id="refreshButton" class="btn btn-primary" onclick="refreshLogs()"><span
                        class="icon-refresh"></span></button>

                <!-- Download Log Button -->
                <a href="<?php echo e(route('admin.downloadLog')); ?>" class="btn btn-primary">Download Log</a>
            </div>


        </div>
        <!-- Filter Validation Messages -->
        <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert alert-danger">Invalid Date Range.</div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


        <!-- Filters Section -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="<?php echo e(route('logs.index')); ?>" method="GET" class="row g-3">
                    <!-- Row 1: Date Range & Search -->
                    <div class="col-md-4">
                        <label class="form-label">Date Range</label>
                        <div class="d-flex gap-2">
                            <input type="date" class="form-control" name="start_date"
                                value="<?php echo e(request('start_date') ?? \Carbon\Carbon::today()->format('Y-m-d')); ?>">
                            <input type="date" class="form-control" name="end_date"
                                value="<?php echo e(request('end_date') ?? \Carbon\Carbon::today()->format('Y-m-d')); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Search by Email</label>
                        <input type="text" class="form-control" name="search" value="<?php echo e(request('search')); ?>"
                            placeholder="Enter email...">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </div>

                    <!-- Row 2: Activity Type -->
                    <div class="col-md-12">
                        <label class="form-label">Activity Type</label>
                        <div class="row">
                            <?php $__currentLoopData = $activityTypesSelection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $activityTypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" name="activity_type[]" value="<?php echo e($activityTypes); ?>" <?php echo e(in_array($activityTypes, (array) request('activity_type')) ? 'checked' : ''); ?>>
                                        <label><?php echo e($activityTypes); ?></label>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <!-- Logs Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="cursor-pointer">Date <i class="fas fa-sort ms-1"></i></th>
                                <th>Email</th>
                                <th>Activity</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="cursor-pointer expand-button" data-bs-toggle="collapse"
                                                    data-bs-target="#details-<?php echo e($log->id); ?>">
                                                    <td><i class="fas fa-chevron-right"></i></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($log->created_at)->timezone('Asia/Bangkok')->format('Y-m-d H:i:s')); ?>

                                                    </td>
                                                    <td><?php echo e($log->email); ?></td>
                                                    <td>
                                                        <span class="badge bg-<?php echo e($log->activity_type === 'Login' ? 'success' :
                                                            ($log->activity_type === 'Login Failed' ? 'danger' :
                                                            ($log->activity_type === 'Logout' ? 'primary' :
                                                            ($log->activity_type === 'Create' ? 'info' :
                                                            ($log->activity_type === 'Update' ? 'warning' :
                                                            ($log->activity_type === 'Delete' ? 'danger' :
                                                            ($log->activity_type === 'Error' ? 'dark' : 'warning'))))))); ?>">
                                                            <?php echo e($log->activity_type); ?>

                                                        </span>
                                                    </td>
                                                    <td><?php echo e($log->details); ?></td>
                                                </tr>
                                                <!-- เพิ่มการแสดงรายละเอียดเมื่อคลิก -->
                                                <tr id="details-<?php echo e($log->id); ?>" class="collapse">
                                                    <td colspan="4">
                                                        <div class="log-details">
                                                            <strong>Email:</strong> <?php echo e($log->email); ?><br>
                                                            <strong>IP Address:</strong> <?php echo e($log->ip_address); ?><br>
                                                            <strong>Browser:</strong> <?php echo e($log->browser); ?><br>
                                                            <strong>Device:</strong> <?php echo e($log->device); ?><br>
                                                            <strong>Activity Type:</strong> <?php echo e($log->activity_type); ?><br>
                                                            <strong>Details:</strong> <?php echo e($log->details); ?><br>
                                                        </div>
                                                    </td>
                                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>

                    </table>
                </div>
                <br>
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    <?php echo e($logs->links('pagination::bootstrap-4')); ?>

                </div>
                <br>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<script>
    function refreshLogs() {
        // Reload the page
        location.reload();
    }
</script>

<?php echo $__env->make('dashboards.users.layouts.user-dash-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\File\CS Term 6\SoftEnProject\git-group-repository-group-2-sec-1\InitialProject\SourceCode\resources\views/logs/index.blade.php ENDPATH**/ ?>