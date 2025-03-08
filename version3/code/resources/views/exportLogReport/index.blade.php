@extends('dashboards.users.layouts.user-dash-layout')
<!-- ตัวแปร global สำหรับใช้ในทุก script -->
<script>
    window.activities = {!! $activities !!};
    window.activityTypeConfig = {!! $activityTypes !!};
</script>

<!-- Libraries สำหรับกราฟและการส่งออก -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

<!-- โหลดไฟล์ JavaScript ทั้งหมด -->
<!-- เพิ่มไฟล์ debug helper -->
<script src="{{ asset('js/exportReport/debug-helper.js') }}"></script>
<script src="{{ asset('js/exportReport/chart-utilities.js') }}"></script>
<script src="{{ asset('js/exportReport/table-utilities.js') }}"></script>
<script src="{{ asset('js/exportReport/export-utilities.js') }}"></script>
<script src="{{ asset('js/exportReport/activity-report.js') }}"></script>
<script src="{{ asset('js/exportReport/main.js') }}"></script>

<style>
    .hover-dark:hover {
        color: #000 !important;
    }
</style>

@section('title', 'รายงานกิจกรรมผู้ใช้งานในระบบ')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header Card -->
        <div class="card mb-4 border-0 shadow-sm" style="background: linear-gradient(to right, #2c3e50, #3498db);">
            <div class="card-body d-flex justify-content-between align-items-center py-3">
                <h1 class="m-0 h4 text-white">
                    <i class="fas fa-chart-line me-2"></i>รายงานกิจกรรมผู้ใช้งานในระบบ
                </h1>
                <a href="{{ route('logs.index') }}" class="btn btn-outline-light btn-sm px-3 text-white  hover-dark">
                    <i class="fas fa-arrow-left me-1"></i> กลับหน้ารายการล็อก
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light py-3">
                <h5 class="card-title m-0 fw-bold">
                    <i class="fas fa-filter me-2"></i>ตัวกรองรายงาน
                </h5>
            </div>
            <div class="card-body p-3 p-md-4">
                <form id="filterForm" method="GET">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="dateRangeStart" class="form-label fw-semibold mb-2">
                                <i class="far fa-calendar-alt me-1"></i>ช่วงเวลา
                            </label>
                            <div class="date-range-container">
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-medium">จาก</span>
                                    <input type="date" id="dateRangeStart" name="dateRangeStart" class="form-control"
                                        value="{{ date('Y-m-d', strtotime('-7 days')) }}">
                                    <span class="input-group-text bg-light fw-medium">ถึง</span>
                                    <input type="date" id="dateRangeEnd" name="dateRangeEnd" class="form-control"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12  ">
                            <label class="form-label fw-semibold mb-3">
                                <i class="fas fa-tasks me-1"></i>กิจกรรมที่ต้องการดู
                            </label>
                            <div class="row g-3  px-4">
                                <!-- ปรับให้เป็น checkbox แบบธรรมดา -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" id="activityLoginSuccess" name="activityType[]"
                                            value="loginSuccess" class="form-check-input" checked>
                                        <label for="activityLoginSuccess" class="form-check-label">
                                            <i class="fas fa-sign-in-alt me-1"></i>Login Success
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" id="activityLoginFail" name="activityType[]"
                                            value="loginFail" class="form-check-input" checked>
                                        <label for="activityLoginFail" class="form-check-label">
                                            <i class="fas fa-user-times me-1"></i>Login Failed
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" id="activityLogout" name="activityType[]" value="logout"
                                            class="form-check-input" checked>
                                        <label for="activityLogout" class="form-check-label">
                                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" id="activityCreate" name="activityType[]" value="create"
                                            class="form-check-input" checked>
                                        <label for="activityCreate" class="form-check-label">
                                            <i class="fas fa-plus-circle me-1"></i>Create
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" id="activityUpdate" name="activityType[]" value="update"
                                            class="form-check-input" checked>
                                        <label for="activityUpdate" class="form-check-label">
                                            <i class="fas fa-edit me-1"></i>Update
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" id="activityDelete" name="activityType[]" value="delete"
                                            class="form-check-input" checked>
                                        <label for="activityDelete" class="form-check-label">
                                            <i class="fas fa-trash-alt me-1"></i>Delete
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" id="activityError" name="activityType[]" value="error"
                                            class="form-check-input" checked>
                                        <label for="activityError" class="form-check-label">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Error
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" id="activityCallPaper" name="activityType[]"
                                            value="callPaper" class="form-check-input" checked>
                                        <label for="activityCallPaper" class="form-check-label">
                                            <i class="fas fa-file-alt me-1"></i>Call Paper
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="button" id="btnGenerateReport" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-chart-bar me-2"></i> สร้างรายงาน
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="reportContent" style="display: none;">
            <!-- Export Options -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title m-0 fw-bold">
                        <i class="fas fa-file-export me-2"></i>ส่งออกรายงาน
                    </h5>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="row g-3">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <div class="d-grid">
                                <button id="btnExportPDF" class="btn btn-danger py-3">
                                    <i class="fas fa-file-pdf me-2"></i> ส่งออกเป็น PDF
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid">
                                <button id="btnExportExcel" class="btn btn-success py-3">
                                    <i class="fas fa-file-excel me-2"></i> ส่งออกเป็น Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Quick Stats Summary -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title m-0 fw-bold">
                        <i class="fas fa-tachometer-alt me-2"></i>สรุปกิจกรรมทั้งหมด
                    </h5>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="row g-4" id="statsContainer">
                        <!-- Stats will be filled dynamically by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Chart Preview Container -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title m-0 fw-bold">
                        <i class="fas fa-chart-bar me-2"></i>กราฟสรุปกิจกรรมผู้ใช้งาน
                    </h5>
                    <div class="chart-actions">
                        <button id="btnPreviewGraph" class="btn btn-primary btn-sm px-3">
                            <i class="fas fa-image me-1"></i> บันทึกเป็นภาพ
                        </button>
                    </div>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div id="chartPreviewContainer" class="border rounded p-3 bg-white">
                        <canvas id="activityChart" style="height: 350px;"></canvas>
                    </div>
                </div>
            </div>



            <!-- Activity Table -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title m-0 fw-bold">
                        <i class="fas fa-table me-2"></i>รายละเอียดกิจกรรมผู้ใช้งาน
                    </h5>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="table-responsive">
                        <table id="activityTable" class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-bold py-3"><i class="far fa-calendar-alt me-1"></i>วันที่และเวลา</th>
                                    <th class="fw-bold py-3"><i class="fas fa-user me-1"></i>ชื่อผู้ใช้</th>
                                    <th class="fw-bold py-3"><i class="fas fa-network-wired me-1"></i>IP Address</th>
                                    <th class="fw-bold py-3"><i class="fas fa-tag me-1"></i>ประเภทกิจกรรม</th>
                                    <th class="fw-bold py-3"><i class="fas fa-info-circle me-1"></i>รายละเอียด</th>
                                    <th class="fw-bold py-3"><i class="fas fa-check-circle me-1"></i>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody id="activityTableBody">
                                <!-- Table data will be filled here -->
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
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
                        <h5 class="modal-title fw-bold" id="imagePreviewModalLabel">
                            <i class="fas fa-image me-2"></i>ภาพกราฟแสดงกิจกรรมผู้ใช้งาน
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="border rounded p-3">
                            <img id="graphImage" src="" alt="กราฟแสดงกิจกรรมผู้ใช้งาน" class="img-fluid">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnDownloadImage" class="btn btn-success px-4">
                            <i class="fas fa-download me-2"></i>ดาวน์โหลดภาพ
                        </button>
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>ปิด
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- ตัวแปร global สำหรับใช้ในทุก script -->
    <script>
        window.activities = {!! $activities !!};
        window.activityTypeConfig = {!! $activityTypes !!};
    </script>

    <!-- Libraries สำหรับกราฟและการส่งออก -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

    <!-- โหลดไฟล์ JavaScript ทั้งหมด -->
    <!-- เพิ่มไฟล์ debug helper -->
    <script src="{{ asset('js/exportReport/debug-helper.js') }}"></script>
    <script src="{{ asset('js/exportReport/chart-utilities.js') }}"></script>
    <script src="{{ asset('js/exportReport/table-utilities.js') }}"></script>
    <script src="{{ asset('js/exportReport/export-utilities.js') }}"></script>
    <script src="{{ asset('js/exportReport/activity-report.js') }}"></script>
    <script src="{{ asset('js/exportReport/main.js') }}"></script>

    <!-- JavaScript สำหรับ animation -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // แทนที่ function สำหรับการ show/hide report
            const btnGenerateReport = document.getElementById('btnGenerateReport');
            const reportContent = document.getElementById('reportContent');

            // สร้าง function สำรองในกรณีที่ window.generateReport ยังไม่พร้อมใช้งาน
            function fallbackGenerateReport() {
                reportContent.style.display = 'block';
            }

            // ถ้า window.generateReport มีอยู่แล้ว
            if (typeof window.generateReport === 'function') {
                const originalGenerateReport = window.generateReport;
                window.generateReport = function () {
                    originalGenerateReport();
                    reportContent.style.display = 'block';
                };
            } else {
                btnGenerateReport.addEventListener('click', fallbackGenerateReport);
            }

            // ตรวจสอบ URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('dateRangeStart') || urlParams.has('activityType[]')) {
                setTimeout(function () {
                    reportContent.style.display = 'block';
                }, 300);
            }
        });
    </script>
    <script>
        // ฟังก์ชันช่วยเหลือเพื่อบังคับให้ข้อมูลแสดง
        function forceRenderElements() {
            console.log('Forcing render of stats and table...');

            try {
                // ทำให้พื้นที่แสดงผลปรากฎ
                document.getElementById('reportContent').style.display = 'block';

                // บังคับสร้างสรุปกิจกรรม
                if (typeof generateStatsSummary === 'function' &&
                    Array.isArray(window.filteredActivities) &&
                    typeof window.activityTypeConfig === 'object') {
                    console.log('Regenerating stats summary...');
                    generateStatsSummary(window.filteredActivities, window.activityTypeConfig);
                }

                // บังคับสร้างตาราง
                if (typeof generateActivityTable === 'function' &&
                    Array.isArray(window.filteredActivities) &&
                    typeof window.activityTypeConfig === 'object') {
                    console.log('Regenerating activity table...');
                    generateActivityTable(window.filteredActivities, window.activityTypeConfig, 1);
                }

                console.log('Forced rendering complete');
            } catch (error) {
                console.error('Error during forced rendering:', error);
            }
        }

        // รอให้หน้าโหลดเสร็จแล้วตรวจสอบว่าควรบังคับการแสดงผลหรือไม่
        document.addEventListener('DOMContentLoaded', function () {
            // ถ้ามีพารามิเตอร์ URL และ reportContent แสดงอยู่
            const urlParams = new URLSearchParams(window.location.search);
            if ((urlParams.has('dateRangeStart') || urlParams.has('activityType[]'))) {
                setTimeout(function () {
                    if (document.getElementById('reportContent').style.display !== 'none') {
                        forceRenderElements();
                    }
                }, 1000);
            }

            // บังคับให้ generateReport แสดงส่วนประกอบทั้งหมด
            const btnGenerateReport = document.getElementById('btnGenerateReport');
            if (btnGenerateReport) {
                const oldClickEvent = btnGenerateReport.onclick;
                btnGenerateReport.onclick = function (e) {
                    if (oldClickEvent) {
                        oldClickEvent.call(this, e);
                    }
                    setTimeout(forceRenderElements, 500);
                };
            }
        });
    </script>
@endsection
