@extends('dashboards.users.layouts.user-dash-layout')
<script>
    var totalError = @json($summary['totalError']);
</script>
<script src="{{ asset('js/dashboardlog.js') }}"></script>

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="container-fluid px-4">
        @if(Auth::check() && (Auth::user()->hasRole('student') || Auth::user()->hasRole('teacher') || Auth::user()->hasRole('staff')))
            <div class="welcome-section bg-light p-4 rounded-3 mb-4">
                <h3 class="text-primary mb-3">{{ trans('message.welcome') }}</h3>
                <h4 class="text-dark">{{ trans('message.hello') }} {{ Auth::user()->position_th }} {{ Auth::user()->fname_th }}
                    {{ Auth::user()->lname_th }}
                </h4>
            </div>
        @endif

        @can('role-list')
            <!-- Admin Dashboard Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-2">
                    <h1 class="display-6 fw-bold text-gradient">Dashboard</h1>
                    <div class="text-muted">
                        <!-- Date Picker -->
                        <input type="date" class="form-control" id="datePicker" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary me-2 btn-modern" onclick="window.location.reload();">
                        <i class="fas fa-sync-alt me-2"></i>Reload Page
                    </button>
                    <button class="btn btn-dark btn-modern" onclick="window.location.href='{{ route('logs.index') }}'">
                        <i class="fas fa-list me-2"></i>View Full Log
                    </button>
                </div>
            </div>


            <!-- Stats Cards Row -->
            <div class="row g-4">
                <!-- Total Users Card -->
                <div class="col-xl-2 col-md-4">
                    <a href="{{ url('/users') }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-primary-soft rounded-circle me-3">
                                        <i class="fas fa-users text-primary fa-2x"></i>
                                    </div>
                                    <h6 class="card-title text-muted mb-0">จำนวนผู้ใช้ทั้งหมด</h6>
                                </div>
                                <h2 class="mb-0 text-primary">{{ $summary['totalUsers'] ?? '0'}} <small class="text-muted">คน</small>
                                </h2>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Total Research Card -->
                <div class="col-xl-2 col-md-4">
                    <a href="{{ url('/papers') }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-success-soft rounded-circle me-3">
                                        <i class="fas fa-book text-success fa-2x"></i>
                                    </div>
                                    <h6 class="card-title text-muted mb-0">จำนวนงานวิจัยทั้งหมด</h6>
                                </div>
                                <h2 class="mb-0 text-success">{{ $summary['totalResearch'] ?? '0' }} <small
                                    class="text-muted">งาน</small></h2>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Total Logins Card -->
                <div class="col-xl-2 col-md-4">
                    <a href="{{ url('/logs') }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-info-soft rounded-circle me-3">
                                        <i class="fas fa-sign-in-alt text-info fa-2x"></i>
                                    </div>
                                    <h6 class="card-title text-muted mb-0">จำนวนผู้เข้าสู่ระบบในวันนี้</h6>
                                </div>
                                <h2 class="mb-0 text-info">{{ $summary['totalLogin'] ?? '0' }} <small class="text-muted">คน</small></h2>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- API Calls Card -->
                <div class="col-xl-2 col-md-4">
                    <a href="{{ url('/logs') }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-warning-soft rounded-circle me-3">
                                        <i class="fas fa-code text-warning fa-2x"></i>
                                    </div>
                                    <h6 class="card-title text-muted mb-0">จำนวนการเรียก API ในวันนี้</h6>
                                </div>
                                <h2 class="mb-0 text-warning">{{ $summary['totalApiCall'] ?? '0' }} <small
                                        class="text-muted">ครั้ง</small></h2>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Active Users Card -->
                <div class="col-xl-2 col-md-4">
                    <a href="{{ url('/logs') }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-success-soft rounded-circle me-3">
                                        <i class="fas fa-user-check text-success fa-2x"></i>
                                    </div>
                                    <h6 class="card-title text-muted mb-0">ยังอยู่ในระบบจำนวน</h6>
                                </div>
                                <h2 class="mb-0 text-success">{{ count($activeUser) ?? '12' }} <small class="text-muted">คน</small>
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
                                @if($loginFailed->isNotEmpty()) 
                                    @foreach($loginFailed as $fail)
                                        <div class="list-group-item border-0 bg-light rounded mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="text-danger me-3">
                                                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 text-danger">การพยายามเข้าสู่ระบบผิดพลาดหลายครั้ง</h6>
                                                    <p class="mb-1">{{ $fail }} - พยายามเข้าระบบ  หลายครั้งใน 5 นาที</p>
                                                    <small class="text-muted"><i class="far fa-clock me-1"></i>5 นาทีที่แล้ว</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <h6 class="mb-1">ยังไม่มีรายการแจ้งเตือนปรากฎ</h6>
                                @endif
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
        @endcan
    </div>

    <style>
        /* Enhanced Styles */
        :root {
            --primary-gradient: linear-gradient(120deg, #4e73df 0%, #224abe 100%);
            --transition-speed: 0.3s;
        }

        /* Modern Cards */
        .hover-card {
            transition: all var(--transition-speed) ease-in-out;
            border-radius: 1rem;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(120deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 1rem;
        }

        /* Text Gradient */
        .text-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Icon Wrappers */
        .icon-wrapper {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-speed) ease;
        }

        /* Soft Background Colors */
        .bg-primary-soft {
            background-color: rgba(78, 115, 223, 0.1);
        }

        .bg-success-soft {
            background-color: rgba(40, 167, 69, 0.1);
        }

        .bg-info-soft {
            background-color: rgba(23, 162, 184, 0.1);
        }

        .bg-warning-soft {
            background-color: rgba(255, 193, 7, 0.1);
        }

        .bg-danger-soft {
            background-color: rgba(220, 53, 69, 0.1);
        }

        /* Modern Buttons */
        .btn-modern {
            border-radius: 0.75rem;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            transition: all var(--transition-speed) ease;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }

            .icon-wrapper {
                width: 40px;
                height: 40px;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>

@endsection

@section('scripts')
    @can('role-list')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('js/dashboardlog.js') }}"></script>
    @endcan
@endsection
