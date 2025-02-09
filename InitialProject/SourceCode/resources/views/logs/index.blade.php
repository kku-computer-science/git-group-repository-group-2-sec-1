@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<script src="{{ asset('js/logs.js') }}"></script>

@section('title', 'System Logs')
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


@section('content')
    <!-- Your content goes here (e.g., filters, table of logs) -->
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">System Logs</h1>
      
        </div>

        <!-- Filters Section -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('logs.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Date Range</label>
                        <input type="date" class="form-control" name="date" value="{{ request('date') ?? \Carbon\Carbon::today()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Activity Type</label>
                        <select class="form-select" name="activity_type">
                            <option value="">All Activities</option>
                            <option value="login" {{ request('activity_type') == 'login' ? 'selected' : '' }}>Login</option>
                            <option value="logout" {{ request('activity_type') == 'logout' ? 'selected' : '' }}>Logout</option>
                            <option value="error" {{ request('activity_type') == 'error' ? 'selected' : '' }}>Error</option>
                            <option value="add" {{ request('activity_type') == 'add' ? 'selected' : '' }}>Add Data</option>
                            <option value="update" {{ request('activity_type') == 'update' ? 'selected' : '' }}>Update Data</option>
                            <option value="delete" {{ request('activity_type') == 'delete' ? 'selected' : '' }}>Delete Data</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Search by Email</label>
                        <input type="text" class="form-control" name="email" value="{{ request('email') }}" placeholder="Enter email...">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
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
                                <th>role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr class="cursor-pointer expand-button" data-bs-toggle="collapse" data-bs-target="#details-{{ $log->id }}">
                                    <td><i class="fas fa-chevron-right"></i></td>
                                    <td>{{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Bangkok')->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $log->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $log->activity_type === 'login' ? 'success' :
                                            ($log->activity_type === 'delete' ? 'danger' :
                                                ($log->activity_type === 'update' ? 'warning' : 'primary')) }}">
                                            {{ $log->activity_type }}
                                        </span>
                                    </td>
                                    <td>{{ $log->role ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
