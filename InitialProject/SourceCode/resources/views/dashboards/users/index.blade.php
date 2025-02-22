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
            @include('dashboardLog.index')
        @endcan
    </div>


@endsection

@section('scripts')
    @can('role-list')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('js/dashboardlog.js') }}" defer></script>
    @endcan
@endsection
