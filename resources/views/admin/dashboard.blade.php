@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Service Requests Stats -->
        <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #a8d0e6;">
                <div class="inner">
                    <h3>{{ $totalRequests }}</h3>
                    <p>Total Service Requests</p>
                </div>
            </div>
        </div>
       
        <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #f3d2c1;">
                <div class="inner">
                    <h3>{{ $pendingRequests }}</h3>
                    <p>Pending Requests</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #c0e6a0;">
                <div class="inner">
                    <h3>{{ $approvedRequests }}</h3>
                    <p>Approved Requests</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #f8c8c8;">
                <div class="inner">
                    <h3>{{ $rejectedRequests }}</h3>
                    <p>Rejected Requests</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Report Statistics -->
        <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #99c4d8;">
                <div class="inner">
                    <h3>{{ $totalReports }}</h3>
                    <p>Total Reports</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #f9e9b6;">
                <div class="inner">
                    <h3>{{ $pendingReports }}</h3>
                    <p>Pending Reports</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #b6e0a6;">
                <div class="inner">
                    <h3>{{ $reviewedReports }}</h3>
                    <p>Reviewed Reports</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #ffcccc;">
                <div class="inner">
                    <h3>{{ $rejectedReports }}</h3>
                    <p>Rejected Reports</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- User Statistics -->
        <div class="col-lg-6 col-12">
            <div class="small-box" style="background-color: #add8e6;">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="small-box" style="background-color: #b2d8b2;">
                <div class="inner">
                    <h3>{{ $newUsers }}</h3>
                    <p>New Users This Month</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Report Statistics -->
        <!-- Same as your existing code for reports -->
    </div>

    <div class="row">
        <!-- User Statistics -->
        <!-- Same as your existing code for user stats -->
    </div>

    <!-- Row for the charts side by side -->
    <div class="row">
        <!-- Pie Chart for Service Request Statuses -->
        <div class="col-lg-6 col-12">
            <canvas id="requestChart" style="height: 250px;"></canvas>
        </div>

        <!-- Line Chart for User Logins -->
        <div class="col-lg-6 col-12">
            <canvas id="loginChart" style="height: 250px;"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('requestChart').getContext('2d');
    var requestChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Pending', 'Approved', 'Rejected'],
            datasets: [{
                data: [{{ $pendingRequests }}, {{ $approvedRequests }}, {{ $rejectedRequests }}],
                backgroundColor: ['#f3d2c1', '#c0e6a0', '#f8c8c8']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        }
    });

    var loginCtx = document.getElementById('loginChart').getContext('2d');
    var loginChart = new Chart(loginCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($loginDates) !!},  // This will create an array of dates for the x-axis
            datasets: [{
                label: 'User Logins',
                data: {!! json_encode($loginCounts) !!},  // This will create an array of counts for the y-axis
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection