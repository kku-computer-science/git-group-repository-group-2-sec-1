<script src="{{ asset('js/dashboardlog.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dashboardLog.css') }}">


<script>
    var totalError = @json($summary['totalError']);
    var selectedDate = @json(session('selectedDate', date('Y-m-d')));
</script>

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="container-fluid px-4">
        <!-- Admin Dashboard Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 py-3 bg-light border-bottom">
            <div class="d-flex align-items-center gap-4 dashbord-for-align ">
                <h1 class="display-6 fw-bold text-gradient mb-0">Dashboard</h1>
                <form action="{{ route('dashboard') }}" method="GET"
                    class="d-flex align-items-center dashbord-for-align pt-3">
                    <div class="input-group dashboard-input-group  d-flex align-items-center " style="max-width: 350px;">
                        <input type="date" class="form-control" id="datePicker" name="date"
                            value="{{ old('date', date('Y-m-d')) }}" required>
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
                        <span>{{ $activeUser }} active</span>
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 align-items-center">
                    <button class="btn btn-outline-primary py-2" onclick="window.location.reload();" title="Reload Page">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button class="btn btn-dark btn-modern py-2" onclick="window.location.href='{{ route('logs.index') }}'">
                        <i class="fas fa-list me-2"></i>View Full Log
                    </button>
                </div>
            </div>
        </div>



        <div class="row g-4 mb-4">
            <!-- Total Users Card -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ url('/users') }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-card rounded-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper d-flex align-items-center  justify-content-between bg-info-soft rounded-circle me-3">
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
                    <div class="card h-100 border-0 shadow-sm hover-card rounded-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center  mb-3">
                                <div class="icon-wrapper d-flex align-items-center  justify-content-between bg-info-soft rounded-circle me-3">
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
                <a href="#" onclick="redirectToLogs(event, this.dataset.url, 'Login')"
                    data-url="{{ route('logs.index') }}" class="text-decoration-none">

                    <div class="card h-100 border-0 shadow-sm hover-card rounded-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper d-flex align-items-center  justify-content-between bg-info-soft rounded-circle me-3">
                                    <i class="fas fa-sign-in-alt text-info fa-2x"></i>
                                </div>
                                <h6 class="card-title text-muted mb-0">จำนวนครั้งการเข้าสู่ระบบในวันนี้</h6>
                            </div>
                            <h2 class="mb-0 text-info">{{ $summary['totalLogin'] ?? '0' }} <small
                                    class="text-muted">ครั้ง</small></h2>
                        </div>
                    </div>
                </a>
            </div>

            <!-- API Calls Card -->
            <div class="col-xl-3 col-md-6">
                <a href="#" onclick="redirectToLogs(event, this.dataset.url, 'Call Paper')"
                    data-url="{{ route('logs.index') }}" class="text-decoration-none">

                    <div class="card h-100 border-0 shadow-sm hover-card rounded-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div
                                    class="icon-wrapper d-flex align-items-center  justify-content-between bg-info-soft rounded-circle me-3">
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


        <!-- Critical Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <!-- Header Section -->
                        <div class="d-flex align-items-center mb-4">
                            <div
                                class="icon-wrapper bg-danger-soft rounded-circle d-flex align-items-center justify-content-center p-3">
                                <i class="fas fa-exclamation-triangle text-danger fa-2x"></i>
                            </div>
                            <h5 class="card-title mb-0 fw-bold">เหตุการณ์สำคัญที่ต้องตรวจสอบ</h5>
                        </div>

                        <!-- Events List Container with Fixed Height -->
                        <div class="events-container" style="max-height: 400px; overflow-y: auto;">
                            @if (!empty($apiCallWarning) || !empty($loginFailed))
                                @if (!empty($apiCallWarning))
                                    <div class="list-group">
                                        @foreach ($apiCallWarning as $event)
                                            @if ($event['date'] === session('selectedDate', date('Y-m-d')))
                                                <a href="#"
                                                    onclick="redirectToLogs(event, this.dataset.url, '{{ $event['type'] }}')"
                                                    data-url="{{ route('logs.index') }}" data-date="{{ $event['date'] }}"
                                                    class="list-group-item border-0 rounded mb-3 text-decoration-none p-3 d-flex align-items-center hover-shadow transition card-critical ">
                                                    <div class="text-danger me-3">
                                                        <i class="fas fa-exclamation-triangle fa-lg"></i>
                                                    </div>
                                                    <div class="w-100">
                                                        <h6 class="mb-2 text-danger fw-bold">{{ $event['title'] }}</h6>
                                                        <div class="d-flex flex-column flex-md-row gap-2">
                                                            <p class="mb-1 text-primary fw-semibold">
                                                                {{ $event['user_pointer'] }}</p>
                                                            <p class="mb-1 text-dark">{{ $event['description'] }}</p>
                                                        </div>
                                                        <small class="text-muted d-block mt-2">
                                                            <i class="far fa-clock me-1"></i>{{ $event['last_call'] }}&nbsp; ผ่านไปแล้ว {{ $event['time_diff'] }} นาที
                                                        </small>
                                                    </div>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                                @if (!empty($loginFailed))
                                    <div class="list-group">
                                        @foreach ($loginFailed as $event)
                                            @if ($event['date'] === session('selectedDate', date('Y-m-d')))
                                                <a href="#"
                                                    onclick="redirectToLogs(event, this.dataset.url, '{{ $event['type'] }}')"
                                                    data-url="{{ route('logs.index') }}"
                                                    data-date="{{ $event['date'] }}"
                                                    class="list-group-item border-0 rounded mb-3 text-decoration-none p-3 d-flex align-items-center hover-shadow transition card-critical ">
                                                    <div class="text-danger me-3">
                                                        <i class="fas fa-exclamation-triangle fa-lg"></i>
                                                    </div>
                                                    <div class="w-100">
                                                        <h6 class="mb-2 text-danger fw-bold">{{ $event['title'] }}</h6>
                                                        <div class="d-flex flex-column flex-md-row gap-2">
                                                            <p class="mb-1 text-primary fw-semibold">
                                                                {{ $event['user_pointer'] }}</p>
                                                            <p class="mb-1 text-dark">{{ $event['description'] }}</p>
                                                        </div>
                                                        <small class="text-muted d-block mt-2">
                                                            <i class="far fa-clock me-1"></i>{{ $event['last_call'] }}&nbsp; ผ่านไปแล้ว {{ $event['time_diff'] }} นาที
                                                        </small>
                                                    </div>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                                    <p class="text-muted mb-0">ไม่มีเหตุการณ์สำคัญปรากฎในขณะนี้</p>
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
                                <div
                                    class="icon-wrapper bg-danger-soft rounded-circle d-flex align-items-center justify-content-center p-3">
                                    <i class="fas fa-exclamation-circle text-danger fa-2x"></i>
                                </div>
                                <h5 class="card-title mb-0">Error Status: <span id="error-count"
                                        class="text-danger"></span>
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

@endsection


@section('scripts')
    @can('role-list')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('js/dashboardlog.js') }}"></script>
    @endcan
    
@endsection
