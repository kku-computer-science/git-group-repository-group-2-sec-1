@extends('layouts.app')

@section('content')
<div class="container">
    <h2>System Logs</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date Time</th>
                <th>KKU Mail</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
            <tr>
                <td>{{ $log->date_time }}</td>
                <td>{{ $log->kkumail }}</td>
                <td>{{ $log->action }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $logs->links() }} <!-- แสดง Pagination -->
</div>
@endsection
