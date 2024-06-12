@extends('admin.layout')

@section('content')
    <h1>Highest Paid Courses</h1>
    @include('admin.report_dropdown')

    @if($courses->isEmpty())
        <p>No data available.</p>
    @else
        <canvas id="highestPaidCoursesChart" width="800" height="400"></canvas>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ctx = document.getElementById('highestPaidCoursesChart').getContext('2d');
                var highestPaidCoursesChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($courses->pluck('name')),
                        datasets: [{
                            label: 'Total Payment',
                            data: @json($courses->pluck('payments_sum_total_payment')),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            });
        </script>
    @endif
@endsection
