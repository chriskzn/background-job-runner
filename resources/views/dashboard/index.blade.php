<!DOCTYPE html>
<html>
<head>
    <title>Job Dashboard</title>
</head>
<body>
    <h1>Job Dashboard</h1>
    <table>
        <thead>
            <tr>
                <th>Job ID</th>
                <th>Job Name</th>
                <th>Params</th>
                <th>Status</th>
                <th>Error</th>
                <th>Retry Count</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobLogs as $log)
                <tr>
                    <td>{{ $log['id'] }}</td>
                    <td>{{ $log['name'] }}</td>
                    <td>{{ implode(', ', $log['params']) }}</td>
                    <td>{{ $log['status'] }}</td>
                    <td>{{ $log['error'] ?? '-' }}</td>
                    <td>{{ $log['retry_count'] }}</td>
                    <td>
                        <form action="{{ route('cancel-job', $log['id']) }}" method="POST">
                            @csrf
                            <button type="submit">Cancel</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
