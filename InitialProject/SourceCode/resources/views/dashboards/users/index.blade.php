@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
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
                <div>
                    <h1 class="display-6 fw-bold">Dashboard</h1>
                    <div class="text-muted">{{ date('d/m/Y') }}</div>
                </div>
                <div>
                    <button class="btn btn-primary me-2" onclick="window.location.reload();">
                        <i class="fas fa-sync-alt me-2"></i>Reload Page
                    </button>
                    <button class="btn btn-dark" onclick="window.location.href='{{ route('logs.index') }}'">
                        <i class="fas fa-list me-2"></i>View Full Log
                    </button>
                </div>
            </div>

            <!-- Stats Cards Row -->
            <div class="row g-4">
                <!-- Total Users Card -->
                <div class="col-xl-2 col-md-4">
                    <a href="{{ url('/users') }}" class="text-decoration-none">
                        <div class="card h-100  border-0 shadow-sm hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-users text-primary fa-2x me-3"></i>
                                    <h6 class="card-title text-muted mb-0">จำนวนผู้ใช้ทั้งหมด</h6>
                                </div>
                                <h2 class="mb-0 text-primary">{{ $totalUsers ?? '100' }} <small class="text-muted">คน</small>
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
                                    <i class="fas fa-book text-success fa-2x me-3"></i>
                                    <h6 class="card-title text-muted mb-0">จำนวนงานวิจัยทั้งหมด</h6>
                                </div>
                                <h2 class="mb-0 text-success">{{ $totalResearch ?? '1000' }} <small
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
                                    <i class="fas fa-sign-in-alt text-info fa-2x me-3"></i>
                                    <h6 class="card-title text-muted mb-0">จำนวนผู้เข้าสู่ระบบ</h6>
                                </div>
                                <h2 class="mb-0 text-info">{{ $totalLogins ?? '30' }} <small class="text-muted">คน</small>
                                </h2>
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
                                    <i class="fas fa-code text-warning fa-2x me-3"></i>
                                    <h6 class="card-title text-muted mb-0">จำนวนการเรียก API</h6>
                                </div>
                                <h2 class="mb-0 text-warning">{{ $totalApiCalls ?? '35' }} <small
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
                                    <i class="fas fa-user-check text-success fa-2x me-3"></i>
                                    <h6 class="card-title text-muted mb-0">ยังอยู่ในระบบจำนวน</h6>
                                </div>
                                <h2 class="mb-0 text-success">{{ $activeUsers ?? '12' }} <small class="text-muted">คน</small>
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
                                <i class="fas fa-exclamation-triangle text-danger me-3 fa-2x"></i>
                                <h5 class="card-title mb-0">เหตุการณ์สำคัญที่ต้องตรวจสอบ</h5>
                            </div>
                            <div class="list-group">
                                <div class="list-group-item border-0 bg-light rounded mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="text-danger me-3">
                                            <i class="fas fa-exclamation-triangle fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 text-danger">การพยายามเข้าสู่ระบบผิดพลาดหลายครั้ง</h6>
                                            <p class="mb-1">IP: 192.168.1.100 - พยายามเข้าระบบ 12 ครั้งใน 5 นาที</p>
                                            <small class="text-muted"><i class="far fa-clock me-1"></i>5 นาทีที่แล้ว</small>
                                        </div>
                                    </div>
                                </div>
                                <!-- Other critical events remain the same -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- error Status -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle text-danger me-3 fa-2x"></i>
                                    <h5 class="card-title mb-0">Error Status: <span id="error-count" class="text-danger"></span>
                                    </h5>
                                </div>
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
        .hover-card {
            transition: transform 0.2s ease-in-out;
        }

        .hover-card:hover {
            transform: translateY(-5px);
        }

        .welcome-section {
            background: linear-gradient(120deg, #f8f9fa 0%, #e9ecef 100%);
        }
    </style>

@endsection

@section('scripts')
    @can('role-list')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('js/dashboardlog.js') }}"></script>


    @endcan
@endsection
