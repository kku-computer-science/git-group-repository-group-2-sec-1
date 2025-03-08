@extends('dashboards.users.layouts.user-dash-layout')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<!-- Main Script -->
<script src="{{ asset('js/activity-report.js') }}"></script>
<link href="{{ asset('css/report-log.css') }}" rel="stylesheet">

@section('title', 'รายงานกิจกรรมผู้ใช้งานในระบบ')

@section('content')
    <div class="content-wrapper px-3">
        <!-- Header Card -->
        <div class="card page-header-card mb-4 border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h1 class="page-header-title m-0 h4 text-white">
                    <i class="fas fa-chart-line me-2"></i>รายงานกิจกรรมผู้ใช้งานในระบบ
                </h1>
                <a href="{{ route('logs.index') }}" class="btn back-button text-white btn-sm">
                    <i class="fas fa-arrow-left"></i> กลับหน้ารายการล็อก
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card filter-container mb-4 shadow-sm">
            <div class="filter-header py-2 px-3">
                <h5 class="card-title m-0">
                    <i class="fas fa-filter me-2"></i>ตัวกรองรายงาน
                </h5>
            </div>
            <div class="card-body">
                <form id="filterForm" method="GET">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="dateRangeStart" class="form-label">
                                <i class="far fa-calendar-alt me-1"></i>ช่วงเวลา
                            </label>
                            <div class="date-range-container">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">จาก</span>
                                    <input type="date" id="dateRangeStart" name="dateRangeStart" class="form-control"
                                        value="{{ date('Y-m-d', strtotime('-7 days')) }}">
                                    <span class="input-group-text bg-light">ถึง</span>
                                    <input type="date" id="dateRangeEnd" name="dateRangeEnd" class="form-control"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label mb-3">
                                <i class="fas fa-tasks me-1"></i>กิจกรรมที่ต้องการดู
                            </label>
                            <div class="row g-2">
                                <div class="col-md-3 col-sm-6">
                                    <div class="activity-type-checkbox">
                                        <input type="checkbox" id="activityLoginSuccess" name="activityType[]"
                                            value="loginSuccess" class="form-check-input" checked>
                                        <label for="activityLoginSuccess" class="form-check-label w-100">
                                            <div class="activity-type-tag activity-login-success">
                                                <i class="fas fa-sign-in-alt me-1"></i>Login Success
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="activity-type-checkbox">
                                        <input type="checkbox" id="activityLoginFail" name="activityType[]"
                                            value="loginFail" class="form-check-input" checked>
                                        <label for="activityLoginFail" class="form-check-label w-100">
                                            <div class="activity-type-tag activity-login-fail">
                                                <i class="fas fa-user-times me-1"></i>Login Failed
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="activity-type-checkbox">
                                        <input type="checkbox" id="activityLogout" name="activityType[]" value="logout"
                                            class="form-check-input" checked>
                                        <label for="activityLogout" class="form-check-label w-100">
                                            <div class="activity-type-tag activity-logout">
                                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="activity-type-checkbox">
                                        <input type="checkbox" id="activityCreate" name="activityType[]" value="create"
                                            class="form-check-input" checked>
                                        <label for="activityCreate" class="form-check-label w-100">
                                            <div class="activity-type-tag activity-create">
                                                <i class="fas fa-plus-circle me-1"></i>Create
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="activity-type-checkbox">
                                        <input type="checkbox" id="activityUpdate" name="activityType[]" value="update"
                                            class="form-check-input" checked>
                                        <label for="activityUpdate" class="form-check-label w-100">
                                            <div class="activity-type-tag activity-update">
                                                <i class="fas fa-edit me-1"></i>Update
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="activity-type-checkbox">
                                        <input type="checkbox" id="activityDelete" name="activityType[]" value="delete"
                                            class="form-check-input" checked>
                                        <label for="activityDelete" class="form-check-label w-100">
                                            <div class="activity-type-tag activity-delete">
                                                <i class="fas fa-trash-alt me-1"></i>Delete
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="activity-type-checkbox">
                                        <input type="checkbox" id="activityError" name="activityType[]" value="error"
                                            class="form-check-input" checked>
                                        <label for="activityError" class="form-check-label w-100">
                                            <div class="activity-type-tag activity-error">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Error
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="activity-type-checkbox">
                                        <input type="checkbox" id="activityCallPaper" name="activityType[]"
                                            value="callPaper" class="form-check-input" checked>
                                        <label for="activityCallPaper" class="form-check-label w-100">
                                            <div class="activity-type-tag activity-call-paper">
                                                <i class="fas fa-file-alt me-1"></i>Call Paper
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="button" id="btnGenerateReport" class="btn btn-generate btn-primary px-4">
                                <i class="fas fa-chart-bar me-1"></i> สร้างรายงาน
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="reportContent" style="display: none;">
            <!-- Quick Stats Summary -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light py-2 px-3">
                    <h5 class="card-title m-0">
                        <i class="fas fa-tachometer-alt me-2"></i>สรุปกิจกรรมทั้งหมด
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3" id="statsContainer">
                        <!-- Stats will be filled dynamically by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Chart Preview Container -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2 px-3">
                    <h5 class="card-title m-0">
                        <i class="fas fa-chart-bar me-2"></i>กราฟสรุปกิจกรรมผู้ใช้งาน
                    </h5>
                    <div class="chart-actions">
                        <button id="btnPreviewGraph" class="btn btn-image btn-sm btn-primary">
                            <i class="fas fa-image me-1"></i> บันทึกเป็นภาพ
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chartPreviewContainer" class="chart-preview-container">
                        <canvas id="activityChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Export Options -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light py-2 px-3">
                    <h5 class="card-title m-0">
                        <i class="fas fa-file-export me-2"></i>ส่งออกรายงาน
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <div class="d-grid">
                                <button id="btnExportPDF" class="btn btn-export btn-export-pdf text-white">
                                    <i class="fas fa-file-pdf me-1"></i> ส่งออกเป็น PDF
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid">
                                <button id="btnExportExcel" class="btn btn-export btn-export-excel text-white">
                                    <i class="fas fa-file-excel me-1"></i> ส่งออกเป็น Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Table -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light py-2 px-3">
                    <h5 class="card-title m-0">
                        <i class="fas fa-table me-2"></i>รายละเอียดกิจกรรมผู้ใช้งาน
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="activityTable" class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-semibold"><i class="far fa-calendar-alt me-1"></i>วันที่และเวลา</th>
                                    <th class="fw-semibold"><i class="fas fa-user me-1"></i>ชื่อผู้ใช้</th>
                                    <th class="fw-semibold"><i class="fas fa-network-wired me-1"></i>IP Address</th>
                                    <th class="fw-semibold"><i class="fas fa-tag me-1"></i>ประเภทกิจกรรม</th>
                                    <th class="fw-semibold"><i class="fas fa-info-circle me-1"></i>รายละเอียด</th>
                                    <th class="fw-semibold"><i class="fas fa-check-circle me-1"></i>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody id="activityTableBody">
                                <!-- Table data will be filled here -->
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div id="tableInfo" class="text-muted small">
                            <!-- Will be filled dynamically by JavaScript -->
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm" id="pagination">
                                <!-- Pagination buttons will be added here -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Preview Modal -->
        <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imagePreviewModalLabel">
                            <i class="fas fa-image me-2"></i>ภาพกราฟแสดงกิจกรรมผู้ใช้งาน
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="image-preview-container">
                            <img id="graphImage" src="" alt="กราฟแสดงกิจกรรมผู้ใช้งาน" class="img-fluid">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnDownloadImage" class="btn btn-success">
                            <i class="fas fa-download me-1"></i>ดาวน์โหลดภาพ
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>ปิด
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
   
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const activities = {!! $activities !!};
            const activityTypeConfig = {!! $activityTypes !!};

            initializeActivityReport(activities, activityTypeConfig);
        });
    </script>
@endsection
