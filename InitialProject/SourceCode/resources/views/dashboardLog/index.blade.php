<script src="{{ asset('js/dashboardlog.js') }}"></script>
<script>
    const criticalEventsData = @json($criticalEvents);
    var totalError = @json($summary['totalError']);
    var selectedDate = @json(session('selectedDate', date('Y-m-d')));


</script>

@section('title', 'Dashboard')

@section('content')

    <!-- Welcome Section -->
    <div class="container-fluid px-4">
        <!-- Admin Dashboard Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-2">
                <h1 class="display-6 fw-bold text-gradient">Dashboard</h1>
                    <form action="{{ route('dashboard') }}" method="GET">
                        <div class="form-group">
                            <input type="date" class="form-control" id="datePicker" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        </div>
                    </form>
            </div>
            <div class="d-flex align-items-center gap-2">
                <!-- Active Users Indicator -->
                <div class="d-inline-flex align-items-center me-2">
                    <div class="pulse-dot bg-success me-2"></div>
                    <span class="badge bg-light text-success border border-success px-3 py-2">
                        <i class="fas fa-users me-2"></i>{{ count($activeUser) ?? '12' }} users อยู่ในระบบ
                    </span>
                </div>

                <!-- Divider -->
                <div class="vr text-muted opacity-25"></div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3">
                    <button class="btn btn-primary btn-modern" onclick="window.location.reload();">
                        <i class="fas fa-sync-alt me-2"></i>Reload Page
                    </button>
                    <button class="btn btn-dark btn-modern" onclick="window.location.href='{{ route('logs.index') }}'">
                        <i class="fas fa-list me-2"></i>View Full Log
                    </button>
                </div>
            </div>
        </div>



        <div class="row g-4 mb-4">
            <!-- Total Users Card -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ url('/users') }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-primary-soft rounded-circle me-3">
                                    <i class="fas fa-users text-primary fa-2x"></i>
                                </div>
                                <h6 class="card-title text-muted mb-0">จำนวนผู้ใช้ทั้งหมด</h6>
                            </div>
                            <h2 class="mb-0 text-primary">{{ $summary['totalUsers'] ?? '0' }} <small
                                    class="text-muted">คน</small></h2>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Total Research Card -->
            <div class="col-xl-3 col-md-6">
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
            <div class="col-xl-3 col-md-6">
                <a href="#" onclick="redirectToLogs(event, this.dataset.url, 'Login')" data-url="{{ route('logs.index') }}"
                    class="text-decoration-none">

                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-info-soft rounded-circle me-3">
                                    <i class="fas fa-sign-in-alt text-info fa-2x"></i>
                                </div>
                                <h6 class="card-title text-muted mb-0">จำนวนผู้เข้าสู่ระบบในวันนี้</h6>
                            </div>
                            <h2 class="mb-0 text-info">{{ $summary['totalLogin'] ?? '0' }} <small
                                    class="text-muted">คน</small></h2>
                        </div>
                    </div>
                </a>
            </div>

            <!-- API Calls Card -->
            <div class="col-xl-3 col-md-6">
                <a href="#" onclick="redirectToLogs(event, this.dataset.url, 'Call Paper')"
                    data-url="{{ route('logs.index') }}" class="text-decoration-none">

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
        </div>


        Critical Section
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
                            @if (!empty($criticalEvents) && count($criticalEvents) > 0)
                                <div class="list-group">
                                    @foreach ($criticalEvents as $event)
                                        @if ($event['date'] === session('selectedDate', date('Y-m-d')))
                                            <a href="#" onclick="redirectToLogs(event, this.dataset.url, '{{ $event['type'] }}')"
                                                data-url="{{ route('logs.index') }}" data-date="{{ $event['date'] }}"
                                                class="list-group-item border-0 rounded mb-3 text-decoration-none p-3 d-flex align-items-center hover-shadow transition">
                                                <div class="text-danger me-3">
                                                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                                                </div>
                                                <div class="w-100">
                                                    <h6 class="mb-2 text-danger fw-bold">{{ $event['title'] }}</h6>
                                                    <div class="d-flex flex-column flex-md-row gap-2">
                                                        <p class="mb-1 text-primary fw-semibold">{{ $event['email'] }}</p>
                                                        <p class="mb-1 text-dark">{{ $event['description'] }}</p>
                                                    </div>
                                                    <small class="text-muted d-block mt-2">
                                                        <i class="far fa-clock me-1"></i>{{ $event['timeAgo'] }}
                                                    </small>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                                    <p class="text-muted mb-0">ไม่มีเหตุการณ์สำคัญในขณะนี้</p>
                                </div>
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

        .bg-danger-soft {
            background-color: rgba(220, 53, 69, 0.1);
        }

        .hover-shadow {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            background-color: #f8f9fa;
        }

        .transition {
            transition: all 0.3s ease;
        }

        /* Custom Scrollbar */
        .events-container::-webkit-scrollbar {
            width: 8px;
        }

        .events-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .events-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .events-container::-webkit-scrollbar-thumb:hover {
            background: #555;
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
    <script>
        // ส่งข้อมูล criticalEvents ไปยัง JavaScript
        const criticalEventsData = @json($criticalEvents);

    </script>
@endsection
